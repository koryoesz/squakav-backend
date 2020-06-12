<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAisUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ais_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->unsignedTinyInteger('user_type_id');
            $table->unsignedSmallInteger('state_id');
            $table->string('airport_name')->nullable();
            $table->string('username', 128);
            $table->string('email',128)->unique();
            $table->string('password');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('user_type_id')->references('id')->on('user_types');
        });
// password = admin
        DB::table('ais_users')->insert([
           ['id' => 1, 'state_id' => 24, 'airport_name' => 'murithala airport', 'username' => 'ais001', 'email' => 'ais001@gmail.com',
               'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6',
               'user_type_id' => 2
               ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ais_users');
    }
}
