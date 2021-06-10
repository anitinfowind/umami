<?php

namespace App\Http\Controllers\Backend\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Menu\CreateMenuRequest;

class MenuFormController extends Controller
{
    /**
     * @param $formName
     * @param CreateMenuRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create($formName, CreateMenuRequest $request)
    {
        if (in_array($formName, ['_add_custom_url_form'])) {
            return view('backend.menus.'.$formName);
        }

        return abort(404);
    }
}
