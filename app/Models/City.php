<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }
}
