@extends('frontend.layouts.layout')
@section('content')
@include('frontend.includes.new.mealkit_slider')
<?php 
$useronly='';
if(auth()->user()){
    $useronly = auth()->user()->isUser();
}
?>
@if(auth()->user())
<input type="hidden" name="isuservalid" value="{{auth()->user()->isUser()}}" class="userCheckAuth">
@endif

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Japanese Meal</li>
    </ol>
  </div>
</nav>

<section class="chef-search-sec">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-auto">
        <div class="sec-head">
          <h4>Product</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="product-wrapbox"> @if($categorys->isNotEmpty())
          <div class="catagory-filter m_t20">
            <div class="resturant-lft-src gry-bdr2 d-flex align-items-center">
              <div class="resturant-src-head-lft">
                <h4>Category</h4>
              </div>
            </div>
            <div class="filter-catagory catagory-des">
              <ul>
                <li class="btn filter-cat-li active" data-filter111="*" category_id="">All</li>
                @foreach($categorys as $category)
                <li class="btn filter-cat-li" data-filter111=".category_{{$category->id}}" category_id="{{$category->id}}"><span>{{ $category->name() }}</span></li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif
          @if($diets->isNotEmpty())
          <div class="catagory-filter m_t20">
            <div class="resturant-lft-src gry-bdr2 d-flex align-items-center">
              <div class="resturant-src-head-lft">
                <h4>Preference</h4>
              </div>
            </div>
            <div class="filter-catagory catagory-des">
              <ul>
                <li class="btn filter-cat-li active" data-filter111="*" diet_id="">All</li>
                @foreach($diets as $diet)
                <li class="btn filter-cat-li" data-filter111=".diet_{{$diet->id}}" diet_id="{{$diet->id}}"><span>{{ $diet->name() }}</span></li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif 
          @if($products->isNotEmpty())
          <div class="resturant-lft-sec gry-bdr m_t20">
            <div class="resturant-lft-src d-flex align-items-center gry-bdr-btm">
              <div class="resturant-src-head-lft">
                <h4>Price Range</h4>
              </div>
              <!--<div class="resturant-src-head-rgt"> <a href="#">clear</a> </div>--> 
            </div>
            <div class="range-box">
              <input type="text" class="form-control rang-input" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />
              <div class="price-reng-bar">
                <div id="slider-range"></div>
              </div>
              <!--<div class="range-box-lft">
                <div class="range-box-input dash2">
                  <input type="text" class="form-control range-input-style" placeholder="min">
                </div>
              </div>--> 
              <!--<div class="range-box-rgt">
                <div class="range-box-input">
                  <input type="text" class="form-control range-input-style" placeholder="max">
                </div>
              </div>--> 
            </div>
          </div>
          @endif </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-6 col-12"> @if($products->isNotEmpty())
        <div class="catagory-filte-box product-section p-0 mealfood" id="product-item-section"> 

          <?php
          /*
          @foreach($products as $product)
          @if(isset($product->singleProductImage->image)&& !empty($product->singleProductImage->image))
          <?php 
			$restaurantname=restaurantName($product->restaurant_id);
			$info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
			$ext = $info['extension'];
			$productrating=App::make('App\Http\Controllers\Frontend\ProductController')->getRating($product->rating['product_id']);
			$ratingreview='';
			$totaluser='';
			if(count($productrating)>0){
        $totalsum=collect($productrating)->sum('taste');
				$totaluser		= count($productrating);
				$ratingreview	= ($totalsum/$totaluser);
				$ratingreview	= round($ratingreview,1);
			}
			
			if(!empty($product->favorite)){
				$favorite= 'yes';
			} else{
				$favorite= 'no';
			}
			
			$product_price=0;
			if($product->price()!='') {
				$product_price=$product->price();
			}
			
			$diet_id_class='';
			
			if($product->diet_id!=''){
				if($product->diet_id!='null'){
					$diet_id_arr=explode(',',$product->diet_id);
					for($i=0;count($diet_id_arr)>$i;$i++){
						$diet_id_class .=' diet_'.$diet_id_arr[$i];
					}
				}
			}
		
			
			
		?>
          <div class="item category_{{$product->category_id}} {{$diet_id_class}} custome-col-4 product_items" data-price="{{$product_price}}" data-pid="{{$product->id}}">
            <div class="food-box relative">
              <div class="food-pic relative"> @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                @if(!empty($product->singleProductImage->image) && File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image))
                <?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
                @else
                <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                @endif <a href="{{url('product-detail/'.$product->slug)}}"> <img class="product_image_resto" src="{{ $image }}" alt="{{ $product->title }}"></a> @else
                <video width="100%" height="200px" muted loop  controls poster="{{url('public/thimbnailimage.png')}}">
                  <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
                </video>
                @endif
                <?php 
                if($product->sold_out == '1') 
                  echo '<div class="sold_out">Sold Out</div>';
                 ?>
                @if(auth()->user())
                <?php if($useronly== 1){ ?>
                <?php if ($favorite == 'yes') { ?>
                <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $product->id }}" data-fav-id="{{ $product->id }}"><i class="dataamount food_tab_{{ $product->id }} far fa-heart" id="fav_{{ $product->id }}"></i></a></span>
                <?php }else{ ?>
                <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $product->id }}" data-fav-id="{{ $product->id }}"><i class="dataamount food_tab_{{ $product->id }} fa fa-heart-o" id="fav_{{ $product->id }}"></i></a></span>
                <?php } ?>
                <?php } ?>
                @else <span class="heart-icon"><a href="{{url('/login')}}" class="unfavourite_token fav_{{ $product->id }}"  data-fav-id="{{ $product->id }}" data-fav-value="12"><i class="dataamount food_tab_{{ $product->id }} fa fa-heart-o" id="fav_{{ $product->id }}"></i></a></span> @endif
                <?php if ($ratingreview != 0) {?>
                <!--<div class="food-star-box d-flex align-items-center justify-content-center">
                  <div class="food-rvw-star">
                    <ul class="d-flex rvw-stars">
                      <li><i class="fa fa-star"></i></li>
                      <li><i class="fa fa-star"></i></li>
                      <li><i class="fa fa-star"></i></li>
                      <li><i class="fa fa-star"></i></li>
                      <li><i class="fa fa-star"></i></li>
                    </ul>
                  </div>
                  <div class="foodname-rgt">
                    <p>{{$ratingreview}}</p>
                  </div>
                  <div class="rating-count">
                    <p class="text-right">{{$totaluser}} ratings</p>
                  </div>
                </div>-->
                <?php } ?>
              </div>
              <div class="food-name d-flex align-items-center">
                <div class="foodname-lft">
                  <h4><a href="{{url('product-detail/'.$product->slug)}}">{{$product->title}}</a></h4>
                  <h5>{!! $restaurantname !!}</h5>
                </div>
              </div>
              <div class="food-time-rvw-box">
                <div class="food-time d-flex align-items-center justify-content-between">
                  <p>{{ Str::limit($product->description,82) }}</p>
                </div>
                <div class="price-box d-flex align-items-center justify-content-between">
                  <?php if ($ratingreview != 0) {?>
                  <?php if ($product->is_rating_show == 'Y') {?>
                  <div class="foodname-rgt d-flex">
                    <div class="food-rvw-star">
                      <ul class="d-flex rvw-stars">
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                    </div>
                    <span class="rvw-rating">{{$ratingreview}}</span> <span class="rvw-quantity">({{$totaluser}})</span> </div>
                  <?php } ?>
                  <?php } ?>
                  <div class="price-box-lft">
                    <p>{{$product->quantity}} Meals</p>
                  </div>
                  <div class="price-box-rgt">
                    <p>Price ${{$product->price()}} </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
          @endforeach
          
          */
          ?>
           </div>
        @endif </div>
    </div>
  </div>
</section>
<?php 
$site_settings=App\Models\Settings\Site_setting::all();
$site_settings2 = [];
foreach ($site_settings as $key => $value) {
    $site_settings2[$value->key] = $value->value;
}
$site_settings = $site_settings2;
?>
@include('frontend.includes.new.home_counter')
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/redmond/jquery-ui.css">
<script src="{{asset('public/latest/js/filter.js')}}"></script> 
<script>

function load_products() {
  var search = '{{ $_GET['search'] ?? '' }}';
  var category_id = $('.catagory-des li.active[category_id]').attr('category_id');
  var diet_id = $('.catagory-des li.active[diet_id]').attr('diet_id');
  var min_price = $("#slider-range").slider("values", 0);
  var max_price = $("#slider-range").slider("values", 1);
  $(".umami-loader").show();
  var data = new FormData();
  data.append('action', 'get_products');
  data.append('search', search);
  data.append('category_id', category_id);
  data.append('diet_id', diet_id);
  data.append('min_price', min_price);
  data.append('max_price', max_price);
  data.append('_token', $('meta[name="csrf-token"]').attr('content'));
  $.ajax({
    type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
        $(".umami-loader").hide();
        $('#product-item-section').html(data.data.product_html);
        if(data.success == '0') {
        }
        if(data.success == '1') {
        }
    }
  });
}

/*function showProducts(minPrice, maxPrice) {
  $('.catagory-filte-box').isotope({ filter: function() {
      var price = parseInt($(this).data("price"), 10);
      return price >= minPrice && price <= maxPrice;
    }
  });
}*/
$(document).ready(function(){
//$(function() {
  /*var prices = $('#product-item-section .product_items').map(function() {
    return $(this).data('price');
  }).get();*/
  
  var options = {
      range: true,
      min: 0,
      max: {{ $maxprice->price }},
      values: [0, {{ $maxprice->price }}],
      slide: function(event, ui) {
        var min = ui.values[0],
          max = ui.values[1];

        $("#amount").val("$" + min + " - $" + max);
        //showProducts(min, max);
        load_products();
      }
    },
    min, max;

  $("#slider-range").slider(options);

  min = $("#slider-range").slider("values", 0);
  max = $("#slider-range").slider("values", 1);

  $("#amount").val("$" + min + " - $" + max);

  //showProducts(min, max);

  load_products();
});




$('.catagory-des ul li').click(function() {
  $(this).closest('ul').find('li').removeClass('active');
    $(this).addClass('active');
    load_products();

    /*var selector = $(this).attr('data-filter');
    $('.catagory-filte-box').isotope({
        filter: selector
    });*/
    return false;
});

$(document).on('click','.unfavourite_token',function(){
 var  productId=$(this).attr('data-fav-id');
 $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('favourite') }}",
        data: {'product_id':productId},
        method: 'POST',
    beforeSend: function () {
      $("#overlay").show();
    },
        success: function(data){
          $("#overlay").hide();
          if (data.success == 1) 
          {
              if(data.is_fav == 0)
              {
                 $('.food_tab_'+productId).addClass("fa-heart-o").removeClass("fa-heart");
              }
              else if(data.is_fav == 1)
              {
                 $('.food_tab_'+productId).removeClass("fa-heart-o").addClass("fa-heart");
                 
              }
          }
        }
      });
});




  <?php if(isset($_GET['cat'])) { ?>
    $(window).on('load', function(){
      $('.catagory-filter li[category_id="{{ $_GET['cat'] }}"]').trigger('click');
    });
  <?php } ?>

</script> 
@endsection