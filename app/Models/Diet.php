<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
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

    /**
     * @return string
     */
    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('d-M-Y');
    }

    /**
     * @return string
     */
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
    public function scopeIsActiveDiet($query)
    {
        return  $this->query()->where('is_active', ACTIVE)
            ->orderBy('name', 'ASC');
    }
}
