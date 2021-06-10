<?php

namespace App\Models\Slider;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Slider\Traits\SliderAttribute;
use App\Models\Slider\Traits\SliderRelationship;

class Slider extends Model
{
    use ModelTrait,
        SliderAttribute,
    	SliderRelationship {
            // SliderAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'sliders';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
      'title',
      'description',
      'slider_image',
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
        $this->table = config('module.sliders.table');
    }
}
