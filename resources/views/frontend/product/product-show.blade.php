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

<h1 style="display: none;">
  <?php
  $ttt = 'Japanese Meal';
  foreach($categorys as $category) {
    if(isset($_GET['cat']) && $_GET['cat'] == $category->id)
      $ttt = $category->name();
  }
  echo $ttt;
  ?>
</h1>

<section class="chef-search-sec">
  <div class="filterOptWrap">
    <a href="javascript:;" class="filterOpt"><i class="fa fa-align-left"></i> Filter</a>
  </div>
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
                <!-- <li class="btn filter-cat-li active" data-filter111="*" category_id="">All</li> -->
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
                <!-- <li class="btn filter-cat-li active" data-filter111="*" diet_id="">All</li> -->
                @foreach($diets as $diet)
                <li class="btn filter-cat-li" data-filter111=".diet_{{$diet->id}}" diet_id="{{$diet->id}}"><span>{{ $diet->name() }}</span></li>
                @endforeach
              </ul>
            </div>
          </div>
          @endif 
          
          <div class="resturant-lft-sec gry-bdr m_t20">
            <div class="resturant-lft-src d-flex align-items-center gry-bdr-btm">
              <div class="resturant-src-head-lft">
                <h4>Price Range</h4>
              </div>
              <!--<div class="resturant-src-head-rgt"> <a href="#">clear</a> </div>--> 
            </div>
            <div class="range-box">
              <input type="text" class="form-control rang-input" id="amount" />
              <div class="price-reng-bar">
                <div id="slider-range"></div>
              </div>
              <a href="javascript:;" class="filter_products">Filter</a>
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
          </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-6 col-12"> 
        <div class="catagory-filte-box product-section p-0 mealfood" id="product-item-section" total_pages="1" cur_page="0"> 

          
           </div>
           <div class="load-more-btn"> <a href="javascript:;" class="products_load_more" data-pg="1" style="display: none;">view more</a> </div>
         </div>
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
var loading_products_ajax = 0;

function load_products(params) {
  if(loading_products_ajax == 1) return false;
  loading_products_ajax = 1;
  var search = '{{ $_GET['search'] ?? '' }}';
  /*var category_id = $('.catagory-des li.active[category_id]').attr('category_id');
  var diet_id = $('.catagory-des li.active[diet_id]').attr('diet_id');*/
  var min_price = $("#slider-range").slider("values", 0);
  var max_price = $("#slider-range").slider("values", 1);
  var category_id = '';
  var diet_id = '';
  $('.catagory-des li.active[category_id]').each(function(){
    if(category_id != '') category_id += ',';
    category_id += $(this).attr('category_id');
  });
  $('.catagory-des li.active[diet_id]').each(function(){
    if(diet_id != '') diet_id += ',';
    diet_id += $(this).attr('diet_id');
  });
  /*var total_pages = parseInt($('#product-item-section').attr('total_pages'));
  var cur_page = parseInt($('#product-item-section').attr('cur_page'));*/
  var cur_page = params.cur_page;
  //$(".umami-loader").show();
  //$('body').css('overflow', 'hidden');
  var data = new FormData();
  data.append('action', 'get_products');
  data.append('search', search);
  data.append('category_id', category_id);
  data.append('diet_id', diet_id);
  data.append('min_price', min_price);
  data.append('max_price', max_price);
  data.append('cur_page', cur_page);
  data.append('_token', $('meta[name="csrf-token"]').attr('content'));
  $.ajax({
    type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
        loading_products_ajax = 0;
        //$(".umami-loader").hide();
        //$('body').css('overflow', 'initial');
        $('#product-item-section').attr('total_pages', data.data.total_pages);
        $('#product-item-section').attr('cur_page', cur_page);
        $('#product-item-section').append(data.data.product_html);
        $('.products_load_more').show();
        if(data.data.total_pages == cur_page)
          $('.products_load_more').hide();
        /*modified lazyload*/
        var lazyloadImages = document.querySelectorAll("img.lazy");    
        var lazyloadThrottleTimeout;
        if(lazyloadThrottleTimeout) {
            clearTimeout(lazyloadThrottleTimeout);
          } 
          lazyloadThrottleTimeout = setTimeout(function() {
              var scrollTop = window.pageYOffset;
              lazyloadImages.forEach(function(img) {
                  if(img.offsetTop < (window.innerHeight + scrollTop)) {
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                  }
              });
          }, 20);
        /*modified lazyload*/
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
        //load_products();
      }
    },
    min, max;

  $("#slider-range").slider(options);

  min = $("#slider-range").slider("values", 0);
  max = $("#slider-range").slider("values", 1);

  $("#amount").val("$" + min + " - $" + max);

  //showProducts(min, max);

  
});




$('.catagory-des ul li').click(function() {
  /*$(this).closest('ul').find('li').removeClass('active');
  $(this).addClass('active');*/
  $(this).toggleClass('active');
  $('#product-item-section').attr('total_pages', '1');
  $('#product-item-section').attr('cur_page', '0');
  $('#product-item-section').html('');
  $('.products_load_more').hide();
  load_products({'cur_page': 1});
  if($(window).width() <= 575)
    $('.product-wrapbox').hide();
  return false;
});

$('.filter_products').click(function() {
  $('#product-item-section').attr('total_pages', '1');
  $('#product-item-section').attr('cur_page', '0');
  $('#product-item-section').html('');
  $('.products_load_more').hide();
  load_products({'cur_page': 1});
  if($(window).width() <= 575)
    $('.product-wrapbox').hide();
});

$(document).on('click', '.filterOpt', function(){
  $('.product-wrapbox').toggle();
  $('html, body').animate({
        scrollTop: 0
    }, 100);
});

var window_width = $(window).width();
$(window).on('resize', function(){
  if($(window).width() !== window_width) {
    window_width = $(window).width();
    if($(window).width() <= 575)
      $('.product-wrapbox').hide();
    else
      $('.product-wrapbox').show();
  }
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
    $(document).ready(function(){
      $('.catagory-filter li[category_id="{{ $_GET['cat'] }}"]').trigger('click');
    });
  <?php } else { ?>
    $(document).ready(function(){
      load_products({'cur_page': 1});
    });
  <?php } ?>

  /*$(window).on('scroll', function(){
    if ($(window).scrollTop() >= $('#product-item-section').offset().top + $('#product-item-section').outerHeight() - window.innerHeight) {
      var total_pages = parseInt($('#product-item-section').attr('total_pages'));
      var cur_page = parseInt($('#product-item-section').attr('cur_page'));
      if(cur_page < total_pages) {
        load_products({'cur_page': cur_page + 1});
        //console.log("bottom");
      }
    }
  });*/

  $(document).ready(function(){
    $(document).on('click', '.products_load_more', function(){
      var total_pages = parseInt($('#product-item-section').attr('total_pages'));
      var cur_page = parseInt($('#product-item-section').attr('cur_page'));
      if(cur_page < total_pages) {
        load_products({'cur_page': cur_page + 1});
      }
    });
  });  

</script> 
@endsection