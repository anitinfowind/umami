<?php

namespace App\Models\Brand;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'name',
      'slug',
      'image',
      'description',
      'is_active'
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
        return isset($this->name) ? $this->name : '';
    }

    /**
     * @return mixed
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function description()
    {
        return isset($this->description) ? $this->description : '';
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->is_active;
    }

    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('d-M-Y');
    }

    public function updatedAt()
    {
        return Carbon::parse($this->updated_at)->format('d-M-Y');
    }

     public function scopeIsActiveBrand($query)
     {
       return $this->query()->where('is_active', ACTIVE)->orderBy('name', 'ASC');
     }
}
