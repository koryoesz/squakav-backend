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
            $table->tinyInteger('id');
            $table->string('name', 3);
            $table->string('label', 10);
        });

        DB::table('system_flight_types')->insert([
           ['id' => 1, 'name' => 'ats', 'label' => 'For Ats'],
            ['id' => 2, 'name' => 'rpl', 'label' => 'For Rpl']
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
