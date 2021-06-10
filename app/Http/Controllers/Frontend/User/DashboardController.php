<?php

namespace App\Http\Controllers\Frontend\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Products\Product;
use App\Models\Restaurant\RestaurantBranch;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\DashboardRequest;

class DashboardController extends Controller
{
    /**
     * @param DashboardRequest $request
     * @return View
     */
    private $order;
    /**
     * @var RestaurantBranch
     */
    private $restaurantBranch;
  
    /**
    /**
       * @var Product
       */
    private $product;
  
     public function __construct(
        Order $order,
        Product $product,
        RestaurantBranch $restaurantBranch
      ) {
        $this->order = $order;
        $this->product = $product;
        $this->restaurantBranch = $restaurantBranch;
        }


    public function index(DashboardRequest $request)
    {
        $latestorder=0;
        $cancelorder=0;
        $pendingorder=0;
        $confirmorder=0;
        $shippedorder = 0;
        if(auth()->user()->isVender())
        {
          $dateS = date("Y-m-d");
          $dateE = date("Y-m-d");
          /*$latestorder= $this->getOrder()
            ->where('orders.status','PENDING')->whereBetween('created_at',[$dateS." 00:00:00",$dateE." 23:59:59"])->count();*/
          $latestorder= $this->order
          ->leftJoin('payment_history','payment_history.order_id','orders.order_id')
          ->where('payment_history.refund_id', '=', null)
          ->where('orders.vendor_id', auth()->user()->id)->where('orders.order_id', '!=', null)->where('orders.pickup_date',$dateE)->count();
           
          //$the_order = $this->order->with('product','orderDetails','user')->where('vendor_id', auth()->user()->id);

          /*$pendingorder=  $this->order->with('product','orderDetails','user')->where('vendor_id', auth()->user()->id)->where('orders.status','PENDING')->count();
          $cancelorder=  $this->order->with('product','orderDetails','user')->where('vendor_id', auth()->user()->id)->where('orders.status','CANCELLED')->count();
          $confirmorder=  $this->order->with('product','orderDetails','user')->where('vendor_id', auth()->user()->id)->where('orders.status','DELIVERED')->count();
          $shippedorder = $this->order->with('product','orderDetails','user')->where('vendor_id', auth()->user()->id)->whereIn('orders.status',['PACKED', 'SHIPPED', 'DELIVERED'])->count();*/
          $pendingorder=  $this->order->with('product','orderDetails','user')->where('orders.vendor_id', auth()->user()->id)->where('orders.status','PENDING')
          ->where('orders.order_id', '!=', null)
          ->whereNotNull('payment_history.id')
          ->with('product','orderDetails','user')
          ->leftJoin('payment_history','payment_history.order_id','orders.order_id')
          ->where('payment_history.refund_id', '=', null)
          ->count();
          $cancelorder=  $this->order->with('product','orderDetails','user')->where('orders.vendor_id', auth()->user()->id)->where('orders.status','CANCELLED')
          ->where('orders.order_id', '!=', null)
          ->whereNotNull('payment_history.id')
          ->with('product','orderDetails','user')
          ->leftJoin('payment_history','payment_history.order_id','orders.order_id')
          ->where('payment_history.refund_id', '=', null)
          ->count();
          $confirmorder=  $this->order->with('product','orderDetails','user')->where('orders.vendor_id', auth()->user()->id)->where('orders.status','DELIVERED')
          ->where('orders.order_id', '!=', null)
          ->whereNotNull('payment_history.id')
          ->with('product','orderDetails','user')
          ->leftJoin('payment_history','payment_history.order_id','orders.order_id')
          ->where('payment_history.refund_id', '=', null)
          ->count();
          $shippedorder = $this->order->with('product','orderDetails','user')->where('orders.vendor_id', auth()->user()->id)->whereIn('orders.status',['PACKED', 'SHIPPED', 'DELIVERED'])
          ->where('orders.order_id', '!=', null)
          ->whereNotNull('payment_history.id')
          ->with('product','orderDetails','user')
          ->leftJoin('payment_history','payment_history.order_id','orders.order_id')
          ->where('payment_history.refund_id', '=', null)
          ->count();
        }
        else
        {
          return redirect('/my-order');
          $latestorder= $this->getOrder()
            ->where('orders.status','PENDING')->count();
          $pendingorder=  $this->getOrder()
            ->where('orders.status','PENDING')->count();
          $cancelorder=  $this->getOrder()
            ->where('orders.status','CANCELLED')->count();
          $confirmorder=  $this->getOrder()
            ->where('orders.status','DELIVERED')->count();
        }
         //echo '<pre>'; print_r($latestorder); exit;

        $salesamount= PaymentHistory::with('saleReport')->where('vendor_id', auth()->user()->id)->get();
        $totalamount= PaymentHistory::with('saleReport')
                        ->join( 'order_details', 'order_details.pay_order_id', '=', 'payment_history.order_id' )
                        ->where('payment_history.vendor_id', auth()->user()->id)
                        ->sum('order_details.total');
        //echo '<pre>'; print_r($totalamount); exit;
        return view('frontend.user.dashboard', compact('latestorder','cancelorder','pendingorder','confirmorder', 'shippedorder', 'salesamount','totalamount'));
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
      }
}
