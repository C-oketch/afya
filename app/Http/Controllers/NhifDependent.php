<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class NhifDependent extends Model {

    protected $connection = "nhif";
    
    protected $fillable = [
        'principal',
        'dob',
        'surname',
        'phone',
        'othername',
        'code',
        'identification',
        'gender',    
        'id_document',    
        'passport',    
    ];
}

 ?>
