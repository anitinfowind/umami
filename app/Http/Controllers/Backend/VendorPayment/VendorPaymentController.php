<?php

namespace App\Http\Controllers\Backend\VendorPayment;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use App\Models\Order;
use App\Models\OrderDetail;
use DB;
class VendorPaymentController extends Controller
{

   /**
     * @var Coupon
     */
    protected $PaymentHistory;
     private $order;
     private $orderDetail;
    public function __construct(PaymentHistory $PaymentHistory ,Order $order,OrderDetail $orderDetail)
    {

      $this->PaymentHistory=$PaymentHistory;
      $this->order = $order;
      $this->orderDetail = $orderDetail;

    }

    public function index()
    {
     /* $payments= $this->PaymentHistory->orderBy('id', 'DESC')->groupBy('transaction_id')->paginate(PAGINATION);*/
     /*$payments=$this->orderDetail->where('payment_status','1')->orderBy('created_at','desc')->get();*/
     $payments= DB::table('order_details')
          ->select('order_details.*', 'u.slug as vendor_slug')
          ->groupBy('vendor_id')
          ->join( 'payment_history', 'order_details.pay_order_id', '=', 'payment_history.order_id' )
          ->leftJoin('users as u', 'u.id', 'order_details.vendor_id')
          ->get();
          // echo '<pre>'; print_r($payments); exit;
  	   return view('backend.paymenthistory.payment-history-vendor', compact('payments'));
    }
    public function paymentView($id=null)
   {
    $payments= $this->order->where('order_id', $id)
        ->with('orderDetails')
        ->orderBy('created_at','desc')
        ->first();

      // echo '<pre>'; print_r($payments->orderDetails); exit;
     return view('backend.paymenthistory.payment-view',
                compact('payments'));
   }
 
}
