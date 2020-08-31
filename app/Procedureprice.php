<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Procedureprice extends Model
{
    protected $table = 'procedure_prices';
    public $fillable = ['procedure_id','availability','amount','facility_id','user_id'];

}
