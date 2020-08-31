<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model {

    protected $connection = "nhif";
    
    protected $fillable = [
        'hospital',
        'postal_address',
        'beds',
        'branch',
        'category'
    ];
}

 ?>
