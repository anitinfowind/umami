<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }
}
