<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityFinance extends Model
{
    protected $table = 'facility_finance';

    protected $primaryKey = "id";

    
	protected $fillable = [
    				'user_id',
    				'facilitycode'
    				];
}

