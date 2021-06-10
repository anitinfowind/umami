<?php

namespace App\Models\Subscription;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription\Traits\SubscriptionAttribute;
use App\Models\Subscription\Traits\SubscriptionRelationship;

class Subscription extends Model
{
    use ModelTrait,
        SubscriptionAttribute,
    	SubscriptionRelationship {
            // SubscriptionAttribute::getEditButtonAttribute insteadof ModelTrait;
        }


    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
      'id',
      'title',
      'slug',
      'shipping_type',
      'description',
      'price',
      'discount',
      'more_detail',
      'shipping_detail',
      'payment_type',
      'month',
    ];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * Dates
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Constructor of Model
     * @param array $attributes
     */
    public function subscriptionImage()
    {
      return $this->hasOne(SubscriptionImage::class);
    }
}
