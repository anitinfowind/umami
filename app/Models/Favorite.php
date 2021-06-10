<?php

namespace App\Models;

use App\Models\Access\User\User;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable =[
        'user_id',
        'product_id'
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
      return $this->belongsTo(Product::class, 'product_id')
          ->with('category', 'diet', 'region', 'singleProductImage');
    }
}
