<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    //public $timestamps = false;
    protected $table = 'testimonials';

    protected $fillable = ['first_name', 'last_name', 'title', 'comment', 'image','post_image','status'];
}
