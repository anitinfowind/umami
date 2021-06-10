<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Chef;
use App\Models\Restaurant\RestaurantBranch;
use App\Http\Requests\Frontend\Chef\ChefCreateRequest;
use App\Http\Requests\Frontend\Chef\ChefUpdateRequest;
use Ramsey\Uuid\Uuid;
use File;
use Image;
use App\Models\Restaurant\Restaurant;
use App\Models\Admin_notification;

class ChefController extends Controller
{
    /**
     * @var Chef
     */
    private $chef;

    /**
     * @param Chef $chef
     */

     private $branch;
    /**
     * @param Chef $branch
     */
    public function __construct(Chef $chef, RestaurantBranch $branch)
    {
        $this->chef = $chef;
        $this->branch = $branch;
    }

    /**
     * @return View
     */
    public function index()
    {
        if(auth()->user()->isVender()) {
			$chefs = $this->chef
					->where('restaurant_id', auth()->user()['isApprovedRestaurant']->id )
					->orderBy('id','DESC')
					->paginate(PAGINATION);
		} else {
			$chefs = $this->chef->where('user_id', auth()->user()->id)->orderBy('id','DESC')->paginate(PAGINATION);
		}
		
		

        return view('frontend.chef.chef-list',
            compact('chefs')
        );
    }

    public function chefAdd()
    {
		return view('frontend.chef.add');
    }

    public function chefSave(ChefCreateRequest $request)
    {
		if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
             if($image->getClientOriginalExtension()!='mp4')
              {
                $image->move(CHEF_ROOT_PATH, $name);
                $img = Image::make(CHEF_ROOT_PATH.'/'.$name);
                $img->crop(1024, 680);
                $croppath =CHEF_ROOT_PATH.'/'.$name;
                $img->save($croppath);
              }else{
                $image->move(CHEF_ROOT_PATH, $name);
              }

			$this->chef->create(
					[
						'user_id' => auth()->user()->id,
                        'restaurant_id' => $this->branch->where('user_id', auth()->user()->id)->first()->restaurant_id,
                        'name' => $request->get('name'),
                        'slug' => $this->getSlug($request->get('name'),'','chefs'),
                        'designation' => $request->get('designation'),
                        //'email' => $request->get('email'),
                        'description' => $request->get('description'),
                        'image' => $name,
                        'status' => '0'
                    ]
            );

      $restaurant = Restaurant::find($this->branch->where('user_id', auth()->user()->id)->first()->restaurant_id);

      Admin_notification::create(['user_id' => auth()->user()->id, 'type' => 'CHEF_CREATE', 'message' => $restaurant->name . ' created ' . $request->get('name') . ' chef', 'json_data' => '{}', 'status' => '0']);

            session()->put('chefs',
						[
							'title' => trans('Chefs'),
                            'msg' => trans('Chef has been successfully Added.')
                        ]
            );

            return response()->json([
                'success' => true,
            ]);
		}
    }

    public function chefEdit(int $id)
    {
		$editchef= $this->chef->where('id', $id)->first();
		
        return view('frontend.chef.edit', 
			compact('editchef')
		);
    } 

    public function chefUpdate(ChefUpdateRequest $request) 
    {
		$chefupdate = $this->chef->where('id',$request->get('id'))->first();
		$chefupdate->name = $request->get('name');
		$chefupdate->designation = $request->get('designation');
		//$chefupdate->email = $request->get('email');
		$chefupdate->name = $request->get('name');
		$chefupdate->description = $request->get('description');

        if ($request->hasFile('image')) {
    			if ($chefupdate->image !=='' && File::exists(CHEF_ROOT_PATH.$chefupdate->image)) {
    				@unlink(public_path('/uploads/chef/'.$chefupdate->image));
                }
      			$image = $request->file('image');
      			$name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
            if($image->getClientOriginalExtension()!='mp4')
              {
                $image->move(CHEF_ROOT_PATH, $name);
                $img = Image::make(CHEF_ROOT_PATH.'/'.$name);
                $img->crop(1024, 680);
                $croppath =CHEF_ROOT_PATH.'/'.$name;
                $img->save($croppath);
              }else{
                $image->move(CHEF_ROOT_PATH, $name);
              }
      			

          $chefupdate->image = $name;
        }
		$chefupdate->status = '0';
		$chefupdate->save();

    $restaurant = Restaurant::find($this->branch->where('user_id', auth()->user()->id)->first()->restaurant_id);

    Admin_notification::create(['user_id' => auth()->user()->id, 'type' => 'CHEF_UPDATE', 'message' => $restaurant->name . ' updated ' . $request->get('name') . ' chef', 'json_data' => '{}', 'status' => '0']);
		
		session()->put('chefs-update',
					[
                      'title' => trans('Chefs'),
                      'msg' => trans('Chef has been successfully updated.')
                    ]
        );

        return response()->json([
            'success' => true,
        ]);
    }
	
	
    public function chefDelete(int $id)
	{
		$chefdelete = $this->chef->find($id);
        if($chefdelete->image !=='' && File::exists(CHEF_ROOT_PATH.$chefdelete->image)) {
			$path = CHEF_URL.$chefdelete->image;
            @unlink($path);
        }
		
		$chefdelete->delete();
		
		session()->put('chefs-delete',
					[
						'title' => trans('Chefs'),
                        'msg' => trans('Chef has been successfully Deleted.')
                    ]
        );

        return redirect()->to('/chefs');
    }    
}
