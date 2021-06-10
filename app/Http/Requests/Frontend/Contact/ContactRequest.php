<?php

namespace App\Http\Requests\Frontend\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|min:10',
            'subject' => 'required|string',
            'email' => 'required|email|string',
            'message' => 'required|string',
        ];
    }

    /**
     * @return string
     */
    public function name()
    {
        return ucfirst($this->input('name'));
    }

    /**
     * @return int
     */
    public function phoneNo()
    {
        return (int) $this->input('phone');
    }

    /**
     * @return array|string|null
     */
    public function email()
    {
        return $this->input('email');
    }

    /**
     * @return array|string|null
     */
    public function subject()
    {
        return ucfirst($this->input('subject'));
    }

    /**
     * @return string
     */
    public function message()
    {
        return nl2br(strip_tags($this->input('message')));
    }
}
