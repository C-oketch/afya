<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model {

    protected $connection = 'nhif';
    
    protected $fillable = [
        'county',
        'offices',
        'office_location',
        'address',
        'telephone'
    ];
}

 ?>
