<div class="main-box">
    <div class="topbar">
        <div class="container-fluid">
            <div class="top-left">
               {{-- <ul>
                    <li><a href="{{ url('about') }}">About Us</a></li>
                    <li><a href="{{ url('corporate-gift') }}">Corporate Gifts</a></li>
                    <li><a href="javascript:void(0)">Customer Care</a></li>
                    <li><a href="{{url('coupons')}}">Offers/Coupons</a></li>
                </ul>--}}
            </div>
            <div class="top-right">
                <ul>
                    @if (! auth()->check())
                        <li><a href="{{ url('register') }}">Sign up</a></li>
                        <li><a href="{{ url('login') }}">Log in</a></li>
                        <li><a href="{{ url('vendor-register') }}">Vendor Sign Up</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if(auth()->user()->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.auth()->user()->slug.DS.auth()->user()->image()))
                                    <img class="img-circle user-img" src="{{ USER_PROFILE_IMAGE_URL.auth()->user()->slug.DS.auth()->user()->image() }}">
                                @else
                                    <img class="img-circle user-img" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
                                @endif
                                {{ auth()->user()->fullName() }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                 @if (auth()->user()->isAdmin())
                                    <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                                 @else
                                    <li><a href="{{ url('dashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ url('account') }}">My Accounts</a></li>
                                    @if (auth()->user()->isUser())
                										<li><a href="{{ url('my-order') }}">My Order</a></li>
                										<li><a href="{{ url('address') }}">Address</a></li>
                									@else
                										<li><a href="{{ url('order') }}">Order</a></li>
                									@endif	
                                      @if (auth()->user()->isVender() || auth()->user()->isManager())
                                        <li><a href="{{ url('product-manager') }}">Product</a></li>
                                      @endif
                									<li><a href="{{ url('notification') }}">Notification</a>
                                  </li>
                                  <li>
                                    <a href="{{ url('wish-list') }}">Wish List</a>
                                  </li>
                                  @endif
                                  <li>
                                      <a href="{{ url('logout') }}">Logout</a>
                                  </li>
                          </ul>
                        </li>
                    @endif
                    <?php 
					/*<li class="dropdown"><a href="#" class="dropdown-toggle notification-dropdown" data-toggle="dropdown"><i class="fa fa-bell"></i> 
                      @if(auth()->check())
                        <sup>
                          <span class="badge badge-light">
                             {{count(userNotification())}}
                           </span>
                        </sup>
                      @endif
                      </a>
                      @if(auth()->check())
                        <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">
                          @if(count(userNotification())>0)
                            <div class="notification-heading"><h4 class="menu-title">Notifications</h4><h4 class="menu-title pull-right">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                            </div>
                            <li class="divider"></li>
                           <div class="notifications-wrapper">
                           
                           @foreach(userNotification() as $notify)
                             <a class="content" href="{{url('notification/view/'.$notify->id)}}">
                               <div class="notification-item">
                                <h4 class="item-title">
                                {{$notify->notification_text}} <span class="noti-time">  {{ Carbon\Carbon::parse($notify->created_at)->diffForHumans()}} </span></h4>
                               <!--  <p class="item-info">Marketing 101, Video Assignment</p> -->
                              </div>
                            </a>
                            @endforeach
                            
                           </div>
                            <li class="divider"></li>
                          <a href="{{url('notification/view/all')}}">  <div class="notification-footer"><h4 class="menu-title"> View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4></div></a>
                            @else
                            <div class="notification-heading"><h4 class="menu-title">Not found notification.</h4>
                            </div>
                            @endif

                        </ul>
                      @endif
                    </li>*/
					?>
                    <li>
          						<a href="{{ url('cart') }}"><i class="fa fa-cart-arrow-down"></i>
          							<sup><span class="badge badge-light cart_count">{{ isset($orderCount) ? $orderCount : '' }}</span></sup>
          						</a>
          					</li>
                </ul>
            </div>
        </div>
    </div>
</div>