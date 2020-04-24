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
        Schema::create('flight_ats_surviving_equipments', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('flight_id');
            $table->tinyInteger('polar')->default(0);
            $table->tinyInteger('desert')->default(0);
            $table->tinyInteger('maritime')->default(0);
            $table->tinyInteger('jungle')->default(0);
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
        Schema::dropIfExists('flight_ats_surviving_equipments');
    }
}
