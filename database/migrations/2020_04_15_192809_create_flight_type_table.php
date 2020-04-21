<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFlightTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_type', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->string("name", 50);
            $table->string("label", 50);
            $table->timestamps();
        });

        DB::table('flight_type')->insert([
            ['label' => 'S - Scheduled Air Transport', 'name' => 'scheduled_air_transport'],
            ['label' => 'N - Non-Scheduled Air Transport', 'name' => 'non_scheduled_air_transport'],
            ['label' => 'G - General Aviation', 'name' => 'general_aviation'],
            ['label' => 'M - Military ', 'name' => 'military'],
            ['label' => 'X - Other', 'name' => 'other'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_type');
    }
}
