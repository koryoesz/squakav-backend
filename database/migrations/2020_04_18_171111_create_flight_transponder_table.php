<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightTransponderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_transponder', function (Blueprint $table) {
            $table->unsignedInteger('flight_id');
            $table->unsignedInteger('transponder_type_properties_id');
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flights');
            $table->foreign('transponder_type_properties_id')->references('id')->on('transponder_type_properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_transponder');
    }
}
