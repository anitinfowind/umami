<?php

namespace App\Http\Responses\Backend\Blog;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    protected $blog;

    protected $status;

    public function __construct($blog, $status)
    {
        $this->blog = $blog;
        $this->status = $status;
    }

    public function toResponse($request)
    {
        return view('backend.blogs.edit')->with([
            'blog'               => $this->blog,
            'status'             => $this->status,
        ]);
    }
}
