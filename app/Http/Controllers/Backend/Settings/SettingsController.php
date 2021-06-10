<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Settings\ManageSettingsRequest;
use App\Http\Requests\Backend\Settings\UpdateSettingsRequest;
use App\Http\Responses\Backend\Setting\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Models\Settings\Setting;
use App\Models\Settings\Site_setting;
use App\Repositories\Backend\Settings\SettingsRepository;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * @var SettingsRepository
     */
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
     * @param ManageSettingsRequest $request
     * @return EditResponse
     */
    public function edit(Setting $setting, ManageSettingsRequest $request)
    {
        return new EditResponse($setting);
    }

    /**
     * @param Setting $setting
     * @param UpdateSettingsRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(Request $lararequest, Setting $setting, UpdateSettingsRequest $request)
    {
        $settings_old = Site_setting::all();
        $settings_old2 = [];
        foreach ($settings_old as $key => $value) {
            $settings_old2[$value->key] = $value->value;
        }
        $settingsPath = public_path('/uploads/settings/');
        $home_counter_bg_image = $settings_old2['home_counter_bg_image'] ?? '';
        $home_counter_bg_image_remove = $lararequest->input('home_counter_bg_image_remove');
        if($home_counter_bg_image_remove == '1') {
            @unlink($settingsPath . '/' . $home_counter_bg_image);
            $home_counter_bg_image = '';
        }
        if($lararequest->hasFile('home_counter_bg_image_new')) {
            @unlink($settingsPath . '/' . $home_counter_bg_image);
            $home_counter_bg_image = '';
            $name = time() . 'home_counter_bg_image.' . $lararequest->home_counter_bg_image_new->getClientOriginalExtension();
            $lararequest->home_counter_bg_image_new->move($settingsPath, $name);
            $home_counter_bg_image = $name;
        }
        $footer_text_content = trim($_POST['footer_text_content']);
        $home_counter_1 = trim($_POST['home_counter_1']);
        $home_counter_2 = trim($_POST['home_counter_2']);
        $home_counter_3 = trim($_POST['home_counter_3']);
        $home_counter_4 = trim($_POST['home_counter_4']);
        $shipping_charge_alaska = trim($_POST['shipping_charge_alaska']);
        $shipping_charge_hawaii = trim($_POST['shipping_charge_hawaii']);
        $amount_to_point_percentage = trim($_POST['amount_to_point_percentage']);
        $point_to_amount_discount_percentage = trim($_POST['point_to_amount_discount_percentage']);
        foreach (['footer_text_content', 'home_counter_1', 'home_counter_2', 'home_counter_3', 'home_counter_4', 'shipping_charge_alaska', 'shipping_charge_hawaii', 'home_counter_bg_image', 'amount_to_point_percentage', 'point_to_amount_discount_percentage'] as $key => $value) {
            Site_setting::updateOrCreate(['key' => $value], ['value' => ${$value}]);
        }
        $this->settings->update($setting, $request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.settings.edit', $setting->id),
            ['flash_success' => trans('alerts.backend.settings.updated')]
        );
    }
}
