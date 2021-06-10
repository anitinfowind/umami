<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales_report_payment extends Model
{
    //
    public $timestamps = false;
    protected $table = 'sales_report_payments';

    protected $fillable = ['sales_report_id', 'payment_history_id', 'status', 'amount'];
}
