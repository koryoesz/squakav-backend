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
            $table->string('aircraft_identification', 7);
            $table->unsignedInteger('ats_flight_rules_id');
            $table->string('aircraft_type', 4);
            $table->unsignedInteger('wake_turbulence_category_id');
            $table->unsignedSmallInteger('flight_type_id');
            $table->string('departure', 4);
            $table->string('cruising_speed', 5);
            $table->string('level', 5);
            $table->string('route', 128);
            $table->string('destination', 4);
            $table->smallInteger('total_eet');
            $table->string('alternate_one', 4);
            $table->string('alternate_two', 4)->nullable();
            $table->smallInteger('endurance');
            $table->string('persons_on_board', 3);
            $table->tinyInteger('number')->nullable();
            $table->smallInteger('capacity')->nullable();
            $table->smallInteger('status_id')->default(1);
            $table->string('color_markings');
            $table->string('remarks', 128)->nullable();
            $table->string('pilot_in_command', 128);
            $table->string('filed_by', 128);
            $table->string('additional_requirement', 128)->nullable();
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
