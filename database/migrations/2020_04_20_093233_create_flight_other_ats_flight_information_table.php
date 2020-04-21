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
            $table->unsignedInteger('flight_if');
            $table->unsignedInteger('other_ats_flight_information_id');
            $table->string('value', 50);
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
        Schema::dropIfExists('flight_other_ats_flight_information');
    }
}
