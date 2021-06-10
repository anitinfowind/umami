<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class FeaturesController extends Controller
{
    /**
     * @return View
     */
    public function show()
    {
        return view('frontend.features.features');
    }
}
