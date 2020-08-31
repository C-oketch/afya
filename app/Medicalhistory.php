<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicalhistory extends Model
{
    protected $table='self_reported_medical_history';

    protected $fillable=['afya_user_id', 'appointment_id', 'name', 'status'];
}
