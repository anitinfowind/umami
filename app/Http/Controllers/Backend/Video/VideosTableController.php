<?php

namespace App\Http\Controllers\Backend\Video;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Video\VideoRepository;
use App\Http\Requests\Backend\Video\ManageVideoRequest;

class VideosTableController extends Controller
{
    /**
     * @var VideoRepository
     */
    protected $video;

    /**
     * @param VideoRepository $video
     */
    public function __construct(VideoRepository $video)
    {
        $this->video = $video;
    }

    /**
     * @param ManageVideoRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ManageVideoRequest $request)
    {
        return Datatables::of($this->video->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('title', function ($video) {
                return $video->title;
            })
            ->addColumn('video', function ($video) {
              if($video->video_type=='VIDEO')
              {
                return '<video width="150" height="100" controls>
                <source src="'.url('uploads/video/'.$video->video).'" type="video/mp4">
              </video>';
            }else
            {
               return '<iframe width="150" height="100" src="'.url($video->embedded_url).'">
              </iframe>';
            }
            })
            ->addColumn('location', function ($video) {
                return $video->location;
            })
            ->addColumn('is_active', function ($video) {
                return $video->is_active_label;
            })
            ->addColumn('created_at', function ($video) {
                return Carbon::parse($video->created_at)->toDateString();
            })
            ->addColumn('actions', function ($video) {
                return $video->action_buttons;
            })
            ->make(true);
    }
}
