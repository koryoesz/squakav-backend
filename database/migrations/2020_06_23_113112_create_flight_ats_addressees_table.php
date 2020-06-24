<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightAtsAddresseesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_ats_addressees', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('flight_id');
            $table->unsignedInteger('system_airport_id');

            $table->foreign('flight_id')->references('id')->on('flight_ats');
            $table->foreign('system_airport_id')->references('id')->on('system_airports');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_ats_addressees');
    }
}
