<?php

namespace App\Http\Requests\Frontend\Auth\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'new_password' 		    => 	'required|min:6',
            'confirm_password' =>  'required|min:6|same:new_password',
        ];
    }

    /**
     * @return array|string|null
     */
    public function newPassword()
    {
        return $this->input('new_password');
    }

    public function forgotPasswordString()
    {
        return $this->input('forgotPasswordString');
    }
}
