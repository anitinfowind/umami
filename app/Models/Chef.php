<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'name',
        'slug',
        'designation',
        'email',
        'description',
        'image',
        'status'
    ];

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getRestautentName()
    {
       return $this->hasOne(Restaurant::class,'id','restaurant_id')->with('UserSlug');
    }

    public function getRestautent()
    {
       return $this->hasOne(Restaurant::class,'id','restaurant_id')->with('restaurantLocation');
    }

}
