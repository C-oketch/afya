<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Disease extends Model
{

  use Eloquence;
  protected $table = 'icd10_option';
  protected $searchableColumns = ['name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','subblock','name'];
}
