<?php


namespace App\Http\Traits;


use App\Models\Changelog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait CreatesChangelog
{
    public function addChangelog($data, $projectId): Changelog
    {
        $changelog = new Changelog();
        $changelog->title = $data['title'];
        $changelog->body = $data['body'];
        $changelog->category_id = $data['category_id'];
        $changelog->project_id = $projectId;
        $changelog->created_by = Auth::id();
        if (isset($data['published_at'])) {
            $changelog->published_at = Carbon::parse($data['published_at']);
        }

        $changelog->save();

        return $changelog;
    }

    public function updateChangelog($data, Changelog $changelog): Changelog
    {
        $changelog->title = $data['title'];
        $changelog->body = $data['body'];
        $changelog->category_id = $data['category_id'];
        $changelog->updated_by = Auth::id();
        if (isset($data['published_at'])) {
            $changelog->published_at = Carbon::parse($data['published_at']);
        }

        $changelog->save();

        return $changelog;
    }
}
