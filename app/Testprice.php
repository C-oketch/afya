<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Testprice extends Model
{
    protected $table = 'test_price';
    public $fillable = ['tests_id','availability','amount','facility_id','user_id'];

}
