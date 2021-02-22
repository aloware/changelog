<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const DEFAULTS = ['New', 'Improvement', 'Fix'];

    public function changelogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Changelog::class, 'category_id', 'id');
    }
}
