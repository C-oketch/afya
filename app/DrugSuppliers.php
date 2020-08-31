<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class DrugSuppliers extends Model
{
    use Eloquence;

    protected $table = 'drug_suppliers';

    protected $searchableColumns = ['name','id'];
}
