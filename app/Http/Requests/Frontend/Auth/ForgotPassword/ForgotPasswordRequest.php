<?php

namespace App\Http\Requests\Frontend\Auth\ForgotPassword;

use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class ForgotPasswordRequest extends FormRequest
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
            'email' =>  'required|email|string',
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
     * @return Uuid
     * @throws \Exception
     */
    public function validateString()
    {
        return Uuid::uuid4()->toString();
    }
}
