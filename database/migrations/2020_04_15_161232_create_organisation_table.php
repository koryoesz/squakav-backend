<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrganisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->integerIncrements('id');
            $table->string('name', 50);
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status');
        });

        DB::table('organisations')->insert([
            ['id' => 1, 'name' => 'British Airways'],
            ['id' => 2, 'name' => 'Arik Airline'],
            ['id' => 3, 'name' => 'Dana Airline']
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisations');
    }
}
