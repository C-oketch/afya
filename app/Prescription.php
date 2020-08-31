<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
  public $fillable = ['appointment_id','doc_id','patient_id',
  'filled_status','created_at','updated_at'];

}
