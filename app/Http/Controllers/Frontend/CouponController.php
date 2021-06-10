<?php

namespace App\Http\Controllers\Frontend;

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
      $coupons= $this->coupon->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(PAGINATION);
  	   return view('frontend.coupon.index', compact('coupons'));
    }

    public function addCoupon()
    {
	    return view('frontend.coupon.add');

    }

    public function saveCoupon(CouponAddRequest $request)
    {
		   $this->coupon->create(
                    [ 
                      'user_id' =>  auth()->user()->id,
                      'coupon_code' => $request->get('coupon_code'),
                      'discount_type' => $request->get('discount_type'),
                      'discount' => $request->get('discount'),
                      'start_date' => $request->get('start_date'),
                      'end_date' => $request->get('end_date'),
                      'min_price' => $request->get('min_price'),
                      'description' => $request->get('description'),
                    ]
                  );
                 session()->put('coupon',
                                [
                                  'title' => trans('Coupon'),
                                  'msg' => trans('Coupon has been successfully Add.')
                                ]
                            );

                  return response()->json([
                          'success' => true,
                      ]);
    }

    public function editCoupon(int $id)
    {
      $couponedit = $this->coupon->find($id);
      return view('frontend.coupon.edit', compact('couponedit'));
    } 

    public function updateCoupon(CouponUpdateRequest $request ,int $id)
    {
        $checkDisType= $this->coupon->where('id', $id)->where('discount_type',$request->get('discount_type'))->first();
      if(isset($checkDisType->discount_type) && $checkDisType->discount_type==$request->get('discount_type')) {
          $this->coupon->where('id', $id)->update(
                    [ 
                      'coupon_code' => $request->get('coupon_code'),
                      'discount_type' => $request->get('discount_type'),
                      'discount' => $request->get('discount'),
                      'start_date' => $request->get('start_date'),
                      'end_date' => $request->get('end_date'),
                      'min_price' => $request->get('min_price'),
                      'description' => $request->get('description'),
                    ]
                  );
  

      } else {
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
                      'start_date' => $request->get('start_date'),
                      'end_date' => $request->get('end_date'),
                      'min_price' => $minprice,
                      'description' => $request->get('description'),
                    ]
                  );

       }
                 session()->put('coupon',
                                [
                                  'title' => trans('Coupon'),
                                  'msg' => trans('Coupon has been successfully updated.')
                                ]
                            );

                  return response()->json([
                          'success' => true,
                      ]);
      }

    

     public function deleteCoupon(CouponDeleteRequest $request)
     {
        $this->coupon->where('id',$request->get('coupon_id'))->delete();
         return response()->json([
                          'success' => true,
                      ]);
     }


    public function couponList()
    {
      $currentdate= date('Y-m-d');
      $couponlists = $this->coupon
                  ->whereDate('start_date','<=', $currentdate)
                  ->whereDate('end_date','>=', $currentdate)
                 ->get();
                //  echo "<pre>"; print_r($couponlists); exit;
       return view('frontend.coupon.coupon-list', compact('couponlists'));

    } 
}
