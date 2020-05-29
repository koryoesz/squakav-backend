<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirlineUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airline_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->unsignedInteger("state_id");
            $table->unsignedSmallInteger("status_id");
            $table->string("username")->unique();
            $table->string("airline_name")->unique();
            $table->string("code_icao")->unique()->nullable();
            $table->tinyInteger("status_id")->default(0);
            $table->string("email")->unique();
            $table->string("password");
            $table->string("token")->nullable();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('airline_user');
    }
}
