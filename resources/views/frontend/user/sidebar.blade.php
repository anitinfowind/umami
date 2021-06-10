<?php $segment = \Request::segment(1); $segment2 = \Request::segment(2); ?>

<div class="col-md-3">
  <div class="dash-left-side">
    <div class="menu-toggle"> <span><i class="fa fa-angle-right"></i></span> </div>
    <div class="user-profile"> <a type="button" class="btn btn-lg" data-toggle="modal" data-target="#myModal"> @if(auth()->user()->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.auth()->user()->slug.DS.auth()->user()
      ->image())) <img class="media-object" src="{{ USER_PROFILE_IMAGE_URL.auth()->user()->slug.DS.auth()->user()->image() }}"> @else <img class="media-object" src="{{ WEBSITE_IMG_URL }}profile-user-img.png"> @endif </a>
      <div class="">
        <h5>{{ auth()->user()->name }}</h5>
        <h6>{{ auth()->user()->email }}</h6>
        <h6> Joined {{ auth()->user()->created_at->format('F jS, Y') }} </h6>
      </div>
    </div>
    <div class="dash-list">
      <ul>
        @if(auth()->user()->isVender())
        <li class="@if($segment === 'dashboard') active @endif"> <a  href="{{ url('dashboard') }}"> <i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard </a> </li>
        @endif
        <li class="@if($segment === 'account') active @endif"> <a href="{{ url('account') }}"> <i class="fa fa-user" aria-hidden="true"></i> My Accounts </a> </li>
        @if(auth()->user()->isUser())
        <li class="@if($segment === 'my-order') active @endif"> <a href="{{ url('my-order') }}"> <i class="fa fa-tachometer" aria-hidden="true"></i> My Order </a> </li>
        @else 
        <!-- <li class="@if($segment === 'today-order-pickup') active @endif">
						<a href="{{ url('today-order-pickup') }}">
							<i class="fa fa-tachometer" aria-hidden="true"></i> Today Order
						</a>
					</li> -->
        <li class="@if($segment === 'order') active @endif"> <a href="{{ url('order') }}"> <i class="fa fa-tachometer" aria-hidden="true"></i> Order </a> </li>
        @endif
        
        
        @if(auth()->user()->isVender())
       <!-- <li class="@if($segment === 'payment-history') active @endif"> <a href="{{ url('payment-history') }}"> <i class="fa fa-money" aria-hidden="true"></i> Payment History </a> </li>-->
        <li class="@if($segment === 'restaurant' && $segment2 == 'info') active @endif"> <a href="{{ url('restaurant/info') }}"> <i class="fa fa-cutlery" aria-hidden="true"></i> Restaurant Info </a> </li>
        
        <!-- <li class="@if($segment === 'restaurant' && $segment2 === 'shipping-info') active @endif">
						<a href="{{ url('restaurant/shipping-info') }}">
							<i class="fa fa-cubes" aria-hidden="true"></i> Shipping Info
						</a>
					</li> --> 
        
        @if(auth()->user()['isApprovedRestaurant']) 
        <!-- <li class="@if($segment === 'branch') active @endif">
							<a href="{{ url('branch') }}">
								<i class="fa fa-bars" aria-hidden="true"></i> Branches
							</a>
						</li> -->
        <li class="@if(in_array($segment, ['product-manager','add-product','edit-product'])) active @endif"> <a href="{{ url('product-manager') }}"> <i class="fa fa-product-hunt" aria-hidden="true"></i> Product </a> </li>
        <li class="@if(in_array($segment, ['chefs','add-chef','edit-chef'])) active @endif"> <a href="{{ url('chefs') }}"> <i class="fa fa-product-hunt" aria-hidden="true"></i> Chefs </a> </li>
        @endif
        @endif
        @if(auth()->user()->isManager())
        <li class="@if(in_array($segment, ['product-manager','add-product','edit-product'])) active @endif"> <a href="{{ url('product-manager') }}"> <i class="fa fa-product-hunt" aria-hidden="true"></i> Product </a> </li>
        <li class="@if(in_array($segment, ['chefs','add-chef','edit-chef'])) active @endif"> <a href="{{ url('chefs') }}"> <i class="fa fa-product-hunt" aria-hidden="true"></i> Chefs </a> </li>
        @endif
        @if(auth()->user()->isVender())
            <li class="@if(in_array($segment, ['sales'])) active @endif"> <a href="{{ url('sales') }}"> <i class="fa fa-cubes" aria-hidden="true"></i> Sales Report </a> </li>
        @endif
        @if(auth()->user()->isManager() || auth()->user()->isVender()) 
        <!-- <li class="@if($segment === 'site-setting') active @endif">
				 	  <a href="{{ url('site-setting') }}">
						  <i class="fa fa-table"></i>Site Setting
				  	</a>
			  	</li> -->
        <li  class="@if($segment === 'review-list') active @endif"> <a href="{{url('review-list')}}"> <i class="fa fa-heart-o" aria-hidden="true"></i> Review </a> </li>
        <!-- <li class="@if(in_array($segment, ['coupon','add-coupon','edit-coupon'])) active @endif">
				   		<a href="{{ url('coupon')}}">
							<i class="fa fa-credit-card-alt" aria-hidden="true"></i> Coupon
						</a>
				  	</li> --> 
        @endif
        @if(auth()->user()->isUser())
        <li class="@if(in_array($segment, ['address','add-address','edit-address'])) active @endif"> <a href="{{ url('address') }}"> <i class="fa fa-user" aria-hidden="true"></i> Address </a> </li>
        <li class="@if(in_array($segment, ['rewards'])) active @endif"> <a href="{{ url('rewards') }}"> <i class="fa fa-database" aria-hidden="true"></i> Rewards </a> </li>
        <li class="@if($segment==='e-notification')) active @endif"> <a href="{{ url('e-notification') }}"> <i class="fa fa-envelope" aria-hidden="true"></i> Email-Notification </a> </li>
        <!-- <li  class="@if($segment === 'rewards') active @endif"> <a href="{{url('rewards')}}"> <i class="fa fa-heart-o" aria-hidden="true"></i> Rewards </a> </li> -->
        <!-- <li  class="@if($segment === 'review') active @endif"> <a href="{{url('review')}}"> <i class="fa fa-heart-o" aria-hidden="true"></i> Review </a> </li> -->
        @endif
        <!--<li class="@if($segment === 'notification') active @endif"> <a href="{{ url('notification') }}"> <i class="fa fa-bell" aria-hidden="true"></i> Notification </a> </li>-->
        <li class="@if($segment === 'wish-list') active @endif"> <a href="{{ url('wish-list') }}"> <i class="fa fa-heart-o" aria-hidden="true"></i> Wish List </a> </li>
        <li> <a href="{{ url('logout') }}"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a> </li>
      </ul>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
    	var removeClass = true;
		$(".menu-toggle").click(function() {
		  $(".side-navmenu").toggleClass('menu-open');
		  removeClass = false;
		});
		$("html").click(function() {
		  if (removeClass) {
		    $(".side-navmenu").removeClass('menu-open');
		  }
		  removeClass = true;
		});
    });
</script> 
