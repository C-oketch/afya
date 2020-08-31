<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alcoholhistory extends Model
{
    protected $table="alcohol_drug_history";

    protected $fillable=['afya_user_id', 'drink', 'drinking_frequency', 'used_recreational_drugs', 'drug_type', 'caffeine_liquids'];
}
