<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changelogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('body');

            $table->foreignId('category_id')->constrained('categories')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreignId('project_id')->constrained('projects')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreignId('created_by')->constrained('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->dateTime('published_at')->nullable();
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
        Schema::dropIfExists('changelogs');
    }
}
