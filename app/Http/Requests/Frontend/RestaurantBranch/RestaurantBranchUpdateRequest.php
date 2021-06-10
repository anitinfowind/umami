<?php

namespace App\Http\Requests\Frontend\RestaurantBranch;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantBranchUpdateRequest extends FormRequest
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
            'location' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string|min:10',
            'description' => 'required|string',
            'zip_code' => 'required|string',
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
    public function userId()
    {
        return $this->input('user_id');
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
}
