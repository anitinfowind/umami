<?php

namespace App\Http\Controllers\Backend\Slider;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Slider\SliderRepository;
use App\Http\Requests\Backend\Slider\ManageSliderRequest;
use File;

class SlidersTableController extends Controller
{
    /**
     * @var SliderRepository
     */
    protected $slider;

    /**
     * @param SliderRepository $slider
     */
    public function __construct(SliderRepository $slider)
    {
        $this->slider = $slider;
    }

    /**
     * @param ManageSliderRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ManageSliderRequest $request)
    {
        return Datatables::of($this->slider->getForDataTable())
            ->escapeColumns(['id'])
             ->addColumn('title', function ($slider) {
                return $slider->title;
            })
             ->addColumn('slider_image', function ($slider) {
                $info = pathinfo(SLIDER_ROOT_PATH.$slider->slider_image);
                $ext = $info['extension'];
                  if($ext=='mp4')
                  {
                     $slidervideo = SLIDER_URL . $slider->slider_image;
                     return   '<video width="90px" height="60px" muted loop controls autoplay>
                      <source src="'. $slidervideo.'" type="video/mp4">
                    </video>';
                  }
                  else
                  {
                    if ($slider->slider_image!='' && File::exists(SLIDER_ROOT_PATH.$slider->slider_image)) {
                        $sliderImage = SLIDER_URL . $slider->slider_image;
                    } else {
                        $sliderImage = WEBSITE_IMG_URL . 'no-image.png';
                    }
                  }
                return '<img style="width:90px;height:60px"; src="'.$sliderImage.'">';
            })
             ->addColumn('status', function ($slider) {
                return $slider->status;
            })
            ->addColumn('created_at', function ($slider) {
                return Carbon::parse($slider->created_at)->format('d-M-Y');
            })
            ->addColumn('updated_at', function ($slider) {
                return Carbon::parse($slider->updated_at)->format('d-M-Y');
            })
             ->addColumn('status', function ($slider) {
                return $slider->status_label;
            })
            ->addColumn('actions', function ($slider) {
                return $slider->action_buttons;
            })
            ->make(true);
    }
}
