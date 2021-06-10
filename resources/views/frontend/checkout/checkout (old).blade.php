@extends('frontend.layouts.layout')
@section('content')
@php $price = 0; @endphp
	@foreach($carts as $value)
		@php $price+= $value->total; @endphp
	@endforeach	
	
	
<?php

 $resShippingFee=0;
$shippingone=$shipingOne;
$shippingtwo=$shipingtwo;
$shippingthree=$shipingthree;
$shipping_charge='0';
/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/balance');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_USERPWD, 'pk_test_6ePvp32lsjDSrHufZo4w2LBF00lXYSMQa8' . ':' . '');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);


if(isset($userAddress->pincode)){
$zipcode=$userAddress->pincode;

$street_address=$userAddress->streetAddress();
$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zipcode)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
    $result_string = file_get_contents($url);
    $result = json_decode($result_string, true);
   $dataresultcheck=$result['results'][0]['address_components'];
   $addressstatus='';

 if($addressstatus=='ok')
 {
   if(in_array('administrative_area_level_1', $dataresultcheck[0]['types'])){
     	 $stateshort_code =$result['results'][0]['address_components'][0]['short_name'];
     }else if(in_array('administrative_area_level_1', $dataresultcheck[1]['types'])){
     	 $stateshort_code =$result['results'][0]['address_components'][1]['short_name'];
     }else if(in_array('administrative_area_level_1', $dataresultcheck[2]['types'])){
     	 $stateshort_code =$result['results'][0]['address_components'][2]['short_name'];
     }else if(in_array('administrative_area_level_1', $dataresultcheck[3]['types'])){
     	 $stateshort_code =$result['results'][0]['address_components'][3]['short_name'];
     }else if(in_array('administrative_area_level_1', $dataresultcheck[4]['types'])){
     	 $stateshort_code =$result['results'][0]['address_components'][4]['short_name'];
     }
        }
  }*/
?>
<head>

  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ asset('js/index.js') }}"></script>
 <link rel="stylesheet" type="text/css" href="{{ asset('css/example3.css') }}" data-rel-css="" />
</head>
<section class="inner-breadcrumbs-menu">
	<div class="container">
		<ul class="d-flex">
			<li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
			<li><a href="{{url('cart')}}">Cart</a><i class="fa fa-angle-right"></i></li>
			<li><span>Checkout</span></li>
		</ul>
	</div>
</section>
<section class="cart-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 col-12">
				<div class="shipping-address">
					<h2>Shipping Address</h2>
					<div class="checkout_address_details step2_content" style="display: none;"></div>
					{{ Form::open([
								'url' => 'save-order',
								'class' => 'form-horizontal',
								'id' => 'checkout'
							]
						)
					}}
					<input type="hidden" name="address_primary_id" value="{{isset($userAddress->id)?$userAddress->id:''}}">
						<div class="checkout_error_div"></div>
						<div class="step1_content">
						<div class="row form-group chk-input">
							<div class="col-lg-6 col-md-6 col-sm-12 col-12">
								<label>First Name</label>
								{{ Form::text(
										'first_name',
										auth()->user()->firstName(),
										[
											'class' => 'form-control chk-input-style',
											'placeholder' => trans('First Name')
										]
									)
								}}
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-12">
								<label>Last Name</label>
								{{ Form::text(
										'last_name',
										auth()->user()->lastName(),
										[
											'class' => 'form-control chk-input-style',
											'placeholder' => trans('Last Name')
										]
									)
								}}
							</div>
						</div>
						<div class="row form-group chk-txtare">
							<div class="col-lg-6 col-md-12 col-sm-12 col-12">
								{{-- Form::textarea(
										'street_address',
										isset($userAddress) ? $userAddress->streetAddress() : '',
										[
											'class' => 'form-control textarea chk-txtare-style',
											'id' => 'street_address',
											'rows' => 4,
											'autocomplete' => 'off',
											'placeholder' => trans('Street Address')
										]
									)
								--}}
								<label>Street Address</label>
								{{ Form::text(
										'street_address',
										isset($userAddress) ? $userAddress->streetAddress() : '',
										[
											'class' => 'form-control chk-input-style',
											'id' => 'street_address',
											'autocomplete' => 'off',
											'placeholder' => trans('Street Address')
										]
									)
								}}
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12 col-12">
								<label>Apt / Suit / Other</label>
								{{ Form::text(
										'address_line_2',
										'',
										[
											'class' => 'form-control novalidate chk-input-style',
											'id' => 'address_line_2',
											'autocomplete' => 'off',
											'placeholder' => trans('Apt / Suit / Other')
										]
									)
								}}
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 col-12" style="display: none;">
								{{ Form::textarea(
										'alternative_address',
										isset($userAddress) ? $userAddress->alternativeAddress() : '',
										[
											'class' => 'form-control textarea novalidate chk-txtare-style',
											'rows' => 4,
											'placeholder' => trans('Alternative Address')
										]
									)
								}}
							</div>
						</div>
						<div class="row form-group chk-input">
							<div class="col-lg-3 col-md-6 col-sm-12 col-12">
								<div class="city111">
									{{-- Form::select(
											 'city_id',
											 [
												 '' => trans("Select City")
											 ]+$cities,
											 isset($userAddress) ? $userAddress->cityId() : '',
											 [
												 'class' => 'form-control chk-select-style'
											 ])
									 --}}
									 <label>City</label>
									 {{ Form::text(
											'city',
											'',
											[
												'class' => 'form-control chk-input-style',
												'placeholder' => 'City'
											]
										)
									}}
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12 col-12">
								<div class="state">
									<label>State</label>
									{{ Form::select(
											'state_id',
											[
												'' => trans("Select State")
											]+$states,
											isset($userAddress) ? $userAddress->stateId() : '',
											[
												'class' => 'form-control chk-select-style',
												'id' => 'state'
											])
									}}
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12 col-12">
								<label>Zipcode</label>
								{{ Form::text(
										'zip_code',
										isset($userAddress) ? $userAddress->pincode : '',
										[
											'class' => 'form-control number-field chk-input-style',
											'maxlength' => '8',
											'placeholder' => trans('Zip Code')
										]
									)
								}}
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12 col-12">
								<label>Country</label>
								{{ Form::select(
										'country_id',
										[
											'' => 'Select Country'
										]+$countries,
										isset($userAddress) ? $userAddress->countryId() : '',
										[
											'class' => 'form-control chk-select-style',
											'id' => 'country'
										]
									)
								}}
							</div>
						</div>
						</div>
						<input type="hidden" name="serviceCode"value="{{isset($serviceCode)?$serviceCode:'03'}}">
						<input type="hidden" name="product_weight"value="{{isset($product_weight)?$product_weight:'1'}}">
						<input type="hidden" name="product_height"value="{{isset($product_height)?$product_height:'1'}}">
						<input type="hidden" name="product_length"value="{{isset($product_length)?$product_length:'1'}}">
						<input type="hidden" name="product_width"value="{{isset($product_width)?$product_width:'1'}}">

						<div class="row form-group chk-input">
							<div class="col-12">
								<label>Do you want to add a gift message? <input type="checkbox" name="is_gift" value="ACTIVE" @if(session()->get('is_gift')=='ACTIVE') checked @endif></label>
							</div>
						</div>
				            <div class="row form-group gift_message" @if(session()->get('gift_message')=='')  style="display: none;" @endif>
				              <div class="col-12">
				              	<label>Gift Message</label>
				                {{ Form::textarea(
				                    'gift_message',session()->get('gift_message'),
				                    ['class' => 'form-control textarea novalidate','rows' => 2,'placeholder' => trans('Add Message
				                      ')
				                    ]
				                  )
				                }}
				              </div>
				              <div class="col-12">
				              	<label>Gift From</label>
				                {{ Form::text(
				                    'gift_message_name','',
				                    ['class' => 'form-control novalidate', 'placeholder' => trans('Gift From
				                      ')
				                    ]
				                  )
				                }}
				              </div>
				            </div>
										<div class="row form-group">
							<?php  if($userAddress){ ?>
								<input type="hidden" name="payment_type" value="shipping">
							<?php } ?>
							<!-- <div class="col-sm-12">
								<label>Optional Recipient Information <span>(To send them order info when it ships)</span></label>
							</div> -->
							<?php /* if($userAddress){ ?>
							<div class="col-12">
						<input type="hidden" name="payment_type" value="shipping">
						<label for="one">Shipping Charges:</label><br>
						<input type="radio" class="ship_charge" name="shipping_charge" checked value="{{$shippingthree+$backcharge}}" required>
						<label for="one">One day Charge ({{$shippingthree+$backcharge}})</label><br>
						<input type="radio" class="ship_charge"  name="shipping_charge" value="{{$shippingtwo+$backchargetwo}}">
						<label for="two">Two day Charge ({{$shippingtwo+$backchargetwo}})</label><br>
						<input type="radio" class="ship_charge"  name="shipping_charge" value="{{$shippingone+$backchargethree}}">
						<label for="two">Three day Charge ({{$shippingone+$backchargethree}})</label><br>
							</div>
						<?php } */ ?>

							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<label>Email</label>
								{{ Form::email(
										'email',
										auth()->user()->email(),
										[
											'class' => 'form-control novalidate chk-input-style',
											'placeholder' => trans('Email'),
											'id' => 'email'
										]
									)
								}}
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12">
								<label>Phone</label>
								{{ Form::text(
										'phone',isset(auth()->user()->phone)?auth()->user()->phone:'',
										[
											'class' => 'form-control number-field novalidate chk-input-style',
											'maxlength' => '10',
											'placeholder' => trans('Phone'),
											'id' => 'phone'
										]
									)
								}}
							</div>
						</div>
						<?php
		          $taxamount=isset($tax->amount_to_collect)?$tax->amount_to_collect:0;
		            $shipping_charge=isset($resShippingFee)?number_format($resShippingFee):0;
              $commi=isset($shipping_comm->shipping_commission)?$shipping_comm->shipping_commission:0;
		           $grand_total=$price+$taxamount+$shipping_charge;
		          $grand_total1=$price+$taxamount+$shipping_charge;
             $cc= 100+$commi;
             $comtotal= $grand_total*$cc;
           $grand_total= $comtotal/100;
            $commission=$grand_total1*$commi;
              $coomission_price=$commission/100;
			     ?>
			     <?php

      		if(Session::get('discount')){

      			$discountprice=Session::get('discount');

      			$produc_price=$grand_total-$discountprice;
	      		}else{
	      		$discountprice=0;
	      		$produc_price=$grand_total;
	      		}

	      		if(Session::get('coupon_code')){
      			$coupon_code=Session::get('coupon_code');
	      		}else{
	      		$coupon_code='';
	      		}

      		 ?>
           <input type="hidden" class="commission" value="{{isset($shipping_comm->shipping_commission)?$shipping_comm->shipping_commission:''}}">
    			 <input type="hidden" class="pay_amount" name="payment_ammount" value="<?=$produc_price;?>">
    			 <input type="hidden" class="pay_amount_brfore" value="<?=$produc_price;?>">
    			 <input type="hidden" name="product_amount" value="<?=$price;?>">
    			 <input type="hidden" name="coupon_code" value="<?=$coupon_code;?>">
    			  <input type="hidden" name="discount_price" value="<?=number_format($discountprice,2);?>">
    			 <input type="hidden" class="shipping_charge" name="shipping_charge" value="<?=$shipping_charge;?>">
    			 <input type="hidden" name="tax_ammount" value="<?=$taxamount;?>">
    			  <input type="hidden" class="stripeToken" name="stripeToken">
    			
						<?php 
						if(session()->get('payment_button')=='payment_button'){ ?>
						<div class="row form-group">
							 <input type="hidden" name="payment_type" value="online">
							<div class="col-sm-4">
				
				<!-- <form action="" method="post">
				        <input class="payementbutton btn apply-btn"
				            type="submit" 
				            value="Pay with Card"
				            data-image="{{ WEBSITE_IMG_URL.'logo.png' }}" 
				            data-key="<?=env('STRIPE_PUBLIC_KEY');?>"
				            data-amount="<?=$produc_price*100;?>"
				            data-currency="{{CURRENCY}}"
				            data-name="Umami Square" data-description="Umami payment for <?=$produc_price;?>"/> 
				</form> -->


							</div>
							</div>
						
							<div class="row form-group">
							<div class="col-sm-12">
								<!-- <button onclick='formData("checkout", false, false, "{{ url('my-order') }}")'
                   
                    type="button"
                    class="btn apply-btn"
                >
                Save & Continue</button> -->
                  <div class="paybutton5">
              	 <?php
               
        foreach ($carts as $key => $carttotal) {

        $productrating=App::make('App\Http\Controllers\Frontend\CheckoutController')->restaurantLocation($carttotal->vendor_id);
        if($productrating['shipping']=='0'){
          $shipping_price='Free';
        }else{
          $resShippingFee+=$productrating['shipping'];
          $shipping_price='$'.$productrating['shipping'];
        }
        
        if($productrating['deliver_day']=='0'){
        $delivery_day='3';
        }else{
        $delivery_day=$productrating['deliver_day'];
        }
               ?>
      <div class="checkout-label-list">
         <?php
              $currentdate=date('Y-m-d');
              $time=$productrating['order_time'].":00:00";
            ?>
          
        <h2>Order For {{$productrating['location']}} from {{$productrating['restaurant_name']}}</h2>
        <h5>Item: {{isset($carttotal->product->title)?$carttotal->product->title:''}}</h5>
       {{--<p>Estimated Arrival: {{ date("D ,M d",strtotime($currentdate. ' + '.$delivery_day.' days')) }}<br/>
        Preparation Days: {{ $productrating['prparation_day'] }} days <br/>Order Time:  {{ date("g:i a", strtotime($time))}}
        </p>--}}
            <ul>
            
               <li>
                <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="customRadio"  value="customEx" checked>
              <label class="custom-control-label" for="customRadio">Product Shipping Fee<span>{{$shipping_price}}</span></label>
           </div>
              </li>
            
             
              
            </ul>
          
          </div>
<?php } ?>
              </div>

               <button class="paybutton btn apply-btn" type="submit" class="btn apply-btn" style="display: none;">
                Final Submit</button>
							</div>
						</div>
							<?php }else{ ?>
								<?php
                
				foreach ($carts as $key => $carttotal) {

				$productrating=App::make('App\Http\Controllers\Frontend\CheckoutController')->restaurantLocation($carttotal->vendor_id);
       // print_r($productrating);
				if($productrating['shipping']=='0'){
					$shipping_price='Free';
				}else{
           $resShippingFee+=$productrating['shipping'];
					$shipping_price='$'.$productrating['shipping'];
				}
				
				if($productrating['deliver_day']=='0'){
				$delivery_day='3';
				}else{
				$delivery_day=$productrating['deliver_day'];
				}
		      		 ?>
			<div class="checkout-label-list">
					 <?php
              $currentdate=date('Y-m-d');
              $time=$productrating['order_time'].":00:00";
            ?>
				<h2>Order For {{$productrating['location']}} from {!! $productrating['restaurant_name'] !!}</h2>
				<h5>Item: {{isset($carttotal->product->title)?$carttotal->product->title:''}}</h5>
			{{--<p>Estimated Arrival: {{ date("D ,M d",strtotime($currentdate. ' + '.$delivery_day.' days')) }}<br/>
        Preparation Days: {{ $productrating['prparation_day'] }} days <br/>
          Order Time:  {{ date("g:i a", strtotime($time))}}
        </p>--}}
		      	<ul style="display: none;">
		      	   <li>
		      		  <div class="custom-control custom-radio">
					    <input type="radio" class="custom-control-input" id="customRadio"  value="customEx" checked>
					    <label class="custom-control-label" for="customRadio">Product Shipping Fee<span>{{$shipping_price}}</span></label>
					 </div>
		      	  </li>
		      	</ul>
		      
	        </div>
<?php } ?>
					<a href="javascript:;" class="btn btn-primary calculate_shipping">Next</a>

					<div class="step2_content" style="display: none;">
						<div class="row">
		             <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
		            <label class="title">Card Number</label>
		            <input type="text" name="card_number" class="form-control" id="card_number" placeholder="1234 1234 1234 1234" value="" maxlength="16" autocomplete="off" required="" aria-required="true">
		          </div>
		        </div>       
		        <div class="row">
		          <div class="col-lg-8 col-md-8 col-sm-8 col-12">
		            <div class="form-group">
		              <label class="title">Expiry Date</label>
		              <div class="row">
		                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
		                <input type="text" name="card_exp_month" class="form-control" id="card_exp_month" placeholder="MM" value="" maxlength="2" required="" aria-required="true">
		              </div>
		              <div class="col-lg-6 col-md-6 col-sm-6 col-12">
		                <input type="text" name="card_exp_year" class="form-control" id="card_exp_year" placeholder="YYYY" value="" maxlength="4" required="" aria-required="true">
		              </div>
		              </div>             
		            </div>
		          </div>
		          <div class="col-lg-4 col-md-4 col-sm-4 col-12">
		            <div class="form-group">
		              <label class="title">CVC Code</label>
		              <input type="text" name="card_cvc" class="form-control" id="card_cvc" placeholder="CVC" value="" maxlength="3" autocomplete="off" required="" aria-required="true">
		            </div>
		          </div>
		        </div>
								 
							<div class="row form-group">
								<div class="col-12">
									<button
	                    onclick111='formData("checkout", false, false, "{{ url('checkout') }}")'
	                    onclick='formData("checkout", false, false, "{{ url('thank-you') }}")'
	                    type="button"
	                    class="btn apply-btn save-cont-btn"
	                >
	                <!-- Save & Continue -->Pay ${{ $produc_price+$resShippingFee }}</button>
								</div>
							</div>
						</div>
					<?php } ?>
					{{ Form::close() }}
				</div>
				

			<?php 
						if(session()->get('payment_button')=='payment_button'){ ?>
              <div class="paybutton4">
              	 <?php
               
        foreach ($carts as $key => $carttotal) {

        $productrating=App::make('App\Http\Controllers\Frontend\CheckoutController')->restaurantLocation($carttotal->vendor_id);
        if($productrating['shipping']=='0'){
          $shipping_price='Free';
        }else{
          $resShippingFee+=$productrating['shipping'];
          $shipping_price='$'.$productrating['shipping'];
        }
        
        if($productrating['deliver_day']=='0'){
        $delivery_day='3';
        }else{
        $delivery_day=$productrating['deliver_day'];
        }
               ?>
      <div class="checkout-label-list">
          <?php
              $currentdate=date('Y-m-d');
              $time=$productrating['order_time'].":00:00";
            ?>
        <h2>Order For {{$productrating['location']}} from {{$productrating['restaurant_name']}}</h2>
        <h5>Item: {{isset($carttotal->product->title)?$carttotal->product->title:''}}</h5>
       {{--<p>Estimated Arrival: {{ date("D ,M d",strtotime($currentdate. ' + '.$delivery_day.' days')) }}<br/>
        Preparation Days: {{ $productrating['prparation_day'] }} days <br/>
          Order Time:  {{ date("g:i a", strtotime($time))}}
        </p>--}}
            <ul>
            
               <li>
                <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="customRadio"  value="customEx" checked>
              <label class="custom-control-label" for="customRadio">Product Shipping Fee<span>{{$shipping_price}}</span></label>
           </div>
              </li>
            
             
              
            </ul>
          
          </div>
<?php } ?>
              </div>
			<h4 class="paybuttontitle">Payment Info</h4>
  <div class="cell example example3 paybutton2" id="example-3">

        <form>
        	<div class="fieldset">
            <div id="example3-card-number" class="field empty"></div>
            <div id="example3-card-expiry" class="field empty third-width"></div>
            <div id="example3-card-cvc" class="field empty third-width"></div>
          </div>
          <button type="submit" class="btn btn-dark" data-tid="elements_examples.form.pay_button">Pay ${{ $produc_price+$resShippingFee }}</button>
          <div class="error" role="alert">
            <span class="message"></span></div>
        </form>
        <div class="success">
          <div class="icon">
        
          </div>
          <h3 class="title" data-tid="elements_examples.success.title"></h3>
          <p class="message"><span data-tid="elements_examples.success.message"></span><span class="token"></span></p>
         
        </div>
 </div>
<?php }?>


			</div>



			<div class="col-lg-4 col-md-4 col-sm-4 col-12">
	     	<!-- 		 @include('frontend.cart.payment-element') -->
		  <div class="checkout-box positition-sticky">
		  <?php $rewart_point=0; $rewart_point=auth()->user()->reward_point; ?>
		  	<h2>Your Cart <!-- <a class="btn point-box" href="#">{{$rewart_point}} Points +</a> --></h2>
	     	<div class="checkout-cart-list item-table web-tbody">
	     	<!--  <h6>Order from PieCaken Bakeshop</h6> -->
	     	<table class="table">
				<!-- <thead>
					<tr>
						<th width="75%" style="padding-left: 10px;">Product</th>
						<th style="text-align: right;">Total</th>
					</tr>
				</thead> -->
				<tbody>
					@foreach($carts as $cart)
						<tr class="your-cart-item">
							<td>
								@if(!empty($cart->product->singleProductImage->image) && File::exists(PRODUCT_ROOT_PATH.$cart->product->singleProductImage->image))
									<?php $image = PRODUCT_URL.$cart->product->singleProductImage->image; ?>
								@else
									<?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
								@endif
								<div class="d-flex align-items-center">
									<div class="your-cart-pic">
										<img src="{{ $image }}">
									</div>
										<div class="your-cart-food-name">
											<a href="{{url('product-detail/'.$cart->product->slug)}}">	
												<h5>{{isset($cart->product->title)?$cart->product->title:''}}</h5>
											</a>
										</div>
								</div>

							</td>
							<td style="text-align: right;">
								<b>{{ CURRENCY }}{{number_format($cart->total,2)}}</b>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
	     	</div>

		   
			
      	@if(in_array(\Request::segment('1'), ['increase-decrease-item','cart','delete-cart-product']))
      		<h4>Delivery Charges</h4>
      		<h6>Free Delivery</h6>
      		<div class="calculate-charge">
      			<a href="#">Calculate Delivery Charge</a>
      		</div>
      		<div class="apply-coupon">
      			<h4>Apply Coupon Code</h4>
      			<div class="coupon-box">
      				<input type="text" class="form-control" placeholder="Coupon code">
      				<button class="btn apply-btn">Apply Coupon</button>
      			</div>
      		</div>
      	@endif
	
      	<ul class="food-price-sec pt-0">
      		<li class="d-flex justify-content-between align-items-center"><label>Subtotal</label><span>{{CURRENCY}}{{ number_format($price,2) }}</span></li>
      		<li class="{{ $discountprice == 0 ? '' : 'd-flex' }} justify-content-between align-items-center" style="{{ $discountprice == 0 ? 'display: none;' : '' }}"><label>Discount {{ $coupon_code != '' ? '(' . $coupon_code . ')' : '' }}</label><span>{{CURRENCY}}{{ number_format($discountprice,2) }}</span></li>
      		<li class="d-flex justify-content-between align-items-center"><label>Processing Fee</label><span>{{CURRENCY}}{{ number_format($coomission_price,2) }}</span></li>
      		<!-- <li class="d-flex justify-content-between align-items-center"><label>Shipping Charge</label><span class="shipdata">{{CURRENCY}}{{$resShippingFee}}</span></li>
      		<li class="d-flex justify-content-between align-items-center"><label>Processing Charge</label><span>{{CURRENCY}}{{$coomission_price}}</span></li> -->
      		<!-- <li><label>Discount</label><span>{{CURRENCY}}{{$discountprice}}</span></li> -->
      		
          <!--       		<li><label>Taxable Amount</label><span>{{CURRENCY}}{{$taxamount}}</span></li> -->
        	<!-- 	<li><label>Tax Rate</label><span>{{isset($tax->rate)?$tax->rate:0}} %</span></li> -->
      		<li class="d-flex justify-content-between align-items-center shipping_charge" style11="display: none;"><label>Shipping Charge</label><span class="payable_ammount111">$0.00</span></li>
      		<li class="d-flex justify-content-between align-items-center"><label>Payable Amount</label><span class="payable_ammount">{{CURRENCY}}{{ number_format(($price - $discountprice + $coomission_price), 2) }}</span></li>
      		<li class="d-flex justify-content-between align-items-center"><br></li>
      		<?php
      		$estimated_delivery_date = estimated_delivery_date(['restaurant' => $restaurant]);
			$delivery_date = date('m-d-Y', strtotime($estimated_delivery_date['delivery_date']));
      		?>
      		<li class="d-flex justify-content-between align-items-center"><label>Estimated Delivery Date</label><span>{{ $delivery_date }}</span></li>
      	</ul>

        	@if(in_array(\Request::segment('1'), ['increase-decrease-item','cart','delete-cart-product']))
        		<a href="{{ url('checkout') }}"> <button class="btn checkout-btn">Proceed to Checkout</button></a>
        		<div class="payment-method">
        			<h5>Accepted payment methods</h5>
        			<a href="#"><img src="{{url('images/mastercard.png')}}"></a>
        			<a href="#"><img src="{{url('images/visa.png')}}"></a>
        			<a href="#"><img src="{{url('images/american.png')}}"></a>
        			<a href="#"><img src="{{url('images/paypal.png')}}"></a>
        		</div>
        	@endif
        </div>
			</div>
		</div>
	</div>
</section>
<!-- <script src="https://checkout.stripe.com/v2/checkout.js"></script> -->
       <script type="text/javascript">
 if(sessionStorage.getItem('token_id_data')){
 //	alert(sessionStorage.getItem('token_id_data'));
 	$('.stripeToken').val(sessionStorage.getItem('token_id_data'));
 	 $('.paybutton').css('display','block');
 	 $('.paybutton5').css('display','block');
     $('.paybutton2').css('display','none');
      $('.paybutton4').css('display','none');
     $('.paybuttontitle').css('display','none');
 }
 else{
   $('.paybutton4').css('display','none');
 }
   $(".paybutton").click(function(){
   sessionStorage.removeItem('token_id_data');
  });
	(function() {
  'use strict';

  var elements = stripe.elements({
    fonts: [
      {
        cssSrc: 'https://fonts.googleapis.com/css?family=Quicksand',
      },
    ],
    // Stripe's examples are localized to specific languages, but if
    // you wish to have Elements automatically detect your user's locale,
    // use `locale: 'auto'` instead.
    locale: window.__exampleLocale,
  });

  var elementStyles = {
    base: {
     // color: '#fff',
      fontWeight: 600,
      fontFamily: 'Quicksand, Open Sans, Segoe UI, sans-serif',
      fontSize: '16px',
      fontSmoothing: 'antialiased',

      ':focus': {
        color: '#424770',
      },

      '::placeholder': {
        color: '#9BACC8',
      },

      ':focus::placeholder': {
        color: '#CFD7DF',
      },
    },
    invalid: {
      color: '#fff',
      ':focus': {
        color: '#FA755A',
      },
      '::placeholder': {
        color: '#FFCCA5',
      },
    },
  };

  var elementClasses = {
    focus: 'focus',
    empty: 'empty',
    invalid: 'invalid',
  };

  var cardNumber = elements.create('cardNumber', {
    style: elementStyles,
    classes: elementClasses,
  });
  cardNumber.mount('#example3-card-number');

  var cardExpiry = elements.create('cardExpiry', {
    style: elementStyles,
    classes: elementClasses,
  });
  cardExpiry.mount('#example3-card-expiry');

  var cardCvc = elements.create('cardCvc', {
    style: elementStyles,
    classes: elementClasses,
  });
  cardCvc.mount('#example3-card-cvc');

  registerElements([cardNumber, cardExpiry, cardCvc], 'example3');
})();
</script> 
       <!--  <script>
        $(document).ready(function() {
            $(':submit').on('click', function(event) {
                event.preventDefault();

                var $button = $(this),
                    $form = $button.parents('form');

                var opts = $.extend({}, $button.data(), {
                    token: function(result) {
                        $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
                    }
                });

                StripeCheckout.open(opts);
            });
        });
        </script> -->
<script type="text/javascript">
	$(document).ready(function() {
		 if( $('.ship_charge').is(":checked") ){ 
            var value = $('.ship_charge').val();
            $('.shipdata').text('{{CURRENCY}} '+value);
            $('.shipping_charge').val(value);
         var befor_amount = $('.pay_amount_brfore').val();
         var shicomm = parseInt($('.commission').val());
         var total_amount = (parseFloat(befor_amount) + parseFloat(value)).toFixed(2);
         var commission =100+shicomm;
         var totalshipp=parseFloat(commission*total_amount/100).toFixed(2);
         //alert(totalshipp);
            $('.pay_amount').val(totalshipp);
            $('.payable_ammount').text('{{CURRENCY}} '+totalshipp);
       
          $('.payementbutton').attr('data-amount', totalshipp*100);
           $('.payementbutton').attr('data-description', 'Umami payment for {{CURRENCY}}'+totalshipp);
        }
    $(".ship_charge").change(function(){ 
        if( $(this).is(":checked") ){ 
            var value = $(this).val();
            $('.shipdata').text('{{CURRENCY}} '+value);
            $('.shipping_charge').val(value);
         var befor_amount = $('.pay_amount_brfore').val();
         var shicomm = parseInt($('.commission').val());
         var total_amount = (parseFloat(befor_amount) + parseFloat(value)).toFixed(2);
         var commission =100+shicomm;
         var totalshipp=parseFloat(commission*total_amount/100).toFixed(2);
         //alert(total_amount);
            $('.pay_amount').val(totalshipp);
            $('.payable_ammount').text('{{CURRENCY}} '+totalshipp);
       
          $('.payementbutton').attr('data-amount', totalshipp*100);
           $('.payementbutton').attr('data-description', 'Umami payment for {{CURRENCY}}'+totalshipp);
        }
    });
      $('input[type="checkbox"]').click(function(){
       if($(this).prop("checked") == true){
           $('.gift_message').show();
        }
        else if($(this).prop("checked") == false){
           $('.gift_message').hide();
           $('.textarea[name="gift_message"], input[name="gift_message_name"]').val('');
        }
      
    });
});
</script>

<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click', '.calculate_shipping', function(){
			var first_name = $.trim($('form#checkout input[name="first_name"]').val());
			var last_name = $.trim($('form#checkout input[name="last_name"]').val());
			var country_id = $('form#checkout select[name="country_id"]').val();
			var country = $('form#checkout select[name="country_id"] option:selected').text();
			var street_address = $.trim($('form#checkout input[name="street_address"]').val());
			var address_line_2 = $.trim($('form#checkout input[name="address_line_2"]').val());
			var alternative_address = $.trim($('form#checkout textarea[name="alternative_address"]').val());
			var state_id = $('form#checkout select[name="state_id"]').val();
			var state = $('form#checkout select[name="state_id"] option:selected').text();
			var city = $.trim($('form#checkout input[name="city"]').val());
			var zip_code = $.trim($('form#checkout input[name="zip_code"]').val());
			var restaurant_id = '{{ $restaurant->id }}';
			var email_pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
			var error = 0;
			$('form#checkout .border-red').removeClass('border-red');
			if(first_name == "") {
		    $('form#checkout input[name="first_name"]').addClass('border-red');
		    error = 1;
		  }
		  if(last_name == "") {
		    $('form#checkout input[name="last_name"]').addClass('border-red');
		    error = 1;
		  }
		  if(country_id == "") {
		    $('form#checkout select[name="country_id"]').addClass('border-red');
		    error = 1;
		  }
		  if(street_address == "") {
		    $('form#checkout input[name="street_address"]').addClass('border-red');
		    error = 1;
		  }
		  if(state_id == "") {
		    $('form#checkout select[name="state_id"]').addClass('border-red');
		    error = 1;
		  }
		  if(city == "") {
		    $('form#checkout input[name="city"]').addClass('border-red');
		    error = 1;
		  }
		  if(zip_code == "") {
		    $('form#checkout input[name="zip_code"]').addClass('border-red');
		    error = 1;
		  }
		  if(error == 1) return false;
			$('.umami-loader').show();
			var data = new FormData();
			data.append('first_name', first_name);
			data.append('last_name', last_name);
      data.append('street_address', street_address);
      data.append('address_line_2', address_line_2);
      data.append('state_id', state_id);
      data.append('city', city);
      data.append('zip_code', zip_code);
      data.append('country_id', country_id);
      data.append('restaurant_id', restaurant_id);
      data.append('_token', $('meta[name="csrf-token"]').attr('content'));
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '{{ url('get_shipping_price') }}',
        data: data,
        processData: false,
        contentType: false,
        error: function(data) {
        	$('.umami-loader').hide();
        	
        },
        success: function(data) {
        	if(data.success) {
        		$('.umami-loader').hide();
        		var payment_ammount = parseFloat($('input[name="payment_ammount"]').val());
        		var shipping_charge = parseFloat($('input[name="shipping_charge"]').val());
        		var shipping_charge = shipping_charge + parseFloat(data.data.shipping_price);
        		payment_ammount += shipping_charge;
        		$('input[name="payment_ammount"]').val(payment_ammount);
        		$('input[name="shipping_charge"]').val(shipping_charge);
        		$('.shipping_charge span').text('$' + shipping_charge.toFixed(2));
        		if(shipping_charge > 0)
        			$('.shipping_charge').addClass('d-flex');
        		$('.payable_ammount').text('$' + payment_ammount.toFixed(2));
        		$('.save-cont-btn').text('Pay $' + payment_ammount.toFixed(2));
        		var address_html = '<h5><b>Name: </b>' + first_name + ' ' + last_name + '</h5>';
        		address_html += '<h5><b>Address: </b>' + street_address + ', ' + (address_line_2 != '' ? (address_line_2 + ', ') : '') + city + ', ' + state + ' ' + zip_code + ', ' + country + '</h5>';
        		$('.checkout_address_details.step2_content').html(address_html);
						$('.step1_content, .calculate_shipping').hide();
        		$('.step2_content').show();
        	} else {
        		alert(data.message);
        		location.reload();
        	}
        }
      });
		});

	});
</script>


@endsection