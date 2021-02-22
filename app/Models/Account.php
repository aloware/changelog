<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $uuid = $this->generateUuid();

            //make sure uuid does not already exists
            while (self::where('uuid', $uuid)->count() > 0) {
                $uuid = $this->generateUuid();
            }

            $model->uuid = $uuid;
        });
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function changelogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Changelog::class, 'account_id', 'id');
    }

    protected function generateUuid(): string
    {
        //TODO implement generation of uuid/token
        //https://packagist.org/packages/gladcodes/keygen
        //add time() as of the moment to avoid dupes.
        return 'uuid' . time();
    }
}
