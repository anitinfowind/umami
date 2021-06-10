<?php

namespace App\Http\Requests\Frontend\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class SaveOrderRequest extends FormRequest
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
			'first_name' => 'required|string',
			'last_name' => 'required|string',
			'email' => 'email|string',
			'phone' => 'min:10|string',
			'country_id' => 'required|string',
			'state_id' => 'required|string',
			'city_id' => 'required|string',
			'zip_code' => 'required|min:5',
			'street_address' => 'required|string',
        ];
    }
	
	public function firstName()
	{
		return $this->input('first_name');
	}
	
	public function lastName()
	{
		return $this->input('last_name');
	}
	
	public function email()
	{
		return $this->input('email');
	}
	
	public function phone()
	{
		return $this->input('phone');
	}
	
	public function countryId()
	{
		return $this->input('country_id');
	}
	
	public function stateId()
	{
		return $this->input('state_id');
	}
	
	public function cityId()
	{
		return $this->input('city_id');
	}
	
	public function zipCode()
	{
		return $this->input('zip_code');
	}
	
	public function streetAddress()
	{
		return $this->input('street_address');
	}
	
	public function alternativeAddress()
	{
		return $this->input('alternative_address');
	}
	
	public function isGift()
	{
		return $this->input('is_gift');
	}
	
	public function paymentType()
	{
		return $this->input('payment_type');
	}
}
