<?php

namespace App\Models\Categories;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\Traits\CategoryAttribute;
use App\Models\Categories\Traits\CategoryRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use ModelTrait,
        CategoryAttribute,
    	SoftDeletes,
        CategoryRelationship {
            //
        }


    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'is_active'
    ];

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
    public function slug()
    {
        return $this->slug;
    }
     public function scopeIsActive($query)
     {
       return $this->query()->where(['is_active' => ACTIVE, 'parent_id' => ZERO])->orderBy('name', 'ASC');
     }
}
