<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class NhifEmployer extends Model {

    protected $connection = "nhif";
    
    protected $fillable = [
        'user_id',
        'registration_cert_number',
        'organisation_name',
        'kra_pin',
        'road',
        'building',
        'no_of_emp',
        'business_type',
        'sector',
        'category',
        'sub_category',
        'pin_document',
    ];
}

 ?>
