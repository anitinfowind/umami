<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faqs\Faq;
use App\Models\Slider\Slider;
use App\Models\Brand\Brand;
use App\Models\Banner;
use App\Models\Region;
use App\Models\Reward;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Chef;
use App\Models\Products\Product;
use App\Models\Categories\Category;
use App\Models\Restaurant\Restaurant;
use App\Models\Product_review;
use App\Repositories\Frontend\Pages\PagesRepository;
use App\Repositories\Frontend\Product\ProductRepository;
use Illuminate\Support\Str;
use DB;
use App\Models\Coupon;
use App\Models\Settings\Site_setting;

class AjaxController extends Controller {
	/**
     * @var Slider
     */
    private $slider;

    /**
     * @var PagesRepository
     */
    private $pagesRepository;

    private $productRepository;

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

    /**
     * @param PagesRepository $pagesRepository
     * @param Slider $slider
     * @param Faq $faq
     * @param Brand $brand
     */
	 
	 public function __construct(
        PagesRepository $pagesRepository,
        ProductRepository $productRepository,
        Slider $slider,
        Faq $faq,
        Brand $brand,
        Banner $banner,
        Region $region,
        Product $product,
        Category $category,
        Restaurant $restaurant
    ) {
        $this->slider = $slider;
        $this->pagesRepository = $pagesRepository;
        $this->productRepository = $productRepository;
        $this->faq = $faq;
        $this->brand = $brand;
        $this->banner = $banner;
        $this->region = $region;
        $this->product = $product;
        $this->category = $category;
        $this->restaurant = $restaurant;
    }
	
	public function ajaxpost(Request $request) {
		
		$action = $request->input('action');
		$this->{'ajaxpost_' . $action}($request);
	}

	public function ajaxpost_add_to_cart($request) {
		$product_id = $request->input('product_id');
		$qty = $request->input('qty');
		$product_price = $request->input('product_price');
		$cart = $_COOKIE['cart'] ?? '{}';

		$success = 0; $message = '';
		$product = Product::find($product_id);
		if(!isset($product->id)) {
			$message = 'Sorry, product does not exists';
			return response()->json(['success' => $success, 'message' => $message])->send();
		}
		if($product->sold_out == '1') {
			$message = 'Sorry, product sold out';
			return response()->json(['success' => $success, 'message' => $message])->send();
		}
		$cart = json_decode($cart, true);
		if(isset($cart[$product_id])) {
			$qty += $cart[$product_id];
		}
		
		$avl = Product::check_availability(['product_id' => $product_id, 'with_qty' => $qty, 'return_avlqty' => true]);
		if($avl['avlqty'] != '' && $avl['avlqty'] < $qty) {
			$message = 'You can purchase maximum quantity ' . $avl['avlqty'] . ' today';
			return response()->json(['success' => $success, 'message' => $message])->send();
		}

		foreach ($cart as $pid => $qty2) {
			$pd = Product::find($pid);
			if($pd->user_id != $product->user_id)
				unset($cart[$pid]);
		}

		$cart[$product_id] = $qty;
		if(isset($_COOKIE['cart']))
			setcookie('cart', '', (time() - 3600), "/");
		setcookie('cart', json_encode($cart), time() + (86400), "/");
		$success = 1;
		$message = 'Product successfully added to cart';
		return response()->json(['success' => $success, 'message' => $message])->send();
	}

	
	public function ajaxpost_ajax_get_cart($request) {
		$cart = json_decode(($_COOKIE['cart'] ?? '{}'), true);
		$data = [];
		$total_qty = 0;
		foreach ($cart as $key => $value) {
			$total_qty += $value;
		}
		$data['total_qty'] = $total_qty;
		return response()->json(['success' => 1, 'message' => '', 'data' => $data])->send();
	}

	public function ajaxpost_delete_cart($request) {
		$product_id = $request->input('product_id');
		$cart = json_decode(($_COOKIE['cart'] ?? '{}'), true);
		unset($cart[$product_id]);
		if(isset($_COOKIE['cart']))
			setcookie('cart', '', (time() - 3600), "/");
		setcookie('cart', json_encode($cart), time() + (86400), "/");
		return response()->json(['success' => 1, 'message' => '', 'data' => []])->send();
	}

	public function ajaxpost_update_cart($request) {
		$new_cart = $request->input('new_cart');
		$new_cart = json_decode($new_cart, true);
		$cart_infos = []; $cart2 = []; $data = [];
		foreach ($new_cart as $key => $qty) {
			$key2 = explode('_', $key);
			$product_id = $key2[1];
			$product = Product::find($product_id);
            if(!isset($product->id)) {
                continue;
            }
            if($product->sold_out == '1') {
                $cart_infos[] = $product->title . ' is sold out';
                continue;
            }
            $avl = Product::check_availability(['product_id' => $product_id, 'with_qty' => $qty, 'return_avlqty' => true]);
            if($avl['avlqty'] != '' && $avl['avlqty'] < $qty) {
                if($avl['avlqty'] > 0) {
                    $cart_infos[] = $product->title . ' available quantity ' . $avl['avlqty'] . ' today';
                    $cart2[$product_id] = $avl['avlqty'];
                }
                continue;
            }
            $cart2[$product_id] = $qty;
		}
		$data['cart_infos'] = $cart_infos;
		if(isset($_COOKIE['cart']))
			setcookie('cart', '', (time() - 3600), "/");
		setcookie('cart', json_encode($cart2), time() + (86400), "/");
		return response()->json(['success' => 1, 'message' => 'Cart updated', 'data' => $data])->send();
	}

	public function ajaxpost_update_cart_item($request) {
		$site_settings = Site_setting::all();
    $site_settings2 = [];
    foreach ($site_settings as $key => $value) {
        $site_settings2[$value->key] = $value->value;
    }
    $site_settings = $site_settings2;
		$product_id = $request->input('product_id');
		$qty = $request->input('qty');
		$cart = json_decode(($_COOKIE['cart'] ?? '{}'), true);
		$coupon_code = $_COOKIE['coupon_code'] ?? '';
		$cart_infos = []; $data = [];
		$product = Product::find($product_id);
    if(!isset($product->id)) {
    	$cart_infos[] = 'Product does not exists';
    	$data['cart_infos'] = $cart_infos;
      return response()->json(['success' => 0, 'message' => 'Cart Error', 'data' => $data])->send();
    }
    if($product->sold_out == '1') {
    	$cart_infos[] = $product->title . ' is sold out';
    	$data['cart_infos'] = $cart_infos;
      return response()->json(['success' => 0, 'message' => 'Cart Error', 'data' => $data])->send();
    }
    $avl = Product::check_availability(['product_id' => $product_id, 'with_qty' => $qty, 'return_avlqty' => true]);
    if($avl['avlqty'] != '' && $avl['avlqty'] < $qty) {
    	$cart_infos[] = $product->title . ' available quantity ' . $avl['avlqty'] . ' today';
      $data['cart_infos'] = $cart_infos;
      return response()->json(['success' => 0, 'message' => 'Cart Error', 'data' => $data])->send();
    }
    $cart[$product_id] = $qty;
    $data['cart_infos'] = $cart_infos;
    $product_line_total = $product->price * $qty;
    $subtotal = 0;
    foreach ($cart as $key => $value) {
    	$product = Product::find($key);
    	$subtotal += $product->price * $value;
    }

    $coupon_discount = $reward_redeemed_amt = $reward_redeemed = 0;
    if($coupon_code != '') {
    	$coupon = Coupon::where('coupon_code', $coupon_code)->first();
    	if(isset($coupon->id)) {
				if($coupon->discount_type == 'FIXED')
					$coupon_discount = $coupon->discount;
				if($coupon->discount_type == 'PERCENTAGE') {
					$coupon_discount = $subtotal * $coupon->discount / 100;
					$coupon_discount = number_format($coupon_discount, 2, '.', '');
				}
			}
    }
    $payable_amount = $subtotal - $coupon_discount;
		/*if(auth()->user()) {
			$max_reward_discount_amt = $payable_amount / 2;
			$max_reward_discount_point = ceil(($max_reward_discount_amt * 100) / $site_settings['point_to_amount_discount_percentage']);
			$reward_discount = $max_reward_discount_point;
			if(auth()->user()->reward_point < $max_reward_discount_point)
				$reward_discount = auth()->user()->reward_point;
			$reward_discount_amt = ($reward_discount * $site_settings['point_to_amount_discount_percentage'] / 100);
		}
		$payable_amount -= $reward_discount_amt;*/
		if(auth()->user()) {
			$reward_point = $_COOKIE['reward_point'] ?? '';
			$urpoint = auth()->user()->reward_point;
			$reward_point_applied = [];
			$reward_arr = [5, 10, 15, 20];
			foreach ($reward_arr as $key => $value) {
				$points = ceil(($value * 100) / $site_settings['point_to_amount_discount_percentage']);
				if($reward_point == ($key + 1)) $reward_point_applied = ['price' => $value, 'points' => $points];
			}
			if(isset($reward_point_applied['points'])) {
				$reward_redeemed = $reward_point_applied['points'];
				$reward_redeemed_amt = number_format($reward_point_applied['price'], 2, '.', '');
				$payable_amount -= $reward_point_applied['price'];
			}
		}
		$earnable_points = round($payable_amount * $site_settings['amount_to_point_percentage'] / 100);

    $cart_total_data = ['product_line_total' => number_format($product_line_total, 2, '.', ''), 'subtotal' => number_format($subtotal, 2, '.', ''), 'coupon_discount' => number_format($coupon_discount, 2, '.', ''), 'reward_redeemed' => $reward_redeemed, 'reward_redeemed_amt' => number_format($reward_redeemed_amt, 2, '.', ''), 'earnable_points' => $earnable_points];
    $data['cart_total_data'] = $cart_total_data;
    if(isset($_COOKIE['cart']))
			setcookie('cart', '', (time() - 3600), "/");
		setcookie('cart', json_encode($cart), time() + (86400), "/");
		return response()->json(['success' => 1, 'message' => 'Cart updated', 'data' => $data])->send();
	}
	
	public function ajaxpost_apply_coupon($request) {
		$coupon_code = $request->input('coupon_code');
		$message = ''; $data = [];
		$check_coupon = app('App\Http\Controllers\Frontend\CheckoutController')->check_coupon(['coupon_code' => $coupon_code]);
		$success = $check_coupon['success'];
		$message = $check_coupon['message'];
		if($check_coupon['success'] == 1) {
			if(isset($_COOKIE['coupon_code']))
	            setcookie('coupon_code', '', (time() - 3600), "/");
	        setcookie('coupon_code', $coupon_code, time() + (86400), "/");
			$message = 'Coupon successfully applied';
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data])->send();
	}

	public function ajaxpost_remove_coupon($request) {
		$message = ''; $data = [];
		setcookie('coupon_code', '', (time() - 3600), "/");
		return response()->json(['success' => 1, 'message' => $message, 'data' => $data])->send();
	}

	
	public function ajaxpost_apply_reward_point($request) {
		$type = $request->input('type');
		$message = ''; $data = [];
		if(isset($_COOKIE['reward_point']))
            setcookie('reward_point', '', (time() - 3600), "/");
        setcookie('reward_point', $type, time() + (86400), "/");
		$message = '';
		return response()->json(['success' => 1, 'message' => $message, 'data' => $data])->send();
	}

	public function ajaxpost_remove_reward_point($request) {
		$message = ''; $data = [];
		setcookie('reward_point', '', (time() - 3600), "/");
		return response()->json(['success' => 1, 'message' => $message, 'data' => $data])->send();
	}

	public function ajaxpost_get_products($request) {
		$search = $request->input('search');
		$category_id = $request->input('category_id');
		$diet_id = $request->input('diet_id');
		$min_price = $request->input('min_price');
		$max_price = $request->input('max_price');
		$cur_page = $request->input('cur_page');
		$per_page = 12;
		$offset = ($cur_page - 1) * $per_page;
		$message = ''; $data = [];
		$category_ids = [];
		if($category_id != '')
			$category_ids = explode(',', $category_id);
		$diet_ids = [];
		if($diet_id != '')
			$diet_ids = explode(',', $diet_id);
		//find_in_set('5',diet_id) <> 0
		$products = $this->product
					->with('singleProductImage', 'productImage', 'ppcategory','ppdiet','favorite','rating', 'product_reviews','avgRating', 'totalRating')
					->leftJoin('restaurants', 'products.restaurant_id', '=', 'restaurants.id')
					->where('restaurants.is_active','APPROVED')
          ->where('products.product_admin_status',1)
					->select('products.*')->where('products.price', '>=', $min_price)->where('products.price', '<=', $max_price);
		//if($search != '') $products->where('products.title', 'like', '%' . $search . '%');
		if($search != '') {
			$products->where(function($q) use ($search){
				$q->orWhere('products.title', 'like', '%' . $search . '%')->orWhere('restaurants.name', 'like', '%' . $search . '%');
			});
		}		
		if(count($category_ids) > 0) {
			$products->where(function($q) use ($category_ids){
				foreach ($category_ids as $key => $value) {
					$q->orWhereRaw('find_in_set("' . $value . '",products.category_id) <> 0');
				}
			});
		}
		if(count($diet_ids) > 0) {
			$products->where(function($q) use ($diet_ids){
				foreach ($diet_ids as $key => $value) {
					$q->orWhereRaw('find_in_set("' . $value . '",products.diet_id) <> 0');
				}
			});
		}
		/*if($category_id != '') $products->whereRaw('find_in_set("' . $category_id . '",products.category_id) <> 0');
		if($diet_id != '') $products->whereRaw('find_in_set("' . $diet_id . '",products.diet_id) <> 0');*/
		$total_counts = $products->where('products.product_admin_status', '1')->count();
		$total_pages = ceil($total_counts / $per_page);
		$products = $products->where('products.product_admin_status', '1')->orderBy('products.sold_out')->orderBy('products.title')->limit($per_page)->offset($offset)->get();
		$data['total_pages'] = $total_pages;
		$data['products'] = $products;
		$product_html = '';
		foreach ($products as $key => $product) {
			$restaurantname=restaurantName($product->restaurant_id);
			/*$pd_img = WEBSITE_IMG_URL.'no-product-image.png';
			$ext = 'png';
			if(isset($product->singleProductImage->image) && !empty($product->singleProductImage->image)) {
				if(file_exists(PRODUCT_ROOT_PATH.'th_' . $product->singleProductImage->image)) {
					$pd_img = PRODUCT_URL. 'th_' . $product->singleProductImage->image;
					$info = pathinfo(PRODUCT_ROOT_PATH. 'th_' . $product->singleProductImage->image);
					$ext = $info['extension'];
				} elseif(file_exists(PRODUCT_ROOT_PATH . $product->singleProductImage->image)) {
					$pd_img = PRODUCT_URL . $product->singleProductImage->image;
					$info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
					$ext = $info['extension'];
				}
			}*/
			$ratingreview = ceil(($product->avgRating[0]->avg_rate ?? 0));
    	$totaluser = (isset($product->totalRating[0]) ? $product->totalRating[0]->count_rate : 0);
			$product_html .= '<div class="item custome-col-4 product_items">
	      <div class="food-box relative">
	        <div class="food-pic relative">';
	    /*if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp') {
	    	$product_html .= '<a href="' . url('product-detail/'.$product->slug) . '"> <img class="product_image_resto" src="' . $pd_img . '" alt="' . $product->title . '"></a>';
	    } else {
	    	$product_html .= '<video width="100%" height="200px" muted loop  controls poster111="' . url('public/thimbnailimage.png') . '">
          <source src="' . $pd_img . '" type="video/mp4">
        </video>';
	    }*/
	    $slide_items = product_medias(['medias' => $product->productImage]);
      if(count($slide_items) == 0) {
        $product_html .= '<a href="' . url('product-detail/'.$product->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . WEBSITE_IMG_URL.'no-product-image.png' . '" alt="' . $product->title . '" class="lazy" /> </a>';
      } else {
        $sit = $slide_items[0];
        if($sit['type'] == 'image') {
          $product_html .= '<a href="' . url('product-detail/'.$product->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . PRODUCT_URL.'th_'. $sit['filename'] . '" alt="' . $product->title . '" class="lazy" /> </a>';
        }
        if($sit['type'] == 'video') {
          $poster = $sit['image'];
          if($sit['image_filename'] != '') {
            if(file_exists(PRODUCT_ROOT_PATH.'th_'.$sit['image_filename']))
              $poster = PRODUCT_URL.'th_'. $sit['image_filename'];
          }
          $product_html .= '<a href="' . url('product-detail/'.$product->slug) . '">
          <video width="100%" height="178px" muted loop  controls111 preload="none" poster="' . $poster . '">
            <source src="' . $sit['file'] . '" type="video/mp4">
          </video>
          </a>';
        }
      }
      if($product->sold_out == '1') 
        $product_html .= '<div class="sold_out"><p>Sold Out</p></div>';
      if(!empty($product->favorite)){
				$favorite = 'yes';
			} else{
				$favorite = 'no';
			}
      if(auth()->user()) {
        if(auth()->user()->isUser() == 1){
          if ($favorite == 'yes') {
          $product_html .= '<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_' . $product->id . '" data-fav-id="' . $product->id . '"><i class="dataamount food_tab_' . $product->id . ' far fa-heart" id="fav_' . $product->id . '"></i></a></span>';
          }else{
          $product_html .= '<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_' . $product->id . '" data-fav-id="' . $product->id . '"><i class="dataamount food_tab_' . $product->id . ' fa fa-heart-o" id="fav_' . $product->id . '"></i></a></span>';
          }
        }
      } else { 
      	$product_html .= '<span class="heart-icon"><a href="' . url('/login') . '" class="unfavourite_token fav_' . $product->id . '"  data-fav-id="' . $product->id . '" data-fav-value="12"><i class="dataamount food_tab_' . $product->id . ' fa fa-heart-o" id="fav_' . $product->id . '"></i></a></span>'; 
      }
	    $product_html .= '</div>
	        <div class="food-name d-flex align-items-center">
	          <div class="foodname-lft">
	            <h4><a href="' . url('product-detail/'.$product->slug) . '">' . $product->title . '</a></h4>
	            <h5>' . $restaurantname . '</h5>
	          </div>
	        </div>
	        <div class="food-time-rvw-box">
	          <div class="food-time d-flex align-items-center justify-content-between">
	            <p>' . (Str::limit($product->description,82)) /*. $product->description*/ . '</p>
	          </div>
	          <div class="price-box d-flex align-items-center justify-content-between">';
	          if ($ratingreview != 0) {
	          	if ($product->is_rating_show == 'Y') {
	          		$product_html .= '<div class="foodname-rgt d-flex">
	          		<a href="' . url('product-detail/' . $product->slug . '?tab=D#heading-D') . '" class="d-flex">
                <div class="food-rvw-star">
                  <ul class="d-flex rvw-stars">
                    <li><i class="fa fa-star"></i></li>
                  </ul>
                </div>
                <span class="rvw-rating">' . $ratingreview . '</span> <span class="rvw-quantity">(' . $totaluser . ')</span>
                </a>
                </div>';
	          	}
	          }
	          if ($product->discount()) {
				$discount = (int) $product->price() * (int) $product->discount() / 100;
				$price = (int) $product->price()- (int) $discount;
			   } else {
				$price = $product->price();
			   }
			   $per_price = number_format($price/$product->quantity, 2);
               $serving_for = (!empty($product->serving_for)) ? $product->serving_for : '/people';
               $product_price = (!empty($per_price)) ? $per_price : $price;

	          $product_html .= '<div class="price-box-lft">
	            </div>
	            <div class="price-box-rgt">
	              <p>Price $' .$product_price. $serving_for. '</p>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>';
		}
		$data['product_html'] = $product_html;
		return response()->json(['success' => 1, 'message' => $message, 'data' => $data])->send();
	}

  //    <div class="price-box-lft">
	 //    <p>' . $product->quantity . ' Meals</p>
	 // </div>
	public function ajaxpost_get_reviews($request) {
		$page = $request->input('page');
		$product_id = $request->input('product_id');
		$limit = 10;
		$offset = ($page - 1) * $limit;
		$message = ''; $data = [];
		$total_data = Product_review::where('product_id', $product_id)->where('status', '1')->count();
		$total_page = ceil($total_data / $limit);
		$product_reviews = Product_review::with('user')->where('product_id', $product_id)->where('status', '1')->orderBy('id', 'desc')->limit($limit)->offset($offset)->get();
		$data['product_reviews'] = $product_reviews;
		$data['total_page'] = $total_page;
		return response()->json(['success' => 1, 'message' => $message, 'data' => $data])->send();
	}

	
	public function ajaxpost_submit_review($request) {
		$review_data = json_decode($request->input('review_data'), true);
		$product_id = $request->input('product_id');
		$message = ''; $data = [];
		$review_exists = Product_review::where('user_id', auth()->user()->id)->where('product_id', $product_id)->count();
		$order_exists = OrderDetail::where('user_id', auth()->user()->id)->where('product_id', $product_id)->count();
		if($order_exists == 0)
			return response()->json(['success' => 0, 'message' => 'Please order product first', 'data' => $data])->send();
		if($review_exists > 0)
			return response()->json(['success' => 0, 'message' => 'You already reviewed this product', 'data' => $data])->send();
		Product_review::create(['user_id' => auth()->user()->id, 'product_id' => $product_id, 'rate_food' => $review_data['rate_food'], 'rate_shipping' => $review_data['rate_shipping'], 'rate_packaging' => $review_data['rate_packaging'], 'rate_instructions' => $review_data['rate_instructions'], 'comment' => $review_data['comment'], 'status' => '1']);
		$message = 'Your review successfully added';
		return response()->json(['success' => 1, 'message' => $message, 'data' => $data])->send();
	}
	
	public function ajaxpost_get_load_more_product($request) {
		if (request()->isMethod('post')) {
			
			$category_slug	= $request->slug ?? '';
			$category_id	= $request->category_id ?? '';
			
			$cur_page		= $request->pg ?? '';
			$cur_page 		= $cur_page == '' ? 1 : $cur_page;
			$per_page 		= 4;
			$limit_start 	= ($cur_page - 1) * $per_page;
			
			$total_pg 		= $cur_page * $per_page;
			
			
			$html='';
			
			if($category_id!=''){
				$total_product=$this->product
				  ->with('singleProductImage','category','diet','favorite')
				  ->where('category_id',$category_id)
				  ->where('product_admin_status',1)
				  ->get()
				  ->count();
				  
				$product_result=$this->product
				  ->with('singleProductImage','category','diet','favorite')
				  ->where('category_id',$category_id)
				  ->where('product_admin_status',1)
				  ->skip($limit_start)
				  ->take($per_page)
				  ->get();
				 
				$is_load_more='Y';
				if($total_pg>=$total_product){
					$is_load_more='N';
				}  
				  
				$useronly='';
				if(auth()->user()){
					$useronly = auth()->user()->isUser();
				}
				
				/*foreach($product_result as $product){
					echo $product->id.'-';
					echo isset($product->singleProductImage->image)?$product->singleProductImage->image:'';
					echo '</br>';
					
					//print_r($product->id.'-'.$product->singleProductImage->image.'</br>');
				}
				exit;*/
				foreach($product_result as $product){
					if(isset($product->singleProductImage->image) && !empty($product->singleProductImage->image)){
						$restaurantname=restaurantName($product->restaurant_id);
						$info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
						$ext = $info['extension'];
						
						$productrating=\App::make('App\Http\Controllers\Frontend\ProductController')->getRating($product->id);
						$ratingreview='';
						$totaluser='';
						if(count($productrating)>0){
							$totalsum	= collect($productrating)->sum('average_rating');
							$totaluser	= count($productrating);
							$ratingreview= ($totalsum/$totaluser);
							$ratingreview= round($ratingreview,1);
						}
						
						if(!empty($product->favorite)){
							$favorite='yes';
						} else {
							$favorite='no';
						}
					
						if($product->discount()) {
							$discount = (int) $product->price() * (int) $product->discount() / 100;
							$price = (int) $product->price()- (int) $discount;
						} else {
							$price = $product->price();
						}
						
						$html .='<div class="custome-col-3 product_item" data-id="'.$product->id.'"><div class="food-box relative"><div class="food-pic relative">';
						
						if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp'){
							if(!empty($product->singleProductImage->image) && \File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image)){
								$image = PRODUCT_URL.$product->singleProductImage->image;
							}else{
								$image = WEBSITE_IMG_URL.'no-product-image.png';
							}
							$html .='<a href="'.url("product-detail/".$product->slug).'"> <img src="'.$image.'" alt="'.$product->title.'"> </a>';
						}else{
							$html .='<a href="'.url('product-detail/'.$product->slug).'"><video width="300px" height="178px" muted loop  controls poster="'.url('public/thimbnailimage.png').'"><source src="'.PRODUCT_URL.$product->singleProductImage->image.'" type="video/mp4"></video></a>';
						}
						
						if(auth()->user()){
							if($useronly== 1){
								if($favorite == 'yes') {
									$html .='<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_'.$product->id.'" data-fav-id="'.$product->id.'"><i class="dataamount food_tab_'.$product->id.' far fa-heart" id="fav_'.$product->id.'"></i></a></span>';
								}else{
									$html .='<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_'.$product->id.'" data-fav-id="'.$product->id.'"><i class="dataamount food_tab_'.$product->id.' fa fa-heart-o" id="fav_'.$product->id.'"></i></a></span>';
								}
							}
						}else{
							$html .='<span class="heart-icon"><a href="'.url('/login').'" class="unfavourite_token fav_'.$product->id.'"  data-fav-id="'.$product->id.'" data-fav-value="12"><i class="dataamount food_tab_'.$product->id.' fa fa-heart-o" id="fav_'.$product->id.'"></i></a></span>';
						}
						if($ratingreview != 0) {
							$html .='<div class="food-star-box d-flex align-items-center justify-content-center"><div class="food-rvw-star"><ul class="d-flex rvw-stars"><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li></ul></div><div class="foodname-rgt"><p>'.$ratingreview.'</p></div><div class="rating-count"><p class="text-right">'.$totaluser.' ratings</p></div></div>';
						}
						$html .='</div><div class="food-name align-items-center"><div class="foodname-lft"><h4>'. \Str::limit($product->title,15).'</h4></div></div><div class="food-time-rvw-box"><div class="food-time d-flex align-items-center justify-content-between"><p>'.\Str::limit($product->description,82).'</p></div><div class="price-box d-flex align-items-center justify-content-between"><div class="price-box-lft"><p>Serving For '.$product->quantity.'</p></div>';
						$html .='<div class="price-box-rgt"><p>Price -$'.$price.'</p></div></div></div></div></div>';
					}
				}
			}
			
			echo json_encode(array('html'=>$html,'is_load_more'=>$is_load_more));
		}
	}
	
	public function ajaxpost_get_load_more_japanese_food($request) {
		if (request()->isMethod('post')) {
			
			$cur_page		= $request->pg ?? '';
			$cur_page 		= $cur_page == '' ? 1 : $cur_page;
			$per_page 		= 4;
			$limit_start 	= ($cur_page - 1) * $per_page;
			
			$total_pg 		= $cur_page * $per_page;
			
			
			$html='';
			
			
			$total_product=$this->product->with('singleProductImage','favorite')
				->where('product_admin_status',1)
				->orderBy('id','DESC')->get()->count();
			
			$product_result=$this->product->with('singleProductImage','favorite')
				->where('product_admin_status',1)
				->skip($limit_start)
				->take($per_page)
				->orderBy('id','DESC')
				->get();
			
			$is_load_more='Y';
			if($total_pg>=$total_product){
				$is_load_more='N';
			}  
			  
			$useronly='';
			if(auth()->user()){
				$useronly = auth()->user()->isUser();
			}
				
			foreach($product_result as $product){
				if(isset($product->singleProductImage->image) && !empty($product->singleProductImage->image)){
					$restaurantname=restaurantName($product->restaurant_id);
					$info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
					$ext = $info['extension'];
					
					$productrating=\App::make('App\Http\Controllers\Frontend\ProductController')->getRating($product->id);
					$ratingreview='';
					$totaluser='';
					if(count($productrating)>0){
						$totalsum	= collect($productrating)->sum('average_rating');
						$totaluser	= count($productrating);
						$ratingreview= ($totalsum/$totaluser);
						$ratingreview= round($ratingreview,1);
					}
					
					if(!empty($product->favorite)){
						$favorite='yes';
					} else {
						$favorite='no';
					}
				
					if($product->discount()) {
						$discount = (int) $product->price() * (int) $product->discount() / 100;
						$price = (int) $product->price()- (int) $discount;
					} else {
						$price = $product->price();
					}
					
					$html .='<div class="custome-col-3 product_item" data-id="'.$product->id.'"><div class="food-box relative"><div class="food-pic relative">';
					
					if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp'){
						if(!empty($product->singleProductImage->image) && \File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image)){
							$image = PRODUCT_URL.$product->singleProductImage->image;
						}else{
							$image = WEBSITE_IMG_URL.'no-product-image.png';
						}
						$html .='<a href="'.url("product-detail/".$product->slug).'"> <img src="'.$image.'" alt="'.$product->title.'"> </a>';
					}else{
						$html .='<a href="'.url('product-detail/'.$product->slug).'"><video width="300px" height="178px" muted loop  controls poster="'.url('public/thimbnailimage.png').'"><source src="'.PRODUCT_URL.$product->singleProductImage->image.'" type="video/mp4"></video></a>';
					}
					
					if(auth()->user()){
						if($useronly== 1){
							if($favorite == 'yes') {
								$html .='<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_'.$product->id.'" data-fav-id="'.$product->id.'"><i class="dataamount food_tab_'.$product->id.' far fa-heart" id="fav_'.$product->id.'"></i></a></span>';
							}else{
								$html .='<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_'.$product->id.'" data-fav-id="'.$product->id.'"><i class="dataamount food_tab_'.$product->id.' fa fa-heart-o" id="fav_'.$product->id.'"></i></a></span>';
							}
						}
					}else{
						$html .='<span class="heart-icon"><a href="'.url('/login').'" class="unfavourite_token fav_'.$product->id.'"  data-fav-id="'.$product->id.'" data-fav-value="12"><i class="dataamount food_tab_'.$product->id.' fa fa-heart-o" id="fav_'.$product->id.'"></i></a></span>';
					}
					if($ratingreview != 0) {
						$html .='<div class="food-star-box d-flex align-items-center justify-content-center"><div class="food-rvw-star"><ul class="d-flex rvw-stars"><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li></ul></div><div class="foodname-rgt"><p>'.$ratingreview.'</p></div><div class="rating-count"><p class="text-right">'.$totaluser.' ratings</p></div></div>';
					}
					$html .='</div><div class="food-name align-items-center"><div class="foodname-lft"><h4>'. \Str::limit($product->title,15).'</h4></div></div><div class="food-time-rvw-box"><div class="food-time d-flex align-items-center justify-content-between"><p>'.\Str::limit($product->description,82).'</p></div><div class="price-box d-flex align-items-center justify-content-between"><div class="price-box-lft"><p>Serving For '.$product->quantity.'</p></div>';
					$html .='<div class="price-box-rgt"><p>Price -$'.$price.'</p></div></div></div></div></div>';
				}
			}
			echo json_encode(array('html'=>$html,'is_load_more'=>$is_load_more));
		}
	}
	
	public function ajaxpost_get_load_more_restaurant($request) {
		if (request()->isMethod('post')) {
			
			
			
			$cur_page		= $request->pg ?? '';
			$cur_page 		= $cur_page == '' ? 1 : $cur_page;
			$per_page 		= 4;
			$limit_start 	= ($cur_page - 1) * $per_page;
			
			$total_pg 		= $cur_page * $per_page;
			
			
			$html='';
			
			$total_restaurant= $this->restaurant->isApproved()
				->with('restaurantSingleImage','userSlug','restaurantBranch')
				->get()
				->count();
				
			$restaurant_result= $this->restaurant->isApproved()
				->with('restaurantSingleImage','userSlug','restaurantBranch')
				->skip($limit_start)
				->take($per_page)
				->get();
				
			$is_load_more='Y';
			if($total_pg>=$total_restaurant){
				$is_load_more='N';
			}
				
			foreach($restaurant_result as $restaurant){
				if(isset($restaurant->restaurantSingleImage->image) && !empty($restaurant->restaurantSingleImage->image)){
					$restaurant_image = url('public/uploads/restaurant/'.$restaurant->restaurantSingleImage->image);
				}else{
					$restaurant_image = url('public/images/no-image.png');
				}
				$description='';
				if(isset($restaurant->restaurantBranch->description)){
					$description = \Str::limit($restaurant->restaurantBranch->description,82);
				}
				
				$html .='<div class="custome-col-3"><div class="food-box relative"><div class="food-pic relative"> <img src="'.$restaurant_image.'" alt="'.$restaurant->name.'"></div><div class="food-name d-flex align-items-center justify-content-between"><div class="foodname-lft"><h4><a href="'.url('user-detail/'.$restaurant->userSlug->slug).'">'.$restaurant->name.'</a></h4></div></div><div class="food-time-rvw-box"><p class="box-ftr-text">'. $description .'</p></div></div></div>';
			}
			
			echo json_encode(array('html'=>$html,'is_load_more'=>$is_load_more));
		}
	}
	
	public function ajaxpost_get_load_more_chef($request) {
		if (request()->isMethod('post')) {
			
			$cur_page		= $request->pg ?? '';
			$cur_page 		= $cur_page == '' ? 1 : $cur_page;
			$per_page 		= 4;
			$limit_start 	= ($cur_page - 1) * $per_page;
			
			$total_pg 		= $cur_page * $per_page;
			
			
			$html='';
			
			 $total_chefs = Chef::select('chefs.*','users.slug as userslug')
                ->leftjoin('users','users.id','=','chefs.user_id')
                ->limit(SIX)
                ->orderBy('id','desc')
                ->get()
				->count();
				
			 $chefs_result = Chef::select('chefs.*','users.slug as userslug')
                ->leftjoin('users','users.id','=','chefs.user_id')
                ->skip($limit_start)
				->take($per_page)
                ->orderBy('id','desc')
                ->get();
					
			$is_load_more='Y';
			if($total_pg>=$total_chefs){
				$is_load_more='N';
			}
				
			foreach($chefs_result as $chef){
				if(isset($chef->image) && !empty($chef->image)){
					$chef_image = url('public/uploads/chef/'.$chef->image);
				}else{
					$chef_image = url('public/images/no-image.png');
				}
				$description='';
				if(isset($chef->description)){
					$description = \Str::limit($chef->description,81);
				}
				
				$html .='<div class="custome-col-3"><div class="food-box relative"><div class="food-pic relative"> <img src="'.$chef_image.'" alt=""> </div><div class="food-name d-flex align-items-center justify-content-between"><div class="foodname-lft"><h4><a href="'.url('user-detail/'.$chef->userslug).'">'.$chef->name.'</a></h4></div></div>';
				
				if($description!=''){
					$html .='<div class="food-time-rvw-box food-time-rvw-box4"><p class="box-ftr-text">'.$description.'</p></div>';
				}
				
				$html .='</div></div>';
			}
			
			echo json_encode(array('html'=>$html,'is_load_more'=>$is_load_more));
		}
	}
	
	public function ajaxpost_get_load_more_recommended($request) {
		if (request()->isMethod('post')) {
			
			$cur_page		= $request->pg ?? '';
			$cur_page 		= $cur_page == '' ? 1 : $cur_page;
			$per_page 		= 4;
			$limit_start 	= ($cur_page - 1) * $per_page;
			
			$total_pg 		= $cur_page * $per_page;
			
			
			$html='';
			
			$order = DB::table('orders')
				->select('product_id', DB::raw('count(*) as total'))
				->groupBy('product_id')
				->orderBy('total','desc')
				->limit(TEN)
				->pluck('product_id')->toarray();
			
			$total_productsrecomm=$this->product->whereIn('id',$order)->with('singleProductImage','favorite')->where('product_admin_status',1)->get()->count();
			
			$productsrecomm_result=$this->product->whereIn('id',$order)->with('singleProductImage','favorite')->where('product_admin_status',1)->skip($limit_start)->take($per_page)->get();
			
			$is_load_more='Y';
			if($total_pg>=$total_productsrecomm){
				$is_load_more='N';
			}
			
			$useronly='';
			if(auth()->user()){
				$useronly = auth()->user()->isUser();
			}
			foreach($productsrecomm_result as $key=>$recommend){
				if(isset($recommend->singleProductImage->image) && !empty($recommend->singleProductImage->image)){
					$restaurantname=restaurantName($recommend->restaurant_id);
					$info = pathinfo(PRODUCT_ROOT_PATH.$recommend->singleProductImage->image);
					$ext = $info['extension'];
					
					$productrating=\App::make('App\Http\Controllers\Frontend\ProductController')->getRating($recommend->id);
					$ratingreview='';
					$totaluser='';
					
					if(count($productrating)>0){
						$totalsum		= collect($productrating)->sum('average_rating');
						$totaluser		= count($productrating);
						$ratingreview	= ($totalsum/$totaluser);
						$ratingreview	= round($ratingreview,1);
					}
					
					if(!empty($recommend->favorite)){
						$favorite= 'yes';
					} else{
						$favorite= 'no';
					}
					
					$html .='<div class="custome-col-3"><div class="food-box relative"><div class="food-pic relative"><input type="hidden" class="recommends" value="'.$recommend->id.'">';
					if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp'){
						if(!empty($recommend->singleProductImage->image) && \File::exists(PRODUCT_ROOT_PATH.$recommend->singleProductImage->image)){
							$image = PRODUCT_URL.$recommend->singleProductImage->image;
						}else{
							$image = WEBSITE_IMG_URL.'no-product-image.png';
						}
						
						$html .='<img src="'.$image.'" alt="">';
					}else{
						$html .='<video width="300px" height="200px" muted loop  controls poster="'.url('public/thimbnailimage.png').'"><source src="'.PRODUCT_URL.$recommend->singleProductImage->image.'" type="video/mp4"></video>';
					}
					
					if(auth()->user()){
						if($useronly== 1){
							if ($favorite == 'yes') {
								$html .='<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_'.$recommend->id.'" data-fav-id="'. $recommend->id.'"><i class="dataamount food_tab_'.$recommend->id.' far fa-heart" id="fav_'.$recommend->id.'"></i></a></span>';
							}else{
								$html .='<span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_'.$recommend->id.'" data-fav-id="'. $recommend->id.'"><i class="dataamount food_tab_'.$recommend->id.' fa fa-heart-o" id="fav_'.$recommend->id.'"></i></a></span>';
							}
						}
					}else{
						$html .='<span class="heart-icon"><a href="'.url('/login').'" class="unfavourite_token fav_'.$recommend->id.'"  data-fav-id="'.$recommend->id .'" data-fav-value="12"><i class="dataamount food_tab_'.$recommend->id .' fa fa-heart-o" id="fav_'. $recommend->id .'"></i></a></span>';
					}
					if($ratingreview != 0) {
					$html .='<div class="food-star-box d-flex align-items-center justify-content-center"><div class="food-rvw-star"><ul class="d-flex rvw-stars"><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li><li><i class="fa fa-star"></i></li></ul></div><div class="foodname-rgt"><p>'.$ratingreview.'</p></div><div class="rating-count"><p class="text-right">'.$totaluser.' ratings</p></div></div>';
					}
					$html .='</div><div class="food-name align-items-center"><div class="foodname-lft"><h4>'.\Str::limit($recommend->title,15).'</h4></div></div><div class="food-time-rvw-box"><div class="food-time d-flex align-items-center justify-content-between"><p>'.\Str::limit($recommend->description,82).'</p></div><div class="price-box d-flex align-items-center justify-content-between"><div class="price-box-lft"><p>Serving For '.$recommend->quantity.'</p></div><div class="price-box-rgt"><p>Price $ '.$recommend->price().'</p></div></div></div></div></div>';
				}
			}
			
			echo json_encode(array('html'=>$html,'is_load_more'=>$is_load_more));
		}
	}
}
