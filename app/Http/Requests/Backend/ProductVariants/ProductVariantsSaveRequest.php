<?php

namespace App\Http\Requests\Backend\ProductVariants;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantsSaveRequest extends FormRequest
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
            'product_id' => 'required',
            'variant_name' => 'required',
            'price' => 'required'
        ];
    }

    /*public function name()
    {
        return $this->input('name');
    }

    public function isActive()
    {
        return $this->input('is_active');
    }*/
}
