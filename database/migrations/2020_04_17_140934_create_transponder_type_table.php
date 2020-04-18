<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransponderTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transponder_type', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->string('name', 10);
            $table->string('label', 2);
            $table->timestamps();
        });

        DB::table('transponder_type')->insert([
            ['id' => 1, 'name' => 'a_mode', 'label' => 'Mode A'],
            ['id' => 2, 'name' => 's_mode', 'label' => 'Mode S'],
            ['id' => 3, 'name' => 'c_mode', 'label' => 'Mode C']
        ]);

        Schema::create('transponder_type_properties', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->unsignedInteger('transponder_type_id');
            $table->string('name', 10);
            $table->string('label', 2);
            $table->timestamps();
        });

        DB::table('transponder_type_properties')->insert([
            ['id' => 1, 'transponder_type_id' => 2, 'name' => 'B1', 'label' => 'B1 - ADS-B with dedicated  “out” capability'],
            ['id' => 2, 'transponder_type_id' => 2, 'name' => 'B2', 'label' => 'B2 - ADS-B with dedicated “out” and “in” capability'],
            ['id' => 3, 'transponder_type_id' => 2, 'name' => 'U1', 'label' => 'U1 - ADS-B “out” capability using UAT'],
            ['id' => 4, 'transponder_type_id' => 2, 'name' => 'U2', 'label' => 'U2 - ADS-B “out” and “in” capability using UAT'],
            ['id' => 5, 'transponder_type_id' => 2, 'name' => 'V1', 'label' => 'V1 - ADS-B “out” capability using VDL Mode 4'],
            ['id' => 6, 'transponder_type_id' => 2, 'name' => 'V2', 'label' => 'V2 -  ADS-B “out” and “in” capability using VDLMode 4'],
            ['id' => 7, 'transponder_type_id' => 2, 'name' => 'D1', 'label' => 'D1 - ADS-C with FANS 1/A capabilities'],
            ['id' => 8, 'transponder_type_id' => 2, 'name' => 'G1', 'label' => 'G1 - ADS-C with ATN capabilities']
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transponder_type');
        Schema::dropIfExists('transponder_type_properties');
    }
}
