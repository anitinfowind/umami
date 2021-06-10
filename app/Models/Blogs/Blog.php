<?php

namespace App\Models\Blogs;

use App\Models\ModelTrait;
use App\Models\Blogs\Traits\Attribute\BlogAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes,ModelTrait,BlogAttribute;

    protected $fillable = [
        'name',
        'slug',
        'publish_datetime',
        'content',
        'meta_title',
        'cannonical_link',
        'meta_keywords',
        'meta_description',
        'status',
        'featured_image',
        'created_by',
    ];

    protected $dates = [
        'publish_datetime',
        'created_at',
        'updated_at',
    ];

    public function name()
    {
        return isset($this->name) ? $this->name : '';
    }

    public function content()
    {
        return isset($this->content) ? $this->content : '';
    }

    public function image()
    {
        return isset($this->featured_image) ? $this->featured_image : '';
    }
}
