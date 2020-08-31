<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['firstname','lastname','gender','pin','age','mobileno','relation_kin',
                                'phone_kin','current_weight','current_height','temperature','systolic_bp',
                                'diastolic_bp','chief_compliant','observation','nurse_note',
                                'consulting_physician','prescription']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            //
        });
    }
}
