@extends('frontend.layouts.layout')
@section('content') 
@include('frontend.includes.new.about_slider')
<?php 
$useronly='';
if(auth()->user()){
    $useronly = auth()->user()->isUser();
}
?>
<section class="history-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="history-left-box">
          <h2>A History Has Written For Umami Square <span>Explore more Our Story</span></h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.</p>
          <a href="#">contact us</a> </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="history-lft-pic img-round"> <img src="{{asset('public/latest/images/history-pic1.jpg')}}" alt=""> </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="row">
              <div class="col-12">
                <div class="history-rgt-pic img-round"> <img src="{{asset('public/latest/images/history-pic2.jpg')}}" alt=""> <img src="{{asset('public/latest/images/history-pic3.jpg')}}" alt=""> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="center-sec-heading">
          <h3>Reassuring to Know About Us</h3>
          <p>True Local isn't a listing service - it's a place where the local community comes together to share what they love. Here's how that works for you:</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-3 col-12">
        <div class="about-us-icon relative"> <span></span> <i class="flaticon-magnifying-glass"></i>
          <h4>Search</h4>
          <p>Lorem ipsum, or lipsum as it is sometimes known is dummy text.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-12">
        <div class="about-us-icon relative"> <span></span> <i class="flaticon-tap"></i>
          <h4>Select</h4>
          <p>Lorem ipsum, or lipsum as it is sometimes known is dummy text.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-12">
        <div class="about-us-icon relative"> <span></span> <i class="flaticon-stopwatch"></i>
          <h4>Order</h4>
          <p>Lorem ipsum, or lipsum as it is sometimes known is dummy text.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-12">
        <div class="about-us-icon relative"> <span></span> <i class="flaticon-boy"></i>
          <h4>Enjoy</h4>
          <p>Lorem ipsum, or lipsum as it is sometimes known is dummy text.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="about-ads-sec">
  <div class="container">
    <div class="ads-pic">
      <div class="col-lg-6 col-md-6 col-sm-6 col-12 about-spce-LR">
        <div class="ads-pic-block relative"> <img src="{{asset('public/latest/images/ads1.jpg')}}" alt="">
          <div class="about-ads-text clr-black">
            <h4>Become</h4>
            <p>A Partner</p>
            <h5>In Restaurant</h5>
            <a href="#">click hare</a> </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12 about-spce-LR">
        <div class="ads-pic-block relative"> <img src="{{asset('public/latest/images/ads2.jpg')}}" alt="">
          <div class="about-ads-text clr-white">
            <h4>Add Your</h4>
            <p>Restaurant</p>
            <h5>With Us</h5>
            <a href="#">click hare</a> </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="counter-section counter-bg relative d-flex align-items-center" style="background: url({{asset('public/latest/images/counter-bg.jpg')}});">
  <div class="container">
    <div class="count-down w-100">
      <div id="counter" class="justify-content-between d-flex align-items-center w-100">
        <div class="counter-box"> <span><i class="flaticon-layers"></i></span>
          <div class="counter-value" data-to="230" data-count="230"></div>
          <p>Projects Done</p>
        </div>
        <div class="counter-box"> <span><i class="flaticon-rating"></i></span>
          <div class="counter-value" data-to="789" data-count="789"></div>
          <p>Satisfied Clients</p>
        </div>
        <div class="counter-box"> <span><i class="flaticon-coffee-cup"></i></span>
          <div class="counter-value" data-to="580" data-count="580"></div>
          <p>Cup Of Coffee</p>
        </div>
        <div class="counter-box"> <span><i class="flaticon-trophy"></i></span>
          <div class="counter-value" data-to="129" data-count="129"></div>
          <p>Awards Win</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="testimonial-sec relative" style="background: url({{asset('public/latest/images/testimonial-bg.jpg')}}) no-repeat center center">
  <div class="container">
    <div class="testimonial-main-box">
      <div class="test-box">
        <div class="loop testimonial-slider owl-carousel">
          <div class="test-slider-box">
            <div class="item quot">
              <p>Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>
              <div class="testi-user d-flex">
                <div class="user-pic"><img class="img-fluid" src="{{asset('public/latest/images/test-user-pic.jpg')}}" alt=""></div>
                <div class="user-name"> <a href="#">Kate Lawrence</a>
                  <p>Photographer</p>
                  <div class="testi-reviw">
                    <ul>
                      <li class="stars">
                        <ul class="align-items-center">
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="test-slider-box">
            <div class="item quot">
              <p>Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>
              <div class="testi-user d-flex">
                <div class="user-pic"><img class="img-fluid" src="{{asset('public/latest/images/test-user-pic.jpg')}}" alt=""></div>
                <div class="user-name"> <a href="#">Kate Lawrence</a>
                  <p>Photographer</p>
                  <div class="testi-reviw">
                    <ul>
                      <li class="stars">
                        <ul class="align-items-center">
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="test-slider-box">
            <div class="item quot">
              <p>Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>
              <div class="testi-user d-flex">
                <div class="user-pic"><img class="img-fluid" src="{{asset('public/latest/images/test-user-pic.jpg')}}" alt=""></div>
                <div class="user-name"> <a href="#">Kate Lawrence</a>
                  <p>Photographer</p>
                  <div class="testi-reviw">
                    <ul>
                      <li class="stars">
                        <ul class="align-items-center">
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li class="str-active"><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>

$(document).on('click', '.load_more_btn', function() {
	var pcategory_slug	= $(this).attr('data-categoty');
	var pcategory_id	= $(this).attr('data-category_id');
	var pcategory_pg	= $(this).attr('data-pg');
	var pg				=  Number(pcategory_pg)+1;
	
	$(this).attr('data-pg',pg);
	
	var load_more_sec=$(this);
	
    $.ajax({
		type: 'POST',
        url: "{{ url('/ajaxpost') }}",
        data: {
            action: 'get_load_more_product',
			slug: pcategory_slug,
			category_id: pcategory_id,
			pg: pg,
			_token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        beforeSend: function() {
            $("#overlay").show();
			load_more_sec.text('Loading...');
        },
        success: function(data) {
            //$("#overlay").hide();
			$('#category_'+pcategory_slug).append(data.html);
			if(data.is_load_more=='N'){
				load_more_sec.hide();
			}
			load_more_sec.text('load more');
        }
    });
});

$(document).on('click', '.unfavourite_token', function() {
    var productId = $(this).attr('data-fav-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('favourite') }}",
        data: {
            'product_id': productId
        },
        method: 'POST',
        beforeSend: function() {
            $("#overlay").show();
        },
        success: function(data) {
            $("#overlay").hide();
            if (data.success == 1) {
                if (data.is_fav == 0) {
                    $('.food_tab_' + productId).addClass("fa fa-heart-o").removeClass("far fa-heart");
                } else if (data.is_fav == 1) {
                    $('.food_tab_' + productId).removeClass("fa fa-heart-o").addClass("far fa-heart");

                }
            }
        }
    });
});
</script> 
<script>
$(document).ready(function() {
    $('.testimonial-slider').owlCarousel({
        autoplay: false,
        stagePadding: 15,
        autoplayTimeout: 5000,
        loop: true,
        margin: 15,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
});
</script> 
@endsection