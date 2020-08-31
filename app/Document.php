<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
   protected $table = 'radiology_images';
  public $fillable = ['radiology_td_id','image'];


}
