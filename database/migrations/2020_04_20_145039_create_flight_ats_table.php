<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightAtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_ats', function (Blueprint $table) {
            $table->bigIncrements();
            $table->string('aircraft_identification', 7);
            $table->unsignedInteger('ats_flight_rules_id');
            $table->unsignedInteger('ats_flight_rules_type');
            $table->tinyInteger('number')->nullable();
            $table->string('aircraft_type', 4);
            $table->unsignedInteger('ats_wake_turbulence_category_id');
            $table->string('departure', 4);
            $table->smallInteger('departure');
            $table->string('cruising_speed', 5);
            $table->string('level', 5);
            $table->string('route', 50);
            $table->string('destination', 4);
            $table->string('alternate', 4);
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
        Schema::dropIfExists('flight_ats');
    }
}
