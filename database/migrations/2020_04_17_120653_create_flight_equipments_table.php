<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_equipments', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedInteger('flight_id');
            $table->unsignedInteger('flight_equipment_id');
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flights');
            $table->foreign('flight_equipment_id')->references('id')->on('equipments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_equipments');
    }
}
