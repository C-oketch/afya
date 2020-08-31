<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Nicolaslopezj\Searchable\SearchableTrait;
use Sofa\Eloquence\Eloquence;


class Inventory extends Model
{
    //use SearchableTrait;
    use Eloquence;
    protected $table = 'inventory';

    protected $searchableColumns = ['drugname','drug_id'];
}
