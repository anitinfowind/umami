<?php

namespace App\Models\Restaurant;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantBranch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'phone',
        'background_image',
        'description',
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
     * @return mixed|string
     */
    public function phone()
    {
        return isset($this->phone) ? $this->phone : '';
    }

    /**
     * @return mixed|string
     */
    public function description()
    {
        return isset($this->description) ? $this->description : '';
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function restaurantLocation() : HasOne
    {
        return $this->hasOne(RestaurantLocation::class, 'user_id', 'user_id');
    }

    public function restaurantName() : HasOne
    {
        return $this->hasOne(Restaurant::class, 'user_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function restaurantCategory() : HasMany
    {
        return $this->hasMany(RestaurantCategory::class,'user_id', 'user_id')->with('category');
    }

    /**
     * @return HasMany
     */
    public function restaurantServiceType() : HasMany
    {
        return $this->hasMany(RestaurantServiceType::class,'user_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function  restaurantTime() : HasMany
    {
        return $this->hasMany(RestaurantTime::class,'user_id', 'user_id')->orderBy('day', 'asc');;
    }

    /**
     * @return HasMany
     */
    public function  restaurantImage() : HasMany
    {
        return $this->hasMany(RestaurantImage::class,'user_id', 'user_id');
    }
}
