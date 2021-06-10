<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SiteSettingController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        return view('frontend.setting.setting');
    }
}
