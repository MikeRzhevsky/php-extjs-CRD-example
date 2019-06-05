<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCityLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_city_link');

        Schema::create('user_city_link', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userid');
            $table->unsignedInteger('cityid');
        });

        Schema::table('user_city_link', function($table) {
            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('cityid')->references('id')->on('city');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_city_link');
    }
}
