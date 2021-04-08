<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangelogStoreRequest;
use App\Http\Traits\StoresChangelog;
use App\Models\Project;
use App\Models\Changelog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ChangelogController extends Controller
{
    use StoresChangelog;

    public function index($uuid)
    {
        $project = Project::where('uuid', $uuid)->first();

        if (!$project) {
            abort(404);
        }


        return view('changelog.index')->with('user', Auth::user())->with('project', $project);
    }

    /**
     *  * @OA\Post (
     *     path="/project/{projectUuid}/changelogs",
     *     summary="store project new changelog",
     *     @OA\Parameter(
     *     name="projectUuid",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="title",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="body",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="category_id",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="project_id",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *    @OA\Parameter(
     *     name="published_at",
     *     in="header",
     *     required=false,
     *     @OA\Schema(type="string")
     * ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param ChangelogStoreRequest $request
     * @param $projectUuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ChangelogStoreRequest $request, $projectUuid): \Illuminate\Http\JsonResponse
    {
        $project = Project::where('uuid', $projectUuid)->first();
        $changelog = $this->addChangelog($request->validated(), $project->id);
        return response()->json(['changelog' => $changelog->load(['category', 'project'])]);
    }

    /**
     *  * @OA\Put  (
     *     path="/project/changelogs/{id}",
     *     summary="update project changelog",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="title",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="body",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="category_id",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="project_id",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *    @OA\Parameter(
     *     name="published_at",
     *     in="header",
     *     required=false,
     *     @OA\Schema(type="string")
     * ),
     *
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param ChangelogStoreRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ChangelogStoreRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $changelog = Changelog::find($id);
        if (!$changelog) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog.']);
        }

        if (\auth()->user()->can('update', $changelog)) {
            $changelog = $this->updateChangelog($request->validated(), $changelog);

            return response()->json(['changelog' => Changelog::with('category')->with('project')->where('id', $changelog->id)->first()]);
        } else {
            return $this->handleUnauthorizedJsonResponse();
        }
    }

    /**
     *  * @OA\Delete (
     *     path="/project/changelogs/{id}",
     *     summary="delete specific project changelog",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $changelog = Changelog::find($id);

        if (!$changelog) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog.']);
        }

        if (\auth()->user()->can('delete', $changelog)) {
            $changelog->delete();
            return response()->json(['status' => 'success', 'message' => 'Changelog has been successfully deleted.']);
        } else {
            return $this->handleUnauthorizedJsonResponse();
        }
    }
}
