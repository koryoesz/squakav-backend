<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemFlights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_flights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('system_flight_types_id');
            $table->unsignedBigInteger('flight_id');
            $table->unsignedSmallInteger('status_id')->default(1);

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('system_flight_types_id')->references('id')->on('system_flight_types');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_flights');
    }
}
