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
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedTinyInteger('system_flight_types_id');
            $table->unsignedBigInteger('flight_id');
            $table->unsignedInteger('operator_id');
            $table->unsignedTinyInteger('user_type_id')->default(1);
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->date('date');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('system_flight_types_id')->references('id')->on('system_flight_types');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('user_type_id')->references('id')->on('user_types');
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
