<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaccinesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('immunization', function (Blueprint $table) {
            $table->increments('id');
            $table->string('disease');
            $table->string('antigen');
            $table->integer('age');
            $table->string('date');
            $table->string('dateofguideline')->nullable();
            $table->string('status');
            $table->string('vaccine_name');
            
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
        Schema::drop('immunization');    }
}
