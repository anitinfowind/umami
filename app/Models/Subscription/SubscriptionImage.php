<?php

namespace App\Models\Subscription;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class SubscriptionImage extends Model
{
  
    

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
      'id',
      'subscription_id',
      'image',

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

  


}
