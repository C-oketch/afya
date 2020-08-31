<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

//<<<<<<< HEAD
//class NhifEmployee extends Model {
//=======
class NhifEmployee extends Model {
//>>>>>>> 5f197f537fcdc35b9a1e65a3a4dcd505fa6e3ca3

    protected $connection = "nhif";
    
    protected $fillable = [
        'user_id',
        'employer_code',
        'employer_name',
        'employer_pin',
        'id_type',
        'id_number',
        'id_serial_number',
        'first_name',
        'other_name',
        'dob',
        'gender',
        'marital_status',
        'passport',
    ];
}

?>
