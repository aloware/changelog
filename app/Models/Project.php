<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class Project extends Model
{

    use HasFactory;

    const TERMINOLOGY_CHANGELOG = 1;
    const TERMINOLOGY_RELEASE_NOTES = 2;
    const TERMINOLOGY_UPDATES = 3;
    const TERMINOLOGY_NEWS = 4;

    const DEFAULT_CHANGELOG_PAGE_ENTRY_LIMIT = 5;
    const DEFAULT_CHANGELOG_WIDGET_ENTRY_LIMIT = 3;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'application_name',
        'terminology',
        'created_by',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $uuid = Uuid::uuid4();

            //make sure uuid does not already exists
            while (self::where('uuid', $uuid)->count() > 0) {
                $uuid = Uuid::uuid4();
            }

            $model->uuid = $uuid->toString();
        });
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function changelogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Changelog::class, 'project_id', 'id')->with('category');
    }

    public function published(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->changelogs()->whereDate('published_at', '<=', Carbon::now()->toDateTimeString())->latest('created_at');
    }

    public function getTerminology(): string
    {
        switch ($this->id) {
            case self::TERMINOLOGY_RELEASE_NOTES :
                $terminology = 'Release Notes';
                break;
            case self::TERMINOLOGY_UPDATES :
                $terminology = 'Updates';
                break;
            case self::TERMINOLOGY_NEWS :
                $terminology = 'News';
                break;
            case self::TERMINOLOGY_CHANGELOG:
            default:
                $terminology = 'Changelog';
        }

        return $terminology;
    }

    public function getLogo(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = Storage::disk('public')->path($this->uuid.'/logo/' .$this->logo);
        return response()->file($path);
    }
}
