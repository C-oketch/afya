<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Testpricexray extends Model
{
  protected $table = 'test_prices_xray';
public $fillable = ['tests_id','availability','amount','facility_id','user_id'];

}
