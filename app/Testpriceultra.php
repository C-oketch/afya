<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Testpriceultra extends Model
{
    protected $table = 'test_prices_ultrasound';
    public $fillable = ['ultrasound_id','name','availability','amount','facility_id','user_id'];

}
