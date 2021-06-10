<?php

namespace App\Http\Requests\Frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class RegisterRequest extends FormRequest
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
            'role'              =>  'required',
            //'first_name'        =>  'required|string',
            //'last_name'         =>  'required|string',
            //'phone'             =>  'required|min:10|unique:users,phone',
            'email'             =>  'required|string|email|'.Rule::unique('users'),
            'password'          =>  'required|string|min:6',
            'confirm_password'  =>  'required|string|min:6|same:password',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'role.required' => 'The user type field is required.',
        ];
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
    public function phoneNo()
    {
        return $this->input('phone');
    }
    /**
     * @return mixed
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
        return Hash::make($this->input('password'));
    }

    /**
     * @return mixed
     */
    public function userType()
    {
        return $this->input('role');
    }

    /**
     * @return array|string|null
     */
    public function token()
    {
        return $this->input('_token');
    }

    /**
     * @return Uuid
     * @throws \Exception
     */
    public function confirmationCode()
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @return int
     */
    public function isActive()
    {
        return ONE;
    }

    /**
     * @return int
     */
    public function isConfirm()
    {
        return ZERO;
    }
}
