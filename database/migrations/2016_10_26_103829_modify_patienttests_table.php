<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPatienttestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patienttests', function (Blueprint $table) {
            $table->dropColumn(['test_id','patient_id','facility_code']);
            $table->integer('appointment_id');
            $table->integer('triage_id');
            $table->string('test_status');
            $table->string('tests_recommended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patienttests', function (Blueprint $table) {
            //
        });
    }
}
