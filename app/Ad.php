<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table="ads";

    protected $fillable=['user_id','ad_name','ad_video','drug_id'];
}
