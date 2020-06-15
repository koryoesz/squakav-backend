<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->string('name', 50);
            $table->string('description', 50);
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status');
        });

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin', 'description' => '', 'status_id' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
