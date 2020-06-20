<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('operators')->insert([
            [
            'id' => 2, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Ben', 'email' => 'ben@email.com',
            'organisation_id' => 1, 'last_name' => 'Onogwu', 'avatar' => ''],
            [
                'id' => 3, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Clinton', 'email' => 'clinton@email.com',
                'organisation_id' => 1, 'last_name' => 'Okene', 'avatar' => '']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
