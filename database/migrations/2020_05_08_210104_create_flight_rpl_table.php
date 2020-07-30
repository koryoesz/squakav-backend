<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightRplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_rpl', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedInteger('operator_id');
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->date('valid_from')->nullable();
            $table->unsignedInteger('departure_airport_id')->nullable();
            $table->string('supplementary_data')->nullable();
            $table->dateTime('accepted_date')->nullable();
            $table->unsignedInteger('accepted_by')->nullable();
            $table->string('official_remarks', 128)->nullable();
            $table->string('additional_addressees', 128)->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->foreign('accepted_by')->references('id')->on('ais');
            $table->foreign('departure_airport_id')->references('id')->on('system_airports');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_rpl');
    }
}
