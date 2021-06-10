@extends('frontend.layouts.app')
@section('content')
    <div class="inner-breadcrumbs-menu">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
                <li><span>Features</span></li>
            </ul>
        </div>
    </div>
    @if(isset($pages) && !empty($pages))
  <div class="wdo bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>{{$pages->title}}</h2>
          <p>
            {!!$pages->description!!}</p>
        </div>
      </div>
    </div>
  </div>
  @else
    <div class="menu-detail-banner">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3">
                    <h1>Features</h1>
                </div>
                <div class="col-12 col-sm-9">
                    <div class="spec-description">
                        <p>Lorem ipsum netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="features">
            <div class="row">
                <div class="col-md-3">
                    <div class="fea-bx">
                        <img src="images/fast.png">
                        <h4>Fast Delivery</h4>
                        <p>Lorem ipsum dolar sit amet.Aenean imperdiet aliquet hendrerit.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="fea-bx">
                        <img src="images/fresh-food.png">
                        <h4>Fresh Food</h4>
                        <p>Lorem ipsum dolar sit amet.Aenean imperdiet aliquet hendrerit.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="fea-bx">
                        <img src="images/chef.png">
                        <h4>Experienced Chefs</h4>
                        <p>Lorem ipsum dolar sit amet.Aenean imperdiet aliquet hendrerit.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="fea-bx">
                        <img src="images/dish.png">
                        <h4>A Variety of Dishes</h4>
                        <p>Lorem ipsum dolar sit amet.Aenean imperdiet aliquet hendrerit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="featured-dish">
        <div class="container">
            <div class="product-section">
                <div class="container">
                    <h2>Our Featured Dishes</h2>
                    <div class="row">
                        <div class="owl-demo">
                            <div class="item">
                                <div class="product-box col-sm-12">
                                    <div class="product-img-box">
                                        <div class="product-img">
                                            <img src="images/product15.jpg">
                                        </div>
                                        <div class="view-detail">
                                            <button class="btn view-btn">View Details</button>
                                        </div>
                                    
                                    <div class="product-detail">
                                        <h4>Chicken Rice</h4>
                                        
                                        <b>$59</b>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product-box col-sm-12">
                                    <div class="product-img-box">
                                        <div class="product-img">
                                            <img src="images/product16.jpg">
                                        </div>
                                        <div class="view-detail">
                                            <button class="btn view-btn">View Details</button>
                                        </div>
                                    
                                    <div class="product-detail">
                                        <h4>Beef Food</h4>
                                        
                                        <b>$59</b>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product-box col-sm-12">
                                    <div class="product-img-box">
                                        <div class="product-img">
                                            <img src="images/product17.jpg">
                                        </div>
                                        <div class="view-detail">
                                            <button class="btn view-btn">View Details</button>
                                        </div>
                                    
                                    <div class="product-detail">
                                        <h4>Veg Roll</h4>
                                        
                                        <b>$59</b>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product-box col-sm-12">
                                    <div class="product-img-box">
                                        <div class="product-img">
                                            <img src="images/product18.jpg">
                                        </div>
                                        <div class="view-detail">
                                            <button class="btn view-btn">View Details</button>
                                        </div>
                                    
                                    <div class="product-detail">
                                        <h4>Chicken Drumsticks</h4>
                                        
                                        <b>$59</b>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product-box col-sm-12">
                                    <div class="product-img-box">
                                        <div class="product-img">
                                            <img src="images/product19.jpg">
                                        </div>
                                        <div class="view-detail">
                                            <button class="btn view-btn">View Details</button>
                                        </div>
                                    
                                    <div class="product-detail">
                                        <h4>Pasta & Pizza</h4>
                                        
                                        <b>$59</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product-box col-sm-12">
                                    <div class="product-img-box">
                                        <div class="product-img">
                                            <img src="images/product20.jpg">
                                        </div>
                                        <div class="view-detail">
                                            <button class="btn view-btn">View Details</button>
                                        </div>
                                    
                                    <div class="product-detail">
                                        <h4>Meat Special Lasagna</h4>
                                        
                                        <b>$59</b>
                                  </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="menu-list" class="menu-list">
        <div class="container">
            <h2 class="mb-4">Our Featured Dishes Menu</h2>
            <div id="moreMenuContent">
                <div class="row">
                    <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">French Bread</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$149.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Italian Bread</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$149.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Regular Bread</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$149.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Regular Tea</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$20.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Garlic Tea</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$30.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Black Coffee</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$40.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Bacon</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$70.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Sausage</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$50.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                        <div class="row">
                           <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Chicken Balls</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$90.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                         <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Chicken Balls</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$90.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Bacon</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$70.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="menu-item">
                                <h3 class="menu-title">Sausage</h3>
                                <p class="menu-about">Lorem Ipsum dalar sit amet</p>
                                <div class="menu-system">
                                    <div class="half">
                                        <p class="price">$50.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a id="" class="btn more-btn">Load More </a>
            </div>
        </div>
    </section>
    <div class="wdo bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Little things make us best in town</h2>
                    <p>Lorem ipsum netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit. Nunc interdum ullamcorper lectus et pellentesque enim interdum at. Suspendisse malesuada dignissim facilisis ligula rutrum sed.Dolor nunc vule putateulr ips dol consec.</p>
                    <p>Donec semp ertet lacinia ultri cie upien disse comete dolo lectus fgilla itollicil tua ludin dolor nec met quam accumsan dolore condime netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet.</p>
                    <div class="">
                        <button class="btn order-btn">Read More</button>
                    </div>
                </div>
                <div class="col-md-6 my-auto">
                  <img src="images/features-bottom.png" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    @endif
  <script type="text/javascript">
    $('.owl-demo').owlCarousel({
      items: 4,
      itemsDesktop : [1199, 4],
      itemsDesktopSmall : [991, 3],
      itemsTablet : [768, 2],
      itemsTabletSmall : false,
      itemsMobile : [479, 2],
      navigation : true,
      pagination : false,
      navigationText : ["",""],
    });
  </script>
@endsection