<?php

namespace App\Http\Requests\Frontend\Auth\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'         =>  'required|string',
            'password'      =>  'required|min:6',
        ];
    }

    /**
     * @return array|string|null
     */
    public function email()
    {
        return $this->input('email');
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->input('password');
    }
}
