<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_redeemed_point extends Model
{
    //
    //public $timestamps = false;
    protected $table = 'user_redeemed_points';

    protected $fillable = ['user_id', 'order_id', 'points', 'price'];
}
