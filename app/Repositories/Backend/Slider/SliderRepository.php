<?php

namespace App\Repositories\Backend\Slider;

use DB,File;
use Carbon\Carbon;
use App\Models\Slider\Slider;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Image;
class SliderRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Slider::class;

    protected $upload_path;

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'slider'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.sliders.table').'.id',
                config('module.sliders.table').'.title',
                config('module.sliders.table').'.description',
                config('module.sliders.table').'.slider_image',
                config('module.sliders.table').'.status',
                config('module.sliders.table').'.created_at',
                config('module.sliders.table').'.updated_at',
            ]);
    }

    /**
     * @param array $input
     * @return bool
     * @throws GeneralException
     */
    public function create(array $input)
    {
        $input['title']= isset($input['name']) ? $input['name'] : '';
        $input['status']=isset($input['status']) ? 1 : 0;
        //$input['type']= isset($input['answer']) ? $input['answer'] : 'no';
        $input = $this->uploadImage($input);

        if (Slider::create($input)) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.sliders.create_error'));
    }

    /**
     * @param Slider $slider
     * @param array $input
     * @return bool
     * @throws GeneralException
     */
    public function update(Slider $slider, array $input)
    {
        $input['title']= isset($input['name']) ? $input['name'] : '';
        $input['status']=isset($input['status']) ? 1 : 0;
        //$input['type']= isset($input['answer']) ? $input['answer'] : 'no';

        if (array_key_exists('slider_image', $input)) {
            $this->deleteOldFile($slider);
            $input = $this->uploadImage($input);
        }

        // if (array_key_exists('slider_video', $input)) {
        //     $this->deleteOldFileVideo($slider);
        //     $input = $this->uploadImage($input);
        // }

    	if ($slider->update($input)) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.sliders.update_error'));
    }

    /**
     * @param Slider $slider
     * @return bool
     * @throws GeneralException
     */
    public function delete(Slider $slider)
    {
        $this->deleteOldFile($slider);
         //$this->deleteOldFileVideo($slider);
        if ($slider->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.sliders.delete_error'));
    }

    /**
     * @param $input
     * @return array
     */
    public function uploadImage($input)
    {
        $avatar = $input['slider_image'];
        //$avatar_video = $input['slider_video'];
        
        if (isset($avatar) && !empty($avatar)) {
            $extension = $avatar->getClientOriginalExtension();
            $fileName =	Uuid::uuid4()->toString().'.'.$extension;
            $data = getimagesize($input['slider_image']);

             if($extension!='mp4' && $data[0] >=1920 && $data[1]>=900)
              {
                $avatar->move(SLIDER_ROOT_PATH, $fileName);
                $img = Image::make(SLIDER_ROOT_PATH.'/'.$fileName);
                $img->crop(1920, 900);
                $croppath =SLIDER_ROOT_PATH.'/'.$fileName;
                $img->save($croppath);
                $input = array_merge($input, ['slider_image' => $fileName]);
              }else{
                $avatar->move(SLIDER_ROOT_PATH, $fileName);
                $input = array_merge($input, ['slider_image' => $fileName]);
              }

               // if (isset($avatar_video) && !empty($avatar_video)) {
               //      $extension = $avatar_video->getClientOriginalExtension();
               //      $fileName = Uuid::uuid4()->toString().'.'.$extension;
               //      $data = getimagesize($input['slider_video']);

               //      if($extension == 'mp4')
               //       {
               //          if (isset($avatar_video) && !empty($avatar_video)) {
               //               $images = $input['slider_video'];
               //               $name = Uuid::uuid4()->toString().'.'.$images->getClientOriginalExtension();
               //               $destinationPath = public_path('/uploads/slider/');
               //               $images->move($destinationPath, $name);
               //               //$product->video= $name;
               //               $input = array_merge($input, ['slider_video' => $name]);
               //          }
               //       }else{
               //          $avatar_video->move(SLIDER_ROOT_PATH, $fileName);
               //          $input = array_merge($input, ['slider_video' => $fileName]);
               //      }
               //  }

            // if ($avatar->move(SLIDER_ROOT_PATH, $fileName)) {
            //     $input = array_merge($input, ['slider_image' => $fileName]);
            // }

            return $input;

        }
    }

    /**
     * @param $model
     * @return bool
     */
    public function deleteOldFile($model)
    {
        if (File::exists(SLIDER_ROOT_PATH.$model->slider_image)) {
            @unlink(SLIDER_ROOT_PATH.$model->slider_image);
        }
    }

    //  public function deleteOldFileVideo($model)
    // {
    //     if (File::exists(SLIDER_ROOT_PATH.$model->slider_video)) {
    //         @unlink(SLIDER_ROOT_PATH.$model->slider_video);
    //     }
    // }
}
