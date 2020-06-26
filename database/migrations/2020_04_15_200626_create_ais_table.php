<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ais', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedSmallInteger("state_id");
            $table->unsignedSmallInteger("status_id")->default(1);
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('system_airport_id');
            $table->string("email")->unique();
            $table->string("first_name");
            $table->string("last_name")->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('system_airport_id')->references('id')->on('system_airports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ais');
    }
}
