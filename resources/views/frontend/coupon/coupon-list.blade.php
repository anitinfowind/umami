@extends('frontend.layouts.app')
@section ('title', trans('coupon'))
@section('content')
<div class="inner-breadcrumbs-menu">
  <div class="container">
  <ul>
  	<li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
  	<li><span>Coupon</span></li>
  </ul>
</div>
</div>
<div class="u-menu">
	<div class="container">
		<div class="food-menu-tab">
		  	<div class="row">
          @if($couponlists->isNotEmpty())
           @foreach($couponlists as $couponlist)
  		  		<div class="col-md-3">
  		  			<div class="offer-box">
  		  				<div class="coupon-inner">
		  					  @if(!empty($couponlist->discount))
                     <h3 class="coupon-title">{{$couponlist->discount}}% OFF</h3>
                     <div class="cp-data"> {!!$couponlist->description!!}</div>
                  @else
                      <h3 class="coupon-title discount_per">Minimum price Rs {{$couponlist->min_price}}</h3>
                     <div class="cp-data">{{$couponlist->description}}</div>   
                  @endif
  		  					<div class="coupon-btn">
  						  	<span class="">{{strtoupper($couponlist->coupon_code)}}</span>
  						  </div>
  		  				</div>
  		  			</div>
  		  		</div>
           @endforeach 
           @else
            <img src="{{WEBSITE_IMG_URL.'no-offer.jpg'}}">
          @endif 
      	</div>
      </div>
    </div>
  </div>

<!-- The Modal -->
<div class="modal coupon-modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">New User – Flat 50% Off On 1st Order, Minimum Order Value Of Rs.500</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body coupon-data">
        <h5>Copy The Below Coupon & Apply It At The Time Of Payment</h5>

        <div class="code-coupon">
        	<h2>#57678DFG</h2>
        </div>

        <div class="coupon-card">
        	<img src="images/coupon.png">
        </div>
      </div>

    </div>
  </div>
</div>
@endsection