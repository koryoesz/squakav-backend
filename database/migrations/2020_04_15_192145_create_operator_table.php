<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOperatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integerIncrements('id');
            $table->unsignedInteger("organisation_id");
            $table->unsignedSmallInteger("state_id");
            $table->unsignedSmallInteger("status_id")->default(1);
            $table->unsignedInteger('role_id');
            $table->string("email")->unique();
            $table->string("first_name");
            $table->string("last_name")->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('organisation_id')->references('id')->on('organisations');
        });

        DB::table('operators')->insert([
           'id' => 1, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Yomi', 'email' => 'british@email.com',
            'organisation_id' => 1, 'last_name' => 'Kolawole', 'avatar' => ''
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operators');
    }
}
