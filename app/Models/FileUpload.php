<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileUpload extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        /**
         * @OA\Schema (schema="uuid", type="char", description="A unique identififer for a model.")
         *
         */
        //$table->char('uuid', 36);
        'uuid',
        //$table->string('extension')->nullable()->after('uuid');
        'extension',
        //$table->string('mimetype')->nullable()->after('extension');
        'mimetype',
        //$table->integer('project_id')->unsigned();
        'project_id',
        //$table->text('original_file')->nullable();
        'original_file',
    ];
}
