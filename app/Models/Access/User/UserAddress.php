<?php

namespace App\Models\Access\User;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
        'state_id',
        'city_id',
        'street_address',
        'alternative_address',
        'landmark',
        'pincode',
        'add_lat',
        'add_long',
        'address_type',
        'is_active',
        'is_primary_address'
    ];

    /**
     * @return int
     */
    public function userId()
    {
        return (int) $this->user_id;
    }

    /**
     * @return int
     */
    public function countryId()
    {
        return (int) $this->country_id;
    }

    /**
     * @return int
     */
    public function stateId()
    {
        return (int) $this->state_id;
    }

    /**
     * @return int
     */
    public function cityId()
    {
        return (int) $this->city_id;
    }

    /**
     * @return int
     */
    public function pincode()
    {
        return (int) $this->pincode;
    }

    /**
     * @return string
     */
    public function streetAddress()
    {
        return (string) $this->street_address;
    }

    /**
     * @return string
     */
    public function alternativeAddress()
    {
        return isset($this->alternative_address) ? $this->alternative_address : '';
    }

    /**
     * @return string
     */
    public function landmark()
    {
        return (string) $this->landmark;
    }

    /**
     * @return mixed
     */
    public function addressType()
    {
        return ucfirst(strtolower($this->address_type));
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * @return mixed
     */
    public function isPrimaryAddress()
    {
        return $this->is_primary_address == ACTIVE;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLoginUserId($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    /**
     * @return BelongsTo
     */
    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function state() : BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return BelongsTo
     */
    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @param string $value
     * @return string
     */
    public function setStreetAddressAttribute(string $value)
    {
        return $this->attributes['street_address'] =  ucfirst($value);
    }
}
