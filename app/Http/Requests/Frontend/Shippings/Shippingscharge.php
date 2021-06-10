<?php

namespace App\Http\Requests\Frontend\Shippings;

use Illuminate\Foundation\Http\FormRequest;

class Shippingscharge extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin() ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'day'=>'required',
            'from_zipcode'=>'required',
            'to_zipcode'=>'required',
        ];
    }
}
