<?php

namespace App\Http\Controllers\Backend\PaymentHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Models\Order;
use App\Models\OrderDetail;
use DB;

class PaymentHistoryController extends Controller
{

   /**
     * @var Coupon
     */
    protected $PaymentHistory;
     private $order;
    public function __construct(PaymentHistory $PaymentHistory ,Order $order)
    {

      $this->PaymentHistory=$PaymentHistory;
      $this->order = $order;

    }

    public function index()
    {
      /*$stripe_refund = stripe_refund(['charge_id' => 'ch_1ICOEVGDuoslQd26KbiIECMz']);
      if($stripe_refund['success'] == '1') {
        $stripe_refund['refund_id']
      }*/

      //$payments = $this->PaymentHistory->select('payment_history.*', 'od.status as order_status')->leftJoin('orders as od', 'od.order_id', 'payment_history.order_id')->orderBy('payment_history.id', 'DESC')->groupBy('payment_history.transaction_id')->paginate(PAGINATION);

      //$payments = $this->PaymentHistory->select('payment_history.*', 'od.status as order_status', 'st.name as state_name', 'st.state_code')->leftJoin('orders as od', 'od.order_id', 'payment_history.order_id')->leftJoin('states as st', 'st.id', 'od.state_id')->orderBy('payment_history.id', 'DESC')->groupBy('payment_history.transaction_id')->get();

      $payments = $this->PaymentHistory->select('payment_history.*', 'od.status as order_status', 'st.name as state_name', 'st.state_code', DB::raw('(select count(sales_report_payments.id) from sales_report_payments where sales_report_payments.payment_history_id = payment_history.id) as sales_reported'))->leftJoin('orders as od', 'od.order_id', 'payment_history.order_id')->leftJoin('states as st', 'st.id', 'od.state_id')->orderBy('payment_history.id', 'DESC')->groupBy('payment_history.transaction_id')->get();
	  
	 //echo '<pre>';print_r($payments);exit;
	  
	  
	  return view('backend.paymenthistory.index', compact('payments'));
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

   
   public function details($id = null) {
    $payment_history = $this->PaymentHistory->where('id', $id)->first();
    return response()->json([
      'data' => ['payment_history' => $payment_history]
    ]);
  }


public function changeSalesDeduction(Request $request) {
  $payment_id = $request->input('payment_id');
  $sales_deduction = $request->input('sales_deduction');
  $sales_deduction_info = $request->input('sales_deduction_info');
  $payment = $this->PaymentHistory->where('id', $payment_id)->update(['sales_deduction' => $sales_deduction, 'sales_deduction_info' => $sales_deduction_info]);
  return response()->json([]);
  }
   
  public function refund($id = null) {
    $payment = $this->PaymentHistory->where('id', $id)->where('refund_id', null)->first();
    if(isset($payment->id)) {
      $stripe_refund = stripe_refund(['charge_id' => $payment->charge_id]);
      //print_r($stripe_refund); die;
      if($stripe_refund['success'] == '1') {
        $this->PaymentHistory->where('id', $id)->update(['refund_id' => $stripe_refund['refund_id']]);
      }
    }
      /*$stripe_refund = stripe_refund(['charge_id' => 'ch_1ICOEVGDuoslQd26KbiIECMz']);
      if($stripe_refund['success'] == '1') {
        $stripe_refund['refund_id']
      }*/
    return redirect('admin/paymenthistory');
  }

  public function refund_payment(Request $request) {
    $payment_id = $request->input('payment_id');
    $refund_amount = $request->input('refund_amount');
    $refund_info = $request->input('refund_info');
    $payment = $this->PaymentHistory->where('id', $payment_id)->where('refund_id', null)->first();
    if(isset($payment->id)) {
      $stripe_refund = stripe_refund(['charge_id' => $payment->charge_id, 'refund_amount' => $refund_amount, 'refund_info' => $refund_info]);
      //print_r($stripe_refund); die;
      if($stripe_refund['success'] == '1') {
        $this->PaymentHistory->where('id', $payment_id)->update(['refund_id' => $stripe_refund['refund_id'], 'refund_amount' => $refund_amount, 'refund_info' => $refund_info]);
      }
    }
    return response()->json(['success' => 1]);
  }

  public function label($id = null) {
    $payment = $this->PaymentHistory->where('id', $id)->first();
    $label_image = $this->order->where('order_id', $payment->order_id)->pluck('label_image')->first();
    return response()->json([
      'data' => ['label_image' => $label_image]
    ]);
  }

  public function changelabel(Request $request) {
    $payment_id = $request->input('payment_id');
    $ups_service_code = $request->input('ups_service_code');
    $payment = $this->PaymentHistory->where('id', $payment_id)->first();
    $order = $this->order->where('order_id', $payment->order_id)->first();
    $label_msg = Order::generate_shipping_label(['order_id' => $order->id, 'service_code' => $ups_service_code]);
    return response()->json(['data' => ['message' => $label_msg['message']]]);
  }

  public function changestatus(Request $request) {
    $order_id = $request->input('order_id');
    $status = $request->input('status');
    $this->order->where('id', $order_id)->update(['status' => $status]);
    return response()->json(['data' => []]);
  }

  public function delete($order_id) {
    $order = $this->order->where('id', $order_id)->first();
    $this->order->where('id', $order_id)->delete();
    OrderDetail::where('order_id', $order_id)->delete();
    PaymentHistory::where('order_id', $order->order_id)->delete();
    return redirect('admin/paymenthistory');
  }
 
}
