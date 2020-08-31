<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable=['status','p_status', 'afya_user_id','filenumber','persontreated', 'appointment_date', 'appointment_time', 'doc_id', 'facility_id', 'visit_type', 'date_present', 'created_by_users_id', 'actual_visit_date', 'last_app_id'];
}
