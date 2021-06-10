<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;

class ProductVariants extends Model
{
    protected $fillable = [
        'product_id',
        'variant_name',
        'price',
    ];

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

     public function productId()
    {
        return $this->product_id;
    }


    public function variant_name()
    {
        return $this->variant_name;
    }

    public function price()
    {
       return $this->price;
    }


    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->status;
    }

    public function createdAt()
    {
       return Carbon::parse($this->created_at)->format('d-M-Y');
    }

     public function updatedAt()
    {
       return Carbon::parse($this->updated_at)->format('d-M-Y');
    }

    /**
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


 
    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
   /* public function scopeIsActiveProductAttribute($query)
    {
        return  $this->query()->where('is_active', ACTIVE)
            ->orderBy('name', 'ASC');
    }*/
}

