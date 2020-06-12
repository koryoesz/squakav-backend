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
            ['id' => 16, 'state_id' => State::EDO, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'benin', 'label' => 'Benin', 'icao_code' => 'DNBE', 'route_id' => 'BEN/BC'],
            ['id' => 17, 'state_id' => State::RIVERS, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'finima', 'label' => 'Finima', 'icao_code' => 'DNFB', 'route_id' => 'FB'],
            ['id' => 18, 'state_id' => State::KEBBI, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'bebbi', 'label' => 'Bebbi', 'icao_code' => 'DNBB', 'route_id' => 'BEB'],
            ['id' => 19, 'state_id' => State::RIVERS, 'system_acc_id' => SystemAcc::LAGOS,
                'name' => 'portharcourt_nafbase', 'label' => 'Portharcourt Nafbase', 'icao_code' => 'DNPM'],
            ['id' => 20, 'state_id' => State::FCT, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'abuja', 'label' => 'Abuja', 'icao_code' => 'DNAA', 'route_id' => 'ABC'],
            ['id' => 21, 'state_id' => State::KANO, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'kano', 'label' => 'Kano', 'icao_code' => 'DNKN', 'route_id' => 'KAN'],
            ['id' => 22, 'state_id' => State::KADUNA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'kaduna', 'label' => 'Kaduna', 'icao_code' => 'DNKA', 'route_id' => 'KDA'],
            ['id' => 23, 'state_id' => State::KATSINA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'katsina', 'label' => 'Katsina', 'icao_code' => 'DNKT', 'route_id' => 'KAT'],
            ['id' => 24, 'state_id' => State::KATSINA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'gombe', 'label' => 'Gombe', 'icao_code' => 'DNGO', 'route_id' => 'GME'],
            ['id' => 25, 'state_id' => State::GOMBE, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'gombe', 'label' => 'Gombe', 'icao_code' => 'DNGO', 'route_id' => 'GME'],
            ['id' => 26, 'state_id' => State::KEBBI, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'kebbi', 'label' => 'Kebbi', 'icao_code' => 'DNBK', 'route_id' => 'BIK'],
            ['id' => 27, 'state_id' => State::BENUE, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'makurdi', 'label' => 'Makurdi', 'icao_code' => 'DNMK'],
            ['id' => 28, 'state_id' => State::ADAMAWA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'yola', 'label' => 'Yola', 'icao_code' => 'DNYO', 'route_id' => 'YOL'],
            ['id' => 29, 'state_id' => State::SOKOTO, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'sokoto', 'label' => 'Sokoto', 'icao_code' => 'DNSO', 'route_id' => 'SOK'],
            ['id' => 30, 'state_id' => State::PLATEAU, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'jos', 'label' => 'Jos', 'icao_code' => 'DNJO', 'route_id' => 'JOS'],
            ['id' => 31, 'state_id' => State::BORNO, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'maiduguri', 'label' => 'Maiduguri', 'icao_code' => 'DNMA', 'route_id' => 'MIU'],
            ['id' => 32, 'state_id' => State::KADUNA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'kaduna_nafbase', 'label' => 'Kaduna Nafbase', 'icao_code' => 'DNMA', 'route_id' => 'MIU'],
            ['id' => 33, 'state_id' => State::KADUNA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'zaria', 'label' => 'Zaria', 'icao_code' => 'DNZA', 'route_id' => 'ZA'],
            ['id' => 34, 'state_id' => State::BAUCHI, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'bauchi_tafawa', 'label' => 'Bauchi, Tafawa', 'icao_code' => 'DNBC', 'route_id' => 'BCH'],
            ['id' => 35, 'state_id' => State::BAUCHI, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'bauchi', 'label' => 'Bauchi', 'icao_code' => 'DNBA', 'route_id' => 'BA'],
            ['id' => 36, 'state_id' => State::JIGAWA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'dutse', 'label' => 'Dutse', 'icao_code' => 'DNDS', 'route_id' => 'DUT'],
            ['id' => 37, 'state_id' => State::ZAMFARA, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'gusau', 'label' => 'Gusau', 'icao_code' => 'DNGU'],
            ['id' => 38, 'state_id' => State::NIGER, 'system_acc_id' => SystemAcc::KANO,
                'name' => 'minna', 'label' => 'Minna', 'icao_code' => 'DNMN', 'route_id' => 'MNA'],
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
