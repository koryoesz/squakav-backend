<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWakeTurbulenceCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wake_turbulence_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->tinyIncrements('id');
            $table->string("name", 10);
            $table->string("label", 10);
            $table->string("code", 1);
            $table->timestamps();
        });

        DB::table('wake_turbulence_category')->insert([
            ['label' => 'Light (L)', 'name' => 'light_l', 'code' => 'l'],
            ['label' => 'Medium (M)', 'name' => 'medium_m', 'code' => 'm'],
            ['label' => 'Heavy (H)', 'name' => 'heavy_h', 'code' => 'h']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wake_turbulence_category');
    }
}
