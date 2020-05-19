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
        Schema::create('flight_ats_other_flight_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('flight_id');
            $table->unsignedSmallInteger('other_ats_flight_information_id');
            $table->string('value', 128);
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flight_ats');
            $table->foreign('other_ats_flight_information_id', 'o_f_id')->references('id')->on('other_ats_flight_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_ats_other_flight_information');
    }
}
