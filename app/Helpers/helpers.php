<?php

use App\Helpers\uuid;
use App\Models\Notification\Notification;
use Carbon\Carbon as Carbon;
use App\Models\Access\User\User;
use App\Models\Categories\Category;
use App\Models\Brand\Brand;
use App\Models\Diet;
use Illuminate\Support\Facades\DB;
use App\Models\Restaurant\Restaurant;
use App\Models\Products\Product;
/**
 * Henerate UUID.
 *
 * @return uuid
 */
function generateUuid()
{
    return uuid::uuid4();
}

if (!function_exists('homeRoute')) {

    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (access()->allow('view-backend')) {
            return 'admin.dashboard';
        } 
        elseif (auth()->check()) {
            return 'frontend.user.dashboard';
        }

        return 'frontend.index';
    }
}

/*
 * Global helpers file with misc functions.
 */
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('access');
    }
}

if (!function_exists('history')) {
    /**
     * Access the history facade anywhere.
     */
    function history()
    {
        return app('history');
    }
}

if (!function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('includeRouteFiles')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        $directory = $folder;
        $handle = opendir($directory);
        $directory_list = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ($filename != '.' && $filename != '..' && is_dir($directory.$filename)) {
                array_push($directory_list, $directory.$filename.'/');
            }
        }

        foreach ($directory_list as $directory) {
            foreach (glob($directory.'*.php') as $filename) {
                require $filename;
            }
        }
    }
}

if (!function_exists('getRtlCss')) {

    /**
     * The path being passed is generated by Laravel Mix manifest file
     * The webpack plugin takes the css filenames and appends rtl before the .css extension
     * So we take the original and place that in and send back the path.
     *
     * @param $path
     *
     * @return string
     */
    function getRtlCss($path)
    {
        $path = explode('/', $path);
        $filename = end($path);
        array_pop($path);
        $filename = rtrim($filename, '.css');

        return implode('/', $path).'/'.$filename.'.rtl.css';
    }
}

if (!function_exists('settings')) {
    /**
     * Access the settings helper.
     */
    function settings()
    {
        // Settings Details
        $settings = Setting::latest()->first();
        if (!empty($settings)) {
            return $settings;
        }
    }
}
if (!function_exists('userNotification')) {
    /**
     * Access the settings helper.
     */
    function userNotification()
    {
        // notifications Details
        $notification = DB::table('user_notifications')->where('user_id',auth()->user()->id)->where('is_read',0)->get();
        if (!empty($notification)) {
            return $notification;
        }
    }
}

if (!function_exists('createNotification')) {
    /**
     * create new notification.
     *
     * @param  $message    message you want to show in notification
     * @param  $userId     To Whom You Want To send Notification
     *
     * @return object
     */
    function createNotification($message, $userId)
    {
        $notification = new Notification();

        return $notification->insert([
            'message'    => $message,
            'user_id'    => $userId,
            'type'       => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}

if (!function_exists('escapeSlashes')) {
    /**
     * Access the escapeSlashes helper.
     */
    function escapeSlashes($path)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $path = str_replace('//', DIRECTORY_SEPARATOR, $path);
        $path = trim($path, DIRECTORY_SEPARATOR);

        return $path;
    }
}

if (!function_exists('getMenuItems')) {
    /**
     * Converts items (json string) to array and return array.
     */
    function getMenuItems($type = 'backend', $id = null)
    {
        $menu = new \App\Models\Menu\Menu();
        $menu = $menu->where('type', $type);
        if (!empty($id)) {
            $menu = $menu->where('id', $id);
        }
        $menu = $menu->first();
        if (!empty($menu) && !empty($menu->items)) {
            return json_decode($menu->items);
        }

        return [];
    }
}

if (!function_exists('getRouteUrl')) {
    /**
     * Converts querystring params to array and use it as route params and returns URL.
     */
    function getRouteUrl($url, $url_type = 'route', $separator = '?')
    {
        $routeUrl = '';
        if (!empty($url)) {
            if ($url_type == 'route') {
                if (strpos($url, $separator) !== false) {
                    $urlArray = explode($separator, $url);
                    $url = $urlArray[0];
                    parse_str($urlArray[1], $params);
                    $routeUrl = route($url, $params);
                } else {
                    $routeUrl = route($url);
                }
            } else {
                $routeUrl = $url;
            }
        }

        return $routeUrl;
    }
}

if (!function_exists('renderMenuItems')) {
    /**
     * render sidebar menu items after permission check.
     */
    function renderMenuItems($items, $viewName = 'backend.includes.partials.sidebar-item')
    {
        foreach ($items as $item) {
            // if(!empty($item->url) && !Route::has($item->url)) {
            //     return;
            // }
            if (!empty($item->view_permission_id)) {
                if (access()->allow($item->view_permission_id)) {
                    echo view($viewName, compact('item'));
                }
            } else {
                echo view($viewName, compact('item'));
            }
        }
    }
}

if (!function_exists('isActiveMenuItem')) {
    /**
     * checks if current URL is of current menu/sub-menu.
     */
    function isActiveMenuItem($item, $separator = '?')
    {
        $item->clean_url = $item->url;
        if (strpos($item->url, $separator) !== false) {
            $item->clean_url = explode($separator, $item->url, -1);
        }
        if (Active::checkRoutePattern($item->clean_url)) {
            return true;
        }
        if (!empty($item->children)) {
            foreach ($item->children as $child) {
                $child->clean_url = $child->url;
                if (strpos($child->url, $separator) !== false) {
                    $child->clean_url = explode($separator, $child->url, -1);
                }
                if (Active::checkRoutePattern($child->clean_url)) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('checkDatabaseConnection')) {

    /**
     * @return bool
     */
    function checkDatabaseConnection()
    {
        try {
            DB::connection()->reconnect();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}

if (!function_exists('checkUserName')) {

    /**
     * @return bool
     */
    function checkUserName($id=null)
    {
       $username=User::where('id',$id)->select('first_name')->first();

       return $username->first_name ?? '';
    }
}

if (!function_exists('checkCategoryName')) {

    /**
     * @return bool
     */
    function checkCategoryName($id=null)
    {
      $catnames='';
      $catname=Category::where('id',$id)->select('name')->first();
      if(!empty($catname))
      {
        $catnames=$catname->name;
      }
      
     return $catnames;
    }
}

if (!function_exists('checkDietName')) {

    /**
     * @return bool
     */
    function checkDietName($id=null)
    {
      $dietnames='';
      $dietname=Diet::where('id',$id)->select('name')->first();
      if(!empty($dietname))
      {
        $dietnames=$dietname->name;
      }
      
     return $dietnames;
    }
}

if (!function_exists('checkBrandName')) {

    /**
     * @return bool
     */
    function checkBrandName($id=null)
    {
       $brand='';
      if(!empty($id))
      {
        $brandname=Brand::where('id',$id)->select('name')->first();
       $brand= $brandname->name;
      }
      

       return  $brand;
    }
}

function restaurantOpen($userId, $restaurantId,$day)
{
    return \App\Models\Restaurant\RestaurantTime::where(['user_id'=> $userId, 'restaurant_id' => $restaurantId, 'day' => $day])->first();
}

 function productName($id=null)
 {
    $product= Product::where('id',$id)->select('title')->first();
     return $product->title ?? '';
 }

 function restaurantName($id=null)
 {
    $restaurant= Restaurant::where('id',$id)->select('name')->first();
     return $restaurant->name ?? '';
 }




function stripe_payment($params = []) {
    $card_number = $params['card_number'] ?? '';
    $exp_month = $params['exp_month'] ?? '';
    $exp_year = $params['exp_year'] ?? '';
    $card_cvv = $params['card_cvv'] ?? '';
    $order_total = $params['order_total'] ?? '';
    $currency = $params['currency'] ?? 'eur';
    $description = $params['description'] ?? '';
    $customer_data = $params['customer_data'] ?? [];
    /*$customer_name = $params['customer_name'] ?? '';
    $customer_description = $params['customer_description'] ?? '';
    $customer_email = $params['customer_email'] ?? '';
    $customer_name = $params['customer_name'] ?? '';
    $customer_name = $params['customer_name'] ?? '';
    $customer_name = $params['customer_name'] ?? '';*/
    $currency = strtolower($currency);
    $secret_key = $_ENV['STRIPE_API_KEY'];
    $return = ['success' => 0, 'message' => '', 'txn_id' => '', 'payment_data' => []];
    require_once (base_path() . '/stripe-php-4.4.2/init.php');
    //\Stripe\Stripe::setApiKey('sk_live_pNFn0VRVqeBYldZ5dWUOvvhd'); // client secrete key
    //\Stripe\Stripe::setApiKey('sk_test_HW4cwR4Ak6xVaSOKHOUPRise'); // sudipta test secrete key
    

    \Stripe\Stripe::setApiKey($secret_key);
    try {
      
        $card_token=\Stripe\Token::create(array(
          "card" => array(
            "number" => $card_number,
            "exp_month" => $exp_month,
            "exp_year" => $exp_year,
            "cvc" => $card_cvv
          )
        ));
        try {
            
            $customer = \Stripe\Customer::create(array_merge(['source' => $card_token->id], $customer_data));
            try {
              $charge=\Stripe\Charge::create(array(
                  'customer' => $customer->id,
                  "amount" => ($order_total * 100),
                  "currency" => $currency,
                  //"source" => $card_token->id,
                  "description" => $description
                ));
                $stripeobject = new \Stripe\StripeObject($charge);
                $stripearray = $stripeobject->__toArray(true);
                //print_r($stripearray)."<br><br>";
                $charge_id = $stripearray['id']['id'];
                $txn_id = $stripearray['id']['balance_transaction'];
                $customer = $stripearray['id']['customer'];
                $return['success'] = 1;
                $return['txn_id'] = $txn_id;
                $return['charge_id'] = $charge_id;
                $return['customer'] = $customer;
                $return['payment_data'] = $stripearray;

              } catch(\Stripe\Error\Card $e) {
            
                  $return['message'] = $e->getMessage();
              }
            
            } catch(\Stripe\Error\InvalidRequest $e) {
                $return['message'] = $e->getMessage();
            }
            
    } catch(\Stripe\Error\Authentication $e) {
        $return['message'] = $e->getMessage();
    } catch(\Stripe\Error\Card $e) {
        $return['message'] = $e->getMessage();
    }
    return $return;
}


function stripe_refund($params = []) {
  $charge_id = $params['charge_id'] ?? '';
  $refund_amount = $params['refund_amount'] ?? '';
  $refund_info = $params['refund_info'] ?? '';
  $secret_key = $_ENV['STRIPE_API_KEY'];
  $return = ['success' => 0, 'message' => '', 'refund_id' => '', 'payment_data' => []];
  require_once (base_path() . '/stripe-php-4.4.2/init.php');
  \Stripe\Stripe::setApiKey($secret_key);
  try {
    $arr = ['charge' => $charge_id];
    if($refund_amount != '') $arr['amount'] = ($refund_amount * 100);
    if($refund_info != '') $arr['metadata'] = ['refund_info' => $refund_info];
    $refund = \Stripe\Refund::create($arr);
    $stripeobject = new \Stripe\StripeObject($refund);
    $stripearray = $stripeobject->__toArray(true);
    $return['success'] = 1;
    $return['refund_id'] = $stripearray['id']['id'];
    $return['payment_data'] = $stripearray;
    //echo '<pre>'. print_r($stripearray, true) . '</pre>';
  } catch(\Stripe\Error\InvalidRequest $e) {
    $return['message'] = $e->getMessage();
    //echo $e->getMessage();
  }
  return $return;
}


function estimated_delivery_date($params) {
  $order_date = $params['order_date'] ?? date('Y-m-d');
  $restaurant = $params['restaurant'] ?? new \stdClass;
  $shipping_info = json_decode($restaurant->shipping_info, true);
  $delivery_date = date('Y-m-d', strtotime("+" . $shipping_info['preparation_time'] . " day", strtotime($order_date)));
  $daynum = (date('N', strtotime($delivery_date)) - 1);
  //nearest pickup date
  $first_pickup_date = '';
  $days_after = '';
  foreach ($shipping_info['pickuptime'] as $key => $value) {
    if(isset($value['enabled']) && $value['enabled'] == 1) {
      if($first_pickup_date === '') $first_pickup_date = $key;
      if($key >= $daynum && $days_after == '') $days_after = $key - $daynum;
    }
  }
  if($days_after === '') {
    $days_after = (6 - $daynum) + $first_pickup_date + 1;
  }
  $pickup_date = date('Y-m-d', strtotime("+" . $days_after . " day", strtotime($delivery_date)));
  $delivery_date = date('Y-m-d', strtotime("+" . ($days_after + $shipping_info['delivery_days']) . " day", strtotime($delivery_date)));
  return ['delivery_date' => $delivery_date, 'pickup_date' => $pickup_date];
}

function ups_service_codes() {
  return [
    ['service_code' => '11', 'title' => 'UPS Standard'],
    ['service_code' => '03', 'title' => 'UPS Ground'],
    ['service_code' => '12', 'title' => 'UPS 3 Day Select'],
    ['service_code' => '02', 'title' => 'UPS 2nd Day Air'],
    ['service_code' => '59', 'title' => 'UPS 2nd Day Air AM'],
    ['service_code' => '13', 'title' => 'UPS Next Day Air Saver'],
    ['service_code' => '01', 'title' => 'UPS Next Day Air'],
    ['service_code' => '14', 'title' => 'UPS Next Day Air Early A.M.'],
    ['service_code' => '07', 'title' => 'UPS Worldwide Express'],
    ['service_code' => '54', 'title' => 'UPS Worldwide Express Plus'],
    ['service_code' => '08', 'title' => 'UPS Worldwide Expedited'],
    ['service_code' => '65', 'title' => 'UPS World Wide Saver']
  ];
}


function klaviyo_add_user($params) {
  $type = $params['type'] ?? '';
  $email = $params['email'] ?? '';
  $first_name = $params['first_name'] ?? '';
  $last_name = $params['last_name'] ?? '';
  $apiKey = 'pk_a8bb87cda134b79dba27d7ca1ef5095f35';
  $data = array (
    'api_key' => $apiKey,
    'profiles' => array ('0' => array ( 'email' => $email, 'first_name' => $first_name, 'last_name' => $last_name )),
  );
  $list_id = 'UPVVwf';
  if($type == 'newsletter') $list_id = 'TankSr';
  if($type == 'register') $list_id = 'SUuzQf';
  if($type == 'guest_checkout') $list_id = 'VXxNCk';
  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => "https://a.klaviyo.com/api/v2/list/".$list_id."/members?api_key=".$apiKey,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
          "content-type: application/json",
      ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  //print_r($response);
}


function product_medias($params) {
  $medias = $params['medias'] ?? [];
  $slide_items = [];
  if($medias->isNotEmpty()) {
    foreach($medias as $k => $images) {
      $info = pathinfo(PRODUCT_ROOT_PATH.$images->image);
      $ext = $info['extension'];
      if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp') {
        $lit = $slide_items[(count($slide_items) - 1)] ?? [];
        if(isset($lit['type']) && $lit['type'] == 'video' && isset($lit['image_filename']) && $lit['image_filename'] == $images->image)
          continue;
        $slide_items[] = ['type' => 'image', 'file' => PRODUCT_URL.$images->image, 'filename' => $images->image];
      } else {
        $img = ($medias[($k + 1)]->image ?? '');
        $ext2 = '';
        if($img != '') {
          $info2 = pathinfo(PRODUCT_ROOT_PATH.$img);
          $ext2 = $info2['extension'];
        }
        $sit = ['type' => 'video', 'file' => PRODUCT_URL.$images->image, 'filename' => $images->image, 'image' => url('public/thimbnailimage.png'), 'image_filename' => '','product_id' => $images->product_id];
        if($ext2=='jpeg'||$ext2=='jpg'||$ext2=='png' ||$ext2=='gif'||$ext2=='webp') {
          $sit['image'] = PRODUCT_URL.$img;
          $sit['image_filename'] = $img;
        }
        $slide_items[] = $sit;
      }
    }
  }
  return $slide_items;
}


function restaurant_medias($params) {
  $medias = $params['medias'] ?? [];
  $slide_items = [];
  if($medias->isNotEmpty()) {
    foreach($medias as $k => $images) {
      $info = pathinfo(RESTAURANT_ROOT_PATH.$images->image);
      $ext = $info['extension'];
      if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp') {
        $lit = $slide_items[(count($slide_items) - 1)] ?? [];
        if(isset($lit['type']) && $lit['type'] == 'video' && isset($lit['image_filename']) && $lit['image_filename'] == $images->image)
          continue;
        $slide_items[] = ['type' => 'image', 'file' => RESTAURANT_URL.$images->image, 'filename' => $images->image];
      } else {
        $img = ($medias[($k + 1)]->image ?? '');
        $ext2 = '';
        if($img != '') {
          $info2 = pathinfo(RESTAURANT_ROOT_PATH.$img);
          $ext2 = $info2['extension'];
        }
        $sit = ['type' => 'video', 'file' => RESTAURANT_URL.$images->image, 'filename' => $images->image, 'image' => url('public/thimbnailimage.png'), 'image_filename' => ''];
        if($ext2=='jpeg'||$ext2=='jpg'||$ext2=='png' ||$ext2=='gif'||$ext2=='webp') {
          $sit['image'] = RESTAURANT_URL.$img;
          $sit['image_filename'] = $img;
        }
        $slide_items[] = $sit;
      }
    }
  }
  return $slide_items;
}

function get_addon_price($product_id){
    //echo $product_id;
    $product_addons = DB::table('product_addons')->where('product_id', $product_id)->get()->toArray();
    $product_addons = array_map(function ($value) {
        return (array)$value;
    }, $product_addons);
    if (!empty($product_addons)) {
        $product_addons = group_by('label', $product_addons);
    }
    //echo '<pre>'; print_r($product_addons);die;
    return $product_addons;
}

function group_by($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}
