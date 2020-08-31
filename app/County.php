<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class County extends Model
{
     protected $table = 'constituency';
  use Eloquence;
   protected $searchableColumns = ['Constituency'];
  
}
