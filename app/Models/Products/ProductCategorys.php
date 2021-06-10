<?php

namespace App\Models\Products;
use App\Models\Categories\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCategorys extends Model
{
    protected $fillable = [
        'p_id',
        'category_id',
    ];



    public function p_category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
