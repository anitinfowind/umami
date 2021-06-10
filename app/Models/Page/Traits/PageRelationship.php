<?php

namespace App\Models\Page\Traits;

use App\Models\Access\User\User;
use App\Models\Page_meta;

trait PageRelationship
{
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function page_meta()
    {
        return $this->hasMany(Page_meta::class, 'page_id');
    }
}
