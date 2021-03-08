<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uuid', 36);
            $table->foreignId('project_id')->unsigned()->constrained('projects')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->string('extension')->nullable();
            $table->string('mimetype')->nullable();
            $table->text('name');
            $table->text('original_file')->nullable();

            $table->foreignId('created_by')->constrained('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_uploads');
    }
}
