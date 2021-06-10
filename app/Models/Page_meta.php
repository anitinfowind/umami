<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page_meta extends Model
{
    //
    public $timestamps = false;
    protected $table = 'page_meta';

    protected $fillable = ['page_id', 'meta_key', 'meta_value'];
}
