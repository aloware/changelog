<?php


namespace App\Http\Traits;


use App\Models\Changelog;
use App\Models\FileUpload;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

trait CreatesProject
{
    public function addProject(array $data, $companyId, $userId = null): Project
    {
        $project = new Project();

        $project->company_id = $companyId;

        $name = '';

        if (isset($data['url'])) {
            $name = str_replace('.', '-', preg_replace("(^https?://)", "", $data['url']));
        }

        $project->name = isset($data['name']) ? $data['name'] : $name;

        $project->page_entry_limit = isset($data['page_entry_limit']) ? $data['page_entry_limit'] : Project::DEFAULT_CHANGELOG_PAGE_ENTRY_LIMIT;
        $project->widget_entry_limit = isset($data['widget_entry_limit']) ? $data['widget_entry_limit'] : Project::DEFAULT_CHANGELOG_WIDGET_ENTRY_LIMIT;
        $project->url = $data['url'];
        $project->slug = Str::slug($project->name);
        $project->terminology = isset($data['terminology']) ? $data['terminology'] : Project::TERMINOLOGY_CHANGELOG;
        $project->created_by = !$userId ? Auth::id() : $userId;

        $project->save();

        return $project;
    }

    public function updateProject($data, Project $project): Project
    {
        $project->name = $data['name'];

        if (isset($data['logo'])) {
            $project->application_logo = '';
        }

        $project->page_entry_limit = isset($data['page_entry_limit']) ? $data['page_entry_limit'] : Project::DEFAULT_CHANGELOG_PAGE_ENTRY_LIMIT;
        $project->widget_entry_limit = isset($data['widget_entry_limit']) ? $data['widget_entry_limit'] : Project::DEFAULT_CHANGELOG_WIDGET_ENTRY_LIMIT;

        $project->url = $data['url'];
        $project->slug = Str::slug($project->name);
        $project->terminology = isset($data['terminology']) ? $data['terminology'] : Project::TERMINOLOGY_CHANGELOG;
        $project->updated_by = Auth::id();

        $project->save();

        return $project;
    }
}
