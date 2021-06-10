<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CorporateGiftController extends Controller
{
    /**
     * @return View
     */
    public function gift()
    {
        return view('frontend.pages.corporate-gift');
    }
}
