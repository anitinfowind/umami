<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Shippings extends Model
{
    protected $fillable = [
                    'day',
                    'service_name',
                    'price',
                  ];
}
