<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active'
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

    public function createdAt()
    {
       return Carbon::parse($this->created_at)->format('d-M-Y');
    }

     public function updatedAt()
    {
       return Carbon::parse($this->updated_at)->format('d-M-Y');
    }

    /**
     * @param string $value
     * @return string
     */
    public function setNameAttribute(string $value)
    {
        return $this->attributes['name'] =  ucfirst($value);
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsActiveProductAttribute($query)
    {
        return  $this->query()->where('is_active', ACTIVE)
            ->orderBy('name', 'ASC');
    }
}
