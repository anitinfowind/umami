<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Settings\Setting;
use Illuminate\Http\Request;
use DB;
use App\Models\Sales_report;
use App\Models\Sales_report_payment;
use App\Models\Restaurant\Restaurant;

class SalesReportController extends Controller
{
    /**
     * @return View
     */
    public function index() {
    }

    public function sales()
    {
        $user_id = auth()->user()->id;
        $restaurant = Restaurant::where('user_id', $user_id)->first();
        $restaurant_id = $restaurant->id;
        $sales_reports = Sales_report::where('restaurant_id', $restaurant_id)->orderBy('from_date')->get();

        return view('frontend.order.sales', compact('sales_reports'));
    }

    public function sales_payment(Request $request) {
        $sales_report_id = $request->input('sales_report_id');
        $sales_report_payments = Sales_report_payment::select('sales_report_payments.*', 'ph.order_id', 'ph.sales_deduction', 'ph.sales_deduction_info')->leftJoin('payment_history as ph', 'ph.id', 'sales_report_payments.payment_history_id')->where('sales_report_payments.sales_report_id', $sales_report_id)->orderBy('sales_report_payments.payment_history_id')->get();
        $data = ['sales_report_payments' => $sales_report_payments];
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }


}
