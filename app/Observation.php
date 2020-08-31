<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Observation extends Model
{
    
     use Eloquence;
protected $searchableColumns = ['name'];
}
