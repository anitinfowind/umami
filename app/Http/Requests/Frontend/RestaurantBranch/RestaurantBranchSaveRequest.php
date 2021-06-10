<?php

namespace App\Http\Requests\Frontend\RestaurantBranch;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantBranchSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isVender();
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
            'email'  => 'required|email|unique:users,email',
            'location' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string|min:10',
            'description' => 'required|string',
            'zip_code' => 'required|string',
            'files'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'The about restaurant field is required.',
        ];
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->input('id');
    }

    /**
     * @return mixed
     */
    public function firstName()
    {
        return $this->input('first_name');
    }

    /**
     * @return mixed
     */
    public function lastName()
    {
        return $this->input('last_name');
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return $this->input('email');
    }

    /**
     * @return mixed
     */
    public function location()
    {
        return $this->input('location');
    }

    /**
     * @return mixed
     */
    public function country()
    {
        return $this->input('country');
    }

    /**
     * @return mixed
     */
    public function state()
    {
        return $this->input('state');
    }

    /**
     * @return mixed
     */
    public function city()
    {
        return $this->input('city');
    }

    /**
     * @return mixed
     */
    public function latitude()
    {
        return $this->input('latitude');
    }

    /**
     * @return mixed
     */
    public function longitude()
    {
        return $this->input('longitude');
    }

    /**
     * @return mixed
     */
    public function zipCode()
    {
        return $this->input('zip_code');
    }

    /**
     * @return mixed
     */
    public function phoneNo()
    {
        return $this->input('phone');
    }

    /**
     * @return mixed
     */
    public function description()
    {
        return nl2br(strip_tags($this->input('description')));
    }

    /**
     * @return mixed
     */
    public function categoryIds()
    {
        return $this->input('category_id') ?? [];
    }

    /**
     * @return mixed
     */
    public function serviceTypeIds()
    {
        return $this->input('service_type_id') ?? [];
    }

    /**
     * @return mixed
     */
    public function openTime()
    {
        return $this->input('time') ?? [];
    }

    /**
     * @return mixed
     */
    public function images()
    {
        return $this->input('files') ?? [];
    }

    /**
     * @return |null
     */
    public function confirmationCode()
    {
        return null;
    }

    /**
     * @return false|string
     */
    public function password()
    {
        return \Hash::make($this->input('password'));
    }

    /**
     * @return false|string
     */
    public function isActive()
    {
        return ONE;
    }

    /**
     * @return false|string
     */
    public function isConfirm()
    {
        return ONE;
    }

    /**
     * @return array|string|null
     */
    public function token()
    {
        return $this->input('_token');
    }

    /**
     * @return mixed
     */
    public function userType()
    {
        return FOUR;
    }
}
