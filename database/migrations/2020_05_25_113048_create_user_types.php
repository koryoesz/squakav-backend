<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->tinyIncrements('id');
            $table->string('name');
            $table->string('label');
            $table->timestamps();
        });

        DB::table('user_types')->insert([
            ['id' => 1, 'name' => 'airline', 'label' => 'For Airlines'],
            ['id' => 2, 'name' => 'ais', 'label' => 'For AIS'],
            ['id' => 3, 'name' => 'tower', 'label' => 'For Tower'],
            ['id' => 4, 'name' => 'acc', 'label' => 'For ACC'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_types');
    }
}
