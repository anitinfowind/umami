<?php

namespace App\Http\Requests\Backend\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerSaveRequest extends FormRequest
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
            'banner_image'=>'required',
        ];
    }

    public function title()
    {
        return $this->input('title');
    }

}
