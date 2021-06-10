<?php

namespace App\Http\Controllers\Backend\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantBranch;
use App\Models\Categories\Category;
use App\Models\Restaurant\RestaurantServiceType;
use App\Models\Restaurant\RestaurantTime;
use App\Models\Restaurant\RestaurantImage;
use App\Models\Restaurant\RestaurantCategory;
use App\Models\Restaurant\RestaurantLocation;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Requests\Backend\Restaurant\UpdateRestaurantRequest;
use App\Http\Requests\Backend\Restaurant\StoreRestaurantRequest;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use File;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Products\Product;
use Image;
use DB;
use App\Models\Access\User\User;
class RestaurantController extends Controller
{
    /**
     * @var Diet
     */
    private $restaurant;
    private $servicetype;
    private $restaurantTime;
    private $restaurantCategory;
    private $restaurantImage;
    private $restaurantLocation;
    private $country;
    private $restaurantbranch;

    /**
     * @var State
     */
    private $state;

    /**
     * @var City
     */
    private $city;

    /**
     * @param Diet $diet
     */
    public function __construct(Restaurant $restaurant,RestaurantServiceType $servicetype,RestaurantTime $restaurantTime,RestaurantCategory $restaurantCategory,RestaurantImage $restaurantImage,RestaurantLocation $restaurantLocation,Country $country,
        State $state,
        City $city,RestaurantBranch $restaurantbranch)
    {
        $this->restaurant = $restaurant;
        $this->servicetype = $servicetype;
        $this->restaurantTime = $restaurantTime;
        $this->restaurantCategory = $restaurantCategory;
        $this->restaurantImage = $restaurantImage;
        $this->restaurantLocation = $restaurantLocation;
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
        $this->restaurantbranch = $restaurantbranch;
        
    }

    /**
     * @param DietShowRequest $request
     * @return View
     */
    public function index()
    {
        $getresdata = $this->restaurant->with('restaurantLocation','restaurantSingleImage','restaurantBranch','restaurantTime')->get();
        //echo "<pre>"; print_r($getresdata); exit;
        return view('backend.restaurant.index',
            compact('getresdata')
        );
    }


     public  function restaurantCreate()
     {
      $vendorname=User::select('users.first_name','users.id')
                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.role_id',2)
                ->get();
             //  echo '<pre>'; print_r($vendorname); exit;
      $countriedata = $this->country->where('sortname','US')->select('name','id')->get();
               
      return view('backend.restaurant.create', compact('vendorname','countriedata'));
     }
 
    public function restaurantStore(StoreRestaurantRequest $request)
    {
      $checkrestaurant= $this->restaurant->where('user_id',$request->user_id)->first();
       if(!empty($checkrestaurant))
       {
          return redirect('admin/restaurant/create')->withErrors('Restaurant Allready Create');
       }
        $restaurantId= $this->restaurant->create([
                                  'user_id'=>$request->user_id,
                                  'name'=>$request->name,
                                  'slug'=>$this->getSlug($request->name,'','restaurants')
                                ]);
              $this->restaurantLocation->create([
                                    'user_id'=>$request->user_id,
                                    'restaurant_id'=>$restaurantId->id,
                                    'location'=>$request->location,
                                    'country'=>$request->country,
                                    'state'=>$request->state,
                                    'city'=>isset($request->city)?$request->city:''
                                  ]);

                $res_background='';
               if ($request->hasFile('background_image')) 
               {
                 $images = $request->file('background_image');
                 $res_background = Uuid::uuid4()->toString().'.'.$images->getClientOriginalExtension();
                 $destinationPath = public_path('/uploads/restaurant/');
                 $images->move($destinationPath, $res_background);
               }
              $this->restaurantbranch->create([
                                    'user_id'=>$request->user_id,
                                    'restaurant_id'=>$restaurantId->id,
                                    'phone'=>isset($request->phone)?$request->phone:'',
                                    'description'=>isset($request->description)?$request->description:'',
                                    'preparation_day'=>isset($request->preparation_day)?$request->preparation_day:0,
                                    'delivery_day'=>isset($request->delivery_day)?$request->delivery_day:0,
                                    'order_time'=>isset($request->order_time)?$request->order_time:0,
                                    'background_image'=>isset($res_background)? $res_background:'',
                                  ]);

               $images = $request->file('image');
                if ($request->hasFile('image')) {
                    foreach ($images  as $key => $value) {

                         $name = Uuid::uuid4()->toString().'.'.$value->getClientOriginalExtension();
                         $destinationPath = public_path('/uploads/restaurant/');
                          if($value->getClientOriginalExtension()!='mp4')
                          {
                              $value->move($destinationPath, $name);
                              $img = Image::make(public_path('/uploads/restaurant/'.$name));
                              $img->crop(1024, 680);
                              $croppath =RESTAURANT_ROOT_PATH.'/'.$name;
                              $img->save($croppath);
                            }else
                            {
                               $value->move($destinationPath, $name);
                            }
                        
                          $resimage= array('user_id'=>$request->user_id,'restaurant_id'=>$restaurantId->id,'image'=>$name);
                        DB::table('restaurant_images')->insert($resimage);
                      }    
                }
                $this->restauranttimes($request->user_id,$restaurantId->id,$request->time);

             return redirect()->to('admin/restaurant')->with(['flash_success' => trans('Restaurant Add successfully.')]);

    }
    /**
     * @param DietAddRequest $request
     * @return View
     */



    public function approved11111($id=null)
    {
     $restaurantappr= $this->restaurant->with('restaurantBranch')->where('id', $id)->first();
     if($restaurantappr->restaurantBranch->preparation_day!=0 && $restaurantappr->restaurantBranch->delivery_day!=0 && $restaurantappr->restaurantBranch->order_time!=0)
     {
        //echo '<pre>'; print_r($restaurantappr); exit;
        if($restaurantappr->is_active=='APPROVED')
        {
          $this->restaurant->where('id', $id)->update([
              'is_active' =>'PENDING',
          ]);
           return redirect()->back()->with(['flash_success' => trans('Restaurant Unapproved successfully.')]);
        }
        else
        {
          $this->restaurant->where('id', $id)->update([
              'is_active' =>'APPROVED',
          ]);
           return redirect()->back()->with(['flash_success' => trans('Restaurant approved successfully.')]);
        }
      }else{
          return redirect()->back()->with(['flash_danger' => trans('Please update delivery day, Preparation day and Order time After approved restaurant.')]);
      }
      
    }


    public function approved($id=null)
    {
     $restaurantappr= $this->restaurant->with('restaurantBranch')->where('id', $id)->first();
     
        //echo '<pre>'; print_r($restaurantappr); exit;
      if($restaurantappr->is_active=='APPROVED')
      {
        $this->restaurant->where('id', $id)->update([
            'is_active' =>'PENDING',
        ]);
         return redirect()->back()->with(['flash_success' => trans('Restaurant Unapproved successfully.')]);
      }
      else
      {
        $this->restaurant->where('id', $id)->update([
            'is_active' =>'APPROVED',
        ]);
         return redirect()->back()->with(['flash_success' => trans('Restaurant approved successfully.')]);
      }
      
    }

    
    public function delete($id=null) {
      $this->restaurant->where('id', $id)->delete();
      return redirect()->back()->with(['flash_success' => trans('Restaurant deleted successfully.')]);
    }

    /**
     * @param DietSaveRequest $request
     */
    public function restaurantView($id=null)
    {
      $restaurant = $this->restaurant->where('id',$id)->with('restaurantCategory','restaurantImage','restaurantTime','restaurantLocation','restaurantBranch')->first();

      $servicetype=$this->servicetype->where('restaurant_id',$restaurant->id)->pluck('service_type_id')->all();
     // echo '<pre>'; print_r($restaurant); exit;
  
        return view('backend.restaurant.show', compact('restaurant','servicetype'));
    }

    public function restaurantEdit($id=null)
    {
      $restaurants = $this->restaurant->where('id',$id)->with('restaurantCategory','restaurantImage','restaurantTime','restaurantLocation','restaurantBranch')->first();
       $restaurantCategory = $this->restaurantCategory
                          ->where('user_id',$restaurants->user_id)
                          ->where('restaurant_id',$restaurants->id)
                          ->pluck('category_id')
                          ->all();
      $categories=Category::get();
      $categorysdata=Category::pluck('id')->all();
      $servicetype=$this->servicetype->where('restaurant_id',$restaurants->id)->pluck('service_type_id')->all();
      $countriedata = $this->country->where('sortname','US')->select('name','id')->get();
        $states=[];
        $cities=[];
        if(isset($restaurants->restaurantLocation->country) && !empty($restaurants->restaurantLocation->country))
        {
          $countrname = $this->country->where('name',$restaurants->restaurantLocation->country)->select('name','id')->first();
        }

        
         if(!empty($countrname))
         {
          $states = $this->state->where('country_id',$countrname->id)->select('name')->get();
         }
         if(isset($restaurants->restaurantLocation->state) && !empty($restaurants->restaurantLocation->state))
         {
          $statesname = $this->state->where('name',$restaurants->restaurantLocation->state)->select('name','id')->first();
         }
        if(!empty($statesname))
        {
         $cities = $this->city->where('state_id', $statesname->id)->select('name','id')->get();
        }
      //echo '<pre>'; print_r($restaurantCategory); exit;
	  
	  	$rating_product_ids= Product::where('products.user_id',$restaurants->user_id)->pluck('id')->toArray();
		
		$total_user		='';
		$total_user_rating	='';
		if(count($rating_product_ids)>0){
			$rating_result= DB::table('ratings')->whereIN('product_id',$rating_product_ids)->get();
			if(count($rating_result)>0){
				$totalsum=collect($rating_result)->sum('average_rating');
				$total_user= count($rating_result);
				$ratingreview=($totalsum/$total_user);
				$total_user_rating=number_format(floor($ratingreview*100)/100,2, '.', '');
			}
		}
	  
  
        return view('backend.restaurant.edit', compact('restaurants','servicetype','categorysdata','categories','restaurantCategory','countriedata','states','cities','total_user','total_user_rating'));
    }

     public  function restaurantUpdate($id=null, UpdateRestaurantRequest $request)
     {
       $name=$request->oldimage;
       if ($request->hasFile('backimage')) {

         $backImage= RestaurantBranch::where('user_id',$id)->first();
         if(File::exists(RESTAURANT_ROOT_PATH.$backImage->background_image))
         {
           File::delete(RESTAURANT_ROOT_PATH.$backImage->background_image);
         }
        $image = $request->file('backimage');
        $name = rand(0000,9999).'.'.$image->getClientOriginalExtension();
        $destinationPath = RESTAURANT_ROOT_PATH;
        $image->move($destinationPath,$name);
      }
        //echo '<pre>'; print_r($request->all()); exit;
      $ups_account_no = trim($request->ups_account_no);
      $preparation_time = trim($request->preparation_time);
      $delivery_days = trim($request->delivery_days);
      $pickuptime = $request->pickuptime;
      $shipping_info = ['preparation_time' => $preparation_time, 'delivery_days' => $delivery_days, 'pickuptime' => $pickuptime];
      Restaurant::where('id', $request->restaurant_id)->update(['name' => $request->name, 'ups_account_no' =>$request->ups_account_no, 'is_home_show' =>$request->is_home_show,'is_rating_show' =>$request->is_rating_show,'shipping_info' => json_encode($shipping_info)]);
      RestaurantBranch::where('user_id', $id)->update([
	  		'phone' =>$request->phone,
          	'preparation_day' =>$request->preparation_day, 'delivery_day' =>$request->delivery_day, 'order_time' =>$request->order_time,'background_image'=>$name, 'description' => $request->description
        ]);
        $restaurantId=$request->restaurant_id;
        $userId=$id;
        $this->restauranttimes($userId, $restaurantId, $request->time);
        /*if(isset($request->restaurantmage) && !empty($request->restaurantmage))
        {
         $this->restaurantImage($userId, $restaurantId, $request->restaurantmage);
        }*/

        if(isset($request->restaurant_image_url)){
            $restaurantimagedata = RestaurantImage::where('restaurant_id',$restaurantId)->get();
            foreach ($restaurantimagedata as $k => $v) {
              RestaurantImage::where('id',$v->id)->update(['image' => $request->restaurant_image_url[$k]]);
            }
          }

        $images = $request->file('restaurantmage');
        if ($request->hasFile('restaurantmage')){
           foreach ($images  as $key => $value)
            {
                $name = Uuid::uuid4()->toString().'.'.$value->getClientOriginalExtension();
               $destinationPath = public_path('/uploads/restaurant/');
                if($value->getClientOriginalExtension()!='mp4')
                {
                    $value->move($destinationPath, $name);
                    $img = Image::make(public_path('/uploads/restaurant/'.$name));
                    $img->crop(1024, 680);
                    $croppath =RESTAURANT_ROOT_PATH.'/'.$name;
                    $img->save($croppath);

                    $name2 = 'th_' . $name;
                    $img2 = Image::make($croppath)->resize(500, 332);
                    $croppath2 = RESTAURANT_ROOT_PATH.'/'.$name2;
                    $img2->save($croppath2, 60);
                  }else
                  {
                     $value->move($destinationPath, $name);
                  }
                $restaurantimage= array('user_id' => $userId, 'restaurant_id'=>$restaurantId,'image'=>$name);
              DB::table('restaurant_images')->insert($restaurantimage);
            }
        }

        $oldcats = $this->restaurantCategory->where('restaurant_id', $restaurantId)->pluck('category_id')->all();
        $oldcats = !is_array($oldcats) ? [] : $oldcats;
        $category_ids = $request->category_id;
        if(is_array($category_ids)) {
          foreach ($category_ids as $key => $value) {
            if(!in_array($value, $oldcats))
              $this->restaurantCategory->create(['user_id' => $userId, 'restaurant_id' => $restaurantId, 'category_id' => $value]);
          }
        } else {
          $category_ids = [];
        }
        foreach ($oldcats as $key => $value) {
          if(!in_array($value, $category_ids))
            $this->restaurantCategory->where('restaurant_id', $restaurantId)->where('category_id', $value)->delete();
        }
        //print_r($oldcats); die;

        $this->saveAndUpdateRestaurantLocation($userId, $restaurantId, $request);

        return redirect()->back()->with(['flash_success' => trans('Restaurant update successfully.')]);
     }

    private function saveAndUpdateRestaurantLocation(int $userId, int $restaurantId, object $requestData)
    {
        $this->restaurantLocation->updateOrCreate(
            [
                'user_id' => $userId
            ],
            [
                //'user_id' => $userId,
                'restaurant_id' => $restaurantId,
                'location' => $requestData->location,
                'country' => $requestData->country,
                'state' => $requestData->state,
                'city' => $requestData->city,
                'zip_code' => $requestData->zip_code,
                'latitude' => $requestData->latitude,
                'longitude' => $requestData->longitude,
            ]
        );
    }

     public function restauranttimes(int $userId, int $restaurantId, array $openTime)
    {
        if (!empty($openTime)) {
            $this->restaurantTime->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();
            foreach($openTime as $time) {
                if (array_values($time)[0] && array_values($time)[1] && array_values($time)[2]) {
                    $this->restaurantTime->create([
                        'user_id' => $userId,
                        'restaurant_id' => $restaurantId,
                        'day' => array_values($time)[0],
                        'open' => array_values($time)[1],
                        'close' => array_values($time)[2],
                        'status' => OPEN,
                    ]);
                }
            }
        }
    }

    public function restaurantImage(int $userId, int $restaurantId, array $images)
    {
        if (!empty($images)) {
            foreach ($images as $image) {
              $fileName = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
                 $destinationPath = public_path('/uploads/restaurant/');

                 if($image->getClientOriginalExtension()!='mp4')
                  {
                     $image->move($destinationPath, $fileName);
                      $img = Image::make(public_path('/uploads/restaurant/'.$fileName));
                      $img->crop(1024, 680);
                      $croppath =RESTAURANT_ROOT_PATH.'/'.$fileName;
                      $img->save($croppath);

                      $fileName2 = 'th_' . $fileName;
                      $img2 = Image::make($croppath)->resize(500, 332);
                      $croppath2 = RESTAURANT_ROOT_PATH.'/'.$fileName2;
                      $img2->save($croppath2, 60);
                    }else
                    {
                       $image->move($destinationPath, $fileName);
                    }
                 
                    $this->restaurantImage->create([
                        'user_id' => $userId,
                        'restaurant_id' => $restaurantId,
                        'image' => $fileName,
                    ]);

                
            }
        }

        return;
    }
    public function restaurantRemoveImage(Request $request)
    {
       $imageId = $request->get('image_id');

        $restaurantImage = $this->restaurantImage->find($imageId)->delete();
        if ($restaurantImage) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    
    }

      public function restaurantRemoveBackImage(Request $request)
    {
       $imageId = $request->get('image_id');
         $restImage= RestaurantBranch::where('id',$imageId)->first();

         if(File::exists(RESTAURANT_ROOT_PATH.$restImage->background_image))
         {
           File::delete(RESTAURANT_ROOT_PATH.$restImage->background_image);
          $restaurantImage = RestaurantBranch::find($imageId)->update(['background_image'=>NULL]);
         }
        if ($restaurantImage) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    
    }


    public function getBackendState(Request $request)
    {
        $countryId  = $request->get('country_id');
        $countryId=$this->country->where('name',$countryId)->select('id')->first();
        if ($countryId !='') {
            $stateList  = $this->state
                                ->where('country_id',$countryId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control box-size" id="resstate" name="state"><option value="">'.trans('Select State').'</option>';

            if (count($stateList)>0) {
                foreach($stateList as $k=>$v) {
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        } else {
            echo '<select class="form-control box-size" name="state"><option value="">'.trans('Select State').'</option></select>';
            die;
        }
    }

    /**
     * @param AddressFormRequest $request
     */
    public function getBackendCity(Request $request)
    {
        $stateId  = $request->get('state_id');
         $stateId=$this->state->where('name',$stateId)->select('id')->first();
        if ($stateId !='') {
            $cityList = $this->city
                                ->where('state_id', $stateId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control box-size"  name="city"><option value="">'.trans('Select City').'</option>';

            if(count($cityList)>0){
                foreach($cityList as $k=>$v){
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        }else{
            echo '<select class="form-control box-size" name="city"><option value="">'.trans('Select City').'</option></select>';
            die;
        }
    }

    
}
