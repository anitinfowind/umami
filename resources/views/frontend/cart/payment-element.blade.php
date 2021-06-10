<?php
$text_msg='';
$color='';

/*if(isset($payment_details)){
$text_msg='Coupon Has Already Used! Please use different Coupon';
$type='';	
$color='red';
$min_price=0;
$discount=0;
}else{*/
if(isset($coupon_details)){
	$maxcoupon=$coupon_details->max_users;
	if($countcoupon>$maxcoupon){
		$text_msg='Coupon Has Got Limit Exceed! Please use different Coupon';
		$color='red';
		$min_price=0;
		$discount=0;
		$type=$coupon_details->discount_type;
	}else{
		$type=$coupon_details->discount_type;
		$expire_date=$coupon_details->end_date;
		$today_date=date('Y-m-d');
		$today_compare=strtotime($today_date);
		$expire_date_comp=strtotime($expire_date);
		if($today_compare>$expire_date_comp){
		$text_msg='Coupon Has expired! Please use different Coupon';
		$color='red';
		$min_price=0;
		$discount=0;
		//print_r($coupon_details);die;	
	}else{
		$text_msg='Coupon Applied Successfuly';
		$color='green';
		$min_price=$coupon_details->min_price;
		$discount=$coupon_details->discount;
	}
}

}else{
	$type='';
	$min_price=0;
	$discount=0;	
}

//}

?>

<div class="checkout-box positition-sticky">
	@if(in_array(\Request::segment('1'), ['increase-decrease-item','cart','delete-cart-product']))
		<!--<h4>Delivery Charges</h4>
		<h6>Free Delivery</h6>
		 <div class="calculate-charge">
			<a href="#">Calculate Delivery Charge</a>
		</div> -->
		<div class="apply-coupon">
			<h4>Apply Coupon Code</h4>
			<div class="coupon-box">
				{{ Form::open([
								'url' => 'cart/coupon',
								'class' => 'form-horizontal',
								'id' => 'checkout'
							]
						)
					}}
				<div class="d-flex">
					<input type="text" class="form-control coupon-input" name="coupon_code" placeholder="Coupon code">
					<button class="btn apply-btn apply-coupon-btn" type="submit">Apply Coupon</button>
				</div>
				{{ Form::close() }}
				<span style="color: <?=$color?>"><?=$text_msg;?></span>
				
			</div>
		</div>
	@endif
	
	@php $price = 0; @endphp
	@foreach($carts as $value)
		@php $price+= $value->total; @endphp
	@endforeach	
	<?php
		
		$discounterror='';
		$discountolor='';
		$product_price=$price;
		$discount_price= 0.00;
		if($type=='FIXED'){
			if($min_price<$product_price){
		$discount_price=$discount;
		$discount_price=number_format($discount_price,2);	
		session()->put('discount',$discount_price);
		session()->put('coupon_code',$coupon_details->coupon_code);
		$discountolor='green';
		}else{
		$discounterror='Discount not available on this amount, Minimum amount should be ' .$min_price;
		$discountolor='red';
		}
		}
		if($type=='PERCENTAGE'){
				if($min_price<$product_price){
		$discount_price=$product_price*$discount/100;
		
		session()->put('discount',$discount_price);

		session()->put('coupon_code',$coupon_details->coupon_code);
		$discountolor='green';
		}else{
		$discounterror='Discount not available on this amount, Minimum amount should be ' .$min_price;
		$discountolor='red';
		}
		
		}
		if($discount_price>0){
		$payable_amount=$product_price-$discount_price;
		}else{
		$payable_amount=$product_price;
		}
		 ?>
		 <span style="color: <?=$discountolor?>"><?=$discounterror;?></span>
	<ul class="food-price-sec">
		
		<li class="d-flex justify-content-between align-items-center"><label>Subtotal</label><span>{{CURRENCY}}{{ number_format($price,2) }}</span></li>
		<li class="d-flex justify-content-between align-items-center"><label>Discount</label><span>{{CURRENCY}}{{number_format($discount_price,2)}}</span></li>
		<li class="d-flex justify-content-between align-items-center"><label>Payable Amount</label><span>{{CURRENCY}}{{number_format($payable_amount,2)}}</span></li>
	</ul>
	
	@if(in_array(\Request::segment('1'), ['increase-decrease-item','cart','delete-cart-product']))
		<div class="food-checkout-btn">
			<a href="{{ url('checkout') }}"> <button class="btn checkout-btn">Proceed to Checkout</button></a>
		</div>
		<div class="payment-method">
			<h5>Accepted payment methods</h5>
			<a href="#"><img src="{{url('public/images/mastercard.png')}}"></a>
			<a href="#"><img src="{{url('public/images/visa.png')}}"></a>
			<a href="#"><img src="{{url('public/images/american.png')}}"></a>
			<a href="#"><img src="{{url('public/images/paypal.png')}}"></a>
		</div>
	@endif
</div>
			