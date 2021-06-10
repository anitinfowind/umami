<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            //'first_name' => 'required|max:255',
            //'last_name'  => 'required|max:255',
            //'phone'  => 'required|numeric|unique:users,phone,'.auth()->user()->id,
        ];
    }

    /**
     * @return mixed
     */
    public function firstName()
    {
        //return $this->input('first_name');
        $d = $this->input('first_name');
        return ($d == null ? '' : $d);
    }

    /**
     * @return mixed
     */
    public function lastName()
    {
        //return $this->input('last_name');
        $d = $this->input('last_name');
        return ($d == null ? '' : $d);
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
    public function phoneNo()
    {
        //return $this->input('phone');
        $d = $this->input('phone');
        return ($d == null ? '' : $d);
    }

    /**
     * @return mixed
     */
    public function profileImage()
    {
        return $this->input('image');
    }
}
