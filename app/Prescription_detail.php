<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription_detail extends Model
{
  public $fillable = ['presc_id','drug_id','doseform','afya_user_id','dependant_id',
  'strength_unit','diagnosis','state','strength','routes','appointment_id','frequency','facility_id','created_at','updated_at'];

}
