<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
    ];
    
    public function image()
    {
        return isset($this->image) ? $this->image : '';
    }
}
