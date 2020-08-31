<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Testpricemri extends Model
{
    protected $table = 'test_prices_mri';
    public $fillable = ['mri_id','name','availability','amount','facility_id','user_id'];

}
