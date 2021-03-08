<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Traits\CreatesProject;
use App\Models\FileUpload;
use App\Models\Project;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

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
        $project = Project::where('uuid', $projectUuid)->first();

        return response()->json($project->changelogs);
    }

    /**  @OA\Get(
     *     path="/api/{project_uuid}/published/changelogs",
     *     summary="list of project's published changelogs",
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
    public function getPublishedChangelogs($projectUuid): \Illuminate\Http\JsonResponse
    {
        $project = Project::where('uuid', $projectUuid)->first();

        return response()->json($project->published()->paginate(Project::DEFAULT_CHANGELOG_LIST_COUNT));
    }

    public function getPageView($projectUuid)
    {
        $project = Project::where('uuid', $projectUuid)->first();
        return view('output.page')->with('project', $project);
    }

    public function getWidgetView($projectUuid)
    {
        $project = Project::where('uuid', $projectUuid)->first();
        return view('output.widget')->with('project', $project);
    }

    public function store(ProjectStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $company = Company::find($request->get('company_id'));
        $project = $this->addProject($request->validated(), $company->id);

        return response()->json(['account' => $project]);
    }

    public function update(ProjectStoreRequest $request, $id): \Illuminate\Http\JsonResponse
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

    public function getImage($filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $fileUpload = FileUpload::where('name', $filename)->first();
        $project = Project::find($fileUpload->project_id);


        $path = Storage::disk('public')->path($project->uuid.'/' .$filename);
        return response()->file($path);
    }

    public function uploadImage(Request $request, $projectUuid): \Illuminate\Http\JsonResponse
    {
        $project = Project::where('uuid', $projectUuid)->first();
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = Uuid::uuid1().'.'.$file->extension();

            $fileUpload = new FileUpload();
            $fileUpload->uuid = Uuid::uuid1();
            $fileUpload->project_id = $project->id;

            $fileUpload->extension = $file->extension();
            $fileUpload->mimetype = $file->getClientMimeType();

            $fileUpload->name = $filename;
            $fileUpload->original_file = $file->getClientOriginalName().'.'.$file->getExtension();

            $fileUpload->created_by = Auth::id();
            $fileUpload->save();


            $request->file('image')->storeAs($project->uuid, $filename, 'public');
            return response()->json(['url' => '/api/project/changelog/image/' . $filename]);
        }

        return response()->json(['status' => 'error', 'message' => 'No file found.']);
    }

    public function settings($projectUuid)
    {
        $project =  Project::where('uuid', $projectUuid)->first();

        return view('project.settings')->with('project', $project)->with('user', Auth::user());
    }
}
