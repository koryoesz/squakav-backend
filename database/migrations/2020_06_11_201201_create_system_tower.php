<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemTower extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_tower', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->string('name', 100)->nullable();
            $table->string('label', 100)->nullable();
            $table->string("code", 100);
            $table->timestamps();
        });

        DB::table('system_tower')->insert([
            ["id" => 1, 'name' => 'lagos_tower', 'label' => '', 'code' => 'DNMMZTZX'],
            ["id" =>2, 'name' => 'portharcourt_international_tower', 'label' => '', 'code' => 'DNPOZTZX'],
            ["id" => 3, 'name' => 'calabar_tower', 'label' => '', 'code' => 'DNCAZTZX'],
            ["id" => 4, 'name' => 'ilorin_tower', 'label' => '', 'code' => 'DNILZTZX'],
            ["id" =>5, 'name' => 'akure_tower', 'label' => '', 'code' => 'DNAKZTZX'],
            ["id" =>6, 'name' => 'ibadan_tower', 'label' => '', 'code' => 'DNIBZTZX'],
            ["id" =>7, 'name' => 'enugu_tower', 'label' => '', 'code' => 'DNENZTZX'],
            ["id" =>8, 'name' => 'osubi_tower', 'label' => '', 'code' => 'DNSUZTZX'],
            ["id" =>9, 'name' => 'asaba_tower', 'label' => '', 'code' => 'DNASZTZX'],
            ["id" =>10, 'name' => 'escravos_tower', 'label' => '', 'code' => 'DNESZTZX'],
            ["id" =>11, 'name' => 'owerri_tower', 'label' => '', 'code' => 'DNIMZTZX'],
            ["id" =>12, 'name' => 'akwaibom_tower', 'label' => '', 'code' => 'DNAIZTZX'],
            ["id" =>13, 'name' => 'eket_tower', 'label' => '', 'code' => 'DNEKZTZX'],
            ["id" =>14, 'name' => 'yenagoa_tower', 'label' => '', 'code' => 'DNBYZTZX'],
            ["id" =>15, 'name' => 'benin_tower', 'label' => '', 'code' => 'DNBEZTZX'],
            ["id" =>16, 'name' => 'finima_tower', 'label' => '', 'code' => 'DNFBZTZX'],
            ["id" =>17, 'name' => 'bebbi_tower', 'label' => '', 'code' => 'DNBBZTZX'],
            ["id" =>18, 'name' => 'portharcourt_nafbase_tower', 'label' => '', 'code' => 'DNPMZTZX'],
            ["id" =>19, 'name' => 'abuja_tower', 'label' => '', 'code' => 'DNAAZTZX'],
            ["id" =>20, 'name' => 'kano_tower', 'label' => '', 'code' => 'DNKNZTZX'],
            ["id" =>21, 'name' => 'kaduna_tower', 'label' => '', 'code' => 'DNKAZTZX'],
            ["id" =>22, 'name' => 'katsina_tower', 'label' => '', 'code' => 'DNKTZTZX'],
            ["id" =>23, 'name' => 'gombe_tower', 'label' => '', 'code' => 'DNGOZTZX'],
            ["id" =>24, 'name' => 'kebbi_tower', 'label' => '', 'code' => 'DNBKZTZX'],
            ["id" =>25, 'name' => 'makurdi_tower', 'label' => '', 'code' => 'DNMKZTZX'],
            ["id" =>26, 'name' => 'yola_tower', 'label' => '', 'code' => 'DNYOZTZX'],
            ["id" =>27, 'name' => 'sokoto_tower', 'label' => '', 'code' => 'DNSOZTZX'],
            ["id" =>28, 'name' => 'jos_tower', 'label' => '', 'code' => 'DNJOZTZX'],
            ["id" =>29, 'name' => 'maiduguri_tower', 'label' => '', 'code' => 'DNMAZTZX'],
            ["id" =>30, 'name' => 'kaduna_nafbase_tower', 'label' => '', 'code' => 'DN53ZTZX'],
            ["id" =>31, 'name' => 'zaria_tower', 'label' => '', 'code' => 'DNZAZTZX'],
            ["id" =>32, 'name' => 'bauchi_tafawa_tower', 'label' => '', 'code' => 'DNBCZTZX'],
            ["id" =>33, 'name' => 'bauchi_tower', 'label' => '', 'code' => 'DNBAZTZX'],
            ["id" =>34, 'name' => 'dutse_tower', 'label' => '', 'code' => 'DNDSZTZX'],
            ["id" =>35, 'name' => 'gusau_tower', 'label' => '', 'code' => 'DNGUZTZX'],
            ["id" =>36, 'name' => 'minna_tower', 'label' => '', 'code' => 'DNMNZTZX']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_tower');
    }
}
