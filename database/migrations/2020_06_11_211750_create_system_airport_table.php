<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use App\Models\SystemAcc;

class CreateSystemAirportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_airports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('state_id');
            $table->unsignedInteger('system_acc_id');
            $table->string('name', 50);
            $table->string('label', 50)->nullable();
            $table->string('icao_code', 20);
            $table->string('route_id', 20)->nullable();
            $table->timestamps();
        });

        DB::table('system_airports')->insert([
           ['id' => 1, 'state_id' => State::LAGOS, 'system_acc_id' => SystemAcc::LAGOS,
               'name' => 'lagos', 'label' => 'Lagos Airport', 'icao_code' => 'DNMM', 'route_id' => 'LAG'],
            ['id' => 2, 'state_id' => State::DELTA, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'portharcourt_international', 'label' => 'Portharcourt International',
                'icao_code' => 'DNPO', 'route_id' => 'POT'],
            ['id' => 3, 'state_id' => State::CROSSRIVER, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'calabar', 'label' => 'Lagos Airport', 'icao_code' => 'DNCA', 'route_id' => 'CAL/CR'],
            ['id' => 4, 'state_id' => State::KWARA, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'ilorin', 'label' => 'Ilorin',
                'icao_code' => 'DNIL', 'route_id' => 'ILR/IL'],
            ['id' => 5, 'state_id' => State::ONDO, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'akure', 'label' => 'Akure',
                'icao_code' => 'DNAK', 'route_id' => 'AK'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_airports');
    }
}
