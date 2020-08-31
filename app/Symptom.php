<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Symptom extends Model
{
      use Eloquence;
protected $searchableColumns = ['name'];
}
