<?php

namespace App\Repositories\Frontend\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantBranch;
use App\Models\Restaurant\RestaurantCategory;
use App\Models\Restaurant\RestaurantImage;
use App\Models\Restaurant\RestaurantLocation;
use App\Models\Restaurant\RestaurantServiceType;
use App\Models\Restaurant\RestaurantTime;
use Ramsey\Uuid\Uuid;
use File;
use Image;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Admin_notification;

class RestaurantRepository
{
      private $country;

    /**
     * @var State
     */
    private $state;

    /**
     * @var City
     */
    private $city;
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
     * @param Restaurant $restaurant
     * @param RestaurantBranch $restaurantBranch
     * @param RestaurantLocation $restaurantLocation
     * @param RestaurantCategory $restaurantCategory
     * @param RestaurantServiceType $restaurantServiceType
     * @param RestaurantTime $restaurantTime
     * @param RestaurantImage $restaurantImage
     */
    public function __construct(
        Restaurant $restaurant,
        Country $country,
        State $state,
        City $city,
        RestaurantBranch $restaurantBranch,
        RestaurantLocation $restaurantLocation,
        RestaurantCategory $restaurantCategory,
        RestaurantServiceType $restaurantServiceType,
        RestaurantTime $restaurantTime,
        RestaurantImage $restaurantImage
    ) {
        $this->restaurant = $restaurant;
        $this->restaurantBranch = $restaurantBranch;
        $this->restaurantLocation = $restaurantLocation;
        $this->restaurantCategory = $restaurantCategory;
        $this->restaurantServiceType = $restaurantServiceType;
        $this->restaurantTime = $restaurantTime;
        $this->restaurantImage = $restaurantImage;
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
    }

    /**
     * @param object $requestData
     */
    public function updateOrCreate(object $requestData)
    {
        $this->restaurant->updateOrCreate(
            [
                'id' => $requestData->id(),
                'user_id' => auth()->user()->id,
            ],
            [
                'name' => $requestData->name(),
                'slug' => (!$requestData->id()) ? app(Controller::class)
                                ->getSlug($requestData->name(), '', 'restaurants') : $requestData->slug(),
                'ups_account_no' => $requestData->ups_account_no,
                'is_active' => 'PENDING'
            ]
        );

        $restaurantId = $this->restaurantDetail()->id();
        $userId = $this->restaurantDetail()->userId();

        $this->saveAndUpdateRestaurantBranch($userId, $restaurantId, $requestData);
        $this->saveAndUpdateRestaurantLocation($userId, $restaurantId, $requestData);
        $this->restaurantCategory($userId, $restaurantId, $requestData->categoryIds());
        $this->restaurantServiceType($userId, $restaurantId, $requestData->serviceTypeIds());
        $this->restaurantTime($userId, $restaurantId, $requestData->openTime());


             if(isset($requestData->restaurant_image_id)){
              $productimagedata= RestaurantImage::where('user_id',$userId)->where('restaurant_id',$restaurantId)->get();
              $imagedata=$requestData->restaurant_image_id;
              foreach ($imagedata as $key => $imageid) {
                $this->restaurantImage->where('id', $productimagedata[$key]->id)->update(
                  [ 
                    'image' => $requestData->restaurant_image_url[$key]
                  ]
                );
              }
            }




    $this->restaurantImage($userId, $restaurantId, $requestData->images());

    Admin_notification::create(['user_id' => auth()->user()->id, 'type' => 'RESTAURANT_INFO', 'message' => $requestData->name() . ' restaurant updated', 'json_data' => '{}', 'status' => '0']);

        session()->put('restaurant',
            [
                'title' => trans('Restaurant'),
                'msg' => trans('Restaurant has been successfully Updated.')
            ]
        );


        return;
    }

    /**
     * @return mixed
     */
    public function restaurantDetail()
    {
        return $this->restaurant->where('user_id', auth()->user()->id)
            ->with('restaurantImage','restaurantBranch','restaurantLocation')
            ->first();
    }

    /**
     * @param int $userId
     * @param int $restaurantId
     * @param array $categoryIds
     */
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

    /**
     * @param int $userId
     * @param int $restaurantId
     * @return mixed
     */
    public function getRestaurantCategory(int $userId, int $restaurantId)
    {
        return $this->restaurantCategory->where(['user_id' => $userId, 'restaurant_id' => $restaurantId]);
    }

    /**
     * @param int $userId
     * @param int $restaurantId
     * @param array $serviceTypeIds
     */
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

    /**
     * @param int $userId
     * @param int $restaurantId
     * @return mixed
     */
    public function getRestaurantServiceType(int $userId, int $restaurantId)
    {
        return $this->restaurantServiceType->where(['user_id' => $userId, 'restaurant_id' => $restaurantId]);
    }

    /**
     * @param int $userId
     * @param int $restaurantId
     * @param array $openTime
     */
    public function restaurantTime(int $userId, int $restaurantId, array $openTime)
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

    /**
     * @param int $userId
     * @param int $restaurantId
     * @param array $images
     * @throws \Exception
     */
    public function restaurantImage(int $userId, int $restaurantId, array $images)
    {

        if (!empty($images)) {
            foreach ($images as $image) {
                if (!empty($image)) {
                    $data = explode(';', $image);
                    $data1 = explode(',', $image);
                    $extension = explode("/", $data[0]);

                    $fileName = Uuid::uuid4()->toString() . '.'.$extension[1];
                    if (!is_dir(RESTAURANT_ROOT_PATH)) {
                        mkdir(RESTAURANT_ROOT_PATH);
                    }
                    $ifp = fopen(RESTAURANT_ROOT_PATH.$fileName, 'wb');
                    fwrite($ifp, base64_decode($data1[1]));
                    fclose($ifp);
                     if($extension[1]!='mp4')
                    {
                      $img = Image::make(RESTAURANT_ROOT_PATH.'/'.$fileName);
                      $img->crop(1024, 680);
                      $croppath =RESTAURANT_ROOT_PATH.'/'.$fileName;
                      $img->save($croppath);
                    }

                    $this->restaurantImage->create([
                        'user_id' => $userId,
                        'restaurant_id' => $restaurantId,
                        'image' => $fileName,
                    ]);

                }
            }
        }

        return;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restaurantRemoveImage($request)
    {
        $imageId = $request->get('image_id');

        $restImage= $this->restaurantImage->where('id',$imageId)->first();
         if(File::exists(RESTAURANT_ROOT_PATH.$restImage->image))
         {
           File::delete(RESTAURANT_ROOT_PATH.$restImage->image);
          $restaurantamage = $this->restaurantImage->find($imageId)->delete();
         }
        if (!empty($restaurantamage))


         {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    /**
     * @return mixed
     */
    public function restaurant()
    {
        return $this->restaurant->isApproved()
                    ->with('restaurantSingleImage','restaurantBranch', 'restaurantLocation',
                      'UserSlug')
					->get();
                    //->paginate(PAGINATION);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function restaurantInfomation(string $slug)
    {
        return $this->restaurant
                    ->isApproved()
                    ->where('slug', $slug)
                    ->with([
                        'restaurantCategory',
                        'restaurantServiceType',
                        'restaurantTime',
                        'restaurantImage',
                        'restaurantBranch',
                        'restaurantLocation',
					             	'product'
                    ])
                    ->firstOrFail();
    }

    /**
     * @param int $userId
     * @param int $restaurantId
     * @param object $requestData
     */
    private function saveAndUpdateRestaurantBranch(int $userId, int $restaurantId, object $requestData)
    {
      // print_r($requestData->all());exit;
       $name=$requestData->oldimage;
       if ($requestData->hasFile('backimage')) {

         $backImage= $this->restaurantBranch->where('user_id',$userId)->first();
         if(File::exists(RESTAURANT_ROOT_PATH.$backImage->background_image))
         {
           File::delete(RESTAURANT_ROOT_PATH.$backImage->background_image);
         }
        $image = $requestData->file('backimage');
        $name = rand(0000,9999).'.'.$image->getClientOriginalExtension();
        $destinationPath = RESTAURANT_ROOT_PATH;
        $image->move($destinationPath,$name);
      }
        $this->restaurantBranch->updateOrCreate(
            [
                'user_id' => $userId
            ],
            [   'background_image'=>$name,
                'user_id' => $userId,
                'restaurant_id' => $restaurantId,
                'phone' => $requestData->phoneNo(),
                'description' => $requestData->description()
            ]
        );
    }

    /**
     * @param int $userId
     * @param int $restaurantId
     * @param object $requestData
     */
    private function saveAndUpdateRestaurantLocation(int $userId, int $restaurantId, object $requestData)
    {
        $this->restaurantLocation->updateOrCreate(
            [
                'user_id' => $userId
            ],
            [
                'user_id' => $userId,
                'restaurant_id' => $restaurantId,
                'location' => $requestData->location(),
                'country' => $requestData->country(),
                'state' => $requestData->state(),
                'city' => $requestData->city(),
                'zip_code' => $requestData->zipCode(),
                'latitude' => $requestData->latitude(),
                'longitude' => $requestData->longitude(),
            ]
        );
    }

    /**
     * @param int $userId
     * @param int $restaurantId
     * @param object $requestData
     * @return bool
     * @throws \Exception
     */
    public function createAndUpdateBranch(int $userId, int $restaurantId, object $requestData)
    {
        $this->saveAndUpdateRestaurantBranch($userId, $restaurantId, $requestData);
        $this->saveAndUpdateRestaurantLocation($userId, $restaurantId, $requestData);
        $this->restaurantCategory($userId, $restaurantId, $requestData->categoryIds());
        $this->restaurantServiceType($userId, $restaurantId, $requestData->serviceTypeIds());
        $this->restaurantTime($userId, $restaurantId, $requestData->openTime());
        $this->restaurantImage($userId, $restaurantId, $requestData->images());

        return true;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function branch()
    {
        return $this->restaurantBranch->with('user','restaurantLocation')
            ->where('user_id', '!=', auth()->user()->id)
            ->where('restaurant_id', auth()->user()['isApprovedRestaurant']->id())
            ->paginate(PAGINATION);
    }

    /**
     * @param int $userId
     * @param int $restaurantId
     * @return bool
     */
    public function removeBranch(int $userId, int $restaurantId)
    {
        $this->restaurantBranch->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();
        $this->restaurantLocation->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();
        $this->restaurantCategory->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();
        $this->restaurantServiceType->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();
        $this->restaurantTime->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();
        $this->restaurantImage->where(['user_id' => $userId, 'restaurant_id' => $restaurantId])->delete();

        return true;
    }

    /**
     * @param int $restaurantId
     * @return mixed
     */
    public function branchCount(int $restaurantId)
    {
        return  $this->restaurantBranch->where('user_id', '!=', auth()->user()->id)
                    ->where('restaurant_id', $restaurantId)->count();
    }

    /**
     * @param int $branchId
     * @return mixed
     */
    public function branchInformation(int $branchId)
    {
        return $this->restaurantBranch
            ->with('user', 'restaurantLocation', 'restaurantCategory', 'restaurantServiceType', 'restaurantImage', 'restaurantTime')
            ->firstWhere('id', $branchId);
    }


    public function backgroundImage($request)
    {
          $imageId = $request->get('image_id');

        $restImage= $this->restaurantBranch->where('id',$imageId)->first();
         if(File::exists(RESTAURANT_ROOT_PATH.$restImage->background_image))
         {
           File::delete(RESTAURANT_ROOT_PATH.$restImage->background_image);
          $restaurantImage = $this->restaurantBranch->find($imageId)->update(['background_image'=>NULL]);
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
}
