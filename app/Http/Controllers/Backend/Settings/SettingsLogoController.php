<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Setting;
use App\Repositories\Backend\Settings\SettingsRepository;
use Illuminate\Http\Request;

class SettingsLogoController extends Controller
{
    protected $settings;

    /**
     * @param SettingsRepository $settings
     */
    public function __construct(SettingsRepository $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param Setting $setting
     * @param Request $request
     * @return false|string
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Setting $setting, Request $request)
    {
        $this->settings->removeLogo($setting, $request->data);

        return json_encode([
            'status' => true,
        ]);
    }
}
