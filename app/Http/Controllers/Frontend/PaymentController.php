<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Categories\Category;
use App\Models\Brand\Brand;
use App\Models\Diet;
use App\Models\Region;
use App\Models\Rating;
use App\Models\Products\Product;
use App\Models\OrderDetail;
use App\Models\ProductAttribute;
use App\Models\PaymentHistory;
use App\Models\Restaurant\RestaurantBranch;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use DB;
class PaymentController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var Diet
     */
    protected $diet;

    /**
     * @var Region
     */
    protected $region;

    /**
     * @var Product
     */
    protected $product;
	
    /**
     * @var Product
     */
    protected $productAttribute;
  /**
     * @var RestaurantBranch
     */
    private $restaurantBranch;
/**
  * @param Order
  */
  private $order;
  private $orderDetail;
  /**
     * @param ProductRepository $productRepository
     * @param Category $category
     * @param Brand $brand
     * @param Diet $diet
     * @param Region $region
     * @param Product $product
     */
    public function __construct(
        Category $category,
        Brand $brand,
        Diet $diet,
        Region $region,
        Product $product,
        OrderDetail $orderDetail,
        ProductAttribute $productAttribute,
        RestaurantBranch $restaurantBranch,
        Order $order
    ) {
        $this->category = $category;
        $this->brand = $brand;
        $this->diet = $diet;
        $this->region = $region;
        $this->product = $product;
        $this->productAttribute = $productAttribute;
        $this->restaurantBranch = $restaurantBranch;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    /**
     * @param ProductShowRequest $request
     * @return View
     */
    public function report_download(Request $request){
        $delimiter = ",";
    $filename = "members_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('S.No.', 'Merchant Name', 'Amount', 'Statement Month');
    fputcsv($f, $fields, $delimiter);
        $lineData = array('1', $request->name, $request->price, $request->month);
        fputcsv($f, $lineData, $delimiter);
    fseek($f, 0);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    
    fpassthru($f);
    }

     public function report()
    {
     /*$payments=$this->orderDetail->where('payment_status','1')->where('vendor_id',auth()->user()->id)->orderBy('created_at','desc')->get();*/
     $orders = OrderDetail::select(
            DB::raw('sum(total) as sums'),
            DB::raw('vendor_name'),
            DB::raw("payment_history.created_at"),
            DB::raw("DATE_FORMAT(payment_history.created_at,'%M') as monthKey"),
            DB::raw("DATE_FORMAT(payment_history.created_at,'%m') as month"),
            DB::raw("DATE_FORMAT(payment_history.created_at,'%Y') as year")
  )
      ->join( 'payment_history', 'order_details.pay_order_id', '=', 'payment_history.order_id' )
  ->whereYear('payment_history.created_at', date('Y'))
  ->where('order_details.payment_status','1')->where('payment_history.vendor_id',auth()->user()->id)
  ->groupBy('monthKey')
  ->orderBy('created_at', 'ASC')
  ->get();
   // echo '<pre>'; print_r($orders); exit;
            return view('frontend.paymenthistory.report',
                compact('orders')
            );
          
            
    }
     public function statementView($id= null)
     {
       $statementorders = OrderDetail::select(
                  DB::raw('sum(total) as sums'),
                  DB::raw('vendor_name'),
                  DB::raw("payment_history.created_at"),
                  DB::raw("DATE_FORMAT(payment_history.created_at,'%M') as monthKey"),
                  DB::raw("DATE_FORMAT(payment_history.created_at,'%m') as month")
        )
       ->join( 'payment_history', 'order_details.pay_order_id', '=', 'payment_history.order_id' )
        ->whereMonth('payment_history.created_at', $id)
        ->where('order_details.payment_status','1')->where('payment_history.vendor_id',auth()->user()->id)
        ->groupBy('monthKey')
        ->orderBy('payment_history.created_at', 'ASC')
        ->first();

    $startdate= date('Y-m-01', strtotime($statementorders->created_at));
    $enddate = date('Y-m-t', strtotime($statementorders->created_at));
        //echo '<pre>'; print_r($statementorders); exit;
        return view('frontend.paymenthistory.reportview',
                compact('statementorders','startdate','enddate'));
     }
    public function paymentHistory()
    {
      if(auth()->user()->isUser())
      {
        $payments=PaymentHistory::where('user_id',auth()->user()->id)->groupBy('transaction_id')->orderBy('created_at','desc')->get();
        return view('frontend.paymenthistory.payment-history',
                compact('payments')
            );

      } else{ 
   
           $restaurantId = $this->restaurantBranch->where('user_id', auth()->user()->id)->value('restaurant_id');
            if(auth()->user()->isVender()){
              $productIds = $this->product->where('restaurant_id', $restaurantId)->pluck('id');
            } else {
              $productIds = $this->product->where('restaurant_id', $restaurantId)->where('user_id', auth()->user()->id)->pluck('id');
            }
            $payments=$this->orderDetail->where('payment_status','1')->where('vendor_id',auth()->user()->id)->orderBy('created_at','desc')->get();
            /*$payments=PaymentHistory::where('vendor_id',auth()->user()->id)->groupBy('transaction_id')->orderBy('created_at','desc')->get();*/
           /* $payments=$this->order->whereIn('product_id', $productIds)
            ->where('order_id', '!=', null)
            ->with('orderDetails','payment')
            ->orderBy('created_at','desc')
            ->get();*/
            return view('frontend.paymenthistory.payment-history-vendor',
                compact('payments')
            );
          }
            
    }
 public function paymentView($id=null)
   {

    $payments= $this->order->where('order_id', $id)
        ->with('orderDetails')
        ->orderBy('created_at','desc')
        ->first();
       
      //echo '<pre>'; print_r($payments); exit;
     return view('frontend.paymenthistory.payment-view',
                compact('payments'));
   }

}
