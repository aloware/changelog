<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    const DEFAULTS = ['New', 'Improvement', 'Fix'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'company_id'
    ];

    public function changelogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Changelog::class, 'category_id', 'id');
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /*
     * This is temporary as variant is some kind of static as of the moment
     * Will add an option to select variant/colors later in category handling
     */
    public function getVariant(): string
    {
        switch ($this->id) {
            case 2:
                $variant = 'success';
                break;
            case 3:
                $variant = 'danger';
                break;
            case 1 :
            default:
                $variant = 'primary';
        }

        return $variant;
    }
}
