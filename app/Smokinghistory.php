<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smokinghistory extends Model
{
    protected $table="smoking_history";

    protected $fillable=['afya_user_id', 'smoker', 'cigarretes_per_day', 'ever_smoked', 'stop_date', 'period_smoked'];
}
