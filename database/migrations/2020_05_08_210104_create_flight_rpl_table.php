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
            $table->date('valid_till')->nullable();
            $table->string('departure_aerodrome')->nullable();
            $table->string('supplementary_data')->nullable();
            $table->string('serial_number',15)->nullable();
            $table->dateTime('accepted_date')->nullable();
            $table->unsignedInteger('accepted_by')->nullable();
            $table->string('official_remarks', 128)->nullable();
            $table->string('additional_addressees', 128)->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->foreign('accepted_by')->references('id')->on('ais');
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
