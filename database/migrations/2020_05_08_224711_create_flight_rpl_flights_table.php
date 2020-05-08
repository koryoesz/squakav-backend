<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightRplFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_rpl_flights', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements();
            $table->unsignedBigInteger('flight_rpl_id');
            $table->string('aircraft_identification', 7);
            $table->string('type_of_aircraft', 4);
            $table->unsignedTinyInteger('wake_turbulence_category_id');
            $table->smallInteger('number');
            $table->string('cruising_speed', 5);
            $table->string('level', 5);
            $table->string('route', 128);
            $table->string('destination_aerodrome', 4);
            $table->smallInteger('total_eet');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('flight_rpl_flights');
    }
}
