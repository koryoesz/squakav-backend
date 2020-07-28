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

            $table->bigIncrements('id');
            $table->unsignedBigInteger('flight_rpl_id');
            $table->unsignedBigInteger('flight_rpl_days_id');
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->string('aircraft_identification', 7)->nullable();
            $table->string('aircraft_reg', 10)->nullable();
            $table->string('aircraft_type', 4)->nullable();
            $table->unsignedInteger('wake_turbulence_category_id')->nullable();
            $table->string('cruising_speed', 5)->nullable();
            $table->string('level', 5)->nullable();
            $table->string('route', 128)->nullable();
            $table->string('destination', 4)->nullable();
            $table->string('total_eet', 4)->nullable();
            $table->string('time', 4)->nullable();
            $table->string('remarks', 128)->nullable();
            $table->string('pilot_in_command', 128)->nullable();
            $table->string('additional_requirement', 128)->nullable();
            $table->time('delay_time')->nullable();
            $table->time('actual_depature_time')->nullable();
            $table->timestamps();

            $table->foreign('flight_rpl_id')->references('id')->on('flight_rpl');
            $table->foreign('flight_rpl_days_id')->references('id')->on('flight_rpl_days');
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
        Schema::dropIfExists('flight_rpl_flights');
    }
}
