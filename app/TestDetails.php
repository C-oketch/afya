<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class TestDetails extends Model
{
  protected $table = 'test_details';
  use Eloquence;
   protected $searchableColumns = ['test_name'];
   public $fillable = ['test_name'];

}
