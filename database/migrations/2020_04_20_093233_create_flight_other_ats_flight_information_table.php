<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightOtherAtsFlightInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_other_ats_flight_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('flight_id');
            $table->unsignedSmallInteger('other_ats_flight_information_id');
            $table->string('value', 128);
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
        Schema::dropIfExists('flight_other_ats_flight_information');
    }
}
