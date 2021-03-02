<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Traits\CreatesProject;
use App\Models\Project;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    use CreatesProject;

    /** @OA\Info(title="API to get lists, store, update and delete change logs, companies, projects and categories", version="0.1")
     *  * @OA\Get(
     *     path="/api/{project}/changelogs",
     *     summary="list of project changelogs",
     *     @OA\Parameter(
     *     name="projectUuid",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param $projectUuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChangeLogs($projectUuid): \Illuminate\Http\JsonResponse
    {
        $projects = Project::where('uuid', $projectUuid)->first();

        return response()->json($projects->changelogs);
    }

    public function store(ProjectStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $company = Company::find($request->get('company_id'));
        $project = $this->addProject($request->validated(), $company->id);

        return response()->json(['account' => $project]);
    }

    public function update(ProjectStoreRequest $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find project.']);
        }


        if (\auth()->user()->can('update', $project)) {
            $project = $this->updateProject($request->validated(), $project);
            return response()->json(['project' => $project]);
        } else {
            return $this->handleUnauthorizedJsonResponse();
        }
    }
}
