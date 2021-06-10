<?php

namespace App\Http\Requests\Backend\Brand;

use Illuminate\Foundation\Http\FormRequest;

class BrandSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
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
            'description' => 'required|string',
            'file' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'The image field is required.'
        ];
    }

    public function name()
    {
        return $this->input('name');
    }

    public function description()
    {
        return $this->input('description');
    }
}
