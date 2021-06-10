<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class RestaurantTime extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'day',
        'open',
        'close',
        'status'
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
}
