<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message'
    ];

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function phoneNo()
    {
        return $this->phone;
    }

    /**
     * @return array|string|null
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function subject()
    {
        return $this->subject;
    }
}
