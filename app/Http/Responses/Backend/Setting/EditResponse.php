<?php

namespace App\Http\Responses\Backend\Setting;

use App\Models\Settings\Site_setting;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var \App\Models\Settings\Setting
     */
    protected $setting;

    /**
     * @param \App\Models\Settings\Setting $setting
     */
    public function __construct($setting)
    {
        $this->setting = $setting;
    }

    /**
     * toReponse.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        $site_settings = Site_setting::all();
        $site_settings2 = [];
        foreach ($site_settings as $key => $value) {
            $site_settings2[$value->key] = $value->value;
        }
        return view('backend.settings.edit', compact('site_settings2'))
            ->withSetting($this->setting);
    }
}
