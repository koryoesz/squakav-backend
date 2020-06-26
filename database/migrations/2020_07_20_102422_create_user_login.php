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
                'id' => 1, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Yomi', 'email' => 'yomi@email.com',
                'organisation_id' => 1, 'last_name' => 'Kolawole', 'avatar' => ''],
            [
            'id' => 2, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Ben', 'email' => 'ben@email.com',
            'organisation_id' => 1, 'last_name' => 'Onogwu', 'avatar' => ''],
            [
                'id' => 3, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Clinton', 'email' => 'clinton@email.com',
                'organisation_id' => 1, 'last_name' => 'Okene', 'avatar' => '']
        ]);

        DB::table('ais')->insert([
            [
            'id' => 1, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Ben',
            'last_name' => 'Onogwu', 'avatar' => 'empty', 'system_airport_id' => 1,
            'email' => 'benais@email.com'],
            [
                'id' => 2, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Yomi',
                'last_name' => 'Kolawole', 'avatar' => 'empty', 'system_airport_id' => 1,
                'email' => 'yomiais@email.com'],

            [
            'id' => 3, 'state_id' => 24, 'role_id' => 1, 'first_name' => 'Clinton',
            'last_name' => 'Okene', 'avatar' => 'empty', 'system_airport_id' => 1,
            'email' => 'clintonais@email.com']
        ]);

        DB::table('local_auth')->insert([
            ['user_type_id' => 1, 'user_id' => 1, 'last_logged_in' => null,
                'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'],
            ['user_type_id' => 1, 'user_id' => 2, 'last_logged_in' => null,
                'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'],
            ['user_type_id' => 1, 'user_id' => 3, 'last_logged_in' => null,
                'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'],
            ['user_type_id' => 2, 'user_id' => 1, 'last_logged_in' => null,
                'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'],
            ['user_type_id' => 2, 'user_id' => 2, 'last_logged_in' => null,
                'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'],
            ['user_type_id' => 2, 'user_id' => 3, 'last_logged_in' => null,
            'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6']

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
