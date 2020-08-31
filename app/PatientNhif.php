<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientNhif extends Model
{
    protected $table="patient_nhif";
    protected $fillable=['afya_user_id','employer_code','employer_name','employer_pin','nearest_branch',
  ];
}
