<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\Restaurant\Restaurant;
use App\Models\Chef;
use App\Repositories\Frontend\Restaurant\RestaurantRepository;
use DB;
class CompanyController extends Controller
{
    /**
     * @var User
     */
    private $user;

    
	/**
     * @param Product $product
     */
    private $product;
    protected $restaurantRepository;
     /**
     * @var Product
     */
    protected $productAttribute;

    public function __construct(User $user, Product $product,ProductAttribute $productAttribute,RestaurantRepository $restaurantRepository)
    {
		$this->user = $user;
        $this->product = $product;
        $this->productAttribute = $productAttribute;
        $this->restaurantRepository = $restaurantRepository;

    }

    /**
     * @return View
     */
    public function companyInformation(Request $request, string $slug)
	{
    abort(404);
		$user = $this->user->with('isRestaurantLocation','isRestaurant','isRestaurantBranchs')->where('slug', $slug)->first();
        $query = $this->product->with('singleProductImage', 'productImage', 'category','region','rating')->where('user_id', $user->id)->where('product_admin_status', '1');

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

      $chefsData= Chef::where('user_id',$restaurantInfomation->user_id)->where('status', '1')->get();  

     // $productsrecomm= Restaurant::with('restaurantSingleImage','restaurantBranch','UserSlug')->where('slug','!=',$user->isRestaurant->slug)->get(); 
	  $productsrecomm= Restaurant::with('restaurantSingleImage','restaurantBranch','UserSlug')->where('is_active','APPROVED')->where('slug','!=',$user->isRestaurant->slug)->get();              
       //echo '<pre>'; print_r($productsrecomm); exit;      
		return view('frontend.company.company',
			compact('user','products','slug','productsrecomm','productAttrs','restaurantInfomation','chefsData')
        );
    }
}
