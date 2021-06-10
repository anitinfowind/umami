<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isUser() || $this->user()->isVender() || $this->user()->isManager();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password',
        ];
    }

    public function oldPassword()
    {
        return $this->input('old_password');
    }

    public function newPassword()
    {
        return $this->input('new_password');
    }
}
