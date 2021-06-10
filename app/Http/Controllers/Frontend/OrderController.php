<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Order\MyOrderRequest;
use App\Http\Requests\Frontend\Order\OrderRequest;
use App\Http\Requests\Frontend\Order\OrderStatusRequest;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Models\Restaurant\RestaurantBranch;
use App\Models\Products\Product;
use App\Models\Rating;
use App\Models\Sales_report;
use App\Models\Sales_report_payment;
use DB;
use Illuminate\Http\Request;
class OrderController extends Controller
{
	/**
	* @param Order
	*/
	private $order;
	
	/**
     * @var RestaurantBranch
     */
    private $restaurantBranch;
	
	/**
     * @var Product
     */
    private $product;
	

    public function __construct(
		Order $order,
		RestaurantBranch $restaurantBranch,
		Product $product
	) {
		$this->order = $order;
		$this->restaurantBranch = $restaurantBranch;
		$this->product = $product;
    }

    public function myOrder(MyOrderRequest $request)
	{
		$myOrders = $this->orderIdNotEmpty()->get();
		$ratings= Rating::where('user_id',auth()->user()->id)->get();
		//echo '<pre>'; print_r($myOrders); exit;
		/*foreach ($myOrders as $key => $value) {
		  $payment = \App\Models\PaymentHistory::where('order_id', $value->order_id)->first();
		  $myOrders[$key]->payment_history_data = $payment;
		}*/
		
		//print_r($myOrders);
		return view('frontend.order.my-order', compact('myOrders','ratings'));
	}

	private function orderIdNotEmpty()
	{
		return $this->order
				->where('user_id', auth()->user()->id)
				->where('order_id', '!=', null)
				->with('product','orderDetails', 'payment')
				->orderBy('created_at','desc');
    // return $this->order
    //             ->where('orders.user_id', auth()->user()->id)
    //             ->where('orders.order_id', '!=', null)
    //             ->leftjoin('order_details','order_details.order_id','=','orders.id')
    //             ->leftjoin('products','products.id','=','order_details.product_id')
    //             ->join('ratings','ratings.order_id','=','orders.order_id');
	}
	
	public function orderStatus(OrderStatusRequest $request)
	{
		if($request->ajax()) {
			$this->order->where('id', $request->get('order_id'))->update(['status' => $request->get('status')]);
			
			if (auth()->user()->isUser()) {
				$myOrders = $this->orderIdNotEmpty()->get();
			
				return response()->json([
					'success' => true,
					//'myOrder' => view('frontend.order.my-order-element',compact('myOrders'))->render(),
          'myOrder' => ''
				]);
			} else {
				$getordersdata = $this->getOrder()->get();
        $orderData = $this->getOrder()
                 ->select('order_date', DB::raw('count(*) as totalorder'))
                 ->groupBy('order_date')
                 ->orderBy('order_date','ASC')
                 ->where('vendor_id',auth()->user()->id)
                 ->get();
				
				return response()->json([
					'success' => true,
					//'myOrder' => view('frontend.order.order-element',compact('getordersdata','orderData'))->render(),
          'myOrder' => ''
				]);
			}
		}
		
		return redirect()->to('my-order');
	}
	
	public function trackOrder($encriptId)
	{
		//$myOrder = $this->orderIdNotEmpty()->where('id', Crypt::decryptString($encriptId))->firstOrFail();
    $myOrder = $this->order
        ->with('product','orderDetails', 'payment', 'vendor')
        ->orderBy('created_at','desc')->where('id', Crypt::decryptString($encriptId))->firstOrFail();
		   //echo '<pre>'; print_r($myOrder); exit;
		return view('frontend.order.track-order', compact('myOrder'));
	}

  public function today_order_pickup()
  {
    $getordersdata = $this->order->where('vendor_id',auth()->user()->id)
        ->where('order_id', '!=', null)
        //->where('pickup_date', date('Y-m-d'))
        ->where('order_date', date('Y-m-d'))
        ->with('product','orderDetails','user')
        ->orderBy('order_date','DESC')->orderBy('id','DESC')->get();
    //echo '<pre>'; print_r($myOrders); exit;
    return view('frontend.order.today_order_pickup', compact('getordersdata'));
  }
	
	public function order(Request $request)
	{
    /*$stripe_payment = stripe_payment(['card_number' => '4111111111111111', 'exp_month' => '12', 'exp_year' => '2025', 'card_cvv' => '111', 'order_total' => '100', 'currency' => 'usd', 'description' => 'umamisquare pay', 'customer_data' => [
              'name' => 'sudipta chak', 'description' => '664 Coney Island Ave', 'email' => 'sudipta@gmail.com', "address" => ["city" => 'Brooklyn', "country" => 'US', "line1" => '664 Coney Island Ave', "line2" => "", "postal_code" => '11218']
            ]]);
    print_r($stripe_payment);*/

    $getordersdata = $this->getOrder()->orderBy('order_date','DESC')->get();
    $orderData = $this->getOrder()
                 ->select('order_date', DB::raw('count(*) as totalorder'))
                 ->groupBy('order_date')
                 ->orderBy('order_date','DESC')
                 ->where('vendor_id',auth()->user()->id)
                 ->get();
          //echo '<pre>'; print_r($getordersdata); exit;
     /*if(isset($_REQUEST['status']) && !empty($_REQUEST['status'] && $_REQUEST['status']=='current'))
     {
      
       $getordersdata = $this->getOrder()->whereBetween('created_at',[$dateS." 00:00:00",$dateE." 23:59:59"])->get();
     }
      if(isset($_REQUEST['status']) && !empty($_REQUEST['status'] && $_REQUEST['status']=='pending'))
     {
       $getordersdata = $this->getOrder()->where('status','PENDING')->orderBy('order_date','DESC')->get();
     }
     if(isset($_REQUEST['status']) && !empty($_REQUEST['status'] && $_REQUEST['status']=='cancel'))
     {
       $getordersdata = $this->getOrder()->where('status','CANCELLED')->orderBy('order_date','DESC')->get();
     }
      if(isset($_REQUEST['status']) && !empty($_REQUEST['status'] && $_REQUEST['status']=='complete'))
     {
       $getordersdata = $this->getOrder()->where('status','DELIVERED')->orderBy('order_date','DESC')->get();
     }*/
     //echo '<pre>'; print_r($orders);exit;
     
     /*$from_date = $request->input('fd');
     $to_date = $request->input('td');
      if($from_date == '') {
        $from_date = date('Y-m-d', strtotime('-7day'));
      } else {
        $from_date = date('Y-m-d', strtotime($from_date));
      }
      
      if($to_date == '') {
        $to_date = date('Y-m-d');
      } else {
        $to_date = date('Y-m-d', strtotime($to_date));
      }
      $getordersdata = $this->order->where('vendor_id',auth()->user()->id)
        ->where('order_id', '!=', null)
        ->where('order_date', '>=', $from_date)
        ->where('order_date', '<=', $to_date)
        ->with('product','orderDetails','user')
        ->orderBy('order_date','DESC')->orderBy('id','DESC')->get();*/
      $status = $request->input('status');
      if($status != '') {
        $status = explode(',', strtoupper($status));
        $getordersdata = $this->order->select('orders.*', 'payment_history.*', 'orders.user_id as user_id', 'orders.vendor_id as vendor_id', 'orders.id as id', 'orders.order_id')->where('orders.vendor_id',auth()->user()->id)
        ->where('orders.order_id', '!=', null)
        ->whereIn('orders.status', $status)
        ->whereNotNull('payment_history.id')
        ->with('product','orderDetails','user')
        ->leftJoin('payment_history','payment_history.order_id','orders.order_id')
        ->where('payment_history.refund_id', '=', null)
        ->orderBy('orders.order_date','DESC')->orderBy('orders.id','DESC')->get();
        return view('frontend.order.order_status_list', compact('getordersdata','orderData'));
      }
      /*if(in_array($status, ['pending', 'cancel', 'complete'])) {
        $st = '';
        if($status == 'pending') $st = 'PENDING';
        if($status == 'cancel') $st = 'CANCELLED';
        if($status == 'complete') $st = 'DELIVERED';
        $getordersdata = $this->order->select('orders.*', 'payment_history.*', 'orders.user_id as user_id', 'orders.vendor_id as vendor_id', 'orders.id as id', 'orders.order_id')->where('orders.vendor_id',auth()->user()->id)
        ->where('orders.order_id', '!=', null)
        ->where('orders.status', '=', $st)
        ->whereNotNull('payment_history.id')
        ->with('product','orderDetails','user')
        ->leftJoin('payment_history','payment_history.order_id','orders.order_id')
        ->where('payment_history.refund_id', '=', null)
        ->orderBy('orders.order_date','DESC')->orderBy('orders.id','DESC')->get();
        return view('frontend.order.order_status_list', compact('getordersdata','orderData'));
      }*/
      $date = $request->input('d');
      if($date == '') $date = date('Y-m-d');
      $n = date('N', strtotime($date));
      $prevmonday = date('Y-m-d', strtotime('previous monday', strtotime($date)));
      if($n == '1') // monday
        $prevmonday = $date;
      $nxtsunday = date('Y-m-d', strtotime('next sunday', strtotime($date)));
      if($n == '1') // sunday
        $nxtsunday = $date;
      $daily_order_counts = [];
      for($i = 0; $i < 5; $i++) {
        $d = date('Y-m-d', strtotime($prevmonday . ' +' . $i . ' day'));
        $daily_order_counts[] = $this->order->where('orders.vendor_id',auth()->user()->id)
		->leftJoin('payment_history','payment_history.order_id','orders.order_id')
		->where('payment_history.refund_id', '=', null)
        ->where('orders.order_id', '!=', null)
        ->where('orders.pickup_date', '=', $d)->count();
      }
      /*$getordersdata = $this->order->where('vendor_id',auth()->user()->id)
        ->where('order_id', '!=', null)
        ->where('pickup_date', '=', $date)
        ->with('product','orderDetails','user')
        ->orderBy('order_date','DESC')->orderBy('id','DESC')->get();*/
		
		$getordersdata = $this->order->select('orders.*', 'payment_history.*', 'orders.user_id as user_id', 'orders.vendor_id as vendor_id', 'orders.id as id', 'orders.order_id')->where('orders.vendor_id',auth()->user()->id)
			->where('orders.order_id', '!=', null)
			->where('orders.pickup_date', '=', $date)
      ->whereNotNull('payment_history.id')
			->with('product','orderDetails','user')
			->leftJoin('payment_history','payment_history.order_id','orders.order_id')
			->where('payment_history.refund_id', '=', null)
			->orderBy('orders.order_date','DESC')->orderBy('orders.id','DESC')->get();
      //dd($getordersdata);
	  
	  
      	//echo '<pre>'; print_r($getordersdata);exit;  

      	

		return view('frontend.order.order', compact('getordersdata','orderData', 'date','daily_order_counts'));
	}
	
	private function getOrder()
	{
		$restaurantId = $this->restaurantBranch->where('user_id', auth()->user()->id)->value('restaurant_id');
		if(auth()->user()->isVender()){
			$productIds = $this->product->where('restaurant_id', $restaurantId)->pluck('id');
		} else {
			$productIds = $this->product->where('restaurant_id', $restaurantId)->where('user_id', auth()->user()->id)->pluck('id');
		}
		
		return $this->order->whereIn('product_id', $productIds)
				->where('order_id', '!=', null)
				->with('product','orderDetails','user');
			//	->orderBy('created_at','desc');
				
	}

   public function orderView($id=null)
   {

      $restaurantId = $this->restaurantBranch->where('user_id', auth()->user()->id)->value('restaurant_id');
    if(auth()->user()->isVender()){
      $productIds = $this->product->where('restaurant_id', $restaurantId)->pluck('id');
    } else {
      $productIds = $this->product->where('restaurant_id', $restaurantId)->where('user_id', auth()->user()->id)->pluck('id');
    }
    
    //$ordersDetail= $this->order->whereIn('product_id', $productIds)
    $ordersDetail= $this->order
        ->where('order_id', '!=', null)
        ->where('order_id', $id)
        ->with('product','orderDetails','user')
        ->orderBy('created_at','desc')
        ->first();


       //echo '<pre>'; print_r($ordersDetail); exit;
    return view('frontend.order.orderview', compact('ordersDetail'));
   }

    public function trackImage($orderId)
    {
    $image='';
     $imagelable= DB::table('ups_shipping_payment')->where('product_order_id',$orderId)->select('image_lable')->first();
      if(isset($imagelable) && !empty($imagelable))
      {
       $image=  $imagelable->image_lable;
      }
     return $image;
    }

    public function PrintOrderLable(Request $request ,$id=null)
    {
      $restaurantId = $this->restaurantBranch->where('user_id', auth()->user()->id)->value('restaurant_id');
    if(auth()->user()->isVender()){
      $productIds = $this->product->where('restaurant_id', $restaurantId)->pluck('id');
    } else {
      $productIds = $this->product->where('restaurant_id', $restaurantId)->where('user_id', auth()->user()->id)->pluck('id');
    }
    
    //$ordersDetail= $this->order->whereIn('product_id', $productIds)
    $ordersDetail= $this->order
        ->where('order_id', '!=', null)
        ->where('order_id', $request->orderid)
        ->with('product','orderDetails','user')
        ->orderBy('created_at','desc')
        ->first();
        // echo '<pre>'; print_r($ordersDetail);exit;
      $data='';

      if($ordersDetail->label_image != '')
      {
        $data = '';
        /*$data='
        <div class="recpit-logo" style="margin:10px auto; display:block;text-align:center;">
          <img src="' . url('public/images/logo.png') . '"
          style="width:150px;">
        </div>';*/

        $data.='<div class="recipt-main" style="width:100%; max-width:100%; display: block; margin:30px auto;">';

        $data .= '<table class="order-recipt" style="width:100%; font-weight:600; font-size:16px;">
          <tr>
            <td><img src="' . url('public/images/logo.png') . '" style="width:150px;"></td>
            <td style="width: 40%;">
              <table class="order-recipt" style="width:100%; text-align: right;">
                <tr><td>ORDER #</td><td>'.$ordersDetail->order_id.'</td></tr>
                <tr><td>SHIPS ON</td><td>'.date('m-d-Y', strtotime($ordersDetail->pickup_date)).'</td></tr>
              </table>
            </td>
          </tr>
          <tr><td style="padding: 30px 0;">
            <p style="margin-bottom: 6px;">Dear, <b>' . $ordersDetail->first_name . ' ' . $ordersDetail->last_name . '</b></p>
            <p style="margin-bottom: 6px;">' . ($ordersDetail->is_gift == 'ACTIVE' ? nl2br($ordersDetail->gift_message) : '') . '</p>
            <p style="margin-bottom: 6px;"><b>' . ($ordersDetail->is_gift == 'ACTIVE' ? 'From: ' . $ordersDetail->gift_message_name : '') . '</b></p>
            <!--<p style="margin-bottom: 6px;">Street #156 Burbank,<br>Studio City Hollywood,<br>California USA</p>-->
          </td><td></td></tr>
        </table>

        <table class="order-recipt" style="width:60%; font-weight:600; font-size:16px;">
          <tr style="border-bottom: 1px solid #eee;"><th style="width: 70%;">ITEM</th><th style="width: 30%;">QTY</th></tr>';
          foreach ($ordersDetail->orderDetails as $key => $labledata) {
            // $labledata->price
             $data.='<tr>
              <td>'.$labledata->product->title.'</td>
              <td>'.$labledata->quantity.'</td>
            </tr>';
          }
        $data .= '</table>';

        $data .= '<br><br><hr style="border-bottom: 2px dashed #aaa; width: 100%; height: 1px; display: block; margin: 30px 0;" /><br>';
          
         

        $data.='</div>';


         $data.='<div class="rec-img" style="display: inline-block;
    margin: 20px 0;"><img style="height: auto;max-width: 80%;margin: 20px auto;text-align: center;  display: block;}" class="image_lable" src="data:image/png;base64,'.$ordersDetail->label_image.'"></div></div>';

          return $data;
      // $image=  $imagelable->image_lable;
      }
      
    }

    public function PrintOrderLable11111(Request $request ,$id=null)
    {
      $imagelable= DB::table('ups_shipping_payment')->where('product_order_id',$request->orderid)->select('image_lable')->first();
       


      $restaurantId = $this->restaurantBranch->where('user_id', auth()->user()->id)->value('restaurant_id');
    if(auth()->user()->isVender()){
      $productIds = $this->product->where('restaurant_id', $restaurantId)->pluck('id');
    } else {
      $productIds = $this->product->where('restaurant_id', $restaurantId)->where('user_id', auth()->user()->id)->pluck('id');
    }
    
    $ordersDetail= $this->order->whereIn('product_id', $productIds)
        ->where('order_id', '!=', null)
        ->where('order_id', $request->orderid)
        ->with('product','orderDetails','user')
        ->orderBy('created_at','desc')
        ->first();
        // echo '<pre>'; print_r($ordersDetail);exit;
      $data='';

      if(isset($imagelable) && !empty($imagelable))
      {

        $data='
        <div class="recpit-logo" style="margin:10px auto; display:block;text-align:center;">
          <img src="http://localhost/umami-square/www/public/images/logo.png"
          style="width:150px;">
        </div>';

        $data.='<div class="recipt-main" style="width:100%; max-width:80%; display: block; margin:30px auto;">';
          
         $data.='<div class="rec-left" style="width: 100%;float: left;
    display: inline-block;">
         <table class="order-recipt" style="width:100%; font-weight:600; font-size:16px;">
          <tr>
            <td style="max-width:20px;">ORDER #</td>
            <td style="max-width:20px;">'.$ordersDetail->order_id.'</td>
          </tr>
          <tr>
            <td>SHIPS ON</td>
            <td>'.date('M d/Y').'</td>
          </tr>
          <tr>
            <td style="max-width:20px;">ITEM</td>
            <td style="max-width:20px;">QTY</td>
          </tr>';
          foreach ($ordersDetail->orderDetails as $key => $labledata) {
           $data.='<tr>
            <td style="max-width:20px;">'.$labledata->product->title.'</td>
            <td style="max-width:20px;">'.$labledata->quantity.'</td>
          </tr>';
           }
          $data.='<tr>
         </table>
         </div>
         <div class="rec-right" style="width: 50%;float: right;
    display: inline-block;">';
        $data.='</div></div>';


         $data.='<div class="rec-img" style="display: inline-block;
    margin: 20px 0;"><img style="height: auto;max-width: 80%;margin: 20px auto;text-align: center;  display: block;}" class="image_lable" src="data:image/png;base64,'.$imagelable->image_lable.'"></div></div>';

          return $data;
      // $image=  $imagelable->image_lable;
      }
      
    }

    public  function datewiseOrder($date=null)
    {

      //$orders = $this->getOrder()->orderBy('created_at','DESC')->get();
      $orderData = $this->getOrder()
                 ->select('order_date', DB::raw('count(*) as totalorder'))
                 ->groupBy('order_date')
                 ->orderBy('order_date','ASC')
                 ->where('vendor_id',auth()->user()->id)
                 ->get();
      $date = date('Y-m-d', $date);
       $getordersdata = $this->getOrder()->where('order_date',$date)->where('vendor_id',auth()->user()->id)->orderBy('order_date','DESC')->get();
        //echo '<pre>'; print_r($orders); exit;
      return view('frontend.order.order', compact('getordersdata','orderData'));
    }

    public function sales_report_generate() {
      //run this cron function once daily at 12:00am
      //if today is mid day or last day of month
      $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
      //28 29 30 31
      $mid_day = intval(ceil($days / 2));
      $start_day = ''; $end_day = ''; $start_date = ''; $end_date = '';
      if(intval(date('d')) == ($mid_day + 1)) {
        $start_day = '1';
        $end_day = $mid_day;
        $start_date = date('Y') . '-' . date('m') . '-0' . $start_day;
        $end_date = date('Y') . '-' . date('m') . '-' . $end_day;
      }
      if(intval(date('d')) == 1) {
        $date = new \DateTime('FIRST DAY OF PREVIOUS MONTH');
        $days = cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));
        $mid_day = intval(ceil($days / 2));
        $start_day = ($mid_day + 1);
        $end_day = $days;
        $start_date = $date->format('Y') . '-' . $date->format('m') . '-' . $start_day;
        $end_date = $date->format('Y') . '-' . $date->format('m') . '-' . $end_day;
      }
      //$start_date = '2021-02-15'; $end_date = '2021-02-28';
      //$start_date = '2021-03-02'; $end_date = '2021-04-01';
      if($start_date == '' || $end_date == '')
        die();
      //select payments for date range foreach restaurant
      $restaurants = DB::table('restaurants')->select('id', 'user_id')->get();
      foreach ($restaurants as $rk => $rv) {
        //insert sales report for each restaurant separately
        $sales_report = Sales_report::updateOrCreate(['restaurant_id' => $rv->id, 'from_date' => $start_date, 'to_date' => $end_date], ['amount' => '0.00']);
        $payment_history = DB::table('payment_history')->where('vendor_id', $rv->user_id)->where('payment_date', '>=', $start_date)->where('payment_date', '<=', $end_date)->get();
        if(count($payment_history) > 0) {
          $total_sales_amount = 0;
          foreach ($payment_history as $pk => $pv) {
            $order_id = $pv->order_id;
            $order_details = DB::table('order_details')->select('price', 'quantity', 'included_shipping_price')->where('pay_order_id', $order_id)->get();
            $sales_amount = 0;
            foreach ($order_details as $ok => $ov) {
              $sales_amount += ($ov->price - $ov->included_shipping_price) * $ov->quantity;
            }
            $sales_amount -= $pv->sales_deduction;
            Sales_report_payment::updateOrCreate(['sales_report_id' => $sales_report->id, 'payment_history_id' => $pv->id], ['status' => ($pv->refund_id != '' ? '0' : '1'), 'amount' => $sales_amount]);
            if($pv->refund_id == '')
              $total_sales_amount += $sales_amount;
          }
          Sales_report::where('id', $sales_report->id)->update(['amount' => $total_sales_amount]);
        }
      }
    }


    public function upslabelgenerate() {
      /*$orders = $this->order->where('order_id', '!=', null)->where('pickup_date', date('Y-m-d'))->get();
      //$orders = $this->order->where('order_id', '!=', null)->where('tracking_id', null)->where('pickup_date', '2021-01-27')->whereIn('status', ['PENDING', 'PACKED'])->get();
      if(count($orders) == 0) die();
      Order::generate_shipping_label_dummy(['order_id' => $orders[0]->id]);*/
	  
	  $orders_vendor_result = $this->order->select('vendor_id')->distinct('vendor_id')->where('order_id', '!=', null)->where('pickup_date', date('Y-m-d'))->get();
	  if(count($orders_vendor_result)>0){
		  foreach($orders_vendor_result as $row){
			  $orders_result = $this->order->where('vendor_id', $row->vendor_id)->where('order_id', '!=', null)->where('pickup_date', date('Y-m-d'))->get();
			  if(count($orders_result) == 0) die();
			  Order::generate_shipping_label_dummy(['order_id' => $orders_result[0]->id]);
			}
		}
    }


    public function upslabelgenerate_old_working() {
      $orders = $this->order->where('order_id', '!=', null)->where('tracking_id', null)->where('pickup_date', date('Y-m-d'))->whereIn('status', ['PENDING', 'PACKED'])->get();
      //$orders = $this->order->where('order_id', '!=', null)->where('tracking_id', null)->where('pickup_date', '2021-01-27')->whereIn('status', ['PENDING', 'PACKED'])->get();
      foreach ($orders as $key => $value) {
        $street_address = $value->street_address;
        $first_name = $value->first_name;
        $last_name = $value->last_name;
        $phone = $value->phone;
        $email = $value->email;
        $zip_code = $value->zip_code;
        $city = $value->city;
        $state_code = DB::table('states')->where('id', $value->state_id)->pluck('state_code')->first();

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $shipping = new \Ups\Shipping($accesskey, $userid, $password, false);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            $shipper->setName('Umami Square');
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
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            $shipToAddress->setAddressLine1($street_address);
            //$shipToAddress->setAddressLine2('ADDRESS 2');
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
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
            $shipment_digest = $result->ShipmentDigest;
            $accept = $shipping->accept($shipment_digest);
            
            $tracking_number = $accept->PackageResults->TrackingNumber;
            $imageformat = $accept->PackageResults->LabelImage->LabelImageFormat->Code;
                
            $base64image = $accept->PackageResults->LabelImage->GraphicImage;
            
            $image = base64_decode($base64image);

            DB::table('orders')->where('id', $value->id)->update(['tracking_id' => $tracking_number, 'label_image' => $base64image]);

            $tracking = new \Ups\Tracking($accesskey, $userid, $password);
            try {
              //$shipment = $tracking->track('1ZR673Y50298601139'); // real
              $shipment = $tracking->track($tracking_number);
              /*print_r($shipment);
              echo '<br>' . $shipment->PickupDate . '<br>' . $shipment->ScheduledDeliveryDate;*/
              //20210122
              $PickupDate = substr($shipment->PickupDate, 0, 4) . '-' . substr($shipment->PickupDate, 4, 2) . '-' . substr($shipment->PickupDate, 6, 2);
              $ScheduledDeliveryDate = substr($shipment->ScheduledDeliveryDate, 0, 4) . '-' . substr($shipment->ScheduledDeliveryDate, 4, 2) . '-' . substr($shipment->ScheduledDeliveryDate, 6, 2);
              //echo $PickupDate . ' ' . $ScheduledDeliveryDate . '  | ';
              DB::table('orders')->where('id', $value->id)->update(['pickup_date' => $PickupDate, 'delivery_date' => $ScheduledDeliveryDate]);
            } catch (\Ups\Exception\InvalidResponseException $e) {
            }
            
            //echo $tracking_number."<br />";
            //echo '<img src="data:image/png;base64, '.$base64image.'" alt="Red dot" style="transform: rotate(90deg);" />';
        } catch (\Ups\Exception\InvalidResponseException $e) {
            $error = $e->getMessage();
            print_r($error);
        }

        /*$accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $shipping = new \Ups\Shipping($accesskey, $userid, $password, true);
        $residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            $shipper->setName('Umami Square');
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
      }
    }

    public function test_upslabelgenerate() {
      $order_id = $_GET['order_id'];
      $order = DB::table('orders')->where('id', $order_id)->first();
      $restaurant = DB::table('restaurants')->where('user_id', $order->vendor_id)->first();
      $restaurant_location = DB::table('restaurant_locations')->where('user_id', $order->vendor_id)->first();
      $restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
      $street_address = $order->street_address;
        $first_name = $order->first_name;
        $last_name = $order->last_name;
        $phone = $order->phone;
        $email = $order->email;
        $zip_code = $order->zip_code;
        $city = $order->city;
        $state_code = DB::table('states')->where('id', $order->state_id)->pluck('state_code')->first();

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');
		
		echo '<pre>'; 
		print_r($restaurant_location);
		print_r($restaurant_city);
		
		

        $shipping = new \Ups\Shipping($accesskey, $userid, $password, true);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            //$shipper->setShipperNumber("W007R5");
            $shipper->setName($restaurant->name);
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($restaurant_location->zip_code);
            $shipperAddress->setAddressLine1($restaurant_location->location);
            //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
            $shipperAddress->setCity($restaurant_location->city);
            $shipperAddress->setStateProvinceCode($restaurant_city->state_code);

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('11201');
            $address->setAddressLine1('306 Gold Street');
            //$address->setAddressLine2('BUSINESS ADD 2');
            $address->setCity('Brooklyn');
            $address->setStateProvinceCode('NY');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            $shipToAddress->setAddressLine1($street_address);
            //$shipToAddress->setAddressLine2('ADDRESS 2');
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
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
            //$billshipper->setAccountNumber("W007R5");
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
            $shipment_digest = $result->ShipmentDigest;
            $accept = $shipping->accept($shipment_digest);
            
            $tracking_number = $accept->PackageResults->TrackingNumber;
            $imageformat = $accept->PackageResults->LabelImage->LabelImageFormat->Code;
                
            $base64image = $accept->PackageResults->LabelImage->GraphicImage;
            
            $image = base64_decode($base64image);

            echo '<img src="data:image/png;base64,' . $base64image . '" />';

            //DB::table('orders')->where('id', $order->id)->update(['tracking_id' => $tracking_number, 'label_image' => $base64image]);
        } catch (\Ups\Exception\InvalidResponseException $e) {
            echo $e->getMessage();
        }
    }

    
    public function test_upslabelgenerate_restaurant() {
      $restaurant_id = $_GET['restaurant_id'];
      $restaurant = DB::table('restaurants')->where('id', $restaurant_id)->first();
      $restaurant_location = DB::table('restaurant_locations')->where('user_id', $restaurant->user_id)->first();
      $restaurant_city = DB::table('cities')->select('cities.*')->leftJoin('states', 'states.id', 'cities.state_id')->where('cities.name', $restaurant_location->city)->where('states.name', $restaurant_location->state)->first();
	  
      //$restaurant_location->location = '1200 Frank E Rodgers Blvd S';
  	  echo '<pre>';
  	  print_r($restaurant_location);
  	  print_r($restaurant_city);

	  
      $street_address = '306 Gold Street';
        $first_name = 'sudipta';
        $last_name = 'chakraborti';
        $phone = '1234567890';
        $email = 'sudipta.aqualeaf@gmail.com';
        $zip_code = '11201';
        $city = 'BROOKLYN';
        $state_code = 'NY';

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $shipping = new \Ups\Shipping($accesskey, $userid, $password, true);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            //$shipper->setShipperNumber("W007R5");
            $shipper->setName($restaurant->name);//$restaurant->name
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($restaurant_location->zip_code);
            $shipperAddress->setAddressLine1($restaurant_location->location);
            //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
            $shipperAddress->setCity($restaurant_location->city);
            $shipperAddress->setStateProvinceCode($restaurant_city->state_code);

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('11201');
            $address->setAddressLine1('306 Gold Street');
            //$address->setAddressLine2('BUSINESS ADD 2');
            $address->setCity('Brooklyn');
            $address->setStateProvinceCode('NY');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            $shipToAddress->setAddressLine1($street_address);
            //$shipToAddress->setAddressLine2('ADDRESS 2');
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
            $shipment->setShipTo($shipTo);

            $service = new \Ups\Entity\Service;
            $service->setCode('03'); // 01 = next day air, 02 = 2nd day air, 03 = ground
            $service->setDescription($service->getName());
            $shipment->setService($service);

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
            //$billshipper->setAccountNumber("W007R5");
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
            $shipment_digest = $result->ShipmentDigest;
            $accept = $shipping->accept($shipment_digest);
            
            $tracking_number = $accept->PackageResults->TrackingNumber;
            $imageformat = $accept->PackageResults->LabelImage->LabelImageFormat->Code;
                
            $base64image = $accept->PackageResults->LabelImage->GraphicImage;
            
            $image = base64_decode($base64image);

            echo '<img src="data:image/png;base64,' . $base64image . '" />';

            $tracking = new \Ups\Tracking($accesskey, $userid, $password);
            try {
              $tracking = $tracking->track($tracking_number);
              print_r($tracking);
            } catch (\Ups\Exception\InvalidResponseException $e) {
              echo $e->getMessage();
            }

            //DB::table('orders')->where('id', $order->id)->update(['tracking_id' => $tracking_number, 'label_image' => $base64image]);
        } catch (\Ups\Exception\InvalidResponseException $e) {
            echo $e->getMessage();
        }
    }

    
    public function test_upsrategenerate_restaurant() {
      $restaurant_id = $_GET['restaurant_id'];
      $restaurant = DB::table('restaurants')->where('id', $restaurant_id)->first();
      $restaurant_location = DB::table('restaurant_locations')->where('user_id', $restaurant->user_id)->first();
      //$restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
      $restaurant_city = DB::table('cities')->select('cities.*')->leftJoin('states', 'states.id', 'cities.state_id')->where('cities.name', $restaurant_location->city)->where('states.name', $restaurant_location->state)->first();
    echo '<pre>';
    print_r($restaurant_location);
    print_r($restaurant_city);
    
    
    
      $street_address = '306 Gold Street';
        $first_name = 'sudipta';
        $last_name = 'chakraborti';
        $phone = '1234567890';
        $email = 'sudipta.aqualeaf@gmail.com';
        $zip_code = '11201';
        $city = 'BROOKLYN';
        $state_code = 'NY';


        /*$restaurant_location->zip_code = '99503';
        $restaurant_location->location = '4341 B Street';
        $restaurant_location->city = 'Anchorage';
        $restaurant_city->state_code = 'AK';*/

        $street_address = '4341 B Street';
        $zip_code = '99503';
        $city = 'Anchorage';
        $state_code = 'AK';

        /*$street_address = '59 West 46th Street';
        $zip_code = '10036';
        $city = 'New York';
        $state_code = 'NY';*/

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $rate = new \Ups\Rate($accesskey, $userid, $password);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            //$shipper->setShipperNumber("W007R5");
            $shipper->setName($restaurant->name);//$restaurant->name
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($restaurant_location->zip_code);
            $shipperAddress->setAddressLine1($restaurant_location->location);
            //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
            $shipperAddress->setCity($restaurant_location->city);
            $shipperAddress->setStateProvinceCode($restaurant_city->state_code);

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('11201');
            $address->setAddressLine1('306 Gold Street');
            //$address->setAddressLine2('BUSINESS ADD 2');
            $address->setCity('Brooklyn');
            $address->setStateProvinceCode('NY');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            $shipToAddress->setAddressLine1($street_address);
            //$shipToAddress->setAddressLine2('ADDRESS 2');
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
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

            /*$service = new \Ups\Entity\Service;
            $service->setCode('01'); // 01 = next day air, 02 = 2nd day air, 03 = ground
            $service->setDescription($service->getName());
            $shipment->setService($service);*/

            echo '<pre>' . print_r($rate->getRate($shipment), true);

        } catch (\Ups\Exception\InvalidResponseException $e) {
            echo $e->getMessage();
        }
    }

    
    public function test_upsratetimeintransit_restaurant() {
      $restaurant_id = $_GET['restaurant_id'];
      $restaurant = DB::table('restaurants')->where('id', $restaurant_id)->first();
      $restaurant_location = DB::table('restaurant_locations')->where('user_id', $restaurant->user_id)->first();
      $restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
    
    echo '<pre>';
    print_r($restaurant_location);
    print_r($restaurant_city);
    
    
    
      $street_address = '306 Gold Street';
        $first_name = 'sudipta';
        $last_name = 'chakraborti';
        $phone = '1234567890';
        $email = 'sudipta.aqualeaf@gmail.com';
        $zip_code = '11201';
        $city = 'BROOKLYN';
        $state_code = 'NY';


        $restaurant_location->zip_code = '99503';
        $restaurant_location->location = '4341 B Street';
        $restaurant_location->city = 'Anchorage';
        $restaurant_city->state_code = 'AK';

        /*$street_address = '4341 B Street';
        $zip_code = '99503';
        $city = 'Anchorage';
        $state_code = 'AK';*/

        /*$street_address = '59 West 46th Street';
        $zip_code = '10036';
        $city = 'New York';
        $state_code = 'NY';*/

        $street_address = '2435 Fair Oaks Blvd';
        $zip_code = '95825';
        $city = 'Sacramento';
        $state_code = 'CA';

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $rate = new \Ups\RateTimeInTransit($accesskey, $userid, $password);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            //$shipper->setShipperNumber("W007R5");
            $shipper->setName($restaurant->name);//$restaurant->name
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($restaurant_location->zip_code);
            $shipperAddress->setAddressLine1($restaurant_location->location);
            //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
            $shipperAddress->setCity($restaurant_location->city);
            $shipperAddress->setStateProvinceCode($restaurant_city->state_code);

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('11201');
            $address->setAddressLine1('306 Gold Street');
            //$address->setAddressLine2('BUSINESS ADD 2');
            $address->setCity('Brooklyn');
            $address->setStateProvinceCode('NY');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            $shipToAddress->setAddressLine1($street_address);
            //$shipToAddress->setAddressLine2('ADDRESS 2');
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
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

            /*$service = new \Ups\Entity\Service;
            $service->setCode('01'); // 01 = next day air, 02 = 2nd day air, 03 = ground
            $service->setDescription($service->getName());
            $shipment->setService($service);*/

            $deliveryTimeInformation = new \Ups\Entity\DeliveryTimeInformation();
            $deliveryTimeInformation->setPackageBillType(\Ups\Entity\DeliveryTimeInformation::PBT_NON_DOCUMENT);
            
            /*$pickup = new \Ups\Entity\Pickup();
            $pickup->setDate("20210520");
            $pickup->setTime("160000");*/
            $shipment->setDeliveryTimeInformation($deliveryTimeInformation);

            $result = $rate->shopRatesTimeInTransit($shipment);
            echo '<pre>' . print_r($result, true);

            foreach ($result->RatedShipment as $key => $value) {
              echo '<br>Service code = ' . $value->Service->getCode();
              /*$aa = (array) $value->Service;
              $i = 0;
              foreach ($aa as $k => $v) {
                if($i == 1)
                  echo '<br>Service code = ' . $v;
                $i++;
              }*/
            }

        } catch (\Ups\Exception\InvalidResponseException $e) {
            echo $e->getMessage();
        }
    }

    public function upslabelgenerate_order() {
      $order_id = $_GET['order_id'];
      $service_code = '';
      $order = DB::table('orders')->where('id', $order_id)->first();
      $restaurant = DB::table('restaurants')->where('user_id', $order->vendor_id)->first();
      $restaurant_location = DB::table('restaurant_locations')->where('user_id', $order->vendor_id)->first();
      //$restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
      $restaurant_city = DB::table('cities')->select('cities.*')->leftJoin('states', 'states.id', 'cities.state_id')->where('cities.name', $restaurant_location->city)->where('states.name', $restaurant_location->state)->first();
      $street_address = $order->street_address;
      $address_line_2 = $order->address_line_2;
        $first_name = $order->first_name;
        $last_name = $order->last_name;
        $phone = $order->phone;
        $email = $order->email;
        $zip_code = $order->zip_code;
        $city = $order->city;
        $state_code = DB::table('states')->where('id', $order->state_id)->pluck('state_code')->first();

        /*
        $restaurant->name = 'aasskk';
        $restaurant_location->zip_code = '99503';
        $restaurant_location->location = '4341 B Street';
        $restaurant_location->city = 'Anchorage';
        $restaurant_city->state_code = 'AK';

        $first_name = 'sudipta';
        $last_name = 'chank';

        $phone = '7418529630';
        $email = 'aa@aa.aa';
        $zip_code = '11218';
        $street_address = '664 Coney Island Ave';
        $city = 'Brooklyn';
        $state_code = 'NY';
        */
        
        if($service_code == '') {
            //$from = 'Brooklyn, NY, United States';
            //$to = 'Anchorage, AK, United States';
            $from = $restaurant_location->city . ', ' . $restaurant_city->state_code . ', United States';
            $to = $city . ', ' . $state_code . ', United States';
            $url = "https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($from)."&destination=".urlencode($to)."&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
            $result_string = file_get_contents($url);
            $result = json_decode($result_string, true);
            //echo $result['routes'][0]['legs'][0]['distance']['value'];
            //dd($result);
            $distance = ($result['routes'][0]['legs'][0]['distance']['value'] ?? 0) /1609;
            $shipping_info = json_decode($restaurant->shipping_info, true);
            $delivery_days = $shipping_info['delivery_days'];
            $service_code = '03';
            if($distance < 200) {
                $service_code = '03';
            }
            if($distance >= 200 && $distance <= 700) {
                if(in_array($delivery_days, [1])) $service_code = '13';
                if(in_array($delivery_days, [2])) $service_code = '02';
                if(in_array($delivery_days, [3])) $service_code = '12';
            }
            if($distance > 700) {
                if(in_array($delivery_days, [1])) $service_code = '13';
                if(in_array($delivery_days, [2])) $service_code = '02';
                if(in_array($delivery_days, [3])) $service_code = '12';
            }
            if((in_array($restaurant_city->state_code, ['AK', 'HI']) || in_array($state_code, ['AK', 'HI'])) && $restaurant_city->state_code != $state_code) {
                $service_code = '02';
                if(in_array($delivery_days, [1])) $service_code = '01';
            }
        }

        //$restaurant->name = "Sharlie's Treats";

        echo 'Restaurant: ' . $restaurant->name . '<br>Zipcode: ' . $restaurant_location->zip_code . '<br>Address: ' . $restaurant_location->location . '<br>City: ' . $restaurant_location->city . '<br>State code: ' . $restaurant_city->state_code . '<br><br>Customer name: ' . $first_name . ' ' . $last_name . '<br>Phone: ' . $phone . '<br>Email: ' . $email . '<br>customer zipcode: ' . $zip_code . '<br>Customer address: ' . $street_address . ' ' . $address_line_2 . '<br>customer city: ' . $city . '<br>Customer state code: ' . $state_code . '<br><br>Service code: ' . $service_code . '<br><br>';
        //die;
        

        $accesskey = env('UPS_API_KEY');
        $userid = env('UPS_USER_ID');
        $password = env('UPS_PASSWORD');

        $shipping = new \Ups\Shipping($accesskey, $userid, $password, true);
        //$residential_address = "Jforward Inc, Menya Jiro 306 gold street, Suite c2, BROOKLYN, NY 11201 US";
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipper = $shipment->getShipper();
            $shipper->setShipperNumber("R673Y5");
            //$shipper->setShipperNumber("W007R5");
            $shipper->setName($restaurant->name);
            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode($restaurant_location->zip_code);
            $shipperAddress->setAddressLine1($restaurant_location->location);
            //$shipperAddress->setAddressLine2('BUSINESS ADDRESS 2');
            $shipperAddress->setCity($restaurant_location->city);
            $shipperAddress->setStateProvinceCode($restaurant_city->state_code);

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('11201');
            $address->setAddressLine1('306 Gold Street');
            //$address->setAddressLine2('BUSINESS ADD 2');
            $address->setCity('Brooklyn');
            $address->setStateProvinceCode('NY');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);
            $shipFrom->setCompanyName('Umami Square');
            $shipment->setShipFrom($shipFrom);
            $ship = $shipment->getShipFrom();
            $ship->CompanyName = 'Umami Square';

            $shipTo = $shipment->getShipTo();
            $shipTo->setAttentionName($first_name . ' ' . $last_name);
            $shipTo->setReceivingAddressName($first_name . ' ' . $last_name);
            $shipTo->setPhoneNumber($phone);
            $shipTo->setEmailAddress($email);
            $shipTo->setCompanyName($first_name . ' ' . $last_name);
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zip_code);
            if($address_line_2 != '') {
              $shipToAddress->setAddressLine1($address_line_2);
              $shipToAddress->setAddressLine2($street_address);
            } else {
              $shipToAddress->setAddressLine1($street_address);
            }
            $shipToAddress->setCity($city);
            $shipToAddress->setStateProvinceCode($state_code);
            //$shipToAddress->setCountryCode('US');
            //residenial address indicator will increase the shipping rate
            $shipToAddress->setResidentialAddressIndicator('TRUE');
            $shipment->setShipTo($shipTo);

            $service = new \Ups\Entity\Service;
            //$service->setCode(\Ups\Entity\Service::S_STANDARD);
            $service->setCode($service_code); // 01 = next day air, 02 = 2nd day air, 03 = ground
            $service->setDescription($service->getName());
            $shipment->setService($service);

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
            //$billshipper->setAccountNumber("W007R5");
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
            $shipment_digest = $result->ShipmentDigest;
            $accept = $shipping->accept($shipment_digest);
            
            $tracking_number = $accept->PackageResults->TrackingNumber;
            $imageformat = $accept->PackageResults->LabelImage->LabelImageFormat->Code;
                
            $base64image = $accept->PackageResults->LabelImage->GraphicImage;
            
            $image = base64_decode($base64image);

            echo '<img src="data:image/png;base64,' . $base64image . '" />';

            //DB::table('orders')->where('id', $order->id)->update(['tracking_id' => $tracking_number, 'label_image' => $base64image]);

            
        } catch (\Ups\Exception\InvalidResponseException $e) {
            return $e->getMessage();
        } catch (\ErrorException $e) {
            return $e->getMessage();
        }

    }

    public function test_upstrack() {
      $tracking_number = $_GET['tracking_number'];
      $accesskey = env('UPS_API_KEY');
      $userid = env('UPS_USER_ID');
      $password = env('UPS_PASSWORD');
      $tracking = new \Ups\Tracking($accesskey, $userid, $password);
      try {
        $tracking = $tracking->track($tracking_number);
        print_r($tracking);
        dd($tracking);
      } catch (\Ups\Exception\InvalidResponseException $e) {
        echo $e->getMessage();
      }
    }

    public function test_service_code() {
      $order_id = $_GET['order_id'];
      $order = DB::table('orders')->where('id', $order_id)->first();
      $restaurant = DB::table('restaurants')->where('user_id', $order->vendor_id)->first();
      $restaurant_location = DB::table('restaurant_locations')->where('user_id', $order->vendor_id)->first();
      $restaurant_city = DB::table('cities')->where('name', $restaurant_location->city)->first();
      $street_address = $order->street_address;
      $address_line_2 = $order->address_line_2;
      $first_name = $order->first_name;
      $last_name = $order->last_name;
      $phone = $order->phone;
      $email = $order->email;
      $zip_code = $order->zip_code;
      $city = $order->city;
      $state_code = DB::table('states')->where('id', $order->state_id)->pluck('state_code')->first();
      $from = $restaurant_location->city . ', ' . $restaurant_city->state_code . ', United States';
      $to = $city . ', ' . $state_code . ', United States';
      $url = "https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($from)."&destination=".urlencode($to)."&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
      $result_string = file_get_contents($url);
      $result = json_decode($result_string, true);
      //echo $result['routes'][0]['legs'][0]['distance']['value'];
      //dd($result);
      $distance = $result['routes'][0]['legs'][0]['distance']['value'] /1609;
      $shipping_info = json_decode($restaurant->shipping_info, true);
      $delivery_days = $shipping_info['delivery_days'];
      $service_code = '03';
      if($distance < 200) {
          $service_code = '03';
      }
      if($distance >= 200 && $distance <= 700) {
          if(in_array($delivery_days, [1])) $service_code = '13';
          if(in_array($delivery_days, [2])) $service_code = '02';
          if(in_array($delivery_days, [3])) $service_code = '12';
      }
      if($distance > 700) {
          if(in_array($delivery_days, [1])) $service_code = '13';
          if(in_array($delivery_days, [2])) $service_code = '02';
          if(in_array($delivery_days, [3])) $service_code = '12';
      }
      if((in_array($restaurant_city->state_code, ['AK', 'HI']) || in_array($state_code, ['AK', 'HI'])) && $restaurant_city->state_code != $state_code) {
          $service_code = '02';
          if(in_array($delivery_days, [1])) $service_code = '01';
      }

      echo 'distance = ' . $distance .  ' | service_code = ' . $service_code;
    }

}
