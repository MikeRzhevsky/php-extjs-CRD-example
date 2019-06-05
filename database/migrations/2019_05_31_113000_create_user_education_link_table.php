<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducationLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_education_link');

        Schema::create('user_education_link', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userid');
            $table->unsignedInteger('educationid');
        });

        Schema::table('user_education_link', function($table) {
            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('educationid')->references('id')->on('education');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_education_link');
    }
}
