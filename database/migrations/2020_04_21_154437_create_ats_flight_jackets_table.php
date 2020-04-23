<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtsFlightJacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ats_flight_jackets', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('flight_id');
            $table->tinyInteger('light')->default(0);
            $table->tinyInteger('fluores')->default(0);
            $table->tinyInteger('uhf')->default(0);
            $table->tinyInteger('vhf')->default(0);
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flight_ats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ats_flight_jackets');
    }
}
