<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Changelog extends Model
{
    use HasFactory;
    use SoftDeletes;

    const DEFAULT_TITLE = "We're starting a changelog." ;
    const DEFAULT_BODY = "This is your first change log. Below you can make changes, edit and make it public." ;

    const CACHE_KEY_PREFIX = "changelog_";

    protected $casts = [
        //'published_at' => 'timestamp'
    ];

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model){
            self::forgetCache($model);
        });
        self::updated(function ($model){
            self::forgetCache($model);
        });
        self::deleted(function ($model){
            self::forgetCache($model);
        });
    }

    public static function forgetCache(self $model)
    {
        Cache::forget(self::CACHE_KEY_PREFIX . $model->project->uuid);
    }
}
