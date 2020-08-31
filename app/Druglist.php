<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Druglist extends Model
{

use Eloquence;
protected $table = 'druglists';
protected $searchableColumns = ['drugname'];

  public function manufacturer()
  {
     return $this->belongsTo('App\Manufacturer'); //Profile is your profile model
  }
  
}
