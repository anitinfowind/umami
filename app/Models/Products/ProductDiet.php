<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use App\Models\Diet;
class ProductDiet extends Model
{
    protected $fillable = [
        'p_id',
        'diet_id',
    ];
    public function p_diet()
    {
        return $this->belongsTo(Diet::class, 'diet_id');
    } 
}
