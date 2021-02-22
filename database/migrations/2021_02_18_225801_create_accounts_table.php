<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 100)->unique();

            $table->foreignId('company_id')->constrained()
                ->onDelete('CASCADE')
                ->onUpdate('NO ACTION');

            $table->string('application_name')->unique();
            $table->string('application_logo');
            $table->string('application_url');
            $table->enum('terminology', ['Changelog', 'Release Notes', 'Updates', 'News']);
            $table->foreignId('created_by')->constrained('users')
                ->onDelete('CASCADE')
                ->onUpdate('NO ACTION');

            $table->foreignId('updated_by')->constrained('users')
                ->onDelete('CASCADE')
                ->onUpdate('NO ACTION');
            $table->index('company_id');

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
        Schema::dropIfExists('accounts');
    }
}
