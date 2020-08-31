<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Afya_user extends Model
{
    protected $table="afya_users";
    protected $casts = [
            'dob' => 'date',
        ];

    protected $fillable=['users_id', 'msisdn', 'firstname', 'secondName', 'gender', 'age', 'pin', 'status', 'id_doc', 'nationalId', 'nhif', 'blood_type', 'email', 'postal_address', 'postal_code', 'town', 'marital', 'dob', 'pob', 'occupation', 'kra_pin', 'constituency', 'insurance_company_id', 'policy_no', 'has_smartphone', 'file_no', 'created_by'];



}
