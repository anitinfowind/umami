<?php

namespace App\Models;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Restaurant\Restaurant;

class PaymentHistory extends Model
{
    protected $table = 'payment_history';

    protected $fillable = [
        'amount',
        'tax_ammount',
        'transaction_id',
        'charge_id',
        'order_id',
        'stripe_customer_id',
        'user_id',
        'payment_date',
        'sales_deduction',
        'sales_deduction_info',
        'refund_id',
        'refund_amount',
        'refund_info'
    ];

     public function saleReport()
     {
      return $this->hasMany(OrderDetail::class,'pay_order_id','order_id')->where('payment_status','1');
     }
	 public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
      return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function restaurant()
    {
      return $this->belongsTo(Restaurant::class, 'vendor_id', 'user_id');
    }

}
