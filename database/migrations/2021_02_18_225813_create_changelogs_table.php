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
            $table->string('title', 255);
            $table->text('body');

            $table->foreignId('category_id')->constrained('categories')
                ->onDelete('CASCADE')
                ->onUpdate('NO ACTION');
            $table->index('category_id');

            $table->foreignId('account_id')->constrained('accounts')
                ->onDelete('CASCADE')
                ->onUpdate('NO ACTION');
            $table->index('account_id');

            $table->dateTime('published_at')->nullable();

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
