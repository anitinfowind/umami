<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales_report extends Model
{
    //
    //public $timestamps = false;
    protected $table = 'sales_reports';

    protected $fillable = ['restaurant_id', 'from_date', 'to_date', 'amount'];
}
