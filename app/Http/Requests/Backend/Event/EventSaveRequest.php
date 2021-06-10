<?php

namespace App\Http\Requests\Backend\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventSaveRequest extends FormRequest
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
            'title' => 'required|string',
            'event_image'=>'required',
            'description'=>'required',
        ];
    }

    public function title()
    {
        return $this->input('title');
    }

}
