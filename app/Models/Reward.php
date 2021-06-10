<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    /**
     * @return mixed
     */
    protected $fillable = [
                    'discount_price',
                    'earn_point',
                    'is_active',
                  ];

    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('d-M-Y');
    }
}
