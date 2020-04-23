<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTranspondersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transponders', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->unsignedSmallInteger('transponder_type_id');
            $table->string("name", 10);
            $table->string("label", 128);
            $table->timestamps();

            $table->foreign('transponder_type_id')->references('id')->on('transponder_type');
        });

        DB::table('transponders')->insert([
            ['transponder_type_id' => 1, 'name' => 'a_mode', 'label' => 'A - Mode A (4 digits - 4096 codes)'],
            ['transponder_type_id' => 3, 'name' => 'c_mode', 'label' => 'C - Mode C ()'],
            ['transponder_type_id' => 2, 'name' => 'e_mode', 'label' => 'E - Mode E ()'],
            ['transponder_type_id' => 2, 'name' => 'h_mode', 'label' => 'H - Mode S, including aircraft identification, pressure-altitude and enhanced surveillance
capability
'],
            ['transponder_type_id' => 2, 'name' => 'i_mode', 'label' => 'I - Mode S, including aircraft identification, but no pressure-altitude capability'],
            ['transponder_type_id' => 2, 'name' => 'e_mode', 'label' => 'L - Mode S, including aircraft identification, pressure-altitude, extended squitter (ADS-B) and
enhanced surveillance capability
'],
            ['transponder_type_id' => 2, 'name' => 'p_mode', 'label' => 'P - Mode S, including pressure-altitude, but no aircraft identification capability'],
            ['transponder_type_id' => 2, 'name' => 's_mode', 'label' => 'S - Mode S, including both pressure altitude and aircraft identification capability'],
            ['transponder_type_id' => 2, 'name' => 'x_mode', 'label' => 'X - Mode S with neither aircraft identification nor pressure-altitude capability'],
         ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transponders');
    }
}
