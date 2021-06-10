<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
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
    public function title()
    {
        return $this->title;
    }

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
