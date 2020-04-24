<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtsFlightEmergencyRadioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_ats_emergency_radio', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('flight_id');
            $table->tinyInteger('uhf')->default(0);
            $table->tinyInteger('vhf')->default(0);
            $table->tinyInteger('elt')->default(0);
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flight_ats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_ats_emergency_radio');
    }
}
