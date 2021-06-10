@extends('frontend.layouts.app')
@section('content')
<div class="inner-breadcrumbs-menu">
  <div class="container">
  <ul>
    <li><a href="#">Home</a><i class="fa fa-angle-right"></i></li>
    <li><a href="#"> Seafood Markets</a><i class="fa fa-angle-right"></i></li>
    <li><span>Maine Lobster Roll Kit - 4 Pack</span></li>
  </ul>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div id="c-carousel">
            <div id="wrapper">
              <div id="inner">
                <div id="caroufredsel_wrapper2">
                  <div id="carousel">
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                    <img src="{{url('images/explore1.png')}}" alt=""/>
                  </div>
                  <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
                </div>
                <div id="pager-wrapper">
                  <div id="pager">
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                    <img src="{{url('images/explore1.png')}}" width="120" height="72" alt=""/>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <button id="prev_btn2" class="prev2"><img src="{{url('images/spacer.png')}}" alt=""/></button>
              <button id="next_btn2" class="next2"><img src="{{url('images/spacer.png')}}" alt=""/></button>
            </div>
          </div>
    </div>
    <div class="col-md-6">
      <div class="gift-description">
        <h2>Grandma's Famous Coffee Cake - 3 Pack</h2>
        <span>Xyz Bakery</span>
        <div class="rating-stars">
           <div class="rating-star">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                  </div>
                  <span class="pro-rating">59 reviews</span>
                </div>
                <h6>Calories: 5.00 </h6>
              <div class="product_price">
                <h3>$59.95</h3>
              </div>
              <div class="product__quantity">
          <label for="cart_item_quantity">Quantity:</label>
          <div class="form__select">
             <input type="text" class="form-control" placeholder="1">
          </div>
          <button class="btn cart-btn">Add to Cart</button>
        </div>
        <div class="discription">
          <h4>Description</h4>
          <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        </div>
        <div class="product-info">
            <h4>Product Info</h4>
            <div id="accordion" class="accordion">
                <div class="card mb-0">
                    <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                        <a class="card-title"> Ingredients </a>
                    </div>
                    <div id="collapseOne" class="card-body collapse" data-parent="#accordion">
                        <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                    <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <a class="card-title"> Nutrition </a>
                    </div>
                    <div id="collapseTwo" class="card-body collapse" data-parent="#accordion">
                        <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                    <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <a class="card-title"> Product Details </a>
                    </div>
                    <div id="collapseThree" class="collapse card-body" data-parent="#accordion">
                          <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
      </div>
      </div>
    </div>

         <div class="featured-dish">
        <div class="container">
          <div class="product-section">
              <h2>Recommended for you</h2>
              <div class="row">
                <div class="owl-demo">
                  <div class="item">
                    <div class="product-box col-sm-12">
                      <div class="product-img-box">
                        <div class="product-img">
                          <img src="{{url('images/product15.jpg')}}">
                        </div>
                        <div class="view-detail">
                          <button class="btn view-btn">View Details</button>
                        </div>
                        <div class="cart-d">
                             <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
                          </div>
                      
                      <div class="product-detail">
                        <h4>Chicken Rice</h4>
                        <p>American, Fast Food</p>
                        <b>$59</b>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="product-box col-sm-12">
                      <div class="product-img-box">
                        <div class="product-img">
                          <img src="{{url('images/product16.jpg')}}">
                        </div>
                        <div class="view-detail">
                          <button class="btn view-btn">View Details</button>
                        </div>
                        <div class="cart-d">
                             <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
                          </div>
                      
                      <div class="product-detail">
                        <h4>Beef Food</h4>
                        <p>American, Fast Food</p>
                        <b>$59</b>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="product-box col-sm-12">
                      <div class="product-img-box">
                        <div class="product-img">
                          <img src="{{url('images/product17.jpg')}}">
                        </div>
                        <div class="view-detail">
                          <button class="btn view-btn">View Details</button>
                        </div>
                        <div class="cart-d">
                             <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
                          </div>
                      
                      <div class="product-detail">
                        <h4>Veg Roll</h4>
                        <p>American, Fast Food</p>
                        <b>$59</b>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="product-box col-sm-12">
                      <div class="product-img-box">
                        <div class="product-img">
                          <img src="{{url('images/product18.jpg')}}">
                        </div>
                        <div class="view-detail">
                          <button class="btn view-btn">View Details</button>
                        </div>
                        <div class="cart-d">
                             <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
                          </div>
                      
                      <div class="product-detail">
                        <h4>Chicken Drumsticks</h4>
                        <p>American, Fast Food</p>
                        <b>$59</b>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="product-box col-sm-12">
                      <div class="product-img-box">
                        <div class="product-img">
                          <img src="{{url('images/product19.jpg')}}">
                        </div>
                        <div class="view-detail">
                          <button class="btn view-btn">View Details</button>
                        </div>
                        <div class="cart-d">
                             <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
                          </div>
                      
                      <div class="product-detail">
                        <h4>Pasta & Pizza</h4>
                        <p>American, Fast Food</p>
                        <b>$59</b>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="product-box col-sm-12">
                      <div class="product-img-box">
                        <div class="product-img">
                          <img src="{{url('images/product20.jpg')}}">
                        </div>
                        <div class="view-detail">
                          <button class="btn view-btn">View Details</button>
                        </div>
                        <div class="cart-d">
                             <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
                          </div>
                      
                      <div class="product-detail">
                        <h4>Meat Special Lasagna</h4>
                        <p>American, Fast Food</p>
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

      <footer>
        <div class="footer">
          <div class="container">
            <div class="newsletter-section">
              <div class="row">
                <div class="col-sm-8">
                  <div class="newsletter-left">
                    <h4>Sign up for our newsletter</h4>
                    <div class="input-box">
                      <input type="text" class="form-control" placeholder="Enter your email...">
                      <button class="btn subscribe-btn">Subscribe</button>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="social-footer">
                    <ul>
                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                      <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3">
                <div class="footer-title">
                  <h4>Get to Know</h4>
                  <ul>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Socialize</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="footer-title">
                  <h4>Let Us Help You</h4>
                  <ul>
                    <li><a href="#">Account Details</a></li>
                    <li><a href="#">Order History</a></li>
                    <li><a href="#">Find restaurant</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Track order</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="footer-title">
                  <h4>Doing Business</h4>
                  <ul>
                    <li><a href="#">Suggest an Idea</a></li>
                    <li><a href="#">Be a Partner restaurant</a></li>
                    <li><a href="#">Create an Account</a></li>
                    <li><a href="#">Help</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="footer-title">
                  <h4>Contact us</h4>
                  <p><span><i class="fa fa-home"></i></span> Street #156 Burbank, Studio City
                Hollywood, California USA </p>
                <p><span><i class="fa fa-phone"></i></span> +91 1234567890 </p>
                <p><span><i class="fa fa-envelope"></i></span> support@UmamiSquare.com</p>
              </div>
            </div>
          </div>
          <div class="copyright">
            <p>Copyright@ 2020 Umami Square . All Rights Reserved. </p>
          </div>
        </div>
      </div>
  
<script type="text/javascript">
        var width = 100;
        var animation_speed = 800;
        var time_val = 5000;
        var current_slide = 1;
        var $sliderText = $('#sliderText');
        var $slide_container = $('.slides');
        var $slides = $('.slide');
        var interval;
        $slides.each(function(index){
        $(this).css('left',(index*100)+'%');
        });
        function startsliderText() {
        interval = setInterval(function() {
        $slide_container.animate({'left': '-='+(width+'%')}, animation_speed, function() {
        if (++current_slide === $slides.length) {
        current_slide = 1;
        $slide_container.css('left', 0);
        }
        });
        }, time_val);
        }
        startsliderText();
        </script>
    
    <script>
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
@section('after-scripts')
<script src="{{url('js/jquery.carouFredSel-6.2.1-packed.js')}}"></script>
  <script src="{{url('js/initialize-carousel-detailspage.js')}}"></script>

@endsection