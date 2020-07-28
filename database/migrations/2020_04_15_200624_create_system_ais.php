<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemAis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_ais', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->string('name', 100)->nullable();
            $table->string('label', 100)->nullable();
            $table->string("code", 100);
            $table->timestamps();
        });

        DB::table('system_ais')->insert([
            ["id" => 1, 'name' => 'lagos_ais', 'label' => '', 'code' => 'DNMMZPZX'],
            ["id" => 2, 'name' => 'portharcourt_international_ais', 'label' => '', 'code' => 'DNPOZPZX'],
            ["id" => 3, 'name' => 'calabar_ais', 'label' => '', 'code' => 'DNCAZPZX'],
            ["id" => 4, 'name' => 'ilorin_ais', 'label' => '', 'code' => 'DNILZPZX'],
            ["id" =>5, 'name' => 'akure_ais', 'label' => '', 'code' => 'DNAKZPZX'],
            ["id" =>6, 'name' => 'ibadan_ais', 'label' => '', 'code' => 'DNIBZPZX'],
            ["id" =>7, 'name' => 'enugu_ais', 'label' => '', 'code' => 'DNENZPZX'],
            ["id" =>8, 'name' => 'osubi_ais', 'label' => '', 'code' => 'DNSUZPZX'],
            ["id" =>9, 'name' => 'asaba_ais', 'label' => '', 'code' => 'DNASZPZX'],
            ["id" =>10, 'name' => 'escravos_ais', 'label' => '', 'code' => 'DNESZPZX'],
            ["id" =>11, 'name' => 'owerri_ais', 'label' => '', 'code' => 'DNIMZPZX'],
            ["id" =>12, 'name' => 'akwaibom_ais', 'label' => '', 'code' => 'DNAIZPZX'],
            ["id" =>13, 'name' => 'eket_ais', 'label' => '', 'code' => 'DNEKZPZX'],
            ["id" =>14, 'name' => 'yenagoa_ais', 'label' => '', 'code' => 'DNBYZPZX'],
            ["id" =>15, 'name' => 'benin_ais', 'label' => '', 'code' => 'DNBEZPZX'],
            ["id" =>16, 'name' => 'finima_ais', 'label' => '', 'code' => 'DNFBZPZX'],
            ["id" =>17, 'name' => 'bebbi_ais', 'label' => '', 'code' => 'DNBBZPZX'],
            ["id" =>18, 'name' => 'portharcourt_nafbase_ais', 'label' => '', 'code' => 'DNPMZPZX'],
            ["id" =>19, 'name' => 'abuja_ais', 'label' => '', 'code' => 'DNAAZPZX'],
            ["id" =>20, 'name' => 'kano_ais', 'label' => '', 'code' => 'DNKNZPZX'],
            ["id" =>21, 'name' => 'kaduna_ais', 'label' => '', 'code' => 'DNKAZPZX'],
            ["id" =>22, 'name' => 'katsina_ais', 'label' => '', 'code' => 'DNKTZPZX'],
            ["id" =>23, 'name' => 'gombe_ais', 'label' => '', 'code' => 'DNGOZPZX'],
            ["id" =>24, 'name' => 'kebbi_ais', 'label' => '', 'code' => 'DNBKZPZX'],
            ["id" =>25, 'name' => 'makurdi_ais', 'label' => '', 'code' => 'DNMKZPZX'],
            ["id" =>26, 'name' => 'yola_ais', 'label' => '', 'code' => 'DNYOZPZX'],
            ["id" =>27, 'name' => 'sokoto_ais', 'label' => '', 'code' => 'DNSOZPZX'],
            ["id" =>28, 'name' => 'jos_ais', 'label' => '', 'code' => 'DNJOZPZX'],
            ["id" =>29, 'name' => 'maiduguri_ais', 'label' => '', 'code' => 'DNMAZPZX'],
            ["id" =>30, 'name' => 'kaduna_nafbase_ais', 'label' => '', 'code' => 'DN53ZPZX'],
            ["id" =>31, 'name' => 'zaria_ais', 'label' => '', 'code' => 'DNZAZPZX'],
            ["id" =>32, 'name' => 'bauchi_tafawa_ais', 'label' => '', 'code' => 'DNBCZTZX'],
            ["id" =>33, 'name' => 'bauchi_ais', 'label' => '', 'code' => 'DNBCZPZX'],
            ["id" =>34, 'name' => 'dutse_ais', 'label' => '', 'code' => 'DNDSZPZX'],
            ["id" =>35, 'name' => 'gusau_ais', 'label' => '', 'code' => 'DNGUZPZX'],
            ["id" =>36, 'name' => 'minna_ais', 'label' => '', 'code' => 'DNMNZPZX']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_ais');
    }
}
