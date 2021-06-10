<?php

namespace App\Http\Controllers\Backend\Chef;

use App\Models\Chef;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant\Restaurant;
use Ramsey\Uuid\Uuid;
use File;
use App\Http\Responses\RedirectResponse;
use Image; 
class ChefController extends Controller
{
    /**
     * @var chef
     */
    protected $chef;

    public function __construct(Chef $chef)
    {
        $this->chef = $chef;
    }

    /**
     * @param ManageVideoRequest $request
     * @return ViewResponse
     */
    public function index()
    {
      $chefs= $this->chef->orderBy('id','desc')->get();

        return view('backend.chef.index', compact('chefs'));
    }
    public function create(Request $request)
    {
      $restaurants= Restaurant::get();
        return view('backend.chef.create', compact('restaurants'));
    }

      public function store(Request $request)
    {
       //echo '<pre>'; print_r($request->all()); exit;
      $userId=  Restaurant::where('id',$request->restaurant_id)->first();
     if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
             $data = getimagesize($request->file('image'));
             if($image->getClientOriginalExtension()!='mp4')
              {
                if($data[0] >=1024 && $data[1]>= 680)
                {
                  $image->move(CHEF_ROOT_PATH, $name);
                  $img = Image::make(CHEF_ROOT_PATH.'/'.$name);
                  $img->crop(1024, 680);
                  $croppath =CHEF_ROOT_PATH.'/'.$name;
                  $img->save($croppath);

                  $name2 = 'th_' . $name;
                  $img2 = Image::make($croppath)->resize(500, 332);
                  $croppath2 = CHEF_ROOT_PATH.'/'.$name2;
                  $img2->save($croppath2, 60);
                }else
                {
                   return new RedirectResponse(route('admin.chefs.create'),['flash_danger' => trans('Image Size must be 1024X680 and above size.')]);
                }
                
              }else{
               $image->move(CHEF_ROOT_PATH, $name);
              }
            

            $this->chef->create(
                       [
                        'user_id' => $userId->user_id,
                        'restaurant_id' => $request->restaurant_id,
                        'name' => $request->get('name'),
                        'slug' => $this->getSlug($request->get('name'),'','chefs'),
                        'designation' => $request->get('designation'),
                        'email' => $request->get('email'),
                        'description' => $request->get('description'),
                        'image' => $name,
                        'status' => $request->get('status')
                    ]
            );
      }
         return new RedirectResponse(route('admin.chefs.index'),
            ['flash_success' => trans('Chef add Successfully')]
        );
    }

     public function edit(Chef $chef, Request $request)
    {
       
     $chefs= $this->chef->where('id',$chef['id'])->first();
     $restaurants= Restaurant::get();
        return view('backend.chef.edit', compact('chefs','restaurants'));
    }
   public function update(Request $request, chef $chef)
    {
       $userId=  Restaurant::where('id',$request->restaurant_id)->first(); 
      $chef=$this->chef->where('id',$chef['id'])->first();
      $chef->user_id=$userId->user_id;
      $chef->restaurant_id=$request->restaurant_id;
      $chef->name=$request->name;
      $chef->designation=$request->designation;
      $chef->email=$request->email;
      $chef->description=$request->description;
	    $chef->is_home_show=$request->is_home_show;
      $chef->status=$request->status;
       if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
           $data = getimagesize($request->file('image'));
            if($image->getClientOriginalExtension()!='mp4')
              {
                 if($data[0] >=1024 && $data[1]>= 680)
                {
                  $image->move(CHEF_ROOT_PATH, $name);
                  $img = Image::make(CHEF_ROOT_PATH.'/'.$name);
                  $img->crop(1024, 680);
                  $croppath =CHEF_ROOT_PATH.'/'.$name;
                  $img->save($croppath);

                  $name2 = 'th_' . $name;
                  $img2 = Image::make($croppath)->resize(500, 332);
                  $croppath2 = CHEF_ROOT_PATH.'/'.$name2;
                  $img2->save($croppath2, 60);
                }else{
                   return new RedirectResponse(route('admin.chefs.edit',$chef['id']),['flash_danger' => trans('Image Size must be 1024X680 and above size.')]);
                }
              }else{
               $image->move(CHEF_ROOT_PATH, $name);
              }

            $chef->image= $name;
        }
         $chef->save();
          return new RedirectResponse(route('admin.chefs.index'),
            ['flash_success' => trans('Chef update Successfully')]
        );
    }

   public function destroy(int $id)
    {
         $this->chef->where('id',$id)->delete();

        return new RedirectResponse(route('admin.chefs.index'),
            ['flash_success' => trans('Chef deleted Successfully')]
        );
    }

    public function viewChef(int $id)
    {
      $chef= $this->chef->where('id',$id)->first();
       
       return view('backend.chef.show', compact('chef'));
    }

   
}
