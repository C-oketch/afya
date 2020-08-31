<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surgicalprocedures extends Model
{
    protected $table="self_reported_surgical_procedures";
    protected $fillable=['afya_user_id', 'name_of_surgery', 'surgery_date'];
}
