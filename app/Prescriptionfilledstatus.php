<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Prescriptionfilledstatus extends Model
{
    protected $table = 'prescription_filled_status';
    public $fillable = ['presc_details_id', 'available', 'dose_given', 'dose_reason', 'substitute_presc_id', 'substitution_reason', 'quantity', 'price', 'total', 'payment_option', 'markup', 'start_date', 'end_date', 'outlet_id', 'submitted_by'];

}
