<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightAtsTransponderProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_ats_transponder_properties', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('flight_id');
            $table->unsignedSmallInteger('transponder_properties_id');

            $table->foreign('flight_id')->references('id')->on('flight_ats');
            $table->foreign('transponder_properties_id', 'tq_prop_id')->references('id')->on('transponder_type_properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_ats_transponder_properties');
    }
}
