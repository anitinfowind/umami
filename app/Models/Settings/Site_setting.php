<?php

namespace App\Models\Settings;

use App\Models\BaseModel;

class Site_setting extends BaseModel
{
    protected $table = 'site_settings';

    protected $fillable = ['key', 'value'];

}
