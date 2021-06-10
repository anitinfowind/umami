<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand\Brand;
class ProductBrand extends Model
{
    protected $fillable = [
        'p_id',
        'brand_id',
    ];
    public function p_brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
