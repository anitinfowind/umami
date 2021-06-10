<?php

namespace App\Http\Requests\Backend\Restaurant;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
class StoreRestaurantRequest extends Request
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
              //'userid' => 'required|numeric',
            //'state' => 'required|string',
            //'city' => 'required|string',
            //'zip_code' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            //The Custom messages would go in here
            //For Example : 'title.required' => 'You need to fill in the title field.'
            //Further, see the documentation : https://laravel.com/docs/6.x/validation#customizing-the-error-messages
        ];
    }
}
