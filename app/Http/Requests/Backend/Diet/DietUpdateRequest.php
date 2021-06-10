<?php

namespace App\Http\Requests\Backend\Diet;

use Illuminate\Foundation\Http\FormRequest;

class DietUpdateRequest extends FormRequest
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
            'name' => 'required|string'
        ];
    }

    public function name()
    {
        return $this->input('name');
    }

    public function isActive()
    {
        return $this->input('is_active');
    }
}
