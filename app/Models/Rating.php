<?php

namespace App\Models;
use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;
use App\Models\OrderDetail;
class Rating extends Model
{
    /**
     * @return mixed
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'rating',
        'comment',
        'type',
    ];

    public function product()
    {
    return $this->belongsTo(Product::class, 'product_id')
          ->with('singleProductImage');
    }
    
    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

     public function DetailProduct()
     {
      return $this->belongsTo(OrderDetail::class,'order_detail_id');
     }

}
