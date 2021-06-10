<?php

namespace App\Http\Requests\Frontend\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CouponAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin() ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coupon_code'=>'required',
            'description'=>'required',
            'discount_type'=>'required',
            'min_price'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ];
    }
}
