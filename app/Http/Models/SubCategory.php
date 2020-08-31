<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {

    protected $connection = "nhif";
    
    protected $fillable = [
        'name'
    ];
}

 ?>
