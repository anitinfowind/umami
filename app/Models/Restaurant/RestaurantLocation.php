<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;

class RestaurantLocation extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'location',
        'country',
        'state',
        'city',
        'zip_code',
        'latitude',
        'longitude'
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
     * @param string $value
     * @return string
     */
    public function setCountryAttribute(string $value)
    {
        return $this->attributes['country'] =  ucfirst($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public function setStateAttribute(string $value)
    {
        return $this->attributes['state'] =  ucfirst($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public function setCityAttribute(string $value)
    {
        return $this->attributes['city'] =  ucfirst($value);
    }

    /**
     * @return mixed|string
     */
    public function location()
    {
        return isset($this->location) ? $this->location : '';
    }

    /**
     * @return mixed|string
     */
    public function country()
    {
        return isset($this->country) ? $this->country : '';
    }

    /**
     * @return mixed|string
     */
    public function state()
    {
        return isset($this->state) ? $this->state : '';
    }

    /**
     * @return mixed|string
     */
    public function city()
    {
        return isset($this->city) ? $this->city : '';
    }

    /**
     * @return mixed|string
     */
    public function latitude()
    {
        return isset($this->latitude) ? $this->latitude : '';
    }

    /**
     * @return mixed|string
     */
    public function longitude()
    {
        return isset($this->longitude) ? $this->longitude : '';
    }

    /**
     * @return mixed|string
     */
    public function zipCode()
    {
        return isset($this->zip_code) ? $this->zip_code : '';
    }

    public function withCity()
    {
        return $this->hasOne(City::class, 'name', 'city');
    }
}
