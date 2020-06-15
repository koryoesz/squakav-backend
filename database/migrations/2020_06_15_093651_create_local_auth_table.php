<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLocalAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_auth', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedSmallInteger('status_id')->default(1);
            $table->unsignedTinyInteger('user_type_id');
            $table->unsignedInteger('user_id');
            $table->string('password');
            $table->dateTime('last_logged_in')->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('user_type_id')->references('id')->on('user_types');
        });

        DB::table('local_auth')->insert([
           'user_type_id' => 1, 'user_id' => 1, 'last_logged_in' => null,
            'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_auth');
    }
}
