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
            $table->increments('id');
            $table->string('name');
        });

        DB::table('states')->insert( [
           ["name" => "Abia"],
            ["name" => "Adamawa"],
            ["name" => "Anambra"],
            ["name" => "Akwa Ibom"],
            ["name" => "Bauchi"],
            ["name" => "Bayelsa"],
            ["name" => "Benue"],
            ["name" => "Borno"],
            ["name" => "Cross River"],
            ["name" => "Delta"],
            ["name" => "Ebonyi"],
            ["name" => "Edo"],
            ["name" => "Ekiti"],
            ["name" => "FCT - Abuja"],
            ["name" => "Gombe"],
            ["name" => "Imo"],
            ["name" => "Jigawa"],
            ["name" => "Kaduna"],
            ["name" => "Kano"],
            ["name" => "Katsina"],
            ["name" => "Kebbi"],
            ["name" => "Kogi"],
            ["name" => "Kwara"],
            ["name" => "Lagos"],
            ["name" => "Nasarawa"],
            ["name" => "Niger"],
            ["name" => "Ogun"],
            ["name" => "Ondo"],
            ["name" => "Osun"],
            ["name" => "Oyo"],
            ["name" => "Plateau"],
            ["name" => "Rivers"],
            ["name" => "Sokoto"],
            ["name" => "Taraba"],
            ["name" => "Yobe"],
            ["name" => "Zamfara"]
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
