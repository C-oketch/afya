<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityAdmin extends Model
{
    protected $table = 'facility_admin';

    protected $primaryKey = "id";

    
	protected $fillable = [
    				'user_id',
    				'facilitycode'
    				];
}
