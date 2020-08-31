<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class OTHERIMAGING extends Model
{
  protected $table = 'test_prices_other';
public $fillable = ['other_id','availability','amount','facility_id','user_id'];

}
