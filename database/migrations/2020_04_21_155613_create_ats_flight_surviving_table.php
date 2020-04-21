<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtsFlightSurvivingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ats_flight_surviving_equipments', function (Blueprint $table) {
            $table->bigIncrements();
            $table->unsignedInteger('flight_id');
            $table->tinyInteger('polar')->default(0);
            $table->tinyInteger('desert')->default(0);
            $table->tinyInteger('maritime')->default(0);
            $table->tinyInteger('jungle')->default(0);
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('ats_flights');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ats_flight_surviving_equipments');
    }
}
