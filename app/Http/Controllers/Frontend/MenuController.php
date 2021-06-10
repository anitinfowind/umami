<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * @return View
     */
    public function show()
    {
        return view('frontend.menu.menu');
    }
}
