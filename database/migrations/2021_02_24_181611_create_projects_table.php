<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();

            $table->foreignId('company_id')->constrained()
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->string('url')->nullable();
            $table->integer('terminology');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
