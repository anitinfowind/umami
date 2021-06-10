<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Restaurant\RestaurantInfoRequest;
use App\Http\Requests\Frontend\Restaurant\RestaurantSaveRequest;
use App\Models\Categories\Category;
use App\Models\Restaurant\Restaurant;
use App\Models\Access\User\User;
use App\Repositories\Frontend\Restaurant\RestaurantRepository;
use App\Models\ProductAttribute;
use App\Models\Products\Product;
use App\Models\Chef;
use DB;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Slider\Slider;
use Illuminate\Http\Request;
class RestaurantController extends Controller
{
    /**
     * @var RestaurantRepository
     */
    protected $restaurantRepository;

    /**
     * @var Category
     */
    protected $category;
    protected $chefs;
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
     * @var Product
     */
    protected $productAttribute;

    private $product;

    private $user;

    /**
     * @param RestaurantRepository $restaurantRepository
     * @param Category $category
     */
    public function __construct(
        User $user,
        RestaurantRepository $restaurantRepository,
        Category $category, Country $country,
        State $state,
        City $city,
        Product $product,
		ProductAttribute $productAttribute,Chef $chefs
    ) {
        $this->restaurantRepository = $restaurantRepository;
        $this->category = $category;
        $this->chefs = $chefs;
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
		$this->productAttribute = $productAttribute;
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * @return View
     */
    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'desc')->where('status', ONE)->get();
        $restaurants = $this->restaurantRepository->restaurant();
		
		//echo '<pre>';print_r($restaurants[0]->restaurantLocation);exit;

        if (\Request::segment(1) === 'new-shops') {
			return view('frontend.restaurant.newshop',
				compact('restaurants')
			);
		}
     
		return view('frontend.restaurant.index',
            compact('restaurants', 'sliders')
        );
    }
    
    /**
     * @return View
     */
    public function info(RestaurantInfoRequest $request)
    {
        $categories =  $this->category->isActive()->get();
        $restaurants = $this->restaurantRepository->restaurantDetail();
        if ($restaurants) {
            $restaurantCategory = $this->restaurantRepository
                                        ->getRestaurantCategory(auth()->user()->id, $restaurants->id())
                                        ->pluck('category_id')
                                        ->all();

            $restaurantServiceType = $this->restaurantRepository
                                        ->getRestaurantServiceType(auth()->user()->id, $restaurants->id())
                                        ->pluck('service_type_id')
                                        ->all();
        }
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
        // echo '<pre>'; print_r($states); exit;
       
        return view('frontend.restaurant.info',
            compact('categories', 'restaurants', 'restaurantCategory', 'restaurantServiceType','countriedata','states','cities')
        );
    }

    
    public function shipping_info(Request $request) {
        $restaurant = Restaurant::where('user_id', auth()->user()->id)->first();
        if ($request->has('preparation_time') && $request->isMethod('post')) {
            $preparation_time = trim($request->input('preparation_time'));
            $delivery_days = trim($request->input('delivery_days'));
            $pickuptime = $request->input('pickuptime');
            $shipping_info = ['preparation_time' => $preparation_time, 'delivery_days' => $delivery_days, 'pickuptime' => $pickuptime];
            Restaurant::where('id', $restaurant->id)->update(['shipping_info' => json_encode($shipping_info)]);
            return redirect('/restaurant/shipping-info');
        }
        return view('frontend.restaurant.shipping_info',
            compact('restaurant')
        );
    }

    /**
     * @param RestaurantSaveRequest $request
     */
    public function saveRestaurant(RestaurantSaveRequest $request)
    {
        return $this->restaurantRepository->updateOrCreate($request);
    }

    /**
     * @param RestaurantInfoRequest $request
     */
    public function removeImage(RestaurantInfoRequest $request)
    {
        return $this->restaurantRepository->restaurantRemoveImage($request);
    }

    /**
     * @param string $slug
     * @return View
     */
    public function restaurantInfomation(Request $request, string $slug)
    {
        $restaurantInfomation = $this->restaurantRepository->restaurantInfomation($slug);
        $user_id = $restaurantInfomation->user_id;
        $user = User::find($user_id);
        $slug = $user->slug;
		$user = $this->user->with('isRestaurantLocation','isRestaurant','isRestaurantBranchs')->where('slug', $slug)->first();
        $query = $this->product->with('singleProductImage','category','region','rating', 'product_reviews','avgRating', 'totalRating')->where('user_id', $user->id)->where('product_admin_status', '1');

        if ($request->get('sort') == 'lowest_first') {
            $query->orderBy('products.price','ASC');
        }
        
        if ($request->get('sort') == 'highest_first') {
            $query->orderBy('products.price','DESC');
        }
        
        $products = $query->get();
      //recommended
       $getres= DB::table('products')->where('user_id',$user->id)->groupBy('user_id')->pluck('user_id')->toArray();
       $productdata= DB::table('orders')
          ->select('product_id', DB::raw('count(*) as total'))
          ->whereIn('vendor_id',$getres)
          ->groupBy('product_id')
          ->orderBy('total','desc')
          ->limit(TEN)
          ->pluck('product_id')->toarray();
          // echo '<pre>'; print_r($productdata); exit;
       $productsrecomm3=$this->product->whereIn('id',$productdata)->with('singleProductImage')->get();  
       $productAttrs = $this->productAttribute->isActiveProductAttribute()->get();

        if($request->get('sort')) {
            return view('frontend.company.search',
                compact('user','products','slug','productsrecomm','productAttrs')
            );
        }
    $restaSlug= Restaurant::where('user_id',$user->id)->first();
    $restaurantInfomation = $this->restaurantRepository->restaurantInfomation($restaSlug->slug);
    

    $resturant_total_ratings = Restaurant::total_ratings($restaurantInfomation->id);
    $resturant_avg_ratings = Restaurant::avg_ratings($restaurantInfomation->id);

      $chefsData= Chef::where('user_id',$restaurantInfomation->user_id)->where('status','1')->get();  

     // $productsrecomm= Restaurant::with('restaurantSingleImage','restaurantBranch','UserSlug')->where('slug','!=',$user->isRestaurant->slug)->get(); 
      $productsrecomm= Restaurant::with('restaurantSingleImage','restaurantBranch','UserSlug')->where('is_active','APPROVED')->where('slug','!=',$user->isRestaurant->slug)->get();              
       //echo '<pre>'; print_r($productsrecomm); exit;      
        return view('frontend.company.company',
            compact('user','products','slug','productsrecomm','productAttrs','restaurantInfomation','chefsData', 'resturant_total_ratings', 'resturant_avg_ratings')
        );
    }

    public function restaurantInfomation11111(Request $request, string $slug)
    {
        $restaurantInfomation = $this->restaurantRepository->restaurantInfomation($slug);
        
        $productAttrs = $this->productAttribute->isActiveProductAttribute()->get();

        $chefsData= Chef::where('user_id',$restaurantInfomation->user_id)->get();
        
        return view('frontend.restaurant.detail',
            compact('restaurantInfomation','productAttrs','chefsData')
        );
    }

    public function restaurantRating($id=null)
    {

     $product= Product::where('products.user_id',$id)->pluck('id')->toArray();
     $rating= DB::table('ratings')->whereIN('product_id',$product)->get();
         return $rating ;
    }

     public function backGroundImageDelete(RestaurantInfoRequest $request)
     {
         return $this->restaurantRepository->backgroundImage($request);
     }



    public function getState(Request $request)
    {
        $countryId  = $request->get('country_id');
        $countryId=$this->country->where('name',$countryId)->select('id')->first();
        if ($countryId !='') {
            $stateList  = $this->state
                                ->where('country_id',$countryId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control" id="resstate" name="state"><option value="">'.trans('Select State').'</option>';

            if (count($stateList)>0) {
                foreach($stateList as $k=>$v) {
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        } else {
            echo '<select class="form-control" name="state"><option value="">'.trans('Select State').'</option></select>';
            die;
        }
    }

    /**
     * @param AddressFormRequest $request
     */
    public function getCity(Request $request)
    {
        $stateId  = $request->get('state_id');
         $stateId=$this->state->where('name',$stateId)->select('id')->first();
        if ($stateId !='') {
            $cityList = $this->city
                                ->where('state_id', $stateId->id)
                                ->orderBy('name','ASC')
                                ->pluck('name','id')
                                ->all();

            $list = '<select class="form-control"  name="city"><option value="">'.trans('Select City').'</option>';

            if(count($cityList)>0){
                foreach($cityList as $k=>$v){
                    $list.= '<option value="'.$v.'">'.$v.'</option>';
                }
            }
            $list .=  '</select>';
            echo $list;
            die;
        }else{
            echo '<select class="form-control" name="city"><option value="">'.trans('Select City').'</option></select>';
            die;
        }
    }

}
