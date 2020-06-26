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
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('aircraft_identification', 7)->nullable();
            $table->unsignedInteger('ats_flight_rules_id')->nullable();
            $table->string('aircraft_type', 4)->nullable();
            $table->unsignedInteger('operator_id');
            $table->unsignedInteger('wake_turbulence_category_id')->nullable();
            $table->unsignedSmallInteger('flight_type_id')->nullable();
            $table->string('departure', 4)->nullable();
            $table->string('cruising_speed', 5)->nullable();
            $table->string('level', 5)->nullable();
            $table->string('route', 128)->nullable();
            $table->string('destination', 4)->nullable();
            $table->string('total_eet', 4)->nullable();
            $table->string('time', 4)->nullable();
            $table->date('flight_date')->nullable();
            $table->string('alternate_one', 4)->nullable();
            $table->string('alternate_two', 4)->nullable();
            $table->string('endurance', 4)->nullable();
            $table->string('persons_on_board', 3)->nullable();
            $table->tinyInteger('number')->nullable();
            $table->unsignedsmallInteger('status_id')->default(1);
            $table->string('color_markings')->nullable();
            $table->string('remarks', 128)->nullable();
            $table->string('official_remarks', 128)->nullable();
            $table->string('pilot_in_command', 128)->nullable();
            $table->string('filed_by', 128)->nullable();
            $table->string('additional_requirement', 128)->nullable();
            $table->timestamps();
            $table->dateTime('accepted_date')->nullable();
            $table->unsignedInteger('accepted_by')->nullable();
            $table->string('serial_number',15)->nullable();

            $table->foreign('operator_id')->references('id')->on('operators');
            $table->foreign('accepted_by')->references('id')->on('ais');
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
        Schema::dropIfExists('flight_ats');
    }
}
