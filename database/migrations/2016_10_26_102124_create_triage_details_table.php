<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triage_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('current_weight');
            $table->integer('current_height');
            $table->integer('temperature');
            $table->integer('systolic_bp');
            $table->integer('diastolic_bp');
            $table->string('chief_compliant');
            $table->string('observation');
            $table->integer('consulting_physician');
            $table->string('prescription');
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
        Schema::drop('triage_details');
    }
}
