<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
class Facility extends Model
{

use Eloquence;

protected $searchableColumns = ['FacilityName'];

  public $fillable = [
'FacilityCode','FacilityName','registration_no','KEPHLevel','Type','Owner','regulatory_body','Beds',
'Cots','County','Constituency','sub_county','Ward','OperationalStatus','Open24Hours','OpenPublicHolidays',
'OpenWeekends','OpenLateNight','Approved','PublicVisible','closed'];
}
