<?php

namespace App\Http\Controllers\Backend\Banner;

use App\Http\Requests\Backend\Banner\BannerAddRequest;
use App\Http\Requests\Backend\Banner\BannerDeleteRequest;
use App\Http\Requests\Backend\Banner\BannerEditRequest;
use App\Http\Requests\Backend\Banner\BannerSaveRequest;
use App\Http\Requests\Backend\Banner\BannerUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\TopVideo;
use Ramsey\Uuid\Uuid;
use File;
use Validator;

class BannerController extends Controller
{
    /**
     * @var Diet
     */
    private $banner;
    private $top_video;

    /**
     * @param Diet $diet
     */
    public function __construct(Banner $banner,TopVideo $top_video)
    {
        $this->banner    = $banner;
        $this->top_video = $top_video;
    }

    /**
     * @param DietShowRequest $request
     * @return View
     */
    public function index()
    {
        $banners = $this->banner->orderby('id','DESC')->get();
        return view('backend.banner.index',
            compact('banners')
        );
    }

    public function video()
    {
        $banners = $this->top_video->orderby('id','DESC')->get();
        return view('backend.banner.video',
            compact('banners')
        );
    }

    /**
     * @param DietAddRequest $request
     * @return View
     */
    public function addBanner(BannerAddRequest $request)
    {
        return view('backend.banner.create');
    }

    public function addVideo(Request $request)
    {
        return view('backend.banner.videocreate');
    }

    /**
     * @param DietSaveRequest $request
     */
    public function saveBanner(BannerSaveRequest $request)
    {
       if ($request->hasFile('banner_image')) {
           $image = $request->file('banner_image');
           $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
           $destinationPath = public_path('/uploads/banner/');
           $image->move($destinationPath, $name);
        }

        $this->banner->create([
            'title' => $request->title(),
            'image' => $name,
            'button_url'=>isset($request->button_url)?$request->button_url:'',
            'slug' => $this->getSlug($request->title(),'','banners'),
            'is_active'=> ($request->get('is_active')) ? ACTIVE : INACTIVE,
        ]);

        return redirect()->route('admin.banner.index')
            ->with(['flash_success' => trans('Banner has been successfully added.')]);
    }


    public function saveVideo(Request $request)
    {
        $request->validate([
              'title'    => 'required',
              'video'    => 'required|mimes:mp4,mov,ogg|max:100000',
            ]);

       if ($request->hasFile('video')) {
           $image = $request->file('video');
           $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
           $destinationPath = public_path('/uploads/banner/');
           $image->move($destinationPath, $name);
        }

        $this->top_video->create([
            'title' => $request->title,
            'video' => $name,
            'is_active'=> ($request->get('is_active')) ? ACTIVE : INACTIVE,
        ]);

        return redirect()->route('admin.banner.video')
            ->with(['flash_success' => trans('Video has been successfully added.')]);
    }

    /**
     * @param DietEditRequest $request
     * @param int $id
     * @return View
     */
    public function editBanner(BannerEditRequest $request, int $id)
    {
        $banners = $this->banner->find($id);

        return view('backend.banner.edit',
            compact('banners')
        );
    }

     public function editVideo(Request $request, int $id)
     {
        $banners = $this->top_video->find($id);
        return view('backend.banner.videoedit',
            compact('banners')
        );
     }

    /**
     * @param DietUpdateRequest $request
     * @param int $id
     */
    public function updateBanner(BannerUpdateRequest $request, int $id)
    {
      $banners=  $this->banner->where('id', $id)->first();
      $banners->title =$request->title();
      $banners->button_url =isset($request->button_url)?$request->button_url:'';
      $banners->is_active = ($request->get('is_active')) ? ACTIVE : INACTIVE;

        if ($request->hasFile('banner_image')) {
           $bannerimage= $this->banner->where('id',$id)->first();

            if (File::exists(public_path('/uploads/banner/'.$bannerimage->image))) {
                  @unlink(public_path('/uploads/banner/'.$bannerimage->image));
              }
              $image = $request->file('banner_image');
              $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
              $destinationPath = public_path('/uploads/banner/');
              $image->move($destinationPath, $name);
            $banners->image= $name;
        }
      $banners->save();

        return redirect()->route('admin.banner.index')
            ->with(['flash_success' => trans('Banner has been successfully updated.')]);
    }


    public function updateVideo(Request $request, int $id)
    {
      $request->validate([
              'title' => 'required',
            ]);
      if($request->hasFile('video')) {
         $request->validate([
            'video' => 'required|mimes:mp4,mov,ogg|max:100000',
         ]);
      } 

      $banners=  $this->top_video->where('id', $id)->first();
      $banners->title =$request->title;
      //$banners->button_url =isset($request->button_url)?$request->button_url:'';
      $banners->is_active = ($request->get('is_active')) ? ACTIVE : INACTIVE;

        if ($request->hasFile('video')) {
           $bannerimage= $this->top_video->where('id',$id)->first();

            if (File::exists(public_path('/uploads/banner/'.$bannerimage->video))) {
                  @unlink(public_path('/uploads/banner/'.$bannerimage->video));
              }
              $image = $request->file('video');
              $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
              $destinationPath = public_path('/uploads/banner/');
              $image->move($destinationPath, $name);
            $banners->video= $name;
        }
      $banners->save();

        return redirect()->route('admin.banner.video')
            ->with(['flash_success' => trans('Video has been successfully updated.')]);
    }

    /**
     * @param DietDeleteRequest $request
     * @param int $id
     */
    public function deleteBanner(BannerDeleteRequest $request, int $id)
    {     
        $bannerimage= $this->banner->find($id);
        if (File::exists(public_path('/uploads/banner/'.$bannerimage->image))) {
              @unlink(public_path('/uploads/banner/'.$bannerimage->image));
          }
        $this->banner->find($id)->delete();
        return redirect()->route('admin.banner.index')
            ->with(['flash_success' => trans('Banner has been successfully deleted.')]);
    }

    /**
     * @param DietShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
}
