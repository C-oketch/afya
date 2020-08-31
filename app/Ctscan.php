<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Ctscan extends Model
{
    protected $table = 'test_prices_ct_scan';
    public $fillable = ['ct_scan_id','availability','amount','facility_id','user_id'];

}
