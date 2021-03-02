<?php


namespace App\Http\Traits;


use App\Models\Changelog;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait CreatesProject
{
    public function addProject(array $data, $companyId, $userId = null): Project
    {
        $project = new Project();

        $project->company_id = $companyId;

        $project->name = isset($data['application_name']) ? $data['application_name'] : $data['url'];

        if (isset($data['application_logo'])) {
            $project->application_logo = '';
        }

        $project->url = $data['url'];
        $project->terminology = isset($data['terminology']) ? $data['terminology'] : Project::TERMINOLOGY_CHANGELOG;
        $project->created_by = !$userId ? Auth::id() : $userId;

        $project->save();

        return $project;
    }

    public function updateProject($data, Project $project): Project
    {
        $project->name = $data['application_name'];

        if (isset($data['application_logo'])) {
            $project->application_logo = '';
        }

        $project->url = $data['url'];
        $project->terminology = isset($data['terminology']) ? $data['terminology'] : Project::TERMINOLOGY_CHANGELOG;
        $project->updated_by = Auth::id();

        $project->save();

        return $project;
    }
}
