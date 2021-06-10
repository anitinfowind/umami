<?php

namespace App\Http\Controllers\Backend\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Coupon\CouponAddRequest;
use App\Http\Requests\Frontend\Coupon\CouponUpdateRequest;
use App\Http\Requests\Frontend\Coupon\CouponDeleteRequest;
use App\Models\Coupon;

class CouponController extends Controller
{

   /**
     * @var Coupon
     */
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
      $this->coupon=$coupon;

    }

    public function index()
    {
      $coupons= $this->coupon->orderBy('id', 'DESC')->paginate(PAGINATION);
  	   return view('backend.coupon.index', compact('coupons'));
    }

    public function addCoupon()
    {
	    return view('backend.coupon.create');

    }

    public function saveCoupon(CouponAddRequest $request)
    {
		   $this->coupon->create(
                    [ 
                      'user_id' =>  auth()->user()->id,
                      'coupon_code' => $request->get('coupon_code'),
                      'discount_type' => $request->get('discount_type'),
                      'discount' => $request->get('discount'),
                      'max_users' => $request->get('max_users'),
                      'start_date' => $request->get('start_date'),
                      'end_date' => $request->get('end_date'),
                      'min_price' => $request->get('min_price'),
                      'description' => $request->get('description'),
                    ]
                  );
        return redirect()->to('admin/coupon')->with(['flash_success' => trans('Coupon has been successfully Add.')]);
    }

    public function editCoupon(int $id)
    {
      $coupons = $this->coupon->find($id);
      return view('backend.coupon.edit', compact('coupons'));
    } 

    public function updateCoupon(CouponUpdateRequest $request ,int $id)
    {
        $checkDisType= $this->coupon->where('id', $id)->where('discount_type',$request->get('discount_type'))->first();
      /*if(isset($checkDisType->discount_type) && $checkDisType->discount_type==$request->get('discount_type')) {*/
          $this->coupon->where('id', $id)->update(
                    [ 
                      'coupon_code' => $request->get('coupon_code'),
                      'discount_type' => $request->get('discount_type'),
                      'discount' => $request->get('discount'),
                      'max_users' => $request->get('max_users'),
                      'start_date' => $request->get('start_date'),
                      'end_date' => $request->get('end_date'),
                      'min_price' => $request->get('min_price'),
                      'description' => $request->get('description'),
                    ]
                  );
  

       /* }else {
         if($request->get('discount_type')== 'FIXED')
         {
            $discount=NULL;
            $minprice= $request->get('min_price');
         }
         else
         {
            $minprice=NULL;
            $discount= $request->get('discount');
         }
          $this->coupon->where('id', $id)->update(
                    [ 
                      'coupon_code' => $request->get('coupon_code'),
                      'discount_type' => $request->get('discount_type'),
                      'discount' =>  $discount,
                      'max_users' => $request->get('max_users'),
                      'start_date' => $request->get('start_date'),
                      'end_date' => $request->get('end_date'),
                      'min_price' => $minprice,
                      'description' => $request->get('description'),
                    ]
                  );

       }*/
        return redirect()->to('admin/coupon')->with(['flash_success' => trans('Coupon has been successfully updated.')]);
               
      }

    

     public function deleteCoupon(CouponDeleteRequest $request, $id)
     {
        $this->coupon->where('id',$id)->delete();
        return redirect()->to('admin/coupon')->with(['flash_success' => trans('Coupon has been successfully deleted.')]);
     }


    public function couponList()
    {
      $currentdate= date('Y-m-d');
      $couponlists = $this->coupon
                  ->whereDate('start_date','>=', $currentdate)
                  ->whereDate('end_date','>=', $currentdate)
                 ->get();
       return view('frontend.coupon.coupon-list', compact('couponlists'));

    } 
}
