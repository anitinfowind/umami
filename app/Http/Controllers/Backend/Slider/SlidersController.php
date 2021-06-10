<?php

namespace App\Http\Controllers\Backend\Slider;

use App\Models\Slider\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Slider\CreateResponse;
use App\Http\Responses\Backend\Slider\EditResponse;
use App\Repositories\Backend\Slider\SliderRepository;
use App\Http\Requests\Backend\Slider\ManageSliderRequest;
use App\Http\Requests\Backend\Slider\CreateSliderRequest;
use App\Http\Requests\Backend\Slider\StoreSliderRequest;
use App\Http\Requests\Backend\Slider\EditSliderRequest;
use App\Http\Requests\Backend\Slider\UpdateSliderRequest;
use App\Http\Requests\Backend\Slider\DeleteSliderRequest;

class SlidersController extends Controller
{
    /**
     * @var SliderRepository
     */
    protected $repository;

    /**
     * @param SliderRepository $repository
     */
    public function __construct(SliderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ManageSliderRequest $request
     * @return ViewResponse
     */
    public function index(ManageSliderRequest $request)
    {
        return new ViewResponse('backend.sliders.index');
    }

    /**
     * @param CreateSliderRequest $request
     * @return CreateResponse
     */
    public function create(CreateSliderRequest $request)
    {
        return new CreateResponse('backend.sliders.create');
    }

    /**
     * @param StoreSliderRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(StoreSliderRequest $request)
    {
        
        $data = getimagesize($request->file('slider_image'));
        $avatar = $request->file('slider_image');
        $avatar->getClientOriginalExtension();
        
        // $data = $request->file('slider_video');
        // $avatar_video = $request->file('slider_video');
        // if($avatar_video != ''){
        //    $avatar_video->getClientOriginalExtension(); 
        // }
        
       //  echo '<pre>'; print_r( $data); exit;
       /*if($avatar->getClientOriginalExtension()!='mp4')
         {
          if($data[0] >=1920 && $data[1]>= 900)
          {

          }
          else
          {
             return new RedirectResponse(route('admin.sliders.create'),['flash_danger' => trans('Image Size must be 1920X900 and above size.')]);
          }
         }*/
       //    else
       //    {
       //    return new RedirectResponse(route('admin.sliders.create'),['flash_success' => trans('Image Size must be 1600X750 and above size.')]);
       //    }
        $input = $request->except(['_token']);
        $this->repository->create($input);

        return new RedirectResponse(route('admin.sliders.index'),
            ['flash_success' => trans('alerts.backend.sliders.created')]
        );
    }

    /**
     * @param Slider $slider
     * @param EditSliderRequest $request
     * @return EditResponse
     */
    public function edit(Slider $slider, EditSliderRequest $request)
    {
        return new EditResponse($slider);
    }

    

    /**
     * @param UpdateSliderRequest $request
     * @param Slider $slider
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
      // echo '<pre>';print_r($slider['id']);exit;
      if($request->file('slider_image'))
      {
         //$avatar_video = $request->file('slider_video');
        $data = getimagesize($request->file('slider_image'));
        $avatar = $request->file('slider_image');
        $avatar->getClientOriginalExtension();

        /*if($avatar->getClientOriginalExtension()!='mp4')
         {
            if($data[0] >=1920 && $data[1]>= 900)
            {

            }
            else
            {
               return new RedirectResponse(route('admin.sliders.edit',$slider['id']),['flash_danger' => trans('Image Size must be 1920X900 and above size.')]);
            }
        }*/
      }

      // if($request->hasFile('slider_video')){
      //      $avatar = $request->file('slider_image');
      //      $data = $request->file('slider_video');
      //      $avatar_video = $request->file('slider_video');
      //      if($avatar_video != ''){
      //        $avatar_video->getClientOriginalExtension(); 
      //      }
      // }

        $input = $request->except(['_token']);
        $this->repository->update( $slider, $input );

        return new RedirectResponse(route('admin.sliders.index'),
            ['flash_success' => trans('alerts.backend.sliders.updated')]
        );
    }

    /**
     * @param Slider $slider
     * @param DeleteSliderRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Slider $slider, DeleteSliderRequest $request)
    {
        $this->repository->delete($slider);

        return new RedirectResponse(route('admin.sliders.index'),
            ['flash_success' => trans('alerts.backend.sliders.deleted')]
        );
    }

    /**
     * @param CategoryShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
    public function updateStatus(int $modelId, string $modelStatus)
    {
        Slider::where('id', '=', $modelId)->update(['status' => $modelStatus]);

        return new RedirectResponse(route('admin.sliders.index'),
            ['flash_success' => trans('Status has been changed successfully.')]
        );
    }
    
}
