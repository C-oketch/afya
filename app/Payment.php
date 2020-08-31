<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   
    
	protected $fillable = [
    				'user_id',
    				'payments_category_id',
    				'test_id',
    				'procedure_id',
    				'prescription_id'
    				];
}

