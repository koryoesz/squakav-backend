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
            $table->string('location', 20)->nullable();
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
            ['id' => 6, 'state_id' => State::OYO, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'ibadan', 'label' => 'Ibadan', 'icao_code' => 'DNIB', 'route_id' => 'IBA/IB'],
            ['id' => 7, 'state_id' => State::OYO, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'ibadan', 'label' => 'Ibadan', 'icao_code' => 'DNIB', 'route_id' => 'IBA/IB'],
            ['id' => 8, 'state_id' => State::ENUGU, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'enugu', 'label' => 'Enugu', 'icao_code' => 'DNEN', 'route_id' => 'ENG'],
            ['id' => 9, 'state_id' => State::DELTA, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'osubi', 'label' => 'Osubi', 'icao_code' => 'DNSU', 'route_id' => 'OSB/OS'],
            ['id' => 10, 'state_id' => State::DELTA, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'asaba', 'label' => 'Asaba', 'icao_code' => 'DNAS', 'route_id' => 'SAB'],
            ['id' => 11, 'state_id' => State::DELTA, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'escravos', 'label' => 'Escravos', 'icao_code' => 'DN56/DNES', 'route_id' => 'ESC/ES'],
            ['id' => 12, 'state_id' => State::IMO, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'owerri', 'label' => 'Owerri', 'icao_code' => 'DNIM', 'route_id' => 'OWR/OW'],
            ['id' => 13, 'state_id' => State::AKWAIBOM, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'akwaibom', 'label' => 'Akwaibom', 'icao_code' => 'DNAI', 'route_id' => 'AKW'],
            ['id' => 14, 'state_id' => State::AKWAIBOM, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'eket', 'label' => 'Eket', 'icao_code' => 'DNEK/DN55', 'route_id' => 'EK'],
            ['id' => 15, 'state_id' => State::BAYELSA, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'yenagoa', 'label' => 'Yenagoa', 'icao_code' => 'DNBY', 'route_id' => 'BY'],
            ['id' => 15, 'state_id' => State::EDO, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'benin', 'label' => 'Benin', 'icao_code' => 'DNBE', 'route_id' => 'BEN/BC'],
            ['id' => 16, 'state_id' => State::RIVERS, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'finima', 'label' => 'Finima', 'icao_code' => 'DNFB', 'route_id' => 'FB'],
            ['id' => 17, 'state_id' => State::KEBBI, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'bebbi', 'label' => 'Bebbi', 'icao_code' => 'DNBB', 'route_id' => 'BEB'],
            ['id' => 18, 'state_id' => State::RIVERS, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'portharcourt_nafbase', 'label' => 'Portharcourt Nafbase', 'icao_code' => 'DNPM'],
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
