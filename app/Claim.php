<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $table="claims";
    protected $fillable=['nhif', 'procedure_code', 'facility_id', 'doc_co_id', 'cost','treatment'];
}
