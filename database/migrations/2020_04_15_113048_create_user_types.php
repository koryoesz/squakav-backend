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
            $table->string('class');
        });

        DB::table('user_types')->insert([
            ['id' => 1, 'name' => 'operator', 'label' => 'For Airlines', 'class' => 'App\Models\Operator'],
            ['id' => 2, 'name' => 'ais', 'label' => 'For AIS', 'class' => 'App\Models\Ais'],
            ['id' => 3, 'name' => 'tower', 'label' => 'For Tower', 'class' => 'App\Models\Tower'],
            ['id' => 4, 'name' => 'acc', 'label' => 'For ACC', 'class' => 'App\Models\Acc'],
            ['id' => 5, 'name' => 'admin', 'label' => 'For Admin', 'class' => 'App\Models\Admin']
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
