<?php

namespace App\Models\Products;

use App\Models\Categories\Category;
use App\Models\Diet;
use App\Models\Order;
use App\Models\Favorite;
use App\Models\Region;
use App\Models\Rating;
use App\Models\Products\ProductCategorys;
use App\Models\Products\ProductBrand;
use App\Models\Products\ProductDiet;
use App\Models\Brand\Brand;
use App\Models\Restaurant\Restaurant;
use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Product_review;

class Product extends Model
{
    use SoftDeletes;
 
    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
      'user_id',
      'restaurant_id',
      'category_id',
      'brand_id',
      'diet_id',
      'region_id',
      'order_cat_id',
      'order_no',
      'title',
      'slug',
      'serving_for',
      'description',
      'price',
      'discount',
      'quantity',
      'remaining_quantity',
      'shipping_type',
      'shipping_price',
      'attribute_id',
      'ingredients',
      'nutrition',
      'details',
      'reward'
    ];

    /**
     * @param string $value
     * @return string
     */
    public function setTitleAttribute(string $value)
    {
        return $this->attributes['title'] =  ucfirst($value);
    }

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
    public function restaurantId()
    {
        return $this->restaurant_id;
    }

    /**
     * @return mixed
     */
    public function categoryId()
    {
        return $this->category_id;
    }

    /**
     * @return mixed
     */
    public function brandId()
    {
        return $this->brand_id;
    }

    /**
     * @return mixed
     */
    public function dietId()
    {
        return $this->diet_id;
    }

    /**
     * @return mixed
     */
    public function regionId()
    {
        return $this->region_id;
    }

    /**
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function serving_for()
    {
        return $this->serving_for;
    }

    /**
     * @return mixed
     */
    public function description()
    {
        return nl2br($this->description);
    }
	
	/**
     * @return mixed
     */
    public function ingredients()
    {
        return nl2br($this->ingredients);
    }
	
	/**
     * @return mixed
     */
    public function nutrition()
    {
        return nl2br($this->nutrition);
    }
	
	/**
     * @return mixed
     */
    public function details()
    {
        return nl2br($this->details);
    }

    /**
     * @return mixed
     */
    public function price()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function discount()
    {
        return isset($this->discount) ? $this->discount : '';
    }

    /**
     * @return mixed
     */
    public function quantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function remainingQuantity()
    {
        return $this->remaining_quantity;
    }

    /**
     * @return mixed
     */
    public function shippingType()
    {
        return $this->shipping_type;
    }

    /**
     * @return mixed
     */
    public function shippingPrice()
    {
        return isset($this->shipping_price) ? $this->shipping_price : '';
    }
	
	/**
     * @return mixed
     */
    public function attributeId()
    {
        return isset($this->attribute_id) ? $this->attribute_id : '';
    }

    /**
     * @return HasMany
    */
    public function productImage() : HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @return HasOne
     */
    public function singleProductImage() : HasOne
    {
        return $this->hasOne(ProductImage::class);
    }

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
      /**
     * @return hasMany
     */
    public function ppcategory() : HasOne
    {
        return $this->hasOne(ProductCategorys::class,'p_id');
    }

      /**
     * @return hasMany
     */
    public function ppdiet() : HasOne
    {
        return $this->hasOne(ProductDiet::class,'p_id');
    }

    /**
     * @return BelongsTo
     */
    public function diet() : BelongsTo
    {
        return $this->belongsTo(Diet::class);
    }

    /**
     * @return BelongsTo
     */
    public function region() : BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
        /**
     * @return BelongsTo
     */
    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    /**
     * @return BelongsTo
     */
    public function favorite() : HasOne
    {
        return $this->hasOne(Favorite::class, 'product_id');
    }
      /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

      /**
     * @return BelongsTo
     */
    public function restaurant() : BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
	
	/**
     * @return HasOne
     */
    public function order() : HasOne
    {
		return $this->hasOne(Order::class)
				->where('user_id', auth()->user()->id)
				->where('order_id', null);
    }
    public function rating()
    {
      return $this->hasOne(Rating::class);
    }

       /**
     * @return HasMany
     */
    public function pCategory() : HasMany
    {
        return $this->hasMany(ProductCategorys::class,'p_id')->with('p_category');
    }

    /**
     * @return HasMany
     */
    public function pBrand() : HasMany
    {
        return $this->hasMany(ProductBrand::class,'p_id')->with('p_brand');
    }
     /**
     * @return HasMany
     */
    public function pdiet() : HasMany
    {
        return $this->hasMany(ProductDiet::class,'p_id')->with('p_diet');
    }

    public static function check_availability($params = []) {
        $product_id = $params['product_id'];
        $with_qty = $params['with_qty'];
        $return_avlqty = $params['return_avlqty'] ?? false;
        $return = false;
        $avlqty = '';
        $pd = self::find($product_id);
        if($pd->sold_out == '0') {
            if($pd->daily_limit == '') {
                $return = true;
            } else {
                $order = DB::table('orders')->select('od.quantity')->leftJoin('order_details as od', 'od.order_id', 'orders.id')->where('orders.order_date', date('Y-m-d'))->whereNotNull('orders.order_id')->where('od.product_id', $product_id)->get();
                $total_ordered = 0;
                foreach ($order as $key => $value) {
                    $total_ordered += $value->quantity;
                }
                $avlqty = ($pd->daily_limit - $total_ordered);
                if($pd->daily_limit >= ($total_ordered + $with_qty)) $return = true;
            }
        } else {
            $avlqty = 0;
        }
        if($return_avlqty)
            return ['avlqty' => $avlqty];
        else
            return $return;
    }

    public function product_reviews()
    {
      return $this->hasMany(Product_review::class, 'product_id');
    }

    public function avgRating()
    {
        return $this->product_reviews()
          ->selectRaw('avg(rate_food) as avg_rate,product_id')
          ->where('status', '1')
          ->groupBy('product_id');
    }

    public function totalRating()
    {
        return $this->product_reviews()
          ->selectRaw('count(rate_food) as count_rate, product_id')
          ->where('status', '1')
          ->groupBy('product_id');
    }

    
}
