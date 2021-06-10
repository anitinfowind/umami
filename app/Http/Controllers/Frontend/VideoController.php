<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video\Video;

class VideoController extends Controller
{
    /**
     * @var Video
     */
    protected $videos;

    /**
     * @param Video $videos
     */
    public function __construct(Video $videos)
    {
        $this->videos = $videos;
    }

    /**
     * @return View
     */
    public function showVideo()
    {
        $videos = $this->videos->where('is_active', 'ACTIVE')->orderBy('created_at', 'DESC')->get();

        return view('frontend.video.video',
            compact('videos')
        );
    }

    /**
     * @param string $slug
     * @return View
     */
    public function videoDetail(string $slug)
    {
        $videodetail = $this->videos->where('slug', $slug)->first();
        $videos = $this->videos->where('is_active', 'ACTIVE')->orderBy('created_at', 'DESC')->get();

        return view('frontend.video.video-detail',
            compact('videodetail','videos')
        );
    }
}
