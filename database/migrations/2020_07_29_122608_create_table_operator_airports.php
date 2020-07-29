<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTableOperatorAirports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operator_airports', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->unsignedInteger('operator_id');
            $table->unsignedInteger('system_airport_id');

            $table->foreign('operator_id')->references('id')->on('operators');
            $table->foreign('system_airport_id')->references('id')->on('system_airports');
        });

        DB::table('operator_airports')->insert([
            ['operator_id' => 1, 'system_airport_id' => 1],
            ['operator_id' => 2, 'system_airport_id' => 1],
            ['operator_id' => 3, 'system_airport_id' => 1],
            ['operator_id' => 4, 'system_airport_id' => 16],
            ['operator_id' => 5, 'system_airport_id' => 35],
            ['operator_id' => 6, 'system_airport_id' => 25]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operator_airports');
    }
}
