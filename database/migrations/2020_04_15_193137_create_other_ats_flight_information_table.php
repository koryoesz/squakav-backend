<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOtherAtsFlightInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_ats_flight_information', function (Blueprint $table) {
            $table->id();
            $table->string("name", 10);
            $table->string("label", 10);
            $table->timestamps();
        });

        DB::table('other_ats_flight_information')->insert([
            ['id' => 1, 'name' => 'dof', 'label' => 'DOF'],
            ['id' => 2, 'name' => 'sts', 'label' => 'STS'],
            ['id' => 3, 'name' => 'pbn', 'label' => 'PBN'],
            ['id' => 4, 'name' => 'nav', 'label' => 'NAV'],
            ['id' => 5, 'name' => 'com', 'label' => 'COM'],
            ['id' => 6, 'name' => 'dat', 'label' => 'DAT'],
            ['id' => 7, 'name' => 'dep', 'label' => 'DEP'],
            ['id' => 8, 'name' => 'dest', 'label' => 'DEST'],
            ['id' => 9, 'name' => 'reg', 'label' => 'REG'],
            ['id' => 10, 'name' => 'eet', 'label' => 'EET'],
            ['id' => 11, 'name' => 'sel', 'label' => 'SEL'],
            ['id' => 12, 'name' => 'type', 'label' => 'TYPE'],
            ['id' => 13, 'name' => 'code', 'label' => 'CODE'],
            ['id' => 14, 'name' => 'dle', 'label' => 'DLE'],
            ['id' => 15, 'name' => 'opr', 'label' => 'OPR'],
            ['id' => 16, 'name' => 'orgn', 'label' => 'ORGN'],
            ['id' => 17, 'name' => 'per', 'label' => 'PER'],
            ['id' => 18, 'name' => 'altn', 'label' => 'ALTN'],
            ['id' => 19, 'name' => 'ralt', 'label' => 'RALT'],
            ['id' => 20, 'name' => 'talt', 'label' => 'TALT'],
            ['id' => 21, 'name' => 'rif', 'label' => 'RIF'],
            ['id' => 22, 'name' => 'rmk', 'label' => 'RMK']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_ats_flight_information');
    }
}
