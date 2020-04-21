<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAtsFlightRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ats_flight_rules', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->string('name', 50);
            $table->string('label', 20);
            $table->string('code', 2);
            $table->timestamps();
        });

        DB::table('ats_flight_rules')->insert([
            ['id' => 1, 'name' => 'ifr', 'label' => 'IFR (I) Instrument flight rule', 'code' => 'I'],
            ['id' => 2, 'name' => 'vhf', 'label' => 'VFR (V) Visual Flight', 'code' => 'V'],
            ['id' => 3, 'name' => 'ifr/vfr', 'label' => 'IFR/VFR (Y) IFR changing to VFR', 'code' => 'Y'],
            ['id' => 4, 'name' => 'vfr/ifr', 'label' => 'VFR/IFR (Z) VFR changing to IFR', 'code' => 'Z']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ats_flight_rules');
    }
}
