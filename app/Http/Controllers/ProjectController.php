<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Traits\CreatesProject;
use App\Models\Changelog;
use App\Models\FileUpload;
use App\Models\Project;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
     * @param Request $request
     * @param $projectUuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPublishedChangelogs(Request $request, $projectUuid): \Illuminate\Http\JsonResponse
    {
        $project = Project::where('uuid', $projectUuid)->first();

        switch ($request->get('displayType')) {
            case 'widget' :
                $changelogs = Cache::rememberForever(Changelog::CACHE_WIDGET_KEY_PREFIX . $project->uuid, function() use ($project){
                    return $project->published()
                        ->limit($project->widget_entry_limit)->get();
                });
                break;
            case 'page':
            default:
            if (!$request->has('page')) {
                $changelogs = Cache::rememberForever(Changelog::CACHE_KEY_PREFIX . $project->uuid, function() use ($project){
                    return $project->published()
                        ->paginate($project->page_entry_limit);
                });
            } else {
                $changelogs = $project->published()
                    ->paginate($project->page_entry_limit);
            }
        }

        return response()->json($changelogs);
    }

    public function getPageView($slug)
    {
        $project = Project::where('slug', $slug)->first();

        if (!$project) {
            abort(404);
        }

        return view('output.page')->with('project', $project);
    }

    public function pageViewRedirect(Request $request, $projectUuid): \Illuminate\Http\RedirectResponse
    {
        $project = Project::where('uuid', $projectUuid)->first();

        return redirect()->route('page-changelogs-view', ['projectSlug' => $project->slug]);
    }

    public function getWidgetView(Request $request, $projectUuid)
    {
        $project = Project::where('uuid', $projectUuid)->first();

        if (!$project) {
            abort(404);
        }

        $changelogs = Cache::rememberForever(Changelog::CACHE_WIDGET_KEY_PREFIX . $project->uuid, function() use ($project){
            return $project->published()
                ->limit($project->widget_entry_limit)->get();
        });

        return view('output.widget')->with('project', $project)->with('changelogs', $changelogs)->with('params', ['headerLabel' => $request->get('headerLabel')]);
    }

    public function create($companyId)
    {
        return view('project.settings')
            ->with('project', new Project())
            ->with('user', Auth::user());
    }

    public function store(ProjectStoreRequest $request, $companyId): \Illuminate\Http\JsonResponse
    {
        $company = Company::find($companyId);

        try {
            $project = $this->addProject($request->validated(), $company->id);
            return response()->json(['status' => 'success', 'message' => 'project has been successfully created.', 'redirectTo' => route('project-changelogs-view', ['uuid' => $project->uuid])]);
        } catch (\Exception $e) {
            return $this->handleUnauthorizedJsonResponse();
        }
    }

    public function update(ProjectStoreRequest $request, $uuid): \Illuminate\Http\JsonResponse
    {
        $project = Project::where('uuid', $uuid)->first();
        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find project.']);
        }

        if (\auth()->user()->can('update', $project)) {
            $project = $this->updateProject($request->validated(), $project);

            //need to clear changelog cache when project settings is updated as page limit changes won't take effect because of cached changelog data
            Changelog::forgetCacheByProjectUuid($project->uuid);

            return response()->json(['status' => 'success', 'message' => 'Project has been successfully updated.', 'project' => $project]);
        } else {
            return $this->handleUnauthorizedJsonResponse();
        }
    }

    public function destroy($uuid): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $project = Project::where('uuid', $uuid)->first();
        if ($project) {
            try {
                if ($user->company->projects->count() === 1) {
                    $response = ['status' => 'error', 'message' => 'Unable to delete project. You need to have at least one project.'];
                } else {
                    $project->delete();
                    $response = ['status' => 'success', 'message' => 'Project has been successfully deleted.', 'redirectTo' => url('/home')];
                }
            } catch (\Exception $e) {
                $response = ['status' => 'error', 'message' => 'Unable to delete project.'];
            }
        }

        return response()->json($response ?? ['status' => 'error', 'message' => 'Project not found']);
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
            $fileUpload->original_file = $file->getClientOriginalName();

            $fileUpload->created_by = Auth::id();
            $fileUpload->save();


            $request->file('image')->storeAs($project->uuid, $filename, 'public');
            return response()->json(['url' => url('/api/project/changelog/image/' . $filename)]);
        }

        return response()->json(['status' => 'error', 'message' => 'No file found.']);
    }

    public function settings($uuid)
    {
        $project =  Project::where('uuid', $uuid)->first();

        if (!$project) {
            abort(404);
        }

        return view('project.settings')
            ->with('project', $project)
            ->with('user', Auth::user());
    }

    public function uploadLogo(Request $request, $uuid): \Illuminate\Http\JsonResponse
    {
        $project = Project::where('uuid', $uuid)->first();
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = Uuid::uuid1().'.'.$file->extension();

            $fileUpload = new FileUpload();
            $fileUpload->uuid = Uuid::uuid1();
            $fileUpload->project_id = $project->id;

            $fileUpload->extension = $file->extension();
            $fileUpload->mimetype = $file->getClientMimeType();

            $fileUpload->name = $filename;
            $fileUpload->original_file = $file->getClientOriginalName();

            $fileUpload->created_by = Auth::id();
            $fileUpload->save();

            $project->logo = $filename;
            $project->save();

            $request->file('file')->storeAs($project->uuid . '/logo', $filename, 'public');
            return response()->json(['url' => url('/api/project/'. $project->uuid .'/logo?filename='.$filename)]);
        }

        return response()->json(['status' => 'error', 'message' => 'No file found.']);
    }

    public function getLogo($uuid): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $project = Project::where('uuid', $uuid)->first();
        $fileUpload = FileUpload::where('name', $project->logo)->first();

        if ($fileUpload) {
            $path = Storage::disk('public')->path($project->uuid.'/logo/' . $project->logo);
            return response()->file($path);
        } else {
            //TODO make an avatar logo?
        }
    }

    public function widget()
    {
        return view('project.widget');
    }
}
