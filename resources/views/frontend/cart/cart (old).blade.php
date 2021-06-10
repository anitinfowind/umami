@extends('frontend.layouts.layout')
@section ('title', trans('cart'))
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Cart</li>
    </ol>
  </div>
</nav>

<section>
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<!-- <ul class="d-flex">
				<li><a href="{{url('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>Your Cart</span></li>
			</ul> -->
		</div>
	</div>
</section>
<section class="cart-section">
	<div class="container">
		<div class="row record">
			@if($carts->isNotEmpty())
				<div class="col-lg-8 col-md-8 col-sm-8 col-12">
					<div class="item-table web-tbody table-gap">
						@include('frontend.cart.cart-element')
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-12 pay_ele">
					@include('frontend.cart.payment-element')
				</div>
			@else
			   <div class="empty-cart-item">
			   	 <div class="cart-img">
					<img src="{{ WEBSITE_IMG_URL.'cart-img.jpg' }}">
				 </div>
				 <h4>Empty Cart items?</h4>
				 
			  </div>
			@endif
		</div>
	</div>
</section>

@endsection