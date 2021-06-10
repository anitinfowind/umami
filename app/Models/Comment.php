<?php

namespace App\Models;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'blog_id',
        'comment'
    ];

    /**
     * @return int
     */
    public function id()
    {
        return (int) $this->id;
    }

    /**
     * @return int
     */
    public function userId()
    {
        return (int) $this->user_id;
    }

    /**
     * @return int
     */
    public function blogId()
    {
        return (int) $this->blog_id;
    }

    /**
     * @return string
     */
    public function comment()
    {
        return (string) $this->comment;
    }

    /**
     * @return false|string
     */
    public function date()
    {
        return date('M d,Y', strtotime($this->created_at));
    }

    /**
     * @param $query
     * @param int $blogId
     * @return mixed
     */
    public function scopeBlogComment($query, int $blogId)
    {
        return $query->where('blog_id', $blogId)->orderBy('created_at','desc')->with('user');
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
