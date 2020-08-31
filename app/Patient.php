<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  public $fillable = ['firstname','lastname','gender','national_id','pin',
  'dob','age','mobileno','constituency_id','next_kin','relation_kin','phone_kin','current_weight','current_height','temperature',
  'systolic_bp','diastolic_bp','allergies','chief_compliant','observation'];
}
