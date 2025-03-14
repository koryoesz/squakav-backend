<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_types', function (Blueprint $table){
            $table->engine = 'InnoDB';

            $table->tinyIncrements('id');
            $table->string('name', 128);
        });

        $sql = "INSERT INTO status_types (`id`,`name`) VALUES (1, 'General'), (2, 'Auth');";
        DB::connection()->getPDO()->exec($sql);


        Schema::create('status', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->smallIncrements('id');
            $table->tinyInteger('type_id')->unsigned();
            $table->string('name', 128);
            $table->string('label', 128);
        });


        $sql = "
INSERT INTO status (`id`,`type_id`,`name`,`label`) 
VALUES 
(1, 1, 'fight_active', 'Flight Active'),
(2, 1, 'flight_inactive', 'Flight Inactive'),
(3, 1, 'flight_removed', 'Flight Removed'),
(4, 1, 'flight_approved', 'Flight Approved'),
(5, 1, 'flight_declined', 'Flight Declined'),
(6, 1, 'flight_drafted', 'Flight Drafted'),
(7, 1, 'flight_resent', 'Flight Resent');";

        DB::connection()->getPDO()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
        Schema::dropIfExists('status_types');
    }
}
