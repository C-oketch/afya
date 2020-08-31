<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKinDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kin_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kin_name');
            $table->integer('relation');
            $table->string('phone_of_kin');
            $table->bigInteger('afya_user_id')->unsigned();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('kin_details');
    }
}
