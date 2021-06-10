<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Products\Product;
use App\Models\Access\User\User;
use App\Models\Order;

class Restaurant extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'preparation_day',
        'delivery_day',
        'order_time',
        'shipping_info',
        'ups_account_no',
        'is_active',
    ];

    /**
     * @param string $value
     * @return string
     */
    public function setNameAttribute(string $value)
    {
        return $this->attributes['name'] =  ucfirst($value);
    }

    /**
     * @return mixed|string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed|string
     */
    public function name()
    {
        return isset($this->name) ? $this->name : '';
    }

    /**
     * @return mixed|string
     */
    public function userId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed|string
     */
    public function slug()
    {
        return $this->slug;
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsApproved($query)
    {
        return $query->where('is_active', APPROVED)->orderBy('created_at', 'desc');
    }

    /**
     * @return HasOne
     */
    public function  restaurantSingleImage() : HasOne
    {
        return $this->hasOne(RestaurantImage::class,'user_id', 'user_id')->orderBy('created_at', 'desc');
    }

    public function restaurantBranch()
    {
        return $this->hasOne(RestaurantBranch::class);
    }

    public function restaurantLocation()
    {
        return $this->hasOne(RestaurantLocation::class)->with('withCity');
    }

        public function UserSlug()
    {
         return $this->belongsTo(User::class,'user_id','id');
    }
	
	/**
     * @return HasMany
     */
    public function product() : HasMany
    {
        return $this->hasMany(Product::class,'restaurant_id')->with('singleProductImage','rating');
    }

    public static function total_ratings($restaurant_id) {
        return Restaurant::leftJoin('products as p', 'p.restaurant_id', 'restaurants.id')->leftJoin('product_reviews as pr', 'pr.product_id', 'p.id')->where('restaurants.id', $restaurant_id)->where('p.product_admin_status', '1')->where('pr.status', '1')->count();
    }

    public static function avg_ratings($restaurant_id) {
        return Restaurant::leftJoin('products as p', 'p.restaurant_id', 'restaurants.id')->leftJoin('product_reviews as pr', 'pr.product_id', 'p.id')->where('restaurants.id', $restaurant_id)->where('p.product_admin_status', '1')->where('pr.status', '1')->avg('pr.rate_food');
    }

    /*public function order()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }*/
}
