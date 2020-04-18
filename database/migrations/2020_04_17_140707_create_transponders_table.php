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

            $table->id();
            $table->unsignedInteger('transponder_type_id');
            $table->string("name");
            $table->string("label");
            $table->timestamps();

            $table->foreign('transponder_type_id')->references('id')->on('transponder_type');
        });

        DB::table('transponders')->insert([
            ['transponder_type_id' => 1, 'name' => 'a_mode', 'label' => 'A - Mode A ()'],
            ['transponder_type_id' => 3, 'name' => 'c_mode', 'label' => 'C - Mode C ()'],
            ['transponder_type_id' => 2, 'name' => 'e_mode', 'label' => 'E - Mode E ()'],
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
