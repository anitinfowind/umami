<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    protected $fillable = [
                    'distance',
                    'location_alaska',
                    'location_hawai',
                    'alaska_1day',
                    'hawai_1day',
                    'alaska_2day',
                    'hawai_2day',
                    'alaska_3day',
                    'hawai_3day',
                    'alaska_above',
                    'hawai_above',
                  ];
}
