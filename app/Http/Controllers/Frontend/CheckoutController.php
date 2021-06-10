<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Checkout\CheckoutShowRequest;
use App\Http\Requests\Frontend\Checkout\CartRequest;
use App\Http\Requests\Frontend\Checkout\SaveOrderRequest;
use App\Http\Requests\Frontend\Checkout\CheckoutRequest;
use App\Http\Requests\Frontend\Checkout\Payment_responce;
use App\Http\Requests\Frontend\Checkout\StoreProductRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products\Product;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Coupon;
use App\Models\Shippings;
use App\Models\ShippingFee;
use App\Models\PaymentHistory;
use App\Models\ShippingCommission;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantBranch;
use App\Models\Access\User\UserAddress;
use App\Models\Access\User\User;
use App\Models\User_redeemed_point;
use App\Models\Settings\Site_setting;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
	/**
	* @param Order
	*/
	private $order;

    /**
	* @param OrderDetail
	*/
	private $orderDetail;
	
	/**
     * @var Product
     */
    protected $product;
	protected $shippings;
	/**
     * @var Country
     */
    private $country;
	
	/**
     * @var State
     */
    private $state;

    /**
     * @var City
     */
    private $city;
	private $coupon;
	private $paymentHistory;
	/**
     * @var UserAddress
     */
    private $userAddress;

    public function __construct(
		Order $order, 
		OrderDetail $orderDetail,
		Product $product,
		PaymentHistory $paymentHistory,
		Country $country,
		Coupon $coupon,
		Shippings $shippings,
		State $state,
    City $city,
		UserAddress $userAddress
	) {
		$this->order = $order;
		$this->shippings = $shippings;
    $this->orderDetail = $orderDetail;
		$this->product = $product;
		$this->paymentHistory = $paymentHistory;
		$this->coupon = $coupon;
		$this->country = $country;
		$this->state = $state;
    $this->city = $city;
		$this->userAddress = $userAddress;
    }

    /**
     * @return View
     */
    public function cartStore(StoreProductRequest $request)
    {
		$product = $this->product->where('slug', $request->get('slug'))->where('sold_out', '0')->firstOrFail();
        
		$other_vendors = $this->order->where('vendor_id', '!=', $product->user_id)->whereNull('order_id')->get();
     if(count($other_vendors) > 0) {
     	foreach ($other_vendors as $key => $value) {
     		$this->orderDetail->where('order_id', $value->id)->delete();
     		$this->order->where('id', $value->id)->delete();
     	}
     }

     $checkuser=  $this->order->where('vendor_id', $product->user_id)->where('order_id', null)->first();

		if (!empty($product)) {
			if ($product->discount()) {
				$discount = $product->price() * $price = $product->discount() / 100;
				$price = $product->price() - $discount;
			} else {
				$price = $product->price();
			}
        if(empty($checkuser))
        {
    			$lastId = 	$this->order->insertGetId(
    							[
    								'user_id'=> auth()->user()->id,
    								'product_id'=> $product->id(),
                    'vendor_id' => $product->user_id,
                    'product_price' => $price,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now()
    							]
    						);
				}
				
			   
			$this->orderDetail->create(
				[
					'user_id' => auth()->user()->id,
					'order_id' =>isset($lastId)?$lastId:$checkuser->id,
        	'product_id'=>$product->id(),
        	'vendor_id' => $product->user_id,
					'price' => $price,
					'quantity' => ONE,
					'total' => $price,
                    'included_shipping_price' => $product->shipping_price
				]
			);
			
			return response()->json([
				'success' => true
			]);
		} else {
			return redirect()->to('/');
		}
    }

    public function get_cart() {
        $cart = json_decode(($_COOKIE['cart'] ?? '{}'), true);
        $data = []; $cart2 = []; $cart_infos = [];
        foreach ($cart as $product_id => $qty) {
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
                    $cart[$product_id] = $avl['avlqty'];
                    $cart2[] = ['product' => $product, 'qty' => $avl['avlqty']];
                }
                continue;
            }
            $cart[$product_id] = $qty;
            $cart2[] = ['product' => $product, 'qty' => $qty];
        }
        if(isset($_COOKIE['cart']))
            setcookie('cart', '', (time() - 3600), "/");
        setcookie('cart', json_encode($cart), time() + (86400), "/");
        $coupon_code = $_COOKIE['coupon_code'] ?? '';
        $coupon = new \stdClass;
        if($coupon_code != '') {
            $check_coupon = $this->check_coupon(['coupon_code' => $coupon_code]);
            if($check_coupon['success'] == 0) {
                setcookie('coupon_code', '', (time() - 3600), "/");
            }
            if($check_coupon['success'] == 1)
                $coupon = $check_coupon['coupon'];
        }
        $data = ['cart' => $cart2, 'cart_infos' => $cart_infos, 'coupon' => $coupon];
        return $data;
    }

	public function cart(Request $request)
	{

		/*$accesskey = env('UPS_API_KEY');
	  $userid = env('UPS_USER_ID');
	  $password = env('UPS_PASSWORD');

    $shipping = new \Ups\Shipping($accesskey, $userid, $password, true);
    $residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
    try {
        $shipment = new \Ups\Entity\Shipment();

        $shipper = $shipment->getShipper();
        $shipper->setShipperNumber("R673Y5");
        $shipper->setName('BUSINESS NAME');
        $shipperAddress = $shipment->getShipper()->getAddress();
        $shipperAddress->setPostalCode('11201');
        $shipperAddress->setAddressLine1('306 Gold Street');
        //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
        $shipperAddress->setCity('Brooklyn');
        $shipperAddress->setStateProvinceCode('NY');

        $address = new \Ups\Entity\Address();
        $address->setPostalCode('11201');
        $address->setAddressLine1('306 Gold Street');
        //$address->setAddressLine2('BUSINESS ADD 2');
        $address->setCity('Brooklyn');
        $address->setStateProvinceCode('NY');
        $shipFrom = new \Ups\Entity\ShipFrom();
        $shipFrom->setAddress($address);
        $shipFrom->setCompanyName('BUSINESS NAME');
        $shipment->setShipFrom($shipFrom);
        $ship = $shipment->getShipFrom();
        $ship->CompanyName = 'BUSINESS NAME';

        $shipTo = $shipment->getShipTo();
        $shipTo->setAttentionName('FULL NAME');
        $shipTo->setReceivingAddressName('FULL NAME');
        $shipTo->setPhoneNumber('541-754-3010');
        $shipTo->setEmailAddress('orijit14@gmail.com');
        $shipTo->setCompanyName('COMPANY NAME');
        $shipToAddress = $shipTo->getAddress();
        $shipToAddress->setPostalCode('11201');
        $shipToAddress->setAddressLine1('306 Gold Street');
        //$shipToAddress->setAddressLine2('ADDRESS 2');
        $shipToAddress->setCity('Brooklyn');
        $shipToAddress->setStateProvinceCode('NY');
        //residenial address indicator will increase the shipping rate
        if($residential_address) {
              $shipToAddress->setResidentialAddressIndicator('TRUE');
        } 
        $shipment->setShipTo($shipTo);
        //Add package
        $package = new \Ups\Entity\Package();
        $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
        $package->getPackageWeight()->setWeight(2);

        $dimensions = new \Ups\Entity\Dimensions();
        $dimensions->setHeight(8);
        $dimensions->setWidth(8);
        $dimensions->setLength(8);

        $unit = new \Ups\Entity\UnitOfMeasurement;
        $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

        $dimensions->setUnitOfMeasurement($unit);
        $package->setDimensions($dimensions);
        $shipment->addPackage($package);

        $billshipper = new \Ups\Entity\BillShipper();
        $billshipper->setAccountNumber("R673Y5");
        $prepaid = new \Ups\Entity\Prepaid(); 
        $prepaid->setBillShipper($billshipper);
        $paymentInformation = new \Ups\Entity\PaymentInformation;
        $paymentInformation->setPrepaid($prepaid);
        $shipment->setPaymentInformation($paymentInformation);
        //This will create UPS shipment
        $result = $shipping->confirm(\Ups\Shipping::REQ_VALIDATE, $shipment);

        $shipment_charges = $result->ShipmentCharges->TotalCharges->MonetaryValue;
        $shipment_weight = $result->BillingWeight->Weight." ".$result->BillingWeight->UnitOfMeasurement->Code;
        $tracking_number = $result->ShipmentIdentificationNumber;
        $shipment_digest = $result->ShipmentDigest; //can be used to print labels

        $accept = $shipping->accept($shipment_digest);

        
        $tracking_number = $accept->PackageResults->TrackingNumber;
        $imageformat = $accept->PackageResults->LabelImage->LabelImageFormat->Code;
            
        $base64image = $accept->PackageResults->LabelImage->GraphicImage;
        
        $image = base64_decode($base64image);
        
        echo $tracking_number."<br />";
        echo '<img src="data:image/png;base64, '.$base64image.'" alt="Red dot" style="transform: rotate(90deg);" />';
    } catch (Exception $e) {
        $error = $e->getMessage();
        print_r($error);
    }

	  die;*/

	    $site_settings = Site_setting::all();
        $site_settings2 = [];
        foreach ($site_settings as $key => $value) {
            $site_settings2[$value->key] = $value->value;
        }
        $site_settings = $site_settings2;

	   //$carts =  $this->cartDetail()->get();
      $carts =  $this->get_cart();
     //echo '<pre>'; print_r($carts); exit;
		
		return view('frontend.cart.cart', compact('carts', 'site_settings'));
	} 

    public function check_coupon($params) {
        $coupon_code = $params['coupon_code'];
        $data = ['success' => 0, 'message' => ''];
        $coupon = Coupon::where('coupon_code', $coupon_code)->first();
        if(!isset($coupon->id)) {
            $data['message'] = 'Coupon does not exists';
            return $data;
        }
        $countcoupon = $this->paymentHistory->where('coupon_code', $coupon_code)->count();
        if($countcoupon == $coupon->max_users) {
            $data['message'] = 'Coupon usage limit exceeds';
            return $data;
        }
        $today_st = strtotime(date('Y-m-d'));
        if($today_st > strtotime($coupon->end_date)) {
            $data['message'] = 'Coupon expired';
            return $data;
        }
        $cart = json_decode(($_COOKIE['cart'] ?? '{}'), true);
        $total_amount = 0;
        foreach ($cart as $product_id => $qty) {
            $product = Product::find($product_id);
            $total_amount += $product->price * $qty;
        }
        if($total_amount < $coupon->min_price) {
            $data['message'] = 'Minimum amount should be ' . $coupon->min_price;
            return $data;
        }
        $data['success'] = 1;
        $data['coupon'] = $coupon;
        return $data;
    }

    public function checkout(Request $request) {
        $carts =  $this->get_cart();
        if(count($carts['cart']) == 0)
            return redirect('/cart');
        $site_settings = Site_setting::all();
        $site_settings2 = [];
        foreach ($site_settings as $key => $value) {
            $site_settings2[$value->key] = $value->value;
        }
        $site_settings = $site_settings2;
        $countries = $this->country->where('sortname','US')->pluck('name','id')->all();
        $states = $this->state->where('country_id', array_key_first($countries))->pluck('name','id')->all();
        $cities = []; $country_name = $state_name = $city_name = '';
        $userAddress = new \stdClass;
        if(Auth::id() != '') {
            $userAddress = $this->userAddress->loginUserId()->where('is_primary_address', ACTIVE)->first();
        }
        if(isset($userAddress->id)) {
            $states = $this->state->where('country_id', $userAddress->countryId())->pluck('name','id')->all();
            $cities = $this->city->where('state_id', $userAddress->stateId())->pluck('name','id')->all();
            $country_name=$this->country->where('id', $userAddress->country_id)->pluck('name')->first();
            $state_name=$this->state->where('id', $userAddress->state_id)->pluck('name')->first();
            $city_name=$this->city->where('id', $userAddress->city_id)->pluck('name')->first();
        }
        $restaurant = DB::table('restaurants')->where('user_id', $carts['cart'][0]['product']->user_id)->first();
        return view('frontend.checkout.checkout', compact('carts','countries','states','cities', 'userAddress','country_name','state_name','city_name', 'restaurant', 'site_settings'));
    }

	public function couoponapply(CartRequest $request)
	{
		$couponcode=$request->get('coupon_code');
		$payment_details = $this->paymentHistory->where('coupon_code', $couponcode)
		->where('user_id', auth()->user()->id)->first();
		$countcoupon= $this->paymentHistory->where('coupon_code', $request->get('coupon_code'))->count();
		$coupon_details = $this->coupon->where('coupon_code', $couponcode)->first();
		
		$carts =  $this->cartDetail()->get();
		
		//echo '<pre>'; print_r($carts); exit;
		
		
		return view('frontend.cart.cart', compact('carts','coupon_details','payment_details','countcoupon'));

	}

	public function deleteCartProduct(CheckoutShowRequest $request)
	{
		$order = $this->orderDetail->where('id', $request->get('cart_id'))->first();
    $this->orderDetail->where('id', $request->get('cart_id'))->delete();
    // $this->order->where('id', $request->get('cart_id'))->first();
	//	$order->orderDetails()->delete();
		//$order->delete();
      $rowcount= $this->orderDetail->where('order_id', $request->get('order_id'))->where('payment_status','0')->count();
      if($rowcount==0)
      {
        $this->order->where('id', $request->get('order_id'))->delete();
      }
         $carts =  $this->cartDetail()->get();
         $count = $this->cartDetail()->count();
		
		if($count < ONE){
			$lastRecord		=	true;
		}
        
		return response()->json([
					'success'       =>  true,
					'count'         =>  $count,
					'cartList'      =>  view('frontend.cart.cart-element',compact('carts'))->render(),
					'paymentList'   =>  view('frontend.cart.payment-element',compact('carts'))->render(),
					'lastRecord'	=>	isset($lastRecord) ? $lastRecord : ''
				]);
	}
	
	private function cartDetail()
	{
    return $this->orderDetail->with('product')
          ->where('user_id', auth()->user()->id)
          ->where('payment_status', '0');
		// return $this->order->with('orderDetails','product')
		// 			->where('user_id', auth()->user()->id)
		// 			->where('order_id', null);
	}
	
	/**
     * @param CartRequest $request
     * @return mixed
     * @throws \Throwable
     */
    public function increaseDecreaseItem(CartRequest $request)
    {
       if ($request->ajax()) {
            $orderDetailId = $request->get('order_detail_id');
            $quantity = (int) $request->get('quantity');

            $orderDetail = $this->orderDetail->where('id', $orderDetailId)->first();
            $price = (int) $orderDetail->price;
            $total = $price * $quantity;
			

            if ($quantity == ZERO) {
			         	$this->order->where('id', $orderDetail->order_id)->delete();
                $this->orderDetail->where('id', $orderDetail->id)->delete();
            } else {
                $this->orderDetail->where('id', $orderDetail->id)->update(array('quantity' => $quantity, 'total' => $total));
            }

            $carts =  $this->cartDetail()->get();
		        $count = $this->cartDetail()->count();
			
			if($count < ONE){
				$lastRecord		=	true;
			}
        
			return response()->json([
					'success'       =>  true,
					'count'         =>  $count,
					'cartList'      =>  view('frontend.cart.cart-element',compact('carts'))->render(),
					'paymentList'   =>  view('frontend.cart.payment-element',compact('carts'))->render(),
					'lastRecord'	=>	isset($lastRecord) ? $lastRecord : ''
				]);
        }
    }
public function shipingcharge($code,$pincode){
	
		$rate = new \Ups\Rate(
	    env('UPS_API_KEY'),
	    env('UPS_USER_ID'),
	   env('UPS_PASSWORD')
	);
		//$this->upsShippingPayment();
		//echo $code;
 	$shipment = new \Ups\Entity\Shipment();

    $shipperAddress = $shipment->getShipper()->getAddress();
    $shipperAddress->setPostalCode('10005 ');

    $address = new \Ups\Entity\Address();
    $address->setPostalCode('10005 ');
    $shipFrom = new \Ups\Entity\ShipFrom();
    $shipFrom->setAddress($address);

    $shipment->setShipFrom($shipFrom);

    $shipTo = $shipment->getShipTo();
    $shipTo->setCompanyName('Umami Square');
    $shipToAddress = $shipTo->getAddress();
    $shipToAddress->setPostalCode($pincode);

    $package = new \Ups\Entity\Package();
    $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
    $package->getPackageWeight()->setWeight(10);
    $dimensions = new \Ups\Entity\Dimensions();
    $dimensions->setHeight(10);
    $dimensions->setWidth(10);
    $dimensions->setLength(10);

    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

    $dimensions->setUnitOfMeasurement($unit);
    $package->setDimensions($dimensions);

    $shipment->addPackage($package);

    $service = new \Ups\Entity\Service;
	$service->setCode($code);
	$service->setDescription($service->getName());
	$shipment->setService($service);
	if ($service) {
    $returnService = new \Ups\Entity\ReturnService;
    $returnService->setCode(\Ups\Entity\ReturnService::PRINT_RETURN_LABEL_PRL);
    $shipment->setReturnService($returnService);
}
$rates=$rate->getRate($shipment);
return $rates->RatedShipment[0]->TotalCharges->MonetaryValue;
   // die;
}

public function checkout1(CheckoutRequest $request)
	{
/*
		$rate = new \Ups\Rate(
	    env('UPS_API_KEY'),
	    env('UPS_USER_ID'),
	   env('UPS_PASSWORD')
	);
		//$this->upsShippingPayment();
		//echo $code;
	

		$PickupType = new \Ups\Entity\PickupType();		
   		$PickupType->setCode('03');

   $PackagingType = new \Ups\Entity\PackagingType();		
   		$PackagingType->setCode('03');

 	$shipment = new \Ups\Entity\Shipment();
    $shipperAddress = $shipment->getShipper()->getAddress();

    $shipperAddress->setPostalCode('10005 ');
     $shipperAddress->setPostalCode('10005 ');
    	
 print_r($shipperAddress);die;
    $address = new \Ups\Entity\Address();
    $address->setPostalCode('10005 ');
    $shipFrom = new \Ups\Entity\ShipFrom();
    $shipFrom->setAddress($address);

    $shipment->setShipFrom($shipFrom);

    $shipTo = $shipment->getShipTo();
    $shipTo->setCompanyName('Umami Square');
    $shipToAddress = $shipTo->getAddress();
    $shipToAddress->setPostalCode('90210 ');

    $package = new \Ups\Entity\Package();
    $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
    $package->getPackageWeight()->setWeight(5);
    $dimensions = new \Ups\Entity\Dimensions();
    $dimensions->setHeight(5);
    $dimensions->setWidth(5);
    $dimensions->setLength(5);

    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

    $dimensions->setUnitOfMeasurement($unit);
    $package->setDimensions($dimensions);

    $shipment->addPackage($package);

    $service = new \Ups\Entity\Service;
	$service->setCode('01');
	$service->setDescription($service->getName());
	$shipment->setService($service);
	if ($service) {
    $returnService = new \Ups\Entity\ReturnService;
    $returnService->setCode(\Ups\Entity\ReturnService::PRINT_RETURN_LABEL_PRL);
    $shipment->setReturnService($returnService);
}
$rates=$rate->getRate($shipment);
print_r($rates);die;
   // die;*/

		$arr='01,02,03';
		$ar=explode(',',$arr);
		
		foreach ($ar as $key => $value) {

			$getdaa=$this->upsShippingPayment($value,'1','1','1','1');
	print_r($getdaa);
		$json_string = json_encode($getdaa);    
								$result_array = json_decode($json_string, TRUE);

								$track_number=$result_array['ShipmentResults']['PackageResults']['TrackingNumber'];
							$TotalCharges=$result_array['ShipmentResults']['NegotiatedRates']['NetSummaryCharges']['GrandTotal']['MonetaryValue'];
		die;
		}
		

		$ids=auth()->user()->id;
		$userdetail= User::where('id',$ids)->first();
		print_r($userdetail);die;
		$stripe = new \Stripe\StripeClient($_ENV['STRIPE_API_KEY']);
$daddaa=$stripe->balanceTransactions->all();
//echo "<pre>"; print_r($daddaa);die;
		$carts =  $this->cartDetail()->get();

		$userAddress=array();
		if ($carts->isNotEmpty()) {
			$userAddress = $this->userAddress->loginUserId()->where('is_primary_address', ACTIVE)->first();
			//echo '<pre>'; print_r($carts); exit;
			$countries = $this->country->where('sortname','US')->pluck('name','id')->all();
			$states = $cities = [];
			$country_name='';
			$state_name='';
			$city_name='';
			$shipingOne='0';
			$shipingtwo='0';
			$shipingthree='0';
			if(!empty($userAddress)) {
				$states = $this->state->where('country_id', $userAddress->countryId())->pluck('name','id')->all();
				$cities = $this->city->where('state_id', $userAddress->stateId())->pluck('name','id')->all();
			
			$country_name=$this->country->where('id', $userAddress->country_id)->pluck('name')->first();
			$state_name=$this->state->where('id', $userAddress->state_id)->pluck('name')->first();
			$city_name=$this->city->where('id', $userAddress->city_id)->pluck('name')->first();
		//	$shipingOne=$this->shipingcharge('03',$userAddress->pincode);

			//$shipingtwo=$this->shipingcharge('02',$userAddress->pincode);
			//$shipingthree=$this->shipingcharge('01',$userAddress->pincode);
			
			//$shippingback=  $this->shippings->where('id','1')->first();
		//	$backcharge=$shippingback->price;
			//$shippingbacktwo=  $this->shippings->where('id','2')->first();
			//$backchargetwo=$shippingbacktwo->price;
			//$shippingbackthree=  $this->shippings->where('id','3')->first();
			//$backchargethree=$shippingbackthree->price;

			$service = new \Ups\Entity\Service;
			$service->setCode('01');
			$service->setDescription($service->getName());
			$service_name=$service->Description;

		}

    $shipping_comm=ShippingCommission::first();
    $shippingfee=0;
    foreach($carts as $carttotal)
    {
        $res=RestaurantBranch::with('restaurantLocation')->where('user_id',$carttotal->vendor_id)->first();
        if(!empty($res))
        {
	       $delivery_day=$res->delivery_day;
            $from_location=$res->restaurantLocation->city." ".$res->restaurantLocation->state." ".$res->restaurantLocation->country;
            $to_location=$city_name." ".$state_name." ".$country_name;
            $calculate_distance= $this->calculatedistance($from_location,$to_location);
          if($res->restaurantLocation->state=='Alaska'|| $res->restaurantLocation->state=='Hawaii'){
          $max_distance=ShippingFee::where('max_distance','>=',$calculate_distance)->first();
          if($delivery_day==1){
          	if($res->restaurantLocation->state=='Alaska'){
          		$shippingfee+=isset($max_distance->alaska_1day)?$max_distance->alaska_1day:0;
          	}else if($res->restaurantLocation->state=='Hawaii'){
          		$shippingfee+=isset($max_distance->hawai_1day)?$max_distance->hawai_1day:0;
          	}
          	
          }else if($delivery_day==2){
          	if($res->restaurantLocation->state=='Alaska'){
          		$shippingfee+=isset($max_distance->alaska_2day)?$max_distance->alaska_2day:0;
          	}else if($res->restaurantLocation->state=='Hawaii'){
          		$shippingfee+=isset($max_distance->hawai_2day)?$max_distance->hawai_2day:0;
          	}
          }else if($delivery_day==3){
          	if($res->restaurantLocation->state=='Alaska'){
          		$shippingfee+=isset($max_distance->alaska_3day)?$max_distance->alaska_3day:0;
          	}else if($res->restaurantLocation->state=='Hawaii'){
          		$shippingfee+=isset($max_distance->hawai_3day)?$max_distance->hawai_3day:0;
          	}
          }

          }else{
                $shippingfee+=0;
          }
        }
    }  
        $shipingOne='';
        $shipingtwo='';
        $shipingthree='';
        $backcharge='';
        $backchargetwo='';
        $backchargethree='';
			return view('frontend.checkout.checkout1', compact('carts','countries','states','cities', 'userAddress','country_name','state_name','city_name','shipingOne','shipingtwo','shipingthree','backcharge','backchargetwo','backchargethree','shipping_comm','shippingfee'));
		}
		
		return redirect()->to('/');		
	}
	public function checkout_old(CheckoutRequest $request)
	{
		
        /*$vv = view('emails.account-confirm', [
                'name' => 'sudipta chakraborti',
                'email' => 'sudipta.aqualeaf@gmail.com',
                'url' => url('verification', '1234registerForm')
            ])->render();*/
        /*Mail::raw($vv, function ($message){
            $message->to('sudipta.aqualeaf@gmail.com');
        });*/

        /*$to = 'sudipta.aqualeaf@gmail.com';
        Mail::send('emails.test_account_confirm', [
                'name' => 'sudipta chakraborti',
                'email' => $to,
                'acturl' => url('verification', '1234registerForm22')
            ], function ($message) use ($to){
            $message->to($to);
            //$message->subject('Confirm your account');
        });
        die;*/

        /*$this->sendMail(
            [
                'name' => 'sudipta chakraborti',
                'email' => 'sudipta.aqualeaf@gmail.com',
                'acturl' => url('verification', '1234registerForm')
            ],
            'emails.test_account_confirm',
            'Confirm your account'
        );
        die;*/

        /*$to = 'sudipta.aqualeaf@gmail.com';
        $from = env('MAIL_FROM');
        $mailData = [
            'name' => 'aa aa',
            'email' => $to
        ];
        $subject = 'Confirm your account';
        Mail::send('emails.test_account_confirm',
            $mailData,
            function ($message) use ($mailData, $subject, $to, $from) {
                $message->to($to)
                    ->subject($subject)
                    ->from($from, env('APP_NAME'));
            });*/

        $carts =  $this->cartDetail()->get();
		$userAddress=array();
		if ($carts->isNotEmpty()) {
            $restaurant = DB::table('restaurants')->where('user_id', $carts[0]->vendor_id)->first();
			$userAddress = $this->userAddress->loginUserId()->where('is_primary_address', ACTIVE)->first();
			//echo '<pre>'; print_r($carts); exit;
    	 	$countries = $this->country->where('sortname','US')->pluck('name','id')->all();
			$states = $cities = [];
			$country_name='';
			$state_name='';
			$city_name='';
			$shipingOne='0';
			$shipingtwo='0';
			$shipingthree='0';
			if(!empty($userAddress)) {
				$states = $this->state->where('country_id', $userAddress->countryId())->pluck('name','id')->all();
				
				$cities = $this->city->where('state_id', $userAddress->stateId())->pluck('name','id')->all();
			
				$country_name=$this->country->where('id', $userAddress->country_id)->pluck('name')->first();
				$state_name=$this->state->where('id', $userAddress->state_id)->pluck('name')->first();
				$city_name=$this->city->where('id', $userAddress->city_id)->pluck('name')->first();
				/*$service = new \Ups\Entity\Service;
				$service->setCode('01');
				$service->setDescription($service->getName());
				$service_name=$service->Description;*/
			}

			    $shipping_comm=ShippingCommission::first();
			    $shippingfee=0;
			    $shippingfee1=0;
			    $shippingcharge=0;
			    $serviceCode='03';
			    foreach($carts as $carttotal){
			    	//print_r();die;
			        $res=RestaurantBranch::with('restaurantLocation')->where('user_id',$carttotal->vendor_id)->first();
			 		 if(!empty($res))
			 		{
				       $delivery_day=$res->delivery_day;

			            $from_location=$res->restaurantLocation->city." ".$res->restaurantLocation->state." ".$res->restaurantLocation->country;
			            $to_location=$city_name." ".$state_name." ".$country_name;
			            $calculate_distance= $this->calculatedistance($from_location,$to_location);
					 	if($res->restaurantLocation->state=='Alaska'|| $res->restaurantLocation->state=='Hawaii')
					  	{
					          	$max_distance=ShippingFee::where('max_distance','>=',$calculate_distance)->first();
					          	if($delivery_day==1){
					          	  	if($res->restaurantLocation->state=='Alaska'){
					          	
					          			$shippingfee+=isset($max_distance->alaska_1day)?$max_distance->alaska_1day:0;
					          			$shippingfee1=isset($max_distance->alaska_1day)?$max_distance->alaska_1day:0;
					          		/*	$shipingcharge=$this->shipingcharge1($max_distance->service_1,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_1)?$max_distance->service_1:'01';

					          		}else if($res->restaurantLocation->state=='Hawaii'){
					          		
					          			$shippingfee+=isset($max_distance->hawai_1day)?$max_distance->hawai_1day:0;
					          			$shippingfee1=isset($max_distance->hawai_1day)?$max_distance->hawai_1day:0;
					          			/*$shipingcharge=$this->shipingcharge1($max_distance->service_1,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_1)?$max_distance->service_1:'01';
					          		}
					           }else if($delivery_day==2){
					          		if($res->restaurantLocation->state=='Alaska'){
					          		
					          			$shippingfee+=isset($max_distance->alaska_2day)?$max_distance->alaska_2day:0;
					          			$shippingfee1=isset($max_distance->alaska_2day)?$max_distance->alaska_2day:0;
					          		/*	$shipingcharge=$this->shipingcharge1($max_distance->service_2,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_2)?$max_distance->service_2:'02';
					          		}else if($res->restaurantLocation->state=='Hawaii'){
					          		
					          			$shippingfee+=isset($max_distance->hawai_2day)?$max_distance->hawai_2day:0;
					          			$shippingfee1=isset($max_distance->hawai_2day)?$max_distance->hawai_2day:0;
					          			/*$shipingcharge=$this->shipingcharge1($max_distance->service_2,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_2)?$max_distance->service_2:'02';
					          		} 
					        	}
					      		else if($delivery_day==3){
					          		if($res->restaurantLocation->state=='Alaska'){
					          		
					          			$shippingfee+=isset($max_distance->alaska_3day)?$max_distance->alaska_3day:0;
					          			$shippingfee1=isset($max_distance->alaska_3day)?$max_distance->alaska_3day:0;
					      			/*	$shipingcharge=$this->shipingcharge1($max_distance->service_3,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_3)?$max_distance->service_3:'03';
					  
					          		}else if($res->restaurantLocation->state=='Hawaii'){
					          		
					          			$shippingfee+=isset($max_distance->hawai_3day)?$max_distance->hawai_3day:0;
					          			$shippingfee1=isset($max_distance->hawai_3day)?$max_distance->hawai_3day:0;
					          			/*$shipingcharge=$this->shipingcharge1($max_distance->service_3,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_3)?$max_distance->service_3:'03';
									}
								}else if($delivery_day=='above'){
					          		if($res->restaurantLocation->state=='Alaska'){
					          			$shippingfee+=isset($max_distance->alaska_above)?$max_distance->alaska_above:0;
					          			$shippingfee1=isset($max_distance->alaska_above)?$max_distance->alaska_above:0;
					          			/*$shipingcharge=$this->shipingcharge1($max_distance->service_above,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_above)?$max_distance->service_above:'03';
					      			}else if($res->restaurantLocation->state=='Hawaii'){
					          			$shippingfee+=isset($max_distance->hawai_above)?$max_distance->hawai_above:0;
					          			$shippingfee1=isset($max_distance->hawai_above)?$max_distance->hawai_above:0;
					          		/*	$shipingcharge=$this->shipingcharge1($max_distance->service_above,$res->restaurantLocation->zip_code,$userAddress->pincode);*/
					          			$serviceCode=isset($max_distance->service_above)?$max_distance->service_above:'03';
					          		}
					       		}
					    }else{
					      	
					       		 $shippingfee+=0;
					       		 $shippingfee1=0;
							  	 $serviceCode=isset($max_distance->service_above)?$max_distance->service_above:'03';
					      	}

					      	$shippingfeeData[]=$shippingfee1;
					      	$servicecodes[]=$serviceCode;
					      	$product_weight[]=$carttotal['product']->weight;
					      	$product_height[]=$carttotal['product']->height;
					      	$product_length[]=$carttotal['product']->length;
					      	$product_width[]=$carttotal['product']->width;
					}
			    }  

			  $shippingfeeamaount=implode(',',$shippingfeeData);
			  $serviceCode=implode(',',$servicecodes);
			  $product_weight=implode(',',$product_weight);
			  $product_height=implode(',',$product_height);
			  $product_length=implode(',',$product_length);
			  $product_width=implode(',',$product_width);
		        $shipingOne='';
		        $shipingtwo='';
		        $shipingthree='';
		        $backcharge='';
		        $backchargetwo='';
		        $backchargethree='';
					return view('frontend.checkout.checkout', compact('carts','countries','states','cities', 'userAddress','country_name','state_name','city_name','shipingOne','shipingtwo','shipingthree','backcharge','backchargetwo','backchargethree','shipping_comm','shippingfee','serviceCode','product_weight','product_height','product_length','product_width','shippingfeeamaount', 'restaurant'));
		}
		
		return redirect()->to('/');		
	}
	public function shipingcharge1($code,$restocode,$pincode){
		$rate = new \Ups\Rate(
	    env('UPS_API_KEY'),
	    env('UPS_USER_ID'),
	   env('UPS_PASSWORD')
	);
		//echo $code;die;
 	$shipment = new \Ups\Entity\Shipment();

    $shipperAddress = $shipment->getShipper()->getAddress();
    $shipperAddress->setPostalCode('10005 ');

    $address = new \Ups\Entity\Address();
    $address->setPostalCode('10005 ');
    $shipFrom = new \Ups\Entity\ShipFrom();
    $shipFrom->setAddress($address);

    $shipment->setShipFrom($shipFrom);

    $shipTo = $shipment->getShipTo();
    $shipTo->setCompanyName('Umami Square');
    $shipToAddress = $shipTo->getAddress();
    $shipToAddress->setPostalCode($pincode);

    $package = new \Ups\Entity\Package();
    $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
    $package->getPackageWeight()->setWeight(1);
    $dimensions = new \Ups\Entity\Dimensions();
    $dimensions->setHeight(1);
    $dimensions->setWidth(1);
    $dimensions->setLength(1);

    $unit = new \Ups\Entity\UnitOfMeasurement;
    $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

    $dimensions->setUnitOfMeasurement($unit);
    $package->setDimensions($dimensions);

    $shipment->addPackage($package);

    $service = new \Ups\Entity\Service;
	$service->setCode($code);
	$service->setDescription($service->getName());
	//print_r($service);
	$shipment->setService($service);
	$rates=$rate->getRate($shipment);
	/*print_r($rates);die;*/
return $rates->RatedShipment[0]->TotalCharges->MonetaryValue;
   // die;
}

	public function calculatedistance($from,$to){
	 $url = "https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($from)."&destination=".urlencode($to)."&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
    $result_string = file_get_contents($url);
    $result = json_decode($result_string, true);
    if(isset($result['routes'][0]['legs'][0]['distance']['value'])){
    $distance1=	$result['routes'][0]['legs'][0]['distance']['value'];
    $distance =(int)$distance1*0.000621371;

    }else{
    $distance=0;
    }
     
    return $distance;
	}

    public function order_email_notification($order_id,$vendor_id){
        $order = Order::select('orders.*', 'st.name as state_name', 'st.state_code')->leftJoin('states as st', 'st.id', 'orders.state_id')->where('orders.id', $order_id)->first();
        $order_items = $this->orderDetail->with('product')->where('order_id', $order_id)->get();
        $payment_history = DB::table('payment_history')->where('order_id', $order->order_id)->first();
        $mail_data = [
            'name'  => $order->first_name . ' ' . $order->last_name,
            'email' => $order->email,
            'order_data' => $order,
            'order_items' => $order_items,
            'payment_history' => $payment_history,
            'mail_type' => 'customer'
        ];
        $this->sendMail($mail_data, 'emails.order-confirmation3', 'Your Umami Square Order confirmation ' . $order->order_id);
        $restaurant_user_info = DB::table('users')->where('id', $vendor_id)->select('first_name','last_name','email')->first();
        $mail_data['email'] = $restaurant_user_info->email;
        $mail_data['mail_type'] = 'vendor';
        $this->sendMail($mail_data, 'emails.order-confirmation3', 'New Order placed');
        $mail_data['email'] = 'info@umamisquare.com';
        $mail_data['mail_type'] = 'admin';
        $this->sendMail($mail_data, 'emails.order-confirmation3', 'New Order placed');
    }
	
	public function order_email_notification_xxxx($order_id,$vendor_id){
		
		$carts =  $this->orderDetail->with('product')->where('user_id', auth()->user()->id)->where('order_id', $order_id)->get();
		$order_info = DB::table('order_details')->select('orders.*', 'products.title')->leftJoin('orders', 'order_details.order_id', 'orders.id')->leftJoin('products', 'order_details.product_id', 'products.id')->where('order_details.order_id', $order_id)->first();

        $payment_history = DB::table('payment_history')->where('order_id', $order_info->order_id)->first();
		
		$order_result=array();
		foreach($carts as $cart){
			if(!empty($cart->product->singleProductImage->image) && \File::exists(PRODUCT_ROOT_PATH.$cart->product->singleProductImage->image)){
				$image = PRODUCT_URL.$cart->product->singleProductImage->image;
			}else{
				$image = WEBSITE_IMG_URL.'no-product-image.png';
			}
			
			$customer_info = DB::table('users')->where('id', auth()->user()->id)->first();
			
			$order_result[]=array(
				'image'			=> $image,
				'title'			=> $cart->product->title,
				'price'			=> CURRENCY.number_format($cart->price, 2),
				'qty'			=> $cart->quantity,
				'total'			=> CURRENCY.number_format($cart->total,2),
				'order_info' 	=> $order_info,
				'customer_info'	=> $customer_info
			);
			
		}
		
		$restaurant_user_info = DB::table('users')->where('id', $vendor_id)->select('first_name','last_name','email')->first();
		
		if(count($order_result)>0){
			$customerMailData = [
            'name' 	=> $customer_info->first_name .' '. $customer_info->last_name,
            'email' => $customer_info->email,
			'order_result' =>$order_result,
            'payment_history' =>$payment_history
          ];

          /*$vv = view('emails.order-confirmation2', $customerMailData)->render();
          echo $vv; 
          $vv = view('emails.order-confirmation3', $customerMailData)->render();
          echo $vv; 
          die;*/
		  //dd($customerMailData);
		  
		  $this->sendMail(
				$customerMailData,
                'emails.order-confirmation',
                'New Order placed'
            );
		  
		  $restaurantMailData = [
            'email' => $restaurant_user_info->email,
			'order_result' =>$order_result
          ];
		  
		  $this->sendMail(
				$restaurantMailData,
                'emails.order-admin-confirmation',
                'New Order placed'
            );
		  
		  $adminMailData = [
			'email' => 'info@umamisquare.com',
			'order_result' =>$order_result
          ];
		 
		  $this->sendMail(
				$adminMailData,
                'emails.order-admin-confirmation',
                'New Order placed'
            );
			
		}
	}
	
	public function saveOrder(Request $request)
	{
		/*[address_primary_id] => 18
    [first_name] => Vilsan
    [last_name] => Kumar
    [country_id] => 231
    [street_address] => test
    [alternative_address] => 
    [state_id] => 3956
    [city] => wewe
    [zip_code] => 10005
    [serviceCode] => 03
    [product_weight] => 1
    [product_height] => 1
    [product_length] => 1
    [product_width] => 1
    [gift_message] => 
    [payment_type] => shipping
    [email] => adminwdp@mailinator.com
    [phone] => 9632589632
    [payment_ammount] => 113.3
    [product_amount] => 110
    [coupon_code] => 
    [discount_price] => 0.00
    [shipping_charge] => 0
    [tax_ammount] => 0
    [stripeToken] => */
    //print_r($request); die;
    $order = DB::table('orders')->whereNull('order_id')->get();
    $order = $order[0];
	$cart_order_id 	= $order->id;
	$cart_vendor_id = $order->vendor_id;
    $order_details = DB::table('order_details')->select('order_details.*', 'products.title')->leftJoin('products', 'order_details.product_id', 'products.id')->where('order_details.order_id', $order->id)->get();
    foreach ($order_details as $key => $value) {
      $avl = Product::check_availability(['product_id' => $value->product_id, 'with_qty' => $value->quantity]);
      if(!$avl)
        return response()->json(['message' => $value->title . ' exceeds daily order limit', 'success' => false]);
    }
    $first_name = trim($request->input('first_name'));
    $last_name = trim($request->input('last_name'));
    $street_address = trim($request->input('street_address'));
    $alternative_address = trim($request->input('alternative_address'));
    $serviceCode = trim($request->input('serviceCode'));
    $gift_message = trim($request->input('gift_message'));
    $gift_message_name = trim($request->input('gift_message_name'));
    $payment_type = trim($request->input('payment_type'));
    $email = trim($request->input('email'));
    $phone = trim($request->input('phone'));
    $payment_ammount = trim($request->input('payment_ammount'));
    $coupon_code = trim($request->input('coupon_code'));
    $discount_price = trim($request->input('discount_price'));
    $shipping_charge = trim($request->input('shipping_charge'));
	$tax_ammount = trim($request->input('tax_ammount'));

    $country_id = trim($request->input('country_id'));
    $state_id = trim($request->input('state_id'));
    $city = trim($request->input('city'));
    $street_address = trim($request->input('street_address'));
    $address_line_2 = trim($request->input('address_line_2'));
    $zip_code = trim($request->input('zip_code'));
    $card_number = trim($request->input('card_number'));
    $card_exp_month = trim($request->input('card_exp_month'));
    $card_exp_year = trim($request->input('card_exp_year'));
    $card_cvc = trim($request->input('card_cvc'));
    $country = Country::find($country_id);
    $state = State::find($state_id);

	$accessKey = env('UPS_API_KEY');
	$userId = env('UPS_USER_ID');
	$password = env('UPS_PASSWORD');

	$address = new \Ups\Entity\Address();
    $address->setAttentionName('User Address');
    $address->setBuildingName('User Address');
    $address->setAddressLine1($street_address);
    if($address_line_2 != '')
      $address->setAddressLine2($address_line_2);  
    $address->setStateProvinceCode($state->state_code);
    $address->setCity($city);
    $address->setCountryCode('US');
    $address->setPostalCode($zip_code);
    $xav = new \Ups\AddressValidation($accessKey, $userId, $password);
            $xav->activateReturnObjectOnValidate(); //This is optional
    try {
        $response = $xav->validate($address, $requestOption = \Ups\AddressValidation::REQUEST_OPTION_ADDRESS_VALIDATION, $maxSuggestion = 15);
        if ($response->noCandidates()) {
            return response()->json(['message' => 'Invalid delivary address.', 'success' => false]);
        }
        if ($response->isAmbiguous()) {
            $candidateAddresses = $response->getCandidateAddressList();
            return response()->json(['message' => 'Invalid delivary address.', 'success' => false]);
        }
        if ($response->isValid()) {
            $validAddress = $response->getValidatedAddress();
			//print_r($validAddress); die;
            //return response()->json(['success' => true]);

            $user_id = auth()->user()->id;
            $user = User::find($user_id);

            if($user->first_name == '') $user->first_name = $first_name;
            if($user->last_name == '') $user->last_name = $last_name;
            if($user->phone == '') $user->phone = $phone;
            $user->save();

            /*$shipping_label = Order::generate_shipping_label(['order_id' => $order->id, 'sandbox' => true, 'test_only' => true, 'param_data' => true, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'phone' => $phone, 'street_address' => $street_address, 'address_line_2' => $address_line_2, 'alternative_address' => $alternative_address, 'zip_code' => $zip_code, 'country_id' => $country_id, 'state_id' => $state_id, 'city' => $city]);
            if($shipping_label['success'] == false) 
                return response()->json(['message' => 'You entered an unknown address', 'success' => false]);*/

			$stripe_payment = stripe_payment(['card_number' => $card_number, 'exp_month' => $card_exp_month, 'exp_year' => $card_exp_year, 'card_cvv' => $card_cvc, 'order_total' => $payment_ammount, 'currency' => 'usd', 'description' => 'umamisquare pay', 'customer_data' => [
				'name' => $first_name . ' ' . $last_name, 'description' => $street_address, 'email' => $user->email, "address" => ["city" => $city, "country" => $country->sortname, "line1" => $street_address, "line2" => $address_line_2, "postal_code" => $zip_code]
			]]);
			//print_r($stripe_payment); die;
			if(!isset($stripe_payment['txn_id'])) {
				return response()->json(['success' => false, 'message' => $stripe_payment['message']]);
			}
                        $order_date = date('Y-m-d');
                        $restaurant = DB::table('restaurants')->where('user_id', $order->vendor_id)->first();
                        $shipping_info = json_decode($restaurant->shipping_info, true);
                        $estimated_delivery_date = estimated_delivery_date(['restaurant' => $restaurant]);
                        $delivery_date = $estimated_delivery_date['delivery_date'];
                        $pickup_date = $estimated_delivery_date['pickup_date'];
						
						$order_id = 'US'.mt_rand(1000000000, (int) 9999999999);
						DB::table('orders')->whereNull('order_id')->update(['user_id' => $user_id, 'country_id' => $country_id, 'state_id' => $state_id, 'city' => $city, 'order_id' => $order_id, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'phone' => $phone, 'street_address' => $street_address, 'address_line_2' => $address_line_2, 'alternative_address' => $alternative_address, 'zip_code' => $zip_code, 'preparation_time' => $shipping_info['preparation_time'], 'delivery_days' => $shipping_info['delivery_days'], 'payment_type' => 'ONLINE', 'order_date' => $order_date, 'pickup_date' => $pickup_date, 'delivery_date' => $delivery_date, 'is_gift' => ($gift_message != '' ? 'ACTIVE' : 'INACTIVE'), 'gift_message' => $gift_message, 'gift_message_name' => $gift_message_name]);
						DB::table('order_details')->where('order_id', $order->id)->update(['vendor_name' => $restaurant->name, 'pay_order_id' => $order_id, 'payment_status' => '1', 'order_detail_date' => $order_date]);
						$last_order_result		= DB::table('orders')->whereNotNull('order_id')->orderBy('id', 'DESC')->take(1)->get();
						$last_order_info 		= $last_order_result[0];
						$last_order_details		= DB::table('order_details')->select('order_details.*', 'products.title')->leftJoin('products', 'order_details.product_id', 'products.id')->where('order_details.order_id', $last_order_info->id)->get();
						foreach ($last_order_details as $key => $value) {
							$avl = Product::check_availability(['product_id' => $value->product_id, 'with_qty' => $value->quantity]);
							if(!$avl){
								DB::table('products')->where('id', $value->product_id)->update(['sold_out' => 1]);
								
							}
						}
						$paymentdata = array('coupon_code'=> $coupon_code,'product_amount'=>$request->product_amount,'discount_price'=>$discount_price,'shipping_charge'=>$shipping_charge,'tax_ammount'=>$tax_ammount,'amount'=>$request->payment_ammount,'transaction_id'=>$stripe_payment['txn_id'],'vendor_id'=>$order->vendor_id,'charge_id'=>$stripe_payment['charge_id'],'stripe_customer_id'=>$stripe_payment['customer'],'user_id'=>auth()->user()->id,'payment_date'=>date('Y-m-d'));
    			  $paymentdata['order_id'] = $order_id;
    			  DB::table('payment_history')->insert($paymentdata);
                  Order::generate_shipping_label(['order_id' => $order->id]);
				  $this->order_email_notification($cart_order_id,$cart_vendor_id);
    			  return response()->json(['success' => true, 'message' => '']);
        } else {
        	return response()->json(['success' => false, 'message' => 'There something error in checkout process']);
        }
    } catch (Exception $e) {
        //print_r($e);
    	return response()->json(['success' => false, 'message' => 'There something error in checkout process']);
    }
	}

	public function saveOrder1111111(SaveOrderRequest $request)
	{
		//session()->forget('token_id_data');
		//print_r($request->all());die;
	 //$shipping=$this->upsShippingPayment(); 

		$orderdetailIds = $this->cartDetail()->orderBy('id', 'asc')->pluck('id')->all();
    	$productIds = $this->cartDetail()->orderBy('id', 'asc')->get();
	//	echo '<pre>';print_r($productIds);die;
   		$orderIds = $this->cartDetail()->orderBy('id', 'asc')->groupBy('order_id')->pluck('order_id')->all();

   		$addressarray=array('country_id' => $request->countryId(),
							'state_id' => $request->stateId(),
							'city_id' => $request->cityId(),
							'address_primary_id' => $request->address_primary_id,
							'street_address' => $request->streetAddress(),
							'alternative_address' => $request->alternativeAddress(),
							'updated_at' => Carbon::now(),
					);

   		$useraddressarray=array('country_id' => $request->countryId(),
							'state_id' => $request->stateId(),
							'city_id' => $request->cityId(),
							'pincode' => $request->zip_code,
							'street_address' => $request->streetAddress(),
							'alternative_address' => $request->alternativeAddress(),
							'updated_at' => Carbon::now(),
					);

   		   $country_name=$this->country->where('id',$request->countryId())->pluck('name')->first();
			$state_name=$this->state->where('id', $request->stateId())->pluck('name')->first();
			$city_name=$this->city->where('id', $request->cityId())->pluck('name')->first();

	$urlpre = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($request->zip_code)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
    $result_stringpre= file_get_contents($urlpre);
    $resultpre = json_decode($result_stringpre, true);

     $dataresultcheck=$resultpre['results'][0]['address_components'];
        $addressstatus='';
       foreach ($dataresultcheck as $key => $value) {
         if($value['short_name']=='US')
         {
          $addressstatus='ok';
         }
       }
     
      if(empty($addressstatus))
      {
        // if(count($resultpre['results'])<1){
        	session()->put('errors',
        					[
        					'title' => trans('Wrong Zipcode'),
        					'msg' => trans('Please Use Only United State Based Zipcode.')
        				]);
        		if($request->payment_type!='online')
            {	
        			return response()->json([
        				'success' => true,
        			]);
            } else
            {
              return redirect()->back();
            }
        //}
      }
            
    		
   $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($country_name.$state_name.$request->zip_code)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
				  
	$result_string = file_get_contents($url);
    $result = json_decode($result_string, true);

   $dataresultcheck=$result['results'][0]['address_components'];
   $stateshort_code='';
   if(in_array('country', $dataresultcheck[0]['types'])){
   	 $stateshort_code =$result['results'][0]['address_components'][1]['long_name'];
   }else if(in_array('country', $dataresultcheck[1]['types'])){
   	 $stateshort_code =$result['results'][0]['address_components'][1]['long_name'];
   }else if(in_array('country', $dataresultcheck[2]['types'])){
   	 $stateshort_code =$result['results'][0]['address_components'][2]['long_name'];
   }else if(in_array('country', $dataresultcheck[3]['types'])){
   	 $stateshort_code =$result['results'][0]['address_components'][3]['long_name'];
   } else if(in_array('country', $dataresultcheck[4]['types'])){
   	 $stateshort_code =$result['results'][0]['address_components'][4]['long_name'];
   }else if(in_array('country', $dataresultcheck[5]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][5]['long_name'];
   }else if(in_array('country', $dataresultcheck[6]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][6]['long_name'];
   }else if(in_array('country', $dataresultcheck[7]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][7]['long_name'];
   }else if(in_array('country', $dataresultcheck[8]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][8]['long_name'];
   }else if(in_array('country', $dataresultcheck[9]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][9]['long_name'];
   }else if(in_array('country', $dataresultcheck[10]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][10]['long_name'];
   }else if(in_array('country', $dataresultcheck[11]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][11]['long_name'];
   }else if(in_array('country', $dataresultcheck[12]['types'])){
     $stateshort_code =$result['results'][0]['address_components'][12]['long_name'];
   } 

		if($stateshort_code!='United States'){

			session()->put('errors',
					[
					'title' => trans('Wrong Address'),
					'msg' => trans('Please Use Only United State Based Address.')
				]);
			return redirect()->back();
			return response()->json([
				'success' => true,
			]);

		}

   			if($request->address_primary_id!=''){
					$this->userAddress->where('id',$request->address_primary_id)
							->update($useraddressarray);
                            User::where('id',auth()->user()->id)->update(['phone'=>$request->phone]);
						}else{
							$useraddressarray['user_id']=auth()->user()->id;
							$useraddressarray['is_primary_address']='ACTIVE';
							$this->userAddress
							->create($useraddressarray);
                            User::where('id',auth()->user()->id)->update(['phone'=>$request->phone]);
						}
					
				if($request->payment_type==''){
				
				return response()->json([
					'success' => 'true',
				]);
				}else if($request->payment_type=='shipping'){
					session()->put('payment_button','payment_button');
          session()->put('is_gift',$request->is_gift);
          $gift_message=isset($request->gift_message)?$request->gift_message:'';
          session()->put('gift_message',$gift_message);
					
				}else{
					if(!empty($orderIds)) {
							if(isset($request->stripeToken)){
							$stripe = new \Stripe\StripeClient($_ENV['STRIPE_API_KEY']);
							$customer = $stripe->customers->create([
							'description' => '',
							'email' =>$request->stripeEmail,
							]);

							$charge=$stripe->charges->create([
							'amount' => $request->payment_ammount*100,
							'currency' => 'inr',
							'source' => $request->stripeToken,
							'description' => '',
							]);
						}

						foreach($orderIds as $key => $id) {

							$res=RestaurantBranch::with('restaurantLocation')->where('user_id',$productIds[$key]->vendor_id)->first();
             $vendorName= User::where('id',$productIds[$key]->vendor_id)->first();

							$vendors =$this->order->where('id', $id)->first();
							$addressarray['order_id']='US'.mt_rand(1000000000, (int) 9999999999);
							$addressarray['first_name']=$request->firstName();
		   					$addressarray['last_name']=$request->lastName();
		   					$addressarray['zip_code']=$request->zip_code;
		   					$addressarray['email']=$request->email();
		   					$addressarray['phone']=$request->phone();
						    $addressarray['payment_type']='ONLINE';
                            $addressarray['order_date']=date('Y-m-d');
							session()->forget('payment_button');

							$paymentdata= array('coupon_code'=>$request->coupon_code,'product_amount'=>$request->product_amount,'discount_price'=>$request->discount_price,'shipping_charge'=>$request->shipping_charge,'tax_ammount'=>$request->tax_ammount,'amount'=>$request->payment_ammount,'transaction_id'=>$charge->balance_transaction,'vendor_id'=>$vendors->vendor_id,'charge_id'=>$charge->id,'stripe_customer_id'=>$customer->id,'user_id'=>auth()->user()->id,'payment_date'=>date('Y-m-d'));
    			                 $paymentdata['order_id']=$addressarray['order_id'];
		          			  $shippingcode=$request->serviceCode;
		          			  $code=explode(',',$shippingcode);

		          			  $product_weight=$request->product_weight;
		          			  $product_weight=explode(',',$product_weight);

		          			  $product_height=$request->product_height;
		          			  $product_height=explode(',',$product_height);

		          			  $product_length=$request->product_length;
		          			  $product_length=explode(',',$product_length);

		          			  $product_width=$request->product_width;
		          			  $product_width=explode(',',$product_width);
		          			 
		          			 // foreach ($code as $key => $values) {
		          			  	$shipping=$this->upsShippingPayment($code[$key],$product_weight[$key],$product_height[$key],$product_length[$key],$product_width[$key]);
		          			  
		          			
		          			if($shipping){
								$json_string = json_encode($shipping);    
								$result_array = json_decode($json_string, TRUE);

								$track_number=$result_array['ShipmentResults']['PackageResults']['TrackingNumber'];
								/*$TotalCharges=$result_array['ShipmentResults']['ShipmentCharges']['TotalCharges']['MonetaryValue'];*/
								$TotalCharges=$result_array['ShipmentResults']['NegotiatedRates']['NetSummaryCharges']['GrandTotal']['MonetaryValue'];
								$label_image=$result_array['ShipmentResults']['PackageResults']['LabelImage']['GraphicImage'];
								$userid=auth()->user()->id;
               					 $serviceCode=$code[$key];
								if($serviceCode=='01'){
									$servicename="Next Day Air Service";
								}else if($serviceCode=='02'){
									$servicename="2nd Day Air Service";
								}else if($serviceCode=='03'){
									$servicename="Ground Service";
								}else{
									$servicename="Ground Service";
								}
				          				$ups_shipping=array('user_id'=>$userid,'shipping_charge'=>$TotalCharges,'track_no'=>$track_number,'image_lable'=>$label_image,'product_order_id'=>$addressarray['order_id'],'service_name'=>$servicename);
								DB::table('ups_shipping_payment')->insert($ups_shipping);
		          			}

		          	//	}

         			  DB::table('payment_history')->insert($paymentdata);
								$addressarray['is_gift']=isset($request->is_gift)?$request->is_gift:INACTIVE;
                $addressarray['gift_message']=isset($request->gift_message)?$request->gift_message:'';
								$addressarray['created_at']=Carbon::now();
								$this->order->where('id', $id)
								->update($addressarray);
								$paymentdata1['pay_order_id']=$addressarray['order_id'];

								$paymentdata1['vendor_name']=$vendorName->first_name;
                $paymentdata1['order_detail_date']=date('Y-m-d');
								$this->orderDetail->where('order_id', $id)
								->update($paymentdata1);
					           //Seller Notificatio Start
                session()->forget('is_gift');
                session()->forget('gift_message');
								session()->forget('discount');
								session()->forget('coupon_code');
					          $sellerid= $this->order->with('sellerProductId')->where('id', $id)->first();

					          $notifydata= array('notification_type'=>'product','user_id'=>$sellerid['sellerProductId']['user_id'],
					            'product_id'=>$sellerid['sellerProductId']['id'],'notification_text'=>'New Order success');
					          DB::table('user_notifications')->insert($notifydata);
					          //Seller notification End  
			          
				          //user Notification
				          $notifydata= array('notification_type'=>'product','user_id'=>auth()->user()->id,'product_id'=>$sellerid['sellerProductId']['id'],'notification_text'=>'New order recived');
				          DB::table('user_notifications')->insert($notifydata);
						}
				       	 foreach($orderdetailIds as $key => $value) {
				            $this->orderDetail->where('id', $value)->update(['payment_status'=>'1']);
				       	 }
				       	  $total_reward_point=0;
				       	 $previous_reward=auth()->user()->reward_point;
				       	 $pay_amount=$request->payment_ammount;
				       	 $reedemamount=$pay_amount*10;
				       	 $total_reward_point=$reedemamount+$previous_reward;
				         
				     /*    foreach ($productIds as $key => $rewards) {
				           $totalreward= $totalreward+$rewards->product['reward'];
				         }*/
			        $rewardpoint=array('user_id'=>auth()->user()->id,'point'=>$total_reward_point);
			         DB::table('users')->where('id', auth()->user()->id)->update(['reward_point'=>$total_reward_point]);
			       		 DB::table('user_rewards')->insert($rewardpoint);
							session()->put('order',
								[
								'title' => trans('Order'),
								'msg' => trans('Your Order has been successfully placed.')
							]);
				
						return redirect()->to('my-order');
				}

			}

		
	}

    public function get_shipping_price(Request $request) {
        //return response()->json(['success' => true, 'message' => '', 'data' => ['shipping_price' => 15]]);
        $restaurant_id = $request->input('restaurant_id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $street_address = $request->input('street_address');
        $address_line_2 = $request->input('address_line_2');
        $state_id = $request->input('state_id');
        $city = $request->input('city');
        $zip_code = $request->input('zip_code');
        $country_id = $request->input('country_id');
        $state = State::find($state_id);
        $data = [];
        //$order = DB::table('orders')->whereNull('order_id')->get();
        //$order = $order[0];
        $restaurant = Restaurant::find($restaurant_id);
        $shipping_label = Order::generate_shipping_label(['order_id' => '', 'vendor_id' => $restaurant->user_id, 'sandbox' => true, 'test_only' => true, 'param_data' => true, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => 'test@test.com', 'phone' => '1234567890', 'street_address' => $street_address, 'address_line_2' => $address_line_2, 'alternative_address' => '', 'zip_code' => $zip_code, 'country_id' => $country_id, 'state_id' => $state_id, 'city' => $city]);
        if($shipping_label['success'] == false) {
            return response()->json(['message' => 'You entered an unknown address', 'success' => false]);
        }
        $restaurant = Restaurant::find($restaurant_id);
        $restaurant_location = DB::table('restaurant_locations')->where('user_id', $restaurant->user_id)->first();
        //$restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
        $restaurant_city = DB::table('cities')->select('cities.*')->leftJoin('states', 'states.id', 'cities.state_id')->where('cities.name', $restaurant_location->city)->where('states.name', $restaurant_location->state)->first();
        $site_settings = Site_setting::all();
        $site_settings2 = [];
        foreach ($site_settings as $key => $value) {
            $site_settings2[$value->key] = $value->value;
        }
        $site_settings = $site_settings2;
        $data['shipping_price'] = 0;
        if($state->state_code == 'AK' && $restaurant_city->state_code != 'AK')
            $data['shipping_price'] = $site_settings['shipping_charge_alaska'];
        if($state->state_code == 'HI' && $restaurant_city->state_code != 'HI')
            $data['shipping_price'] = $site_settings['shipping_charge_hawaii'];
        return response()->json(['success' => true, 'message' => '', 'data' => $data]);
        /*$accessKey = env('UPS_API_KEY');
        $userId = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');
        $address = new \Ups\Entity\Address();
        $address->setAttentionName('User Address');
        $address->setBuildingName('User Address');
        $address->setAddressLine1($street_address);
        if($address_line_2 != '')
          $address->setAddressLine2($address_line_2);  
        $address->setStateProvinceCode($state->state_code);
        $address->setCity($city);
        $address->setCountryCode('US');
        $address->setPostalCode($zip_code);
        $xav = new \Ups\AddressValidation($accessKey, $userId, $password);
        $xav->activateReturnObjectOnValidate();
        try {
            $response = $xav->validate($address, $requestOption = \Ups\AddressValidation::REQUEST_OPTION_ADDRESS_VALIDATION, $maxSuggestion = 15);
            if ($response->noCandidates()) {
                return response()->json(['message' => 'Invalid delivary address.', 'success' => false]);
            }
            if ($response->isAmbiguous()) {
                $candidateAddresses = $response->getCandidateAddressList();
                return response()->json(['message' => 'Invalid delivary address.', 'success' => false]);
            }
            if ($response->isValid()) {
                $restaurant = Restaurant::find($restaurant_id);
                $restaurant_location = DB::table('restaurant_locations')->where('user_id', $restaurant->user_id)->first();
                $restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
                $site_settings = Site_setting::all();
                $site_settings2 = [];
                foreach ($site_settings as $key => $value) {
                    $site_settings2[$value->key] = $value->value;
                }
                $site_settings = $site_settings2;
                $data['shipping_price'] = 0;
                if($state->state_code == 'AK' && $restaurant_city->state_code != 'AK')
                    $data['shipping_price'] = $site_settings['shipping_charge_alaska'];
                if($state->state_code == 'HI' && $restaurant_city->state_code != 'HI')
                    $data['shipping_price'] = $site_settings['shipping_charge_hawaii'];
                return response()->json(['success' => true, 'message' => '', 'data' => $data]);
            } else {
                return response()->json(['success' => false, 'message' => 'There something error in checkout process', 'data' => $data]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'There something error in checkout process', 'data' => $data]);
        }*/
    }

    
    public function checkout_pay(Request $request) {
        /*cart check
        coupon check
        shipping price check
        total calculate
        validate address
        payment
        order create
        order item create
        product sold out update
        payment history add
        label generate 
        email send*/ 
        $carts =  $this->get_cart();
        $cart = $carts['cart'];
        $cart_infos = $carts['cart_infos'];
        $coupon = $carts['coupon'];
        if(count($carts['cart_infos']) > 0) {
            return response()->json(['message' => implode('<br />', $carts['cart_infos']), 'success' => false]);
        }
        $first_name = trim($request->input('first_name'));
        $last_name = trim($request->input('last_name'));
        $street_address = trim($request->input('street_address'));
        $address_line_2 = trim($request->input('address_line_2'));
        $state_id = trim($request->input('state_id'));
        $city = trim($request->input('city'));
        $zip_code = trim($request->input('zip_code'));
        $country_id = trim($request->input('country_id'));
        $restaurant_id = trim($request->input('restaurant_id'));
        $email = trim($request->input('email'));
        $phone = trim($request->input('phone'));
        $is_gift = trim($request->input('is_gift'));
        $gift_message = trim($request->input('gift_message'));
        $gift_message_name = trim($request->input('gift_message_name'));
        $card_number = trim($request->input('card_number'));
        $card_exp_month = trim($request->input('card_exp_month'));
        $card_exp_year = trim($request->input('card_exp_year'));
        $card_cvc = trim($request->input('card_cvc'));
        $delivery_date = trim($request->input('delivery_date'));
        $site_settings = Site_setting::all();
        $site_settings2 = [];
        foreach ($site_settings as $key => $value) {
            $site_settings2[$value->key] = $value->value;
        }
        $site_settings = $site_settings2;
        $country = Country::find($country_id);
        $state = State::find($state_id);
        $restaurant = Restaurant::find($restaurant_id);
        $restaurant_location = DB::table('restaurant_locations')->where('user_id', $restaurant->user_id)->first();
        $restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
        $shipping_price = 0;
        if($state->state_code == 'AK' && $restaurant_city->state_code != 'AK')
            $shipping_price = $site_settings['shipping_charge_alaska'];
        if($state->state_code == 'HI' && $restaurant_city->state_code != 'HI')
            $shipping_price = $site_settings['shipping_charge_hawaii'];
        $total_cart_price = $product_total = 0;
        foreach($cart as $crt) {
            $linetotal = number_format(($crt['product']->price * $crt['qty']),2, '.', '');
            $product_total += $linetotal;
            $total_cart_price += $linetotal;
        }
        $discount_price = 0;
        if(isset($coupon->id)) {
            if($coupon->discount_type == 'FIXED')
                $discount_price = $coupon->discount;
            if($coupon->discount_type == 'PERCENTAGE') {
                $discount_price = $total_cart_price * $coupon->discount / 100;
                $discount_price = number_format($discount_price, 2, '.', '');
            }
        }
        $payable_amount = $total_cart_price - $discount_price;
        /*$reward_discount = $reward_discount_amt = 0;
        if(auth()->user()) {
            $max_reward_discount_amt = $payable_amount / 2;
            $max_reward_discount_point = ceil(($max_reward_discount_amt * 100) / $site_settings['point_to_amount_discount_percentage']);
            $reward_discount = $max_reward_discount_point;
            if(auth()->user()->reward_point < $max_reward_discount_point)
                $reward_discount = auth()->user()->reward_point;
            $reward_discount_amt = ($reward_discount * $site_settings['point_to_amount_discount_percentage'] / 100);
        }
        $payable_amount -= $reward_discount_amt;*/
        $reward_point = $_COOKIE['reward_point'] ?? '';
        if(auth()->user()) {
            $reward_point_applied = [];
            $reward_arr = [5, 10, 15, 20];
            foreach ($reward_arr as $key => $value) {
                $points = ceil(($value * 100) / $site_settings['point_to_amount_discount_percentage']);
                if($reward_point == ($key + 1)) $reward_point_applied = ['price' => $value, 'points' => $points];
            }
            if(isset($reward_point_applied['points'])) {
                $payable_amount -= $reward_point_applied['price'];
            }
        }
        $earnable_points = round($payable_amount * $site_settings['amount_to_point_percentage'] / 100);
        $processing_fee = ($payable_amount * 3 / 100); // 3%
        $payable_amount += $processing_fee;
        $payable_amount += $shipping_price;
        $payable_amount = number_format($payable_amount, 2, '.', '');
        $accessKey = env('UPS_API_KEY');
        $userId = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');
        /*$address = new \Ups\Entity\Address();
        $address->setAttentionName('User Address');
        $address->setBuildingName('User Address');
        $address->setAddressLine1($street_address);
        if($address_line_2 != '')
          $address->setAddressLine2($address_line_2);  
        $address->setStateProvinceCode($state->state_code);
        $address->setCity($city);
        $address->setCountryCode('US');
        $address->setPostalCode($zip_code);
        $xav = new \Ups\AddressValidation($accessKey, $userId, $password);
        $xav->activateReturnObjectOnValidate();*/
        try {
            /*$response = $xav->validate($address, $requestOption = \Ups\AddressValidation::REQUEST_OPTION_ADDRESS_VALIDATION, $maxSuggestion = 15);
            if ($response->noCandidates()) {
                return response()->json(['message' => 'Invalid delivary address.', 'success' => false]);
            }
            if ($response->isAmbiguous()) {
                $candidateAddresses = $response->getCandidateAddressList();
                return response()->json(['message' => 'Invalid delivary address.', 'success' => false]);
            }
            if (!$response->isValid()) {
                return response()->json(['success' => false, 'message' => 'There something error in checkout process']);
            }
            $validAddress = $response->getValidatedAddress();*/
            $stripe_payment = stripe_payment(['card_number' => $card_number, 'exp_month' => $card_exp_month, 'exp_year' => $card_exp_year, 'card_cvv' => $card_cvc, 'order_total' => $payable_amount, 'currency' => 'usd', 'description' => 'umamisquare pay', 'customer_data' => [
                'name' => $first_name . ' ' . $last_name, 'description' => $street_address, 'email' => $email, "address" => ["city" => $city, "country" => $country->sortname, "line1" => $street_address, "line2" => $address_line_2, "postal_code" => $zip_code]
            ]]);
            if(!isset($stripe_payment['txn_id'])) {
                return response()->json(['success' => false, 'message' => $stripe_payment['message']]);
            }
            setcookie('cart', '', (time() - 3600), "/");
            setcookie('coupon_code', '', (time() - 3600), "/");
            setcookie('reward_point', '', (time() - 3600), "/");
            $user_id = auth()->user() ? auth()->user()->id : '';
            if($user_id != '') {
                $user = User::find($user_id);
                if($user->first_name == '') $user->first_name = $first_name;
                if($user->last_name == '') $user->last_name = $last_name;
                if($user->phone == '') $user->phone = $phone;
                $user->reward_point = ($user->reward_point - ($reward_point_applied['points'] ?? 0) + $earnable_points);
                $user->save();
            }
            $order_date = date('Y-m-d');
            $shipping_info = json_decode($restaurant->shipping_info, true);
            /*$estimated_delivery_date = estimated_delivery_date(['restaurant' => $restaurant]);
            $delivery_date = $estimated_delivery_date['delivery_date'];
            $pickup_date = $estimated_delivery_date['pickup_date'];*/
            $pickup_date = date('Y-m-d', strtotime("-" . $shipping_info['delivery_days'] . " day", strtotime($delivery_date)));
            $order_uid = 'US'.mt_rand(1000000000, (int) 9999999999);
            $order_id = $this->order->insertGetId(['user_id'=> ($user_id == '' ? '0' : $user_id),'product_id'=> '0', 'vendor_id' => $restaurant->user_id, 'product_price' => '0', 'country_id' => $country_id, 'state_id' => $state_id, 'city' => $city, 'order_id' => $order_uid, 'first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'phone' => $phone, 'street_address' => $street_address, 'address_line_2' => $address_line_2, 'alternative_address' => '', 'zip_code' => $zip_code, 'preparation_time' => $shipping_info['preparation_time'], 'delivery_days' => $shipping_info['delivery_days'], 'payment_type' => 'ONLINE', 'order_date' => $order_date, 'pickup_date' => $pickup_date, 'delivery_date' => $delivery_date, 'is_gift' => ($is_gift != '' ? 'ACTIVE' : 'INACTIVE'), 'gift_message' => $gift_message, 'gift_message_name' => $gift_message_name, 'updated_at' => Carbon::now(), 'created_at' => Carbon::now()]);
            foreach($cart as $crt) {
                $this->orderDetail->create(['user_id' => ($user_id == '' ? '0' : $user_id), 'order_id' => $order_id, 'product_id'=>$crt['product']->id, 'vendor_id' => $crt['product']->user_id, 'price' => $crt['product']->price, 'quantity' => $crt['qty'], 'total' => number_format(($crt['product']->price * $crt['qty']),2, '.', ''), 'included_shipping_price' => $crt['product']->shipping_price, 'vendor_name' => $restaurant->name, 'pay_order_id' => $order_uid, 'payment_status' => '1', 'order_detail_date' => $order_date]);
                $avl = Product::check_availability(['product_id' => $crt['product']->id, 'with_qty' => $crt['qty']]);
                if(!$avl){
                    DB::table('products')->where('id', $crt['product']->id)->update(['sold_out' => 1]);
                }
            }
            $paymentdata = array('coupon_code'=> ($coupon->coupon_code ?? ''),'product_amount'=> $product_total,'discount_price'=>($discount_price + ($reward_point_applied['price'] ?? 0)),'shipping_charge'=>$shipping_price,'tax_ammount'=> '0','amount'=> $payable_amount,'transaction_id'=>$stripe_payment['txn_id'],'vendor_id'=>$restaurant->user_id,'charge_id'=>$stripe_payment['charge_id'],'stripe_customer_id'=>$stripe_payment['customer'],'user_id'=> ($user_id == '' ? '0' : $user_id),'payment_date'=>date('Y-m-d'));
            $paymentdata['order_id'] = $order_uid;
            DB::table('payment_history')->insert($paymentdata);
            if(isset($reward_point_applied['points'])) {
                DB::table('user_redeemed_points')->insert(['user_id' => $user_id, 'order_id' => $order_id, 'points' => $reward_point_applied['points'], 'price' => $reward_point_applied['price']]);
            }
            Order::generate_shipping_label(['order_id' => $order_id, 'sandbox' => false]);
            $this->order_email_notification($order_id, $restaurant->user_id);
            if(!auth()->user())
                klaviyo_add_user(['email' => $email, 'type' => 'guest_checkout']);
            return response()->json(['success' => true, 'message' => '']);
        } catch (Exception $e) {
            //print_r($e);
            return response()->json(['success' => false, 'message' => 'There something error in checkout process']);
        }
        //return response()->json(['message' => '', 'success' => true]);
    }

	public function thank_you() {
		return view('frontend.pages.thank_you');
	}

	public function taxAmount($orderid=null)
	{
		$taxamount= PaymentHistory::where('order_id',$orderid)->select('tax_ammount')->first();
		$tax=0;
		if(!empty($taxamount))
		{
			$tax=$taxamount->tax_ammount;
		}
		return $tax;
	}
	public function upsShippingPayment($code,$product_weight,$product_height,$product_length,$product_width)
	{
		$AccessLicenseNumber ='7D8657A977D58776';
		$UserID ="one@j-fo.com";
		$Password = "Newyork2020";

		$CustomerContext = "Ups Shipping ";
		$RequestAction = "ShipConfirm";     // These values are contained in documentation 
		$RequestOption = "nonvalidate";
		$domtree = new \DOMDocument('1.0');
		$ids=auth()->user()->id;
		$userdetail= User::where('id',$ids)->first();
		$userAddress = $this->userAddress->loginUserId()->where('is_primary_address', ACTIVE)->first();	
			$country_name=$this->country->where('id', $userAddress->country_id)->pluck('name')->first();
			$state_name=$this->state->where('id', $userAddress->state_id)->pluck('name')->first();
			$city_name=$this->city->where('id', $userAddress->city_id)->pluck('name')->first();
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($country_name.$state_name.$userAddress->pincode)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
				  
			$result_string = file_get_contents($url);
		    $result = json_decode($result_string, true);

		   $dataresultcheck=$result['results'][0]['address_components'];
		   $stateshort_code='';
		   $countryshort_code='';
		   if(in_array('country', $dataresultcheck[0]['types'])){
		   	 $countryshort_code =$result['results'][0]['address_components'][1]['short_name'];
		   }else if(in_array('country', $dataresultcheck[1]['types'])){
		   	 $countryshort_code =$result['results'][0]['address_components'][1]['short_name'];
		   }else if(in_array('country', $dataresultcheck[2]['types'])){
		   	 $countryshort_code =$result['results'][0]['address_components'][2]['short_name'];
		   }else if(in_array('country', $dataresultcheck[3]['types'])){
		   	 $countryshort_code =$result['results'][0]['address_components'][3]['short_name'];
		   } else if(in_array('country', $dataresultcheck[4]['types'])){
		   	 $countryshort_code =$result['results'][0]['address_components'][4]['short_name'];
		   } 
		   	   
		   if(in_array('administrative_area_level_1', $dataresultcheck[0]['types'])){
		   	 $stateshort_code =$result['results'][0]['address_components'][1]['short_name'];
		   }else if(in_array('administrative_area_level_1', $dataresultcheck[1]['types'])){
		   	 $stateshort_code =$result['results'][0]['address_components'][1]['short_name'];
		   }else if(in_array('administrative_area_level_1', $dataresultcheck[2]['types'])){
		   	 $stateshort_code =$result['results'][0]['address_components'][2]['short_name'];
		   }else if(in_array('administrative_area_level_1', $dataresultcheck[3]['types'])){
		   	 $stateshort_code =$result['results'][0]['address_components'][3]['short_name'];
		   } else if(in_array('administrative_area_level_1', $dataresultcheck[4]['types'])){
		   	 $stateshort_code =$result['results'][0]['address_components'][4]['short_name'];
		   } 
		
		// <AccessRequest>
		$AccessRequest = $domtree->createElement("AccessRequest");
		$AccessRequest->setAttribute("xml:lang", "en_US");

		$domtree->appendChild($AccessRequest);
		$AccessRequest->appendChild($domtree->createElement('AccessLicenseNumber', $AccessLicenseNumber));
		$AccessRequest->appendChild($domtree->createElement('UserId', $UserID));
		$AccessRequest->appendChild($domtree->createElement('Password', $Password));
		$ShipmentConfirmRequest = $domtree->createElement("ShipmentConfirmRequest");
		$ShipmentConfirmRequest->setAttribute("xml:lang", "en_US");
		$domtree->appendChild($ShipmentConfirmRequest);
		$Request = $domtree->createElement("Request");
		$ShipmentConfirmRequest->appendChild($Request);
		$TransactionReference = $domtree->createElement("TransactionReference");
		$Request->appendChild($TransactionReference);
		$TransactionReference->appendChild($domtree->createElement('CustomerContext', $CustomerContext)); // Length: 1-512, Required: No
		$Request->appendChild($domtree->createElement('RequestAction', $RequestAction)); // Length: 10, Required: Yes, Must be "ShipConfirm"
		// <RequestOption>
		$Request->appendChild($domtree->createElement('RequestOption', $RequestOption)); // Length: 1-256, Required: Yes, "validate" or "nonvalidate"

		$PickupType = $domtree->createElement("PickupType");
		$ShipmentConfirmRequest->appendChild($PickupType);
		$Code ='03';
		$PickupType->appendChild($domtree->createElement('Code', $Code));

		$Shipment = $domtree->createElement("Shipment");
		$ShipmentConfirmRequest->appendChild($Shipment);
		// <Shipper>
		$Shipper = $domtree->createElement("Shipper");
		$Shipment->appendChild($Shipper);
		$ShipperName='Umami Square';
		$Shipper->appendChild($domtree->createElement('Name', $ShipperName)); 
		$ShipperAttentionName='';
	$Shipper->appendChild($domtree->createElement('AttentionName', $ShipperAttentionName)); 
		$ShipperPhoneNumber='+1 3475120849';
		$Shipper->appendChild($domtree->createElement('PhoneNumber', $ShipperPhoneNumber));

		$ShipperNumber='R673Y5';
		$Shipper->appendChild($domtree->createElement('ShipperNumber', $ShipperNumber)); 
		$Address = $domtree->createElement('Address');
		$Shipper->appendChild($Address);
		$ShipperAddressLine='306 gold street';
		$Address->appendChild($domtree->createElement('AddressLine1', $ShipperAddressLine)); // Length: 1-35, Required: Yes
		$ShipperCity='BROOKLYN';

		$Address->appendChild($domtree->createElement('City', $ShipperCity)); // Length: 1-30, Required: Yes
		$ShipperStateProvinceCode='NY';
		$Address->appendChild($domtree->createElement('StateProvinceCode', $ShipperStateProvinceCode)); // Length: 2-5, Required: Cond, Required if shipper is in the US or CA.
		// <PostalCode>
		$ShipperPostalCode='11201';
		$Address->appendChild($domtree->createElement('PostalCode', $ShipperPostalCode)); // Length: 1-10, Required: Cond, For all other countries, the postal code is optional
		// <CountryCode>
		$ShipperCountryCode='US';
		$Address->appendChild($domtree->createElement('CountryCode', $ShipperCountryCode)); // Length: 2, Required: Yes
		// </Address>
		// </Shipper>
		// <ShipTo>
		$ShipTo = $domtree->createElement("ShipTo");
		$Shipment->appendChild($ShipTo);
		$ShipToCompanyName=$userdetail->first_name;
		$ShipTo->appendChild($domtree->createElement('CompanyName', $ShipToCompanyName)); // Length: 1-35, Required: Yes
		// <AttentionName>
		$ShipToAttentionName='';
		$ShipTo->appendChild($domtree->createElement('AttentionName', $ShipToAttentionName)); // Length: 1-35, Required: Cond, for UPS Next Day Air Early service, and when ShipTo country is different than ShipFrom country.
		// <PhoneNumber>
	
		$phone='00';
		if($userdetail->phone){
		$phone=$userdetail->phone;
		}
		$ShipTo_phone_number=$phone;
		$ShipTo->appendChild($domtree->createElement('PhoneNumber', $ShipTo_phone_number)); // Length: 1-15, Required: Cond, Required for UPS Next Day Air Early service, and when Ship To country is different than the ShipFrom country.
		// <Address>
		$Address2=$userAddress->street_address;
		$Address2 = $domtree->createElement('Address');
		$ShipTo->appendChild($Address2);
		// <AddressLine1>
		$ShipToAddressLine=$userAddress->street_address;
		$Address2->appendChild($domtree->createElement('AddressLine1', $ShipToAddressLine)); // Length: 1-35, Required: Yes
		// <City>

		$ShipToCity=$city_name;
		$Address2->appendChild($domtree->createElement('City', $ShipToCity)); // Length: 1-30, Required: Yes
		// <StateProvinceCode>
		$ShipToStateProvinceCode=$stateshort_code;
		//$stateshort_code;
		$Address2->appendChild($domtree->createElement('StateProvinceCode', $ShipToStateProvinceCode)); // Length: 2-5, Required: Cond, Required if shipper is in the US or CA.
		// <PostalCode>
		$ShipToPostalCode=$userAddress->pincode;
		$Address2->appendChild($domtree->createElement('PostalCode', $ShipToPostalCode)); // Length: 1-10, Required: Cond, For all other countries, the postal code is optional
		// <CountryCode>
		$ShipToCountryCode=$countryshort_code;
		$Address2->appendChild($domtree->createElement('CountryCode', $ShipToCountryCode)); // Length: 2, Required: Yes

		// </Address>
		// </ShipTo>
		// <PaymentInformation>
		$PaymentInformation='R673Y5';
		$PaymentInformation = $domtree->createElement("PaymentInformation");
		$Shipment->AppendChild($PaymentInformation);
		// <Prepaid>
		$Prepaid = $domtree->createElement("Prepaid");
		$PaymentInformation->appendChild($Prepaid);
		// <BillShipper>
		$BillShipper = $domtree->createElement("BillShipper");
		$Prepaid->appendChild($BillShipper);
		    // <AccountNumber>
		$AccountNumber='R673Y5';
		    $BillShipper->appendChild($domtree->createElement('AccountNumber', $AccountNumber)); // Length: 6, Required: Cond, Based on PaymentInformation container, Must be the same UPS account number as the one provided in Shipper/ShipperNumber.
		    // </BillShipper>
		    // </Prepaid>
		    // </PaymentInformation>
		    // <Service>
		    $Service = $domtree->createElement("Service");
		    $Shipment->appendChild($Service);
		    // <Code>
		    $ServiceCode=$code;
		    $Service->appendChild($domtree->createElement('Code',$ServiceCode)); // Length: 2, Required: Yes, 01 = Next Day Air 02 = 2nd Day Air ...
		    // </Service>

 // <Service>
		    

		    // <Package>
		    $Package = $domtree->createElement('Package');
		    $Shipment->appendChild($Package);
		    // <PackagingType>
		    $PackagingType = $domtree->createElement('PackagingType');
		    $Package->appendChild($PackagingType);
		    // <Code>
		    $PackageTypeCode='02';
		    $PackagingType->appendChild($domtree->createElement('Code', $PackageTypeCode)); // Length: 2, Required: Yes, 01 = UPS Letter 02 = Customer Supplied Package ...
		    // </PackagingType>
		    // <Description>
		    $Description='Product Deliver';
		    $Package->appendChild($domtree->createElement('Description', $Description)); // Length: 1-35, Required: Cond, Required for shipment with return service.
		    // </Description>
		    // <Dimensions>
		    $Dimensions = $domtree->createElement('Dimensions'); // Required: Cond, Length + 2*(Width + Height) must be less than or equal to 130 IN or CM.
		    $Package->appendChild($Dimensions);
		    // <UnitOfMeasurement>
		    $UnitOfMeasurement = $domtree->createElement('UnitOfMeasurement');
		    $Dimensions->appendChild($UnitOfMeasurement);




		        $PackageLength='5';
		        $Dimensions->appendChild($domtree->createElement('Length', $PackageLength)); // Length: 9, Required: Yes*, Valid values are 0 to 108 IN and 0 to 270 CM.
		        // <Width>
		        $PackageWidth='5';
		        $Dimensions->appendChild($domtree->createElement('Width', $PackageWidth)); // Length: 9, Required: Yes*
		        // <Height>
		        $PackageHeight='5';
		        $Dimensions->appendChild($domtree->createElement('Height', $PackageHeight)); // Length: 9, Required: Yes*
		        // </Dimensions>
		        // <PackageWeight>
		        $PackageWeight = $domtree->createElement('PackageWeight');
		        $Package->appendChild($PackageWeight);
		        // <UnitOfMeasurement>
		        $UnitOfMeasurement2 = $domtree->createElement('UnitOfMeasurement');
		        $PackageWeight->appendChild($UnitOfMeasurement2);

		            $Pack_weights='5';
		            $PackageWeight->appendChild($domtree->createElement('Weight', $Pack_weights)); // Length: 1-5, Required: Yes*, Weight accepted for letters/envelopes.
		            // </UnitOfMeasurement>
		            // </PackageWeight>
		            // </Package>
			$RateInformation = $domtree->createElement("RateInformation");
		    $Shipment->appendChild($RateInformation);
		    $NegotiatedRatesIndicator = $domtree->createElement('NegotiatedRatesIndicator');
		        $RateInformation->appendChild($NegotiatedRatesIndicator);
		            // </Shipment>
		            // <LabelSpecification>
		            $LabelSpecification = $domtree->createElement('LabelSpecification');
		            $ShipmentConfirmRequest->appendChild($LabelSpecification);
		            // <LabelPrintMethod>
		            $LabelPrintMethod = $domtree->createElement('LabelPrintMethod');
		            $LabelSpecification->appendChild($LabelPrintMethod);
		            // <Code>
		            $LabelCode='GIF';
		            $LabelPrintMethod->appendChild($domtree->createElement('Code', $LabelCode)); // Length: 4, Required: Yes*
		            // </LabelPrintMethod>
		            // <LabelImageFormat>
		            $LabelImageFormat = $domtree->createElement('LabelImageFormat');
		            $LabelSpecification->appendChild($LabelImageFormat);
		            // <Code>
		            $LabelImageCode='GIF';
		            $LabelImageFormat->appendChild($domtree->createElement('Code', $LabelImageCode)); 

		            $domtree->preserveWhiteSpace = true;
		            $domtree->formatOutput = true;
		            $xml_string = $domtree->saveXML();
		            //
		           //print_r($xml_string);die;
		            // UPS Address
		            $url = 'https://www.ups.com/ups.app/xml/ShipConfirm';
		            $stream_options = array(
		            	'http' => array(
		            		'method'  => 'POST',
		            		'header'  => 'Content-type: application/x-www-form-urlencoded',
		            		'content' => "$xml_string",
		            	),
		            );
		            $context  = stream_context_create($stream_options);
		            $response = file_get_contents($url, null, $context);
		            $ShipmentConfirmResponse = new \SimpleXMLElement($response);
		       
		            if ((string)$ShipmentConfirmResponse->Response->ResponseStatusCode == 1) { // If the response is "success" then continue with second request
		            // If ShipmentCofirmRequest is successful, send ShipmentAcceptRequest
		            $connect='R673Y5';
		            $ShipmentID=$ShipmentConfirmResponse->ShipmentIdentificationNumber;
		            $ShipmentDigest = $ShipmentConfirmResponse->ShipmentDigest;
		           return $this->AcceptRequest($AccessLicenseNumber, $UserID, $Password, $CustomerContext, $ShipmentDigest, $ShipmentID, $connect); // After first successful request call a function which will send AcceptRequest
		        } else {
		        	echo $ShipmentConfirmResponse->Response->Error->ErrorDescription;
		        }
  	}
    public function AcceptRequest ($AccessLicenseNumber, $UserID, $Password, $CustomerContext, $ShipmentDigest) {
    	$RequestAction = "ShipAccept";
    	$domtree = new \DOMDocument('1.0');
    	$AccessRequest = $domtree->createElement("AccessRequest");
    	$domtree->appendChild($AccessRequest);
    	$AccessRequest->appendChild($domtree->createElement('AccessLicenseNumber', $AccessLicenseNumber));
    	$AccessRequest->appendChild($domtree->createElement('UserId', $UserID));
    	// <Password>
    	$AccessRequest->appendChild($domtree->createElement('Password', $Password));
    	// </AccessRequest>
    	// <ShipmentAcceptRequest>
    	$ShipmentAcceptRequest = $domtree->createElement("ShipmentAcceptRequest");
    	$domtree->appendChild($ShipmentAcceptRequest);
    	// <Request>
    	$Request = $domtree->createElement("Request");
    	$ShipmentAcceptRequest->appendChild($Request);
    	// <TransactionReference>
    	$TransactionReference = $domtree->createElement("TransactionReference");
    	$Request->appendChild($TransactionReference);
    	// <CustomerContext>
    	$TransactionReference->appendChild($domtree->createElement('CustomerContext', $CustomerContext));
    	// </TransactionReference>
    	// <RequestAction>
    	$Request->appendChild($domtree->createElement('RequestAction', $RequestAction));
    	// </Request>
    	// <ShipmentDigest>
    	$ShipmentAcceptRequest->appendChild($domtree->createElement('ShipmentDigest', $ShipmentDigest));
    	$domtree->preserveWhiteSpace = true;
    	$domtree->formatOutput = true;
    	$xml_string = $domtree->saveXML();

    	$url = 'https://www.ups.com/ups.app/xml/ShipAccept'; // Again testing URL
    	$stream_options = array(
    		'http' => array(
    			'method'  => 'POST',
    			'header'  => 'Content-type: application/x-www-form-urlencoded',
    			'content' => "$xml_string",
    		),
    	);
    	$context  = stream_context_create($stream_options);
    	$response = file_get_contents($url, null, $context);

    	$ShipmentAcceptResponse = new \SimpleXMLElement($response);
    	//echo "<pre>"; print_r($ShipmentAcceptResponse);
    	if ((string)$ShipmentAcceptResponse->Response->ResponseStatusCode == 1) {

    		$Tracking_ID = $ShipmentAcceptResponse->ShipmentResults->PackageResults->TrackingNumber;
    		$Price = $ShipmentAcceptResponse->ShipmentResults->ShipmentCharges->TransportationCharges->MonetaryValue;
    		$ImageBase64 = $ShipmentAcceptResponse->ShipmentResults->PackageResults->LabelImage->GraphicImage;
 				 //echo "<pre>"; print_r($Tracking_ID);
    		//$dataarray=array('TrackingNumber'=>$Tracking_ID,'lableimage'=>$ImageBase64);
    		return $ShipmentAcceptResponse;

    	} else {
    		 $ShipmentAcceptResponse->Response->Error->ErrorDescription;
    	}


    }
     public function restaurantLocation($id=null)
     {
     	$res=RestaurantBranch::with('restaurantLocation','restaurantName')->where('user_id',$id)->first();
     	//echo '<pre>'; print_r($res); exit;
     	  if(!empty($res))
        {
        	$userAddress = $this->userAddress->loginUserId()->where('is_primary_address', ACTIVE)->first();
			//echo '<pre>'; print_r($carts); exit;
			$countries = $this->country->where('sortname','US')->pluck('name','id')->all();
			$states = $cities = [];
			$country_name='';
			$state_name='';
			$city_name='';
			$shipingOne='0';
			$shipingtwo='0';
			$shipingthree='0';
			if(!empty($userAddress)) {
				$states = $this->state->where('country_id', $userAddress->countryId())->pluck('name','id')->all();
				$cities = $this->city->where('state_id', $userAddress->stateId())->pluck('name','id')->all();
			
			$country_name=$this->country->where('id', $userAddress->country_id)->pluck('name')->first();
			$state_name=$this->state->where('id', $userAddress->state_id)->pluck('name')->first();
			$city_name=$this->city->where('id', $userAddress->city_id)->pluck('name')->first();
		}

		$delivery_day = $res->delivery_day;		
		$resLocation= $res->restaurantLocation->city." ".$res->restaurantLocation->state." ".$res->restaurantLocation->country;
		$resLocationNY = "New York"." "."New York"." ".$res->restaurantLocation->country;
		$resLocationLA = "Los Angeles"." "."California"." ".$res->restaurantLocation->country;
		$distanceFromNY = $this->calculatedistance($resLocation,$resLocationNY);
		$distanceFromLA = $this->calculatedistance($resLocation,$resLocationLA);
		$shippingfee = 0;
		if($distanceFromNY < $distanceFromLA)
		{
			$minDis = $distanceFromNY;
		}
		else if($distanceFromLA < $distanceFromNY)
		{
			$minDis = $distanceFromLA;
		}
		else
		{
			$minDis = 0;
		}
		
		if($state_name == 'Hawaii' || $state_name == 'Alaska')
		{
			if(($state_name == 'Hawaii' && $res->restaurantLocation->state == 'Hawaii') || ($state_name == 'Alaska' && $res->restaurantLocation->state == 'Alaska') )
			{				
				 $shippingfee = 0;
			}
			else
			{
				
				$dataShippingFees = ShippingFee::where([['min_distance','<=',$minDis],['max_distance','>=',$minDis]])->first();				
				if(!empty($dataShippingFees))
				{
				   if($delivery_day == 1)
				   {
				   		if($state_name == 'Hawaii')
				   		{
				   		   $shippingfee = $dataShippingFees->hawai_1day;
				   		}
				   		else if($state_name == 'Alaska')
				   		{
				   			$shippingfee = $dataShippingFees->alaska_1day;
				   		}
				   }
				   else if($delivery_day == 2)
				   {
				   		if($state_name == 'Hawaii')
				   		{
				   		   $shippingfee = $dataShippingFees->hawai_2day;
				   		}
				   		else if($state_name == 'Alaska')
				   		{
				   			$shippingfee = $dataShippingFees->alaska_2day;
				   		}
				   }
				   else if($delivery_day == 3)
				   {
				   		if($state_name == 'Hawaii')
				   		{
				   		   $shippingfee = $dataShippingFees->hawai_3day;
				   		}
				   		else if($state_name == 'Alaska')
				   		{
				   			$shippingfee = $dataShippingFees->alaska_3day;
				   		}
				   }
				   else if($delivery_day > 3)
				   {
				        if($state_name == 'Hawaii')
				   		{
				   		   $shippingfee = $dataShippingFees->hawai_above;
				   		}
				   		else if($state_name == 'Alaska')
				   		{
				   			$shippingfee = $dataShippingFees->alaska_above;
				   		}
				   }
				}
				else
				{
					$shippingfee = 0;
				}				
			}
		}
		else
		{
			 $shippingfee = 0;
		}
		//echo $shippingfee; die;
	       /* $delivery_day = $res->delivery_day;

            $from_location= $res->restaurantLocation->state." ".$res->restaurantLocation->country;
            $to_location= $state_name." ".$country_name;            
            $calculate_distance= $this->calculatedistance($from_location,$to_location);*/

          /*if($res->restaurantLocation->state=='Alaska'|| $res->restaurantLocation->state=='Hawaii')
          {
	          $max_distance=ShippingFee::where('max_distance','>=',$calculate_distance)->first();
	          if($delivery_day==1)
	          {
	          	if($res->restaurantLocation->state=='Alaska')
	          	{
	          		$shippingfee=isset($max_distance->alaska_1day)?$max_distance->alaska_1day:0;
	          	}
	          	else if($res->restaurantLocation->state=='Hawaii')
	          	{
	          		$shippingfee=isset($max_distance->hawai_1day)?$max_distance->hawai_1day:0;
	          	}
          	
          }          
          else if($delivery_day==2)
          {
          	if($res->restaurantLocation->state=='Alaska'){
          		$shippingfee=isset($max_distance->alaska_2day)?$max_distance->alaska_2day:0;
          	}else if($res->restaurantLocation->state=='Hawaii'){
          		$shippingfee=isset($max_distance->hawai_2day)?$max_distance->hawai_2day:0;
          	}
          }
          else if($delivery_day==3)
          {
          	if($res->restaurantLocation->state=='Alaska'){
          		$shippingfee=isset($max_distance->alaska_3day)?$max_distance->alaska_3day:0;
          	}else if($res->restaurantLocation->state=='Hawaii'){
          		$shippingfee=isset($max_distance->hawai_3day)?$max_distance->hawai_3day:0;
          	}
          }

          }
          else
          {
                $shippingfee=0;
          }*/



          $data= array('shipping'=>$shippingfee,'location'=>$res->restaurantLocation->state,'restaurant_name'=>isset($res->restaurantName->name)?$res->restaurantName->name:'','deliver_day'=>isset($res->delivery_day)?$res->delivery_day:3,'prparation_day'=>isset($res->preparation_day)?$res->preparation_day:4,'order_time'=>isset($res->order_time)?$res->order_time:'12');
           return $data;
        }
     }

     public function test_order_email_notification() {
        $order_id = $_GET['order_id'];
        $order = Order::select('orders.*', 'st.name as state_name', 'st.state_code')->leftJoin('states as st', 'st.id', 'orders.state_id')->where('orders.id', $order_id)->first();
        $vendor_id = $order->vendor_id;
        $order_items = $this->orderDetail->with('product')->where('order_id', $order_id)->get();
        $payment_history = DB::table('payment_history')->where('order_id', $order->order_id)->first();
        $mail_data = [
            'name'  => $order->first_name . ' ' . $order->last_name,
            'email' => $order->email,
            'order_data' => $order,
            'order_items' => $order_items,
            'payment_history' => $payment_history,
            'mail_type' => 'customer'
        ];

        echo view('emails.order-confirmation3', $mail_data)->render();
        die;

        //$mail_data['email'] = 'sudipta.aqualeaf@gmail.com';
        //$this->sendMail($mail_data, 'emails.order-confirmation3', 'New Order placed');

        if($_GET['type'] == 2) 
            echo view('emails.order-confirmation3', $mail_data)->render();
        die;




        $carts =  $this->orderDetail->with('product')->where('user_id', auth()->user()->id)->where('order_id', $order_id)->get();
        $order_info = DB::table('order_details')->select('orders.*', 'products.title')->leftJoin('orders', 'order_details.order_id', 'orders.id')->leftJoin('products', 'order_details.product_id', 'products.id')->where('order_details.order_id', $order_id)->first();

        $payment_history = DB::table('payment_history')->where('order_id', $order_info->order_id)->first();
        
        $order_result=array();
        foreach($carts as $cart){
            if(!empty($cart->product->singleProductImage->image) && \File::exists(PRODUCT_ROOT_PATH.$cart->product->singleProductImage->image)){
                $image = PRODUCT_URL.$cart->product->singleProductImage->image;
            }else{
                $image = WEBSITE_IMG_URL.'no-product-image.png';
            }
            
            $customer_info = DB::table('users')->where('id', auth()->user()->id)->first();
            
            $order_result[]=array(
                'image'         => $image,
                'title'         => $cart->product->title,
                'price'         => CURRENCY.number_format($cart->price, 2),
                'qty'           => $cart->quantity,
                'total'         => CURRENCY.number_format($cart->total,2),
                'order_info'    => $order_info,
                'customer_info' => $customer_info
            );
            
        }
        
        $restaurant_user_info = DB::table('users')->where('id', $vendor_id)->select('first_name','last_name','email')->first();

        //****
        $customer_info->email = 'sudipta.aqualeaf@gmail.com';
        $restaurant_user_info->email = 'sudipta.aqualeaf@gmail.com';
        //****
        
        if(count($order_result)>0){
            $customerMailData = [
            'name'  => $customer_info->first_name .' '. $customer_info->last_name,
            'email' => $customer_info->email,
            'order_result' =>$order_result,
            'payment_history' =>$payment_history
          ];

          /*if($_GET['type'] == 1) 
            echo view('emails.order-confirmation', $customerMailData)->render();
          if($_GET['type'] == 2) 
            echo view('emails.order-confirmation3', $customerMailData)->render();
          die;*/
          
          //print_r($customerMailData); die;
          
          $this->sendMail(
                $customerMailData,
                'emails.order-confirmation',
                'New Order placed'
            );
          
          $restaurantMailData = [
            'email' => $restaurant_user_info->email,
            'order_result' =>$order_result
          ];
          
          $this->sendMail(
                $restaurantMailData,
                'emails.order-admin-confirmation',
                'New Order placed'
            );
            
        }
     }
    
}

