<?php

namespace App\Http\Responses\Backend\Slider;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Slider\Slider
     */
    protected $sliders;

    /**
     * @param App\Models\Slider\Slider $sliders
     */
    public function __construct($sliders)
    {
        $this->sliders = $sliders;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.sliders.edit')->with([
            'sliders' => $this->sliders
        ]);
    }
}