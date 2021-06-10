<?php

namespace App\Http\Controllers\Backend\Video;

use App\Models\Video\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Video\CreateResponse;
use App\Http\Responses\Backend\Video\EditResponse;
use App\Repositories\Backend\Video\VideoRepository;
use App\Http\Requests\Backend\Video\ManageVideoRequest;
use App\Http\Requests\Backend\Video\CreateVideoRequest;
use App\Http\Requests\Backend\Video\StoreVideoRequest;
use App\Http\Requests\Backend\Video\EditVideoRequest;
use App\Http\Requests\Backend\Video\UpdateVideoRequest;
use App\Http\Requests\Backend\Video\DeleteVideoRequest;
use Ramsey\Uuid\Uuid;
use File;

class VideosController extends Controller
{
    /**
     * @var VideoRepository
     */
    protected $repository;

    /**
     * VideosController constructor.
     * @param VideoRepository $repository
     */
    public function __construct(VideoRepository $repository,Video $videos)
    {
        $this->repository = $repository;
        $this->videos = $videos;
    }

    /**
     * @param ManageVideoRequest $request
     * @return ViewResponse
     */
    public function index(ManageVideoRequest $request)
    {
        return new ViewResponse('backend.videos.index');
    }

    /**
     * @param CreateVideoRequest $request
     * @return CreateResponse
     */
    public function create(CreateVideoRequest $request)
    {
        return new CreateResponse('backend.videos.create');
    }

    /**
     * @param StoreVideoRequest $request
     * @return RedirectResponse
     */
    public function store(StoreVideoRequest $request)
    {
        $request->validate([
            'video'=>'mimes:mp4,webm',
            ]);
       $getdata=explode(",", $request->location);

       $videos=new Video;
       $videos->title= $request->title;
       $videos->slug =$this->getSlug($request->title,'','videos');
       $videos->description= $request->description;
       $videos->video_type=$request->video_type;
       $videos->embedded_url=$request->embedded_url;
       $videos->location= $request->location;
       $videos->country=$request->country;
       $videos->state= $request->state;
       $videos->city= $request->city;
       $videos->latitude= $request->latitude;
       $videos->longitude= $request->longitude;
       $videos->is_active= isset($request->is_active)?ACTIVE:INACTIVE;
       if($request->hasFile('video')) {
           $image = $request->file('video');
           $name =Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
           $destinationPath = public_path('/uploads/video');
           $image->move($destinationPath, $name);
           $videos->video=$name;
       }
       $videos->save();

        return new RedirectResponse(route('admin.videos.index'),
            ['flash_success' => trans('alerts.backend.videos.created')]
        );
    }

    /**
     * @param Video $video
     * @param EditVideoRequest $request
     * @return EditResponse
     */
    public function edit(Video $video, EditVideoRequest $request)
    {
        return new EditResponse($video);
    }

    /**
     * @param UpdateVideoRequest $request
     * @param Video $video
     * @return RedirectResponse
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        $videos=Video::where('id',$video['id'])->first();
        $videos->title= $request->title;
        $videos->description= $request->description;
        $videos->video_type=$request->video_type;
        $videos->embedded_url=$request->embedded_url;
        $videos->location= $request->location;
        $videos->country=$request->country;
        $videos->state= $request->state;
        $videos->city= $request->city;
        $videos->latitude= $request->latitude;
        $videos->longitude= $request->longitude;
        $videos->is_active= isset($request->is_active)?ACTIVE:INACTIVE;
        if($request->hasFile('video')) {
            $image = $request->file('video');
            $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/video');
            $image->move($destinationPath, $name);

            if (File::exists(public_path('/uploads/video/'.$videos->video))) {
                @unlink(public_path('/uploads/video/'.$videos->video));
            }
            $videos->video=$name;
        }
        $videos->save();

        return new RedirectResponse(route('admin.videos.index'),
            ['flash_success' => trans('alerts.backend.videos.updated')]
        );
    }

    /**
     * @param Video $video
     * @param DeleteVideoRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Video $video, DeleteVideoRequest $request)
    {
        $this->repository->delete($video);

        return new RedirectResponse(route('admin.videos.index'),
            ['flash_success' => trans('alerts.backend.videos.deleted')]
        );
    }
}
