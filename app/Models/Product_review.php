<?php

namespace App\Models;
use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;
use App\Models\OrderDetail;
use App\Models\Product_review;
class Product_review extends Model
{
    /**
     * @return mixed
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'rate_food',
        'rate_shipping',
        'rate_packaging',
        'rate_instructions',
        'comment',
        'status'
    ];

    public function product()
    {
    return $this->belongsTo(Product::class, 'product_id')
          ->with('singleProductImage', 'restaurant');
    }
    
    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }


}
