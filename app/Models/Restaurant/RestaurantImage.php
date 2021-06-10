<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'image'
    ];

    /**
     * @return mixed|string
     */
    public function image()
    {
        return isset($this->image) ? $this->image : '';
    }

    public function id()
    {
        return $this->id;
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
}
