<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantBranch;
use App\Models\Restaurant\RestaurantCategory;
use App\Models\Restaurant\RestaurantImage;
use App\Models\Restaurant\RestaurantLocation;
use App\Models\Restaurant\RestaurantServiceType;
use App\Models\Restaurant\RestaurantTime;
use App\Models\Categories\Category;
use App\Repositories\Frontend\Access\User\UserRepository;
use Ramsey\Uuid\Uuid;
use App\Models\Access\User\User;
use Validator;
class RestaurantsController extends APIController
{
      /**
     * @var Restaurant
     */
    private $restaurant;

    /**
     * @var RestaurantBranch
     */
    private $restaurantBranch;

    /**
     * @var RestaurantLocation
     */
    private $restaurantLocation;

    /**
     * @var RestaurantCategory
     */
    private $restaurantCategory;

    /**
     * @var RestaurantServiceType
     */
    private $restaurantServiceType;

    /**
     * @var RestaurantTime
     */
    private $restaurantTime;

    /**
     * @var RestaurantImage
     */
    private $restaurantImage;
  /**
     * @var User
     */
    protected $user;

  protected $repository;

    public function __construct(
        Restaurant $restaurant,
        RestaurantBranch $restaurantBranch,
        RestaurantLocation $restaurantLocation,
        RestaurantCategory $restaurantCategory,
        RestaurantServiceType $restaurantServiceType,
        RestaurantTime $restaurantTime,
        RestaurantImage $restaurantImage,
        UserRepository $repository,
        User $user
    ) {
        $this->restaurant = $restaurant;
        $this->restaurantBranch = $restaurantBranch;
        $this->restaurantLocation = $restaurantLocation;
        $this->restaurantCategory = $restaurantCategory;
        $this->restaurantServiceType = $restaurantServiceType;
        $this->restaurantTime = $restaurantTime;
        $this->restaurantImage = $restaurantImage;
        $this->repository = $repository;
        $this->user = $user;
    }
 

    public function restsurantInformation(Request $request)
    {
      if(!empty($request->get('user_id')))
      {

        $restaurants =$this->restaurant
                    ->where('user_id', $request->get('user_id'))
                    ->with(
                        'restaurantCategory',
                        'restaurantServiceType',
                        'restaurantTime',
                        'restaurantImage',
                        'restaurantBranch',
                        'restaurantLocation'
                    )
                    ->firstOrFail();
                    // echo '<pre>'; print_r($restaurants);
          if(!empty($restaurants))
          {  
              $category=array();
              foreach ($restaurants->restaurantCategory as $key => $Categorys) {
                $category[$key]['id']= $Categorys->category->id;
                 $category[$key]['name']= $Categorys->category->name;
               
              }
              $servicetype=array();
              foreach ($restaurants->restaurantServiceType as $key => $serviceType) {
                 $servicetype[]= $serviceType->service_type_id;
              }
              $restauranttime;array();
               foreach ($restaurants->restaurantTime as $key => $time) {
                 $restauranttime[$key]['day']= $time->day;
                 $restauranttime[$key]['open']= $time->open;
                 $restauranttime[$key]['close']= $time->close;
                  if($time->status=='OPEN'){
                     $restauranttime[$key]['isOpen']=1;
                  }
                  else
                  {
                     $restauranttime[$key]['isOpen']=0;
                  }
              }

              $image=array();
               foreach ($restaurants->restaurantImage as $key => $images) {
                 $image[$key]= url('uploads/restaurant').'/'.$images->image;
              }
              $restaurant['restaurant_id']=$restaurants->id;
              $restaurant['user_id']=$restaurants->user_id;
              $restaurant['restaurant_name']=$restaurants->name;
              $restaurant['location']= $restaurants->restaurantLocation->location;
              $restaurant['country']= $restaurants->restaurantLocation->country;
              $restaurant['state']= $restaurants->restaurantLocation->state;
              $restaurant['city']= $restaurants->restaurantLocation->city;
              $restaurant['zip_code']= $restaurants->restaurantLocation->zip_code;
              $restaurant['lat']= $restaurants->restaurantLocation->latitude;
              $restaurant['long']= $restaurants->restaurantLocation->longitude;
              $restaurant['phone']=$restaurants->restaurantBranch->phone;
              $restaurant['description']=$restaurants->restaurantBranch->description;
              $restaurant['category']=$category;
              $restaurant['servicetype']=$servicetype;
              $restaurant['time']=$restauranttime;
              $restaurant['image']=$image;
              return $this->respond([
                'status'=>'1',
                'message'=>'information data successfully get.',
                'data'=>$restaurant]);
          } else {
            return $this->respond([
                'status'=>'0',
                'message'=>'Data not found.']);

          }
              
      } else {
         $restaurant['status']='0';
         $restaurant['message']='User Id invalid';
         return $this->respond($restaurant);
      }
     
    }


    public function addRestaurant(Request $request)
    {
       $categoryid=explode(',', $request->get('categoryIds'));
       $servicetype=explode(',', $request->get('serviceTypeIds'));
       $restauranttime=json_decode($request->get('openTime'));
        //return $this->respond([
        //  'data'=>$restauranttime]);
      // echo '<pre>'; print_r($restauranttime); exit;
       
      $newrestaurant=$this->restaurant->updateOrCreate(
            [
                'id' => $request->get('id')
            ],
            [
                'user_id' => $request->get('user_id'),
                'name' => $request->get('name'),
                'slug' => $this->getSlug($request->get('name'),'','restaurants'),
            ]
        );

        $restaurantId =$newrestaurant->id;
        $userId = $request->get('user_id');
        $this->saveAndUpdateRestaurantBranch($userId, $restaurantId, $request);
        $this->saveAndUpdateRestaurantLocation($userId, $restaurantId, $request);
        $this->restaurantCategory($userId, $restaurantId, $categoryid);
        $this->restaurantServiceType($userId, $restaurantId, $servicetype);
        $this->restaurantTime($userId, $restaurantId, $restauranttime);

        if(!empty($request->file('image')))
        {
        $imageimage=  $this->restaurantImage($userId, $restaurantId, $request->file('image'));
        $imagedata=json_encode($imageimage);
      }
      
    
      // print_r(json_decode($imagedaya));exit;
      $category=array();
      foreach ($categoryid as $key => $value) {
        $categoryname=Category::where('id',$value)->first();
          $category[$key]['id']=$categoryname->id;
          $category[$key]['name']=$categoryname->name;
      }
      $servicedata=array();
      foreach ($servicetype as $k => $service) {
        $servicedata[]=$service;
      }

        $restaurant['name']=$request->get('name');
        $restaurant['user_id']=$request->get('user_id');
        $restaurant['location']=$request->get('location');
        $restaurant['country']=$request->get('country');
        $restaurant['state']=$request->get('state');
        $restaurant['city']=$request->get('city');
        $restaurant['zipcode']=$request->get('zipcode');
        $restaurant['latitude']=$request->get('latitude');
        $restaurant['latitude']=$request->get('latitude');
        $restaurant['longitude']=$request->get('longitude');
        $restaurant['categoryid']=$category;
        $restaurant['servicetype']=$servicedata;
        $restaurant['time']=json_decode($request->get('openTime'));
         if(!empty($request->file('image')))
        {
        $restaurant['image']=json_decode($imagedata);
        }
        else {
           $restaurant['image']='null';
        }

        return$this->respond([
              'status'=>'1',
              'message' =>'Restaurant successfully updated',
              'data'=>$restaurant
            ]);
       
    }


    
    private function saveAndUpdateRestaurantBranch(int $userId, int $restaurantId, object $requestData)
    {
        $this->restaurantBranch->updateOrCreate(
            [
                'user_id' => $userId
            ],
            [
                'user_id' => $userId,
                'restaurant_id' => $restaurantId,
                'phone' => $requestData->get('phone'),
                'description' => $requestData->get('description')
            ]
        );
    }

    private function saveAndUpdateRestaurantLocation(int $userId, int $restaurantId, object $requestData)
    {
        $this->restaurantLocation->updateOrCreate(
            [
                'user_id' => $userId
            ],
            [
                'user_id' => $userId,
                'restaurant_id' => $restaurantId,
                'location' => $requestData->get('location'),
                'country' => $requestData->get('country'),
                'state' => $requestData->get('state'),
                'city' => $requestData->get('city'),
                'zip_code' => $requestData->get('zipcode'),
                'latitude' => $requestData->get('latitude'),
                'longitude' => $requestData->get('longitude'),
            ]
        );
    }

    private function restaurantCategory(int $userId, int $restaurantId, array $categoryIds)
    {
        if (isset($restaurantId)) {
            $this->getRestaurantCategory($userId, $restaurantId)->delete();
        }
        if (!empty($categoryIds)) {
            foreach ($categoryIds as $categoryId) {
                $this->restaurantCategory->create([
                    'user_id' => $userId,
                    'restaurant_id' => $restaurantId,
                    'category_id' => $categoryId
                ]);
            }
        }

        return;
    }

    private function restaurantServiceType(int $userId, int $restaurantId, array $serviceTypeIds)
    {
        if (isset($restaurantId)) {
            $this->getRestaurantServiceType($userId, $restaurantId)->delete();
        }
        if (!empty($serviceTypeIds)) {
            foreach ($serviceTypeIds as $serviceTypeId) {
                $this->restaurantServiceType->create([
                    'user_id' => $userId,
                    'restaurant_id' => $restaurantId,
                    'service_type_id' => $serviceTypeId
                ]);
            }
        }

        return;
    }
    
    public function restaurantTime(int $userId, int $restaurantId, array $openTime)
    {
       //echo '<pre>'; print_r($openTime); exit;
        if (!empty($openTime)) {
            $this->restaurantTime->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();
            // print_r($openTime);exit;
            foreach($openTime as $key=>$time) {
                    $this->restaurantTime->create([
                        'user_id' => $userId,
                        'restaurant_id' => $restaurantId,
                        'day' => $time->day,
                        'open' => $time->open,
                        'close' => $time->close,
                        'status' => $time->status,
                    ]);
                
            }
        }
    }

     public function restaurantImage(int $userId, int $restaurantId, array $images)
    {
       $imagename=array();
        if (!empty($images)) {
          $this->restaurantImage->where('user_id',$userId)->where('restaurant_id',$restaurantId)->delete();
            foreach ($images as $image) {
                if (!empty($image)) {
                    $fileName = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
                     $imagename[]=url('uploads/restaurant').'/'.$fileName;
                  $image->move(RESTAURANT_ROOT_PATH, $fileName);
                    $this->restaurantImage->create([
                        'user_id' => $userId,
                        'restaurant_id' => $restaurantId,
                        'image' => $fileName,
                    ]);

                }
            }
        }

        return $imagename;
    }
       public function getRestaurantCategory(int $userId, int $restaurantId)
      {
          return $this->restaurantCategory->where(['user_id' => $userId, 'restaurant_id' => $restaurantId]);
      }

     public function getRestaurantServiceType(int $userId, int $restaurantId)
    {
        return $this->restaurantServiceType->where(['user_id' => $userId, 'restaurant_id' => $restaurantId]);
    }


    public function showBranch(Request $request)
    {
       $validation = Validator::make($request->all(), [
            'user_id' =>'required',
            'restaurant_id' => 'required',
          ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

          if(!empty($request->get('user_id')))
          {

            $restaurants =$this->restaurantBranch
                        ->where('user_id', $request->get('user_id'))
                        ->with(
                            'restaurantCategory',
                            'restaurantServiceType',
                            'restaurantTime',
                            'restaurantImage',
                            'restaurantLocation'
                        )
                        ->firstOrFail();
                       //echo '<pre>'; print_r($restaurants);
              if(!empty($restaurants))
              {  
                  $category=array();
                  foreach ($restaurants->restaurantCategory as $key => $Categorys) {
                    $category[$key]['id']= $Categorys->category->id;
                     $category[$key]['name']= $Categorys->category->name;
                   
                  }
                  $servicetype=array();
                  foreach ($restaurants->restaurantServiceType as $key => $serviceType) {
                     $servicetype[]= $serviceType->service_type_id;
                  }
                  $restauranttime;array();
                   foreach ($restaurants->restaurantTime as $key => $time) {
                     $restauranttime[$key]['day']= $time->day;
                     $restauranttime[$key]['open']= $time->open;
                     $restauranttime[$key]['close']= $time->close;
                      if($time->status=='OPEN'){
                         $restauranttime[$key]['isOpen']=1;
                      }
                      else
                      {
                         $restauranttime[$key]['isOpen']=0;
                      }
                  }

                  $image=array();
                   foreach ($restaurants->restaurantImage as $key => $images) {
                     $image[$key]= url('uploads/restaurant').'/'.$images->image;
                  }
                  $restaurant['restaurant_id']=$restaurants->restaurant_id;
                  $restaurant['user_id']=$restaurants->user_id;
                  $restaurant['location']= $restaurants->restaurantLocation->location;
                  $restaurant['country']= $restaurants->restaurantLocation->country;
                  $restaurant['state']= $restaurants->restaurantLocation->state;
                  $restaurant['city']= $restaurants->restaurantLocation->city;
                  $restaurant['zip_code']= $restaurants->restaurantLocation->zip_code;
                  $restaurant['lat']= $restaurants->restaurantLocation->latitude;
                  $restaurant['long']= $restaurants->restaurantLocation->longitude;
                  $restaurant['phone']=$restaurants->phone;
                  $restaurant['description']=$restaurants->description;
                  $restaurant['category']=$category;
                  $restaurant['servicetype']=$servicetype;
                  $restaurant['time']=$restauranttime;
                  $restaurant['image']=$image;
                  return $this->respond([
                    'status'=>'1',
                    'message'=>'information data successfully get.',
                    'data'=>$restaurant]);
              } else {
                return $this->respond([
                    'status'=>'0',
                    'message'=>'Data not found.']);

              }
                  
          } else {
             $restaurant['status']='0';
             $restaurant['message']='User Id invalid';
             return $this->respond($restaurant);
          }
    }

    public function addBranch(Request $request)
    {
        $validation = Validator::make($request->all(), 
          ['user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'location' =>'required',
            'country' =>'required',
            'state' =>'required',
            'city' =>'required',
            'zipcode' =>'required',
            'phone' =>'required',
            'category' =>'required',
            'image' =>'required',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }
        $request['password']= rand(111111, 999999);
        $request['role']=4;
      //echo '<pre>'; print_r($request->all()); exit;
        $user = $this->repository->branchAdd($request);

        $restaurantdata= $this->restaurant->where('user_id',$request->get('user_id'))->first();

         $categoryid=explode(',', $request->get('category'));
       $servicetype=explode(',', $request->get('servicetype'));
       $restauranttime=json_decode($request->get('openTime'));

        $restaurantId =$restaurantdata->id;
        $userId = $user->id;
        $this->saveAndUpdateRestaurantBranch($userId, $restaurantId, $request);
        $this->saveAndUpdateRestaurantLocation($userId, $restaurantId, $request);
        $this->restaurantCategory($userId, $restaurantId, $categoryid);
        $this->restaurantServiceType($userId, $restaurantId, $servicetype);
        $this->restaurantTime($userId, $restaurantId, $restauranttime);
         if(!empty($request->file('image')))
          {
           $imageimage=  $this->restaurantImage($userId, $restaurantId, $request->file('image'));
            $imagedata=json_encode($imageimage);
          }

           $category=array();
            foreach ($categoryid as $key => $value) {
              $categoryname=Category::where('id',$value)->first();
                $category[$key]['id']=$categoryname->id;
                $category[$key]['name']=$categoryname->name;
            }
            $servicedata=array();
            foreach ($servicetype as $k => $service) {
              $servicedata[]=$service;
            }

              $restaurant['first_name']=$request->get('first_name');
              $restaurant['last_name']=$request->get('last_name');
              $restaurant['branch_id']=$user->id;
              $restaurant['restaurant_id']=$restaurantId;
              $restaurant['user_id']=$request->get('user_id');
              $restaurant['location']=$request->get('location');
              $restaurant['country']=$request->get('country');
              $restaurant['state']=$request->get('state');
              $restaurant['city']=$request->get('city');
              $restaurant['zipcode']=$request->get('zipcode');
              $restaurant['latitude']=$request->get('latitude');
              $restaurant['latitude']=$request->get('latitude');
              $restaurant['longitude']=$request->get('longitude');
              $restaurant['categoryid']=$category;
              $restaurant['servicetype']=$servicedata;
              $restaurant['time']=json_decode($request->get('openTime'));
               if(!empty($request->file('image')))
              {
              $restaurant['image']=json_decode($imagedata);
              }
              else {
                 $restaurant['image']='null';
              }

              $mailData = [
                  'name' => $user->first_name .' '. $user->last_name,
                  'email' => $user->email,
                  'password' => $request->password,
                  'url' => url('login'),
              ];

             $this->sendMail(
                  $mailData,
                   'emails.user_registration',
                   'New user registration'
                  );

              return$this->respond([
                    'status'=>'1',
                    'message' =>'Branch successfully Added',
                    'data'=>$restaurant
                  ]);
    }

     public function updateBranch(Request $request)
     {
        if(!empty($request->get('id')))
        {
          $branddata= $this->user->where('id', $request->get('id'))->update([
                  'first_name' => $request->first_name,
                  'last_name' => $request->last_name,
              ]);
          if(!empty($branddata))
          {
             $categoryid=explode(',', $request->get('category'));
             $servicetype=explode(',', $request->get('servicetype'));
             $restauranttime=json_decode($request->get('openTime'));

              $restaurantdata=$this->restaurantBranch->where('user_id',$request->get('id'))->first();
              $restaurantId =$restaurantdata->restaurant_id;
              $userId = $request->get('id');
              $this->saveAndUpdateRestaurantBranch($userId, $restaurantId, $request);
              $this->saveAndUpdateRestaurantLocation($userId, $restaurantId, $request);
              $this->restaurantCategory($userId, $restaurantId, $categoryid);
              $this->restaurantServiceType($userId, $restaurantId, $servicetype);
              $this->restaurantTime($userId, $restaurantId, $restauranttime);
               if(!empty($request->file('image')))
                {
                 $imageimage=  $this->restaurantImage($userId, $restaurantId, $request->file('image'));
                  $imagedata=json_encode($imageimage);
                }

                 $category=array();
                  foreach ($categoryid as $key => $value) {
                    $categoryname=Category::where('id',$value)->first();
                      $category[$key]['id']=$categoryname->id;
                      $category[$key]['name']=$categoryname->name;
                  }
                  $servicedata=array();
                  foreach ($servicetype as $k => $service) {
                    $servicedata[]=$service;
                  }

                    $restaurant['first_name']=$request->get('first_name');
                    $restaurant['last_name']=$request->get('last_name');
                    $restaurant['branch_id']=$request->get('id');
                    $restaurant['restaurant_id']=$restaurantId;
                    $restaurant['location']=$request->get('location');
                    $restaurant['country']=$request->get('country');
                    $restaurant['state']=$request->get('state');
                    $restaurant['city']=$request->get('city');
                    $restaurant['zipcode']=$request->get('zipcode');
                    $restaurant['latitude']=$request->get('latitude');
                    $restaurant['latitude']=$request->get('latitude');
                    $restaurant['longitude']=$request->get('longitude');
                    $restaurant['categoryid']=$category;
                    $restaurant['servicetype']=$servicedata;
                    $restaurant['time']=json_decode($request->get('openTime'));
                     if(!empty($request->file('image')))
                    {
                    $restaurant['image']=json_decode($imagedata);
                    }
                    else {
                       $restaurant['image']='null';
                    }
                     return$this->respond([
                          'status'=>'1',
                          'message' =>'Branch successfully updated',
                          'data'=>$restaurant
                        ]);
             } else {
                       return$this->respond([
                          'status'=>'1',
                          'message' =>'Data not found.',
                          ]);
               }
         } else {
                return$this->respond([
                      'status'=>'0',
                      'message' =>'Brand Id not found.',
                    ]);
             }
     }


    public function branchList(Request $request)
    {
       $validation = Validator::make($request->all(), [
            'user_id'       => 'required',
            'restaurant_id' => 'required',
          ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

          if(!empty($request->get('user_id')))
          {

            $restaurants =$this->restaurantBranch
                         ->where('restaurant_id', $request->get('restaurant_id'))
                         ->where('user_id','!=', $request->get('user_id'))
                        ->with(
                            'restaurantCategory',
                            'restaurantServiceType',
                            'restaurantTime',
                            'restaurantImage',
                            'restaurantLocation',
                            'user'
                        )
                        ->get();
                       //echo '<pre>'; print_r($restaurants);//exit;
              if(count($restaurants)>0)
              {  
                $branchlist=array();
                foreach ($restaurants as $r => $restaurant)
                {
                  $category=array();
                  foreach ($restaurant->restaurantCategory as $k => $Categorys) {
                   $category[$k]['id']= $Categorys->category->id;
                     $category[$k]['name']= $Categorys->category->name;
                   
                  }
                  
                  $servicetype=array();
                  foreach ($restaurant->restaurantServiceType as $key => $serviceType) {
                     $servicetype[]= $serviceType->service_type_id;
                  }
                  $restauranttime;array();
                   foreach ($restaurant->restaurantTime as $key => $time) {
                     $restauranttime[$key]['day']= $time->day;
                     $restauranttime[$key]['open']= $time->open;
                     $restauranttime[$key]['close']= $time->close;
                      if($time->status=='OPEN'){
                         $restauranttime[$key]['isOpen']=1;
                      }
                      else
                      {
                         $restauranttime[$key]['isOpen']=0;
                      }
                  }

                  $image=array();
                   foreach ($restaurant->restaurantImage as $key => $images) {
                     $image[$key]= url('uploads/restaurant').'/'.$images->image;
                  }
                  
                  $branchlist[$r]['restaurant_id']=$restaurant->restaurant_id;
                  $branchlist[$r]['branch_owner_id']=$restaurant->user_id;
                  $branchlist[$r]['branch_manager_fname']=$restaurant->user->first_name;
                  $branchlist[$r]['branch_manager_lname']=$restaurant->user->last_name;
                  $branchlist[$r]['branch_manager_email']=$restaurant->user->email;
                  $branchlist[$r]['branch_manager_phone']=$restaurant->user->phone;
                  $branchlist[$r]['branch_manager_image']=url('uploads/user').'/'.$restaurant->user->slug.'/'.$restaurant->user->image;
                  $branchlist[$r]['branch_location']= $restaurant->restaurantLocation->location;
                  $branchlist[$r]['branch_country']= $restaurant->restaurantLocation->country;
                  $branchlist[$r]['branch_state']= $restaurant->restaurantLocation->state;
                  $branchlist[$r]['branch_city']= $restaurant->restaurantLocation->city;
                  $branchlist[$r]['branch_zip_code']= $restaurant->restaurantLocation->zip_code;
                  $branchlist[$r]['branch_lat']= $restaurant->restaurantLocation->latitude;
                  $branchlist[$r]['branch_long']= $restaurant->restaurantLocation->longitude;
                  $branchlist[$r]['branch_phone']=$restaurant->phone;
                  $branchlist[$r]['branch_description']=$restaurant->description;
                  $branchlist[$r]['category']=$category;
                  $branchlist[$r]['servicetype']=$servicetype;
                  $branchlist[$r]['time']=isset($restauranttime)?$restauranttime:'';
                  $branchlist[$r]['image']=$image;
                  
                }
                return $this->respond([
                    'status'=>'1',
                    'message'=>'Branch data successfully get.',
                    'data'=>$branchlist]);
              } else {
                return $this->respond([
                    'status'=>'0',
                    'message'=>'Data not found.']);

              }
                  



          } else {
             $restaurant['status']='0';
             $restaurant['message']='User Id invalid';
             return $this->respond($restaurant);
          }
    }


}
