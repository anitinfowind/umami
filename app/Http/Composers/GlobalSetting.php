<?php

namespace App\Http\Composers;
use App\Models\Settings\Setting;
use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalSetting
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('setting', Setting::first());
    }
}
