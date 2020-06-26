<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\State;

class CreateAccTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_acc', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedSmallInteger('state_id');
            $table->string('name', 50);
            $table->string('label', 50)->nullable();
            $table->string('icao_code', 20)->nullable();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
        });

        DB::table('system_acc')->insert([
            ['id' => 1, 'state_id' => State::LAGOS, 'label' => 'Lagos ACC', 'name' => 'lagos_acc'],
            ['id' => 2, 'state_id' => State::KANO, 'label' => 'Kano ACC', 'name' => 'kano_acc']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_acc');
    }
}
