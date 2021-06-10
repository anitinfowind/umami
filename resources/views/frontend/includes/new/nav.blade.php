<?php $segment=Request::segment(1);
$segment2=Request::segment(2);
?>

<a class="scrollup" href="javascript:void(0);" aria-label="Scroll to top"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
<header class="header up">
  <div class="top-header w-100">
    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col-auto d-flex align-items-center flex-wrap top-block">
          <ul class="top-header-lft d-flex align-items-center">
            <li class="facebook11"><a target="_blank" href="{{ isset($setting->facebook) ? $setting->facebook :'javascript:void(0)' }}"><i class="fab fa-facebook-f"></i></a></li>
            <!-- <li class="twitter"><a target="_blank" href="{{ isset($setting->twitter) ? $setting->twitter : 'javascript:void(0)' }}"><i class="fab fa-twitter"></i></a></li>
            <li class="google-plus"><a target="_blank"href="{{ isset($setting->google) ? $setting->google : 'javascript:void(0)' }}"><i class="fab fa-google-plus"></i></a></li> -->
            <li class="instagram11"><a target="_blank" href="{{ isset($setting->instagram) ? $setting->instagram : 'javascript:void(0)' }}"><i class="fab fa-instagram"></i></a></li>
          </ul>
          <!-- <div class="top-header-call"> <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>+1 631 123 4567</a> </div> -->
        </div>
        <div class="col-auto">
          <ul class="top-header-rgt d-flex align-items-center">
          <?php 
		  
            /*<li class="dropdown"><a href="#" class="dropdown-toggle notification-dropdown" data-toggle="dropdown"><i class="fa fa-bell"></i>Notification 
              @if(auth()->check()) <sup> <span class="badge badge-light"> {{count(userNotification())}} </span> </sup> @endif </a> @if(auth()->check())
              <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
                @if(count(userNotification())>0)
                <div class="notification-heading">
                  <h4 class="menu-title">Notifications</h4>
                  <h4 class="menu-title pull-right">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                </div>
                <li class="divider"></li>
                <div class="notifications-wrapper"> @foreach(userNotification() as $notify) <a class="content" href="{{url('notification/view/'.$notify->id)}}">
                  <div class="notification-item">
                    <h4 class="item-title"> {{$notify->notification_text}} <span class="noti-time"> {{ Carbon\Carbon::parse($notify->created_at)->diffForHumans()}} </span></h4>
                    <!--  <p class="item-info">Marketing 101, Video Assignment</p> --> 
                  </div>
                  </a> @endforeach </div>
                <li class="divider"></li>
                <a href="{{url('notification/view/all')}}">
                <div class="notification-footer">
                  <h4 class="menu-title"> View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                </div>
                </a> @else
                <div class="notification-heading">
                  <h4 class="menu-title">Not found notification.</h4>
                </div>
                @endif
              </ul>
              @endif </li>*/
			  
			?>  
            <li> <a href="{{ url('cart') }}"><i class="fa fa-cart-arrow-down"></i>Cart <sup><span class="badge badge-light cart_count">{{ isset($orderCount) ? $orderCount : '' }}</span></sup> </a> </li>
            <!--<li><a href="#"><i class="far fa-heart"></i>Wishlist</a></li>--> 
            @if (! auth()->check())
            <li><a href="{{ url('register') }}"><i class="fa fa-sign-in"></i> Sign up</a></li>
            <li><a href="{{ url('login') }}"><i class="fa fa-sign-in"></i> Log in</a></li>
            <!-- <li><a href="{{ url('vendor-register') }}"><i class="fa fa-sign-in"></i> Vendor Sign Up</a></li> -->
            @else
            <li class="relative"><a class="dropdown-user" href="javascript:;"> 
              @if(auth()->user()->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.auth()->user()->slug.DS.auth()->user()->image()))
                  <img src="{{ USER_PROFILE_IMAGE_URL.auth()->user()->slug.DS.auth()->user()->image() }}">
              @else
                  <img src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
              @endif
              <!-- <img src="{{asset('public/latest/images/user-pic.png')}}" alt="">  -->
              My Account <i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-open" style="display: none;">
                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ url('/logout') }}">Log out</a></li>
              </ul>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="btm-header w-100">
    <div class="container">
      <div class="row align-items-center justify-content-between">
        <div class="logo p-h-15"> <a href="{{ url('/') }}"> <img src="{{ WEBSITE_IMG_URL."logo.png" }}" alt=""> </a> </div>
        <div class="col d-flex align-items-center">
          <div class="navArea">
            <nav id="res_nav" class="navigation">
              <button id="menu_res" class="menu-responsive"> <span></span> <span></span> <span></span> </button>
              <ul class="d-flex justify-content-between">
                <li <?php if($segment==''){?>class="active" <?php } ?>> <a href="{{ url('/') }}">HOME</a> </li>
                <!-- <li <?php if($segment=='products'){?>class="active" <?php } ?>> <a href="{{ url('products') }}">MEALKIT</a> </li> -->
                @if($categorys->isNotEmpty())
                <li class="sub_menu_open"> <a class="spl-food" href="javascript:;">JAPANESE MEAL <i class="fa fa-caret-down"></i></a>
                  <ul>
                    <li><a class="nav-link" href="{{url('products')}}">ALL( 全て)</a></li>
                    @foreach($categorys as $category)
                    <!-- <li><a class="nav-link" href="{{url('products/?category='.$category->slug)}}">{{$category->name}}</a></li> -->
                    <li><a class="nav-link" href="{{url('products/?cat='.$category->id)}}">{{$category->name}}</a></li>
                    @endforeach
                  </ul>
                </li>
                @endif
                <!-- <li <?php if($segment=='restaurant'){?>class="active upto992" <?php } else { ?> class="upto992" <?php  } ?>> <a href="{{ url('restaurant') }}">RESTAURANT</a> </li> -->
                <!-- <li <?php if($segment=='all-chefs'){?>class="active" <?php } ?>> <a href="{{ url('all-chefs') }}">CHEF</a> </li>
                <li <?php if($segment=='event'){?>class="active" <?php } ?>> <a href="{{ url('event') }}">EVENT</a> </li> -->
                <!-- <li class="sub_menu_open"> <a href="javascript:;">ABOUT <i class="fa fa-caret-down"></i></a>
                  <ul>
                    <li><a class="nav-link" href="{{url('pages/mission')}}">About Us</a></li>
                    <li><a class="nav-link" href="{{url('pages/about')}}">How It Works</a></li>
                    <li><a class="nav-link" href="{{url('contact-us')}}">Contact</a></li>
                  </ul>
                </li> -->
                <li <?php if($segment=='pages' && $segment2=='about'){?>class="active" <?php } ?>> <a href="{{ url('pages/about') }}">HOW IT WORKS</a> </li>
                <li <?php if($segment=='pages' && $segment2=='mission'){?>class="active" <?php } ?>> <a href="{{ url('pages/mission') }}">ABOUT US</a> </li>
                <li <?php if($segment=='contact-us'){?>class="active" <?php } ?>> <a href="{{ url('contact-us') }}">CONTACT</a> </li>
                @if (! auth()->check())
                <li class="mobShow"><a href="{{ url('register') }}"><i class="fa fa-sign-in"></i> Sign up</a></li>
                <li class="mobShow"><a href="{{ url('login') }}"><i class="fa fa-sign-in"></i> Log in</a></li>
                @else
                <li class="mobShow"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="mobShow"><a href="{{ url('/logout') }}">Log out</a></li>
                @endif
                
              </ul>
            </nav>
          </div>
        </div>
        <div class="searchAreaMob p-h-15 relative">
          <ul class="d-flex">
            <li><a href="{{ url('cart') }}"><i class="fa fa-cart-arrow-down"></i><span class="badge badge-light cart_count">{{ isset($orderCount) ? $orderCount : '' }}</span> </a></li>
            <li><a href="javascript:;" class="open_search"><i class="fa fa-search"></i></a></li>
          </ul>
          
        </div>

        <div class="search-area p-h-15 relative">
          <form method="get" action="{{url('products')}}">
            <input type="text" class="form-control search-input-style" name="search" placeholder="Ramen Sushi Sweet" value="{{ $_GET['search'] ?? '' }}">
            <i class="fa fa-search" aria-hidden="true" onclick="$(this).closest('form').submit();"></i>
          </form>
        </div>
        <div class="top-mobile-menu">
          <button><i class="fas fa-ellipsis-v"></i></button>
        </div>
      </div>
    </div>
    <div class="srcInputArea" style11="display: block">
      <form action="{{ url('/products') }}">
        <input type="text" name="search" id="" class="srcInput" value="{{ $_GET['search'] ?? '' }}" />
        <button class="srcInputBtn" onclick="$(this).closest('form').submit();"><i class="fa fa-search"></i></button>
      </form>
    </div>
  </div>
</header>
