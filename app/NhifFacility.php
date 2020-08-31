<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhifFacility extends Model
{
    protected $table="nhif_facilities";
    protected $fillable=['facility_id','status'];
}
