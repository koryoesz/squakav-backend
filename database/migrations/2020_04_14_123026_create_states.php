<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->string('name');
        });

        DB::table('states')->insert( [
           ["id" => 1, "name" => "Abia"],
            ["id" => 2, "name" => "Adamawa"],
            ["id" => 3, "name" => "Anambra"],
            ["id" => 4, "name" => "Akwa Ibom"],
            ["id" => 5, "name" => "Bauchi"],
            ["id" => 6, "name" => "Bayelsa"],
            ["id" => 7, "name" => "Benue"],
            ["id" => 8, "name" => "Borno"],
            ["id" => 9, "name" => "Cross River"],
            ["id" => 10, "name" => "Delta"],
            ["id" => 11, "name" => "Ebonyi"],
            ["id" => 12, "name" => "Edo"],
            ["id" => 13, "name" => "Ekiti"],
            ["id" => 14, "name" => "Enugu"],
            ["id" => 15, "name" => "Gombe"],
            ["id" => 16, "name" => "Imo"],
            ["id" => 17, "name" => "Jigawa"],
            ["id" => 18, "name" => "Kaduna"],
            ["id" => 19, "name" => "Kano"],
            ["id" => 20, "name" => "Katsina"],
            ["id" => 21, "name" => "Kebbi"],
            ["id" => 22, "name" => "Kogi"],
            ["id" => 23, "name" => "Kwara"],
            ["id" => 24, "name" => "Lagos"],
            ["id" => 25, "name" => "Nasarawa"],
            ["id" => 26, "name" => "Niger"],
            ["id" => 27, "name" => "Ogun"],
            ["id" => 28, "name" => "Ondo"],
            ["id" => 29, "name" => "Osun"],
            ["id" => 30, "name" => "Oyo"],
            ["id" => 31, "name" => "Plateau"],
            ["id" => 32, "name" => "Rivers"],
            ["id" => 33, "name" => "Sokoto"],
            ["id" => 34, "name" => "Taraba"],
            ["id" => 35, "name" => "Yobe"],
            ["id" => 36, "name" => "Zamfara"]
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
