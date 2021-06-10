<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventImage extends Model
{

    protected $fillable = [
        'user_id',
        'event_id',
        'image',
    ];

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */


    /**
     * @return mixed
     */

    /**
     * @return string
     */
    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('d-M-Y');
    }

    /**
     * @return string
     */
    public function updatedAt()
    {
        return Carbon::parse($this->updated_at)->format('d-M-Y');
    }
}
