<?php

namespace App\Http\Controllers\Backend;

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
    public function index()
    {
        $restaurant_id = $_GET['restaurant_id'];
        $sales_reports = Sales_report::where('restaurant_id', $restaurant_id)->orderBy('from_date')->get();
        $restaurant = Restaurant::find($restaurant_id);

        return view('backend.sales_report',
            compact('sales_reports', 'restaurant')
        );
    }

    public function sales_report_dates(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        if($from_date != '' && $to_date != '') {
            $sales_report_dates = Sales_report::select('sales_reports.*', 'r.name as restaurant_name')->leftJoin('restaurants as r', 'r.id', 'sales_reports.restaurant_id')->where('sales_reports.from_date', $from_date)->where('sales_reports.to_date', $to_date)->orderBy('r.name')->get();
        } else {
            $sales_report_dates = Sales_report::groupBy('from_date')->orderBy('from_date')->select('from_date', 'to_date', 'id')->get();
        }
        return view('backend.sales_report_dates',
            compact('sales_report_dates')
        );
    }

    public function get_sales_report_payments(Request $request) {
        $sales_report_id = $request->input('sales_report_id');
        $sales_report_payments = Sales_report_payment::select('sales_report_payments.*', 'ph.order_id', 'ph.sales_deduction', 'ph.sales_deduction_info')->leftJoin('payment_history as ph', 'ph.id', 'sales_report_payments.payment_history_id')->where('sales_report_payments.sales_report_id', $sales_report_id)->orderBy('sales_report_payments.payment_history_id')->get();
        $data = ['sales_report_payments' => $sales_report_payments];
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }


}
