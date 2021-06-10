<?php

namespace App\Models\Restaurant;

use App\Models\Categories\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantCategory extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'category_id'
    ];

    /**
     * @return mixed|string
     */
    public function id()
    {
        return isset($this->id) ? $this->id : '';
    }

    /**
     * @return mixed|string
     */
    public function userId()
    {
        return isset($this->user_id) ? $this->user_id : '';
    }

    /**
     * @return mixed|string
     */
    public function restaurantId()
    {
        return isset($this->restaurant_id) ? $this->restaurant_id : '';
    }

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
