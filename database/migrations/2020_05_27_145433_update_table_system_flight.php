<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableSystemFlight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_flights', function (Blueprint $table) {
//            $table->renameColumn('modified_at', 'updated_at');
            $table->addColumn('date', 'date', ['default' => '2020/05/20']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_flights', function (Blueprint $table) {
            //
        });
    }
}
