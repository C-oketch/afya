<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class NhifUser extends Model {

    protected $connection = "nhif";
    
    protected $fillable = [
        'afyapepe_user',
        'type',
        'po_box',
        'postal_code',
        'postal_address',
        'telephone_number',
        'email',
        'town',
        'county',
        'nearest_nhif',
        'id_document',
    ];
}

 ?>
