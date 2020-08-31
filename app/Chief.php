<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;


class Chief extends Model
{
    use Eloquence;
     protected $table = 'symptoms';
protected $searchableColumns = ['name'];
}
