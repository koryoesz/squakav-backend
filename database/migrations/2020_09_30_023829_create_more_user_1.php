<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use App\Models\UserType;

class CreateMoreUser1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('ais')->insert([

            [
                'id' => 7, 'state_id' => State::KANO, 'role_id' => 1, 'first_name' => 'Mr',
                'last_name' => 'Clinton', 'avatar' => '', 'system_airport_id' => 20,
                'email' => 'clintonaiskano@email.com']
        ]);

        DB::table('towers')->insert([

            [
                'id' => 7, 'state_id' => State::KANO, 'role_id' => 1, 'first_name' => 'Mr',
                'last_name' => 'Clinton', 'avatar' => '', 'system_airport_id' => 20,
                'email' => 'clintontowerkano@email.com']
        ]);


        DB::table('local_auth')->insert([

            ['user_type_id' => UserType::TYPE_AIS, 'user_id' => 7, 'last_logged_in' => null,
                'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'],

            ['user_type_id' => UserType::TYPE_TOWER, 'user_id' => 7, 'last_logged_in' => null,
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
