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
        Schema::create('flight_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->string("name", 50);
            $table->string("label", 50);
            $table->string("code", 0);
            $table->timestamps();
        });

        DB::table('flight_types')->insert([
            ['id' => 1, 'label' => 'S - Scheduled Air Transport', 'name' => 'scheduled_air_transport', 'code' => 's'],
            ['id' => 2, 'label' => 'N - Non-Scheduled Air Transport', 'name' => 'non_scheduled_air_transport', 'code' => 'n'],
            ['id' => 3, 'label' => 'G - General Aviation', 'name' => 'general_aviation', 'code' => 'g'],
            ['id' => 4, 'label' => 'M - Military ', 'name' => 'military', 'code' => 'm'],
            ['id' => 5, 'label' => 'X - Other', 'name' => 'other', 'code'=> 'x'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_types');
    }
}
