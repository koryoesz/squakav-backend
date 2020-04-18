<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEquipmentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_type', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->string('name', 10);
            $table->string('label', 2);
            $table->timestamps();
        });

        DB::table('equipment_type')->insert([
           ['id' => 1, 'name' => 'n', 'label' => 'N - Normal'],
            ['id' => 2, 'name' => 's', 'label' => 'S - Standard'],
            ['id' => 3, 'name' => 'o', 'label' => 'O - Other']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_type');
    }
}
