<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_notification extends Model
{
    //
    //public $timestamps = false;
    protected $table = 'admin_notifications';

    protected $fillable = ['user_id', 'type', 'message', 'json_data', 'status'];
}
