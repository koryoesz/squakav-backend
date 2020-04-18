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
(1, 1, 'active', 'Active'),
(2, 1, 'inactive', 'Inactive'),
(3, 1, 'removed', 'Removed');
        ";

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
