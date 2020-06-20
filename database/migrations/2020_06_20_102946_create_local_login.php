<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLocalLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('local_auth')->insert([
            ['user_type_id' => 1, 'user_id' => 2, 'last_logged_in' => null,
            'password' => '$2y$12$D947C0MX/9.ZT7j4aifphunrO3g3GASy16d9D94pN4LP3vZhINWB6'],
            ['user_type_id' => 1, 'user_id' => 3, 'last_logged_in' => null,
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
        Schema::dropIfExists('local_login');
    }
}
