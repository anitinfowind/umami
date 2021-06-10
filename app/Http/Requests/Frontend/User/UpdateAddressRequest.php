<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_id' => 'required|string',
            'state_id'  => 'required|string',
            'city_id'  => 'required|string',
            'street_address'  => 'required|string',
            'landmark'  => 'required|string',
            'pincode'  => 'required|string',
            'address_type'  => 'required|string',
        ];
    }

    /**
     * @return mixed
     */
    public function countryId()
    {
        return $this->input('country_id');
    }

    /**
     * @return mixed
     */
    public function stateId()
    {
        return $this->input('state_id');
    }

    /**
     * @return mixed
     */
    public function cityId()
    {
        return $this->input('city_id');
    }

    /**
     * @return mixed
     */
    public function streetAddress()
    {
        return $this->input('street_address');
    }

    /**
     * @return mixed
     */
    public function alternativeAddress()
    {
        return $this->input('alternative_address');
    }

    /**
     * @return mixed
     */
    public function landmark()
    {
        return $this->input('landmark');
    }

    /**
     * @return mixed
     */
    public function pincode()
    {
        return $this->input('pincode');
    }

    /**
     * @return mixed
     */
    public function addressType()
    {
        return $this->input('address_type');
    }

    /**
     * @return mixed
     */
    public function addressId()
    {
        return $this->input('address_id');
    }
}
