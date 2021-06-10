<?php

namespace App\Http\Responses\Backend\Video;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Video\Video
     */
    protected $videos;

    /**
     * @param App\Models\Video\Video $videos
     */
    public function __construct($videos)
    {
        $this->videos = $videos;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.videos.edit')->with([
            'videos' => $this->videos
        ]);
    }
}