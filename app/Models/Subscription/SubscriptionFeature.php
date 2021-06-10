<?php

namespace App\Models\Subscription;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription\Traits\SubscriptionAttribute;
use App\Models\Subscription\Traits\SubscriptionRelationship;

class SubscriptionFeature extends Model
{
    use ModelTrait,
        SubscriptionAttribute,
    	SubscriptionRelationship {
            // SubscriptionAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'subscription_plan_months';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
      'title',
      'description',
      'status',

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
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

     public function getplan()
     {
      return $this->hasOne('App\Models\Subscription\Subscription','id','subscription_plan_id');
     }
}
