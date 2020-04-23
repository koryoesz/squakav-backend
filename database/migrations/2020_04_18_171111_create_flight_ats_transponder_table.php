<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightAtsTransponderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_ats_transponder', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('flight_id');
            $table->unsignedSmallInteger('transponder_type_properties_id');
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flight_ats');
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
        Schema::dropIfExists('flight_ats_transponder');
    }
}
