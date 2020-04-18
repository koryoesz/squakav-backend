<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->unsignedInteger('equipment_type_id');
            $table->string('name');
            $table->string('label', 2);
            $table->smallInteger('status_id')->default(1);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('status_id')->references('id')->on('status');
        });

        DB::table('equipments')->insert([
            ['equipment_type_id' => 1, 'name' => 'A', 'label' => 'A - GBAS landing system'],
            ['equipment_type_id' => 1, 'name' => 'B', 'label' => 'B - LPV (APV with SBAS)'],
            ['equipment_type_id' => 1, 'name' => 'C', 'label' => 'C - LORAN C'],
            ['equipment_type_id' => 1, 'name' => 'D', 'label' => 'D - DME'],
            ['equipment_type_id' => 1, 'name' => 'E1', 'label' => 'E1 - FMC WPR ACARS'],
            ['equipment_type_id' => 1, 'name' => 'E2', 'label' => 'E2 - D-FIS ACARS'],
            ['equipment_type_id' => 1, 'name' => 'E3', 'label' => 'E3 - PDC ACARS'],
            ['equipment_type_id' => 1, 'name' => 'F', 'label' => 'F - ADF'],
            ['equipment_type_id' => 1, 'name' => 'G', 'label' => 'G - GPS/GNSS'],
            ['equipment_type_id' => 2, 'name' => 'H', 'label' => 'H - HF RTF'],
            ['equipment_type_id' => 1, 'name' => 'I', 'label' => 'I - Inertial Navigation'],
            ['equipment_type_id' => 1, 'name' => 'J1', 'label' => 'J1 - CPDLC ATN VDL Mode 2'],
            ['equipment_type_id' => 1, 'name' => 'J2', 'label' => 'J2 - CPDLC FANS 1/A HFDL'],
            ['equipment_type_id' => 1, 'name' => 'J3', 'label' => 'J3 - CPDLC FANS 1/A VDL Mode A'],
            ['equipment_type_id' => 1, 'name' => 'J4', 'label' => 'J4 - CPDLC FANS 1/A VDL Mode 2'],
            ['equipment_type_id' => 1, 'name' => 'J5', 'label' => 'J5 - CPDLC FANS 1/A SATCOM (INMARSAT)'],
            ['equipment_type_id' => 1, 'name' => 'J6', 'label' => 'J6 - CPDLC FANS 1/A SATCOM (MTSAT)'],
            ['equipment_type_id' => 1, 'name' => 'J7', 'label' => 'J7 - CPDLC FANS 1/A'],
            ['equipment_type_id' => 1, 'name' => 'K', 'label' => 'K - MLS'],
            ['equipment_type_id' => 2, 'name' => 'L', 'label' => 'L - ILS'],
            ['equipment_type_id' => 1, 'name' => 'M1', 'label' => 'M1 - ATC SATVOICE (INMARSAT)'],
            ['equipment_type_id' => 1, 'name' => 'M2', 'label' => 'M2 - ATC SATVOICE (MTSAT)'],
            ['equipment_type_id' => 1, 'name' => 'M3', 'label' => 'M3 - ATC SATVOICE (Iridium)'],
            ['equipment_type_id' => 2, 'name' => 'O', 'label' => 'O - VOR'],
            ['equipment_type_id' => 1, 'name' => 'P1', 'label' => 'P1 - CPDLC RCP 400'],
            ['equipment_type_id' => 1, 'name' => 'P2', 'label' => 'P2 - CPDLC RCP 240'],
            ['equipment_type_id' => 1, 'name' => 'P3', 'label' => 'P3 - SATVOICE RCP 400'],
            ['equipment_type_id' => 1, 'name' => 'R', 'label' => 'R -PBN'],
            ['equipment_type_id' => 1, 'name' => 'T', 'label' => 'T - TACAN'],
            ['equipment_type_id' => 2, 'name' => 'U', 'label' => 'U - UHF RTF'],
            ['equipment_type_id' => 2, 'name' => 'V', 'label' => 'V - VHF RTF'],
            ['equipment_type_id' => 1, 'name' => 'W', 'label' => 'W - RVSM approved (FL 290-410)'],
            ['equipment_type_id' => 1, 'name' => 'X', 'label' => 'X -  MNPS approved'],
            ['equipment_type_id' => 3, 'name' => 'Z', 'label' => 'Z - Other']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
}
