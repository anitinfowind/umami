<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;
use App\Models\Rating;

class OrderDetail extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'order_id',
        'product_id',
        'price',
        'quantity',
        'pay_order_id',
        'vendor_name',
        'order_detail_date',
        'total',
        'included_shipping_price'
    ];

    public function id()
    {
        return $this->id;
    }

	public function price()
    {
        return CURRENCY. number_format($this->price, 2);
    }

	public function quantity()
    {
        return $this->quantity;
    }

	public function total()
    {
        return CURRENCY. number_format($this->total, 2);
    }

    public function product()
    {
    return $this->belongsTo(Product::class, 'product_id')
          ->with('singleProductImage');
    }

    public function ratingData()
    {
      return $this->hasMany(Rating::class, 'order_detail_id');
    }
}
