<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
                    'user_id',
                    'coupon_code',
                    'discount_type',
                    'discount',
                    'start_date',
                    'end_date',
                    'min_price',
                    'max_users',
                    'description',
                  ];

    public function  couponcode()
    {
      return $this->coupon_code;
    }
    
    public function startDate()
    {
      return Carbon::parse($this->start_date)->format('d-M-Y');
    }

    public function endDate()
    {
      return Carbon::parse($this->end_date)->format('d-M-Y');
    }

}
