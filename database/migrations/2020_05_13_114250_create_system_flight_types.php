<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemFlightTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_flight_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->tinyIncrements('id');
            $table->string('name', 3);
            $table->string('label', 10);
            $table->string('class', 128);
        });

        DB::table('system_flight_types')->insert([
           ['id' => 1, 'name' => 'ats', 'label' => 'For Ats', 'class' => 'App\Models\FlightAts'],
            ['id' => 2, 'name' => 'rpl', 'label' => 'For Rpl', 'class' => 'App\Models\FlightRpl']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_flight_types');
    }
}
