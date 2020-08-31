<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medhistory extends Model
{
    protected $table="self_reported_medication";

    protected $fillable=['med_date', 'afya_user_id', 'drug_id'];
}
