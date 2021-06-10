@extends('frontend.layouts.layout')
@section('content')
<?php

  $backgroundImage=isset($restaurantInfomation->restaurantBranch->background_image)?$restaurantInfomation->restaurantBranch->background_image:'sea-food-banner.jpg';

?>
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
      <li class="breadcrumb-item"><a href="{{ url('/restaurant') }}">Restaurant</a></li>
      <li class="breadcrumb-item active" aria-current="page">{!! $restaurantInfomation->name() !!}</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">{!! $restaurantInfomation->name() !!}</h1>

<?php
$slide_items = restaurant_medias(['medias' => $restaurantInfomation->restaurantImage]);
?>


<section class="chef-details-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="outer">
          <div id="big" class="owl-carousel owl-theme"> 
            <?php
            foreach ($slide_items as $key => $value) {
              if($value['type'] == 'image') {
                echo '<div class="item"><img class="img-fluid" src="' . $value['file'] . '" alt=""></div>';
              }
              if($value['type'] == 'video') {
                echo '<div class="item">
                  <video width="100%" height111="178px" muted loop  controls poster="' . $value['image'] . '">
                    <source src="' . $value['file'] . '" type="video/mp4">
                  </video>
                </div>';
              }
            }
            ?>
            <?php
            /* @if($restaurantInfomation->restaurantImage->isNotEmpty())
            <?php $i = ONE ?>
            @foreach($restaurantInfomation->restaurantImage as $restaurantImage)
            @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
            <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
            @else
            <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
            @endif
            <div class="item"> <img class="img-fluid" src="{{ $image }}" alt=""> </div>
            @endforeach
            @else
            <div class="item"> <img class="img-fluid" src="{{ WEBSITE_IMG_URL.'no-image.png' }}" alt=""> </div>
            @endif */
            ?>
          </div>
          <div id="thumbs" class="owl-carousel owl-theme"> 
            <?php
            foreach ($slide_items as $key => $value) {
              if($value['type'] == 'image') {
                echo '<div class="item"><img class="img-fluid" src="' . $value['file'] . '" alt=""></div>';
              }
              if($value['type'] == 'video') {
                echo '<div class="item"><img class="img-fluid" src="' . $value['image'] . '" alt=""></div>';
              }
            }
            ?>
            <?php 
            /* @if($restaurantInfomation->restaurantImage->isNotEmpty())
            <?php $i = ONE ?>
            @foreach($restaurantInfomation->restaurantImage as $restaurantImage)
            @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
            <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
            @else
            <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
            @endif
            <div class="item"> <img class="img-fluid" src="{{ $image }}" alt=""> </div>
            @endforeach
            @else
            <div class="item"> <img class="img-fluid" src="{{ WEBSITE_IMG_URL.'no-image.png' }}" alt=""> </div>
            @endif */
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="chef-name-details">
          <div class="innerpage-logo d-flex">
            <div class="innerpage-logo-lft">
              <div class="chef-logo"> @if($user->image !=='' &&  File::exists(USER_PROFILE_IMAGE_ROOT_PATH.$user->slug.DS.$user->image)) <img  src="{{ USER_PROFILE_IMAGE_URL.$user->slug.DS.$user->image }}"> @else <img  src="{{url('noimage.png')}}"> @endif </div>
            </div>
            <div class="innerpage-logo-rgt">
              <h4>{!! $restaurantInfomation->name() !!}</h4>
              <div class="chef-place">
                <p><i class="fab fa-font-awesome-flag"></i><span>Country :</span> {{ $restaurantInfomation->restaurantLocation->country() }}</p>
                <p><i class="fa fa-map-marker"></i><span>State :</span> {{ $restaurantInfomation->restaurantLocation->state() }}</p>
                <p><i class="fas fa-map-pin"></i><span>City :</span> {{ $restaurantInfomation->restaurantLocation->city() }}</p>
                <?php
                /*$resturant_avg_ratings = ceil($resturant_avg_ratings);
                if($resturant_avg_ratings > 0) {
                  echo '<p>';
                  for($i = 1; $i <= $resturant_avg_ratings; $i++) {
                    echo '<i class="fa fa-star"></i>';
                  }
                  for($i = $resturant_avg_ratings; $i < 5; $i++) {
                    echo '<i class="fa fa-star-o"></i>';
                  }
                  echo '<span>(' . $resturant_total_ratings . ')</span></p>';
                }*/
                ?>
              </div>
            </div>
          </div>
          <div class="chef-description">
            <h5>Description</h5>
            <div class="custome-scroll">
              <p>{!! $restaurantInfomation->restaurantBranch->description()  !!}</p>
            </div>
            <!--<h5>Follow Me</h5>
            <div class="fotter-social p-0">
              <ul class="d-flex align-items-center">
                <li class="facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li class="twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li class="instagram"><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li class="pinterest"><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
              </ul>
            </div>--> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="recommended-sec pb-0">
  <div class="container"> 
    <!--<div class="row">
      <div class="col d-flex justify-content-end">
        <div class="food-select-filter">
          <select class="form-control select-style">
            <option value="">Sort By: Best Sellers</option>
            <option value="">Trending</option>
            <option value="">Price: Lowest First</option>
            <option value="">Price: Highest First</option>
          </select>
        </div>
      </div>
    </div>-->
    <div class="product-section d-flex"> @if($products->isNotEmpty())
      @foreach($products as $product)
      @if(isset($product->singleProductImage->image) && !empty($product->singleProductImage->image))
      <?php 
		$restaurantname=restaurantName($product->restaurant_id);
		$info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
		$ext = $info['extension'];
		//$productrating=App::make('App\Http\Controllers\Frontend\ProductController')->getRating($product->id);
		$ratingreview='';
		$totaluser='';
		/*if(count($productrating)>0)
		{
    $totalsum=collect($productrating)->sum('taste');
		$totaluser= count($productrating);
		$ratingreview=($totalsum/$totaluser);
		$ratingreview	= round($ratingreview,1);
		}*/
    $ratingreview = ceil(($product->avgRating[0]->avg_rate ?? 0));
    $totaluser = (isset($product->totalRating[0]) ? $product->totalRating[0]->count_rate : 0);
		if(!empty($product->favorite))
		{
		$favorite= 'yes';
		} else{
		$favorite= 'no';
		}
	?>
      <div class="custome-col-3 product_item">
        <div class="food-box relative">
          <div class="food-pic relative"> 
            <?php
            $slide_items = product_medias(['medias' => $product->productImage]);
            if(count($slide_items) == 0) {
              echo '<a href="' . url('product-detail/'.$product->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . WEBSITE_IMG_URL.'no-product-image.png' . '" alt="' . $product->title . '" class="lazy" /> </a>';
            } else {
              $sit = $slide_items[0];
              if($sit['type'] == 'image') {
                echo '<a href="' . url('product-detail/'.$product->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . PRODUCT_URL.'th_'. $sit['filename'] . '" alt="' . $product->title . '" class="lazy" /> </a>';
              }
              if($sit['type'] == 'video') {
                $poster = $sit['image'];
                if($sit['image_filename'] != '') {
                  if(File::exists(PRODUCT_ROOT_PATH.'th_'.$sit['image_filename']))
                    $poster = PRODUCT_URL.'th_'. $sit['image_filename'];
                }
                echo '<a href="' . url('product-detail/'.$product->slug) . '">
                <video width="300px" height="178px" muted loop  controls111 poster="' . $poster . '">
                  <source src="' . $sit['file'] . '" type="video/mp4">
                </video>
                </a>';
              }
            }
            ?>
            @if(auth()->user())
            <?php if($useronly== 1){ ?>
            <?php if ($favorite == 'yes') { ?>
            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $product->id }}" data-fav-id="{{ $product->id }}"><i class="dataamount food_tab_{{ $product->id }} far fa-heart" id="fav_{{ $product->id }}"></i></a></span>
            <?php }else{ ?>
            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $product->id }}" data-fav-id="{{ $product->id }}"><i class="dataamount food_tab_{{ $product->id }} fa fa-heart-o" id="fav_{{ $product->id }}"></i></a></span>
            <?php } ?>
            <?php } ?>
            @else <span class="heart-icon"><a href="{{url('/login')}}" class="unfavourite_token fav_{{ $product->id }}"  data-fav-id="{{ $product->id }}" data-fav-value="12"><i class="dataamount food_tab_{{ $product->id }} fa fa-heart-o" id="fav_{{ $product->id }}"></i></a></span> @endif </div>
          <div class="food-name d-flex align-items-center">
            <div class="foodname-lft">
              <h4>{{$product->title}}</h4>
              <p>{!! $restaurantname !!}</p>
              <!--<h4>{{Str::limit($product->title,15)}}</h4>
              <p>{{Str::limit($restaurantname,15)}}</p>-->
            </div>
            
          </div>
          <div class="food-time-rvw-box">
            <div class="food-time d-flex align-items-center justify-content-between">
              <!-- <p>{{ Str::limit($product->description,82) }}</p> -->
              <p>{!! Str::limit($product->description,82) !!}</p>
            </div>
            <div class="price-box d-flex align-items-center justify-content-between">
            <?php if ($ratingreview != 0) {?>
            <div class="foodname-rgt d-flex">
              <a href="{{ url('product-detail/' . $product->slug . '?tab=D#heading-D') }}" class="d-flex">
              <div class="food-rvw-star">
                <ul class="d-flex rvw-stars">
                  <li><i class="fa fa-star"></i></li>
                </ul>
              </div>
              <span class="rvw-rating">{{$ratingreview}}</span> <span class="rvw-quantity">({{$totaluser}})</span>
              </a>
            </div>
            <?php } ?>
              <div class="price-box-lft">
                <p>{{$product->quantity}} Meals</p>
              </div>
              <div class="price-box-rgt">
                <p>Price ${{$product->price()}}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      @endforeach
      @else <img src="{{ WEBSITE_IMG_URL.'no-product.jpg' }}"> @endif </div>
  </div>
</section>
@if($chefsData->isNotEmpty())
<section class="chef-search-sec">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-auto">
        <div class="sec-head">
          <h4>Chefs</h4>
        </div>
      </div>
    </div>
    <div class="product-section d-flex"> @if($chefsData->isNotEmpty())
      @foreach($chefsData as $chefs)
      <div class="custome-col-3">
        <div class="food-box relative non-description">
          <div class="food-pic relative"> @if(!empty($chefs->image) &&
            File::exists(CHEF_ROOT_PATH.$chefs->image))
            <?php $image = CHEF_URL.$chefs->image; ?>
            @else
            <?php $image = WEBSITE_IMG_URL.'ch1.jpg'; ?>
            @endif <img class="chefs_image" src="{{$image}}" onclick="$(this).closest('.food-box').find('.chef_details').trigger('click');"> </div>
          <div class="food-name d-flex align-items-center justify-content-between">
            <div class="foodname-lft chef-name2">
              <h4><a href="{{url('chef-detail/'.$chefs->slug)}}" class="chef_details">{{$chefs->name}}</a></h4>
              <p></p>
            </div>
            <div class="json_data" style="display: none;"><?php echo json_encode(['title' => $chefs->name, 'description' => str_replace("<","&lt;",str_replace(">","&gt;",$chefs->description)), 'image' => $image]); ?></div>
          </div>
          <div class="food-time-rvw-box">
            <p class="box-ftr-text">{!! Str::limit($chefs->description,82) !!}</p>
          </div>
        </div>
      </div>
      @endforeach
      @else
      <h3 class="text-center"> Chefs Not Available. </h3>
      @endif </div>
  </div>
</section>
@endif
<section class="chef-search-sec">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-auto">
        <div class="sec-head">
          <h4>Recommended For You</h4>
        </div>
      </div>
      <!--<div class="col-auto">
        <div class="view-all-btn"> <a href="http://subho.aqualeafitsol.com/umamisquare/all-chefs">view all</a> </div>
      </div>--> 
    </div>
    <div class="product-section d-flex"> @if($productsrecomm->isNotEmpty())
      @foreach($productsrecomm as $restaurant)
      @if(isset($restaurant->restaurantSingleImage->image) && !empty($restaurant->restaurantSingleImage->image))
      <?php 	$info = pathinfo(RESTAURANT_ROOT_PATH.$restaurant->restaurantSingleImage->image);
			$ext = $info['extension'];
	?>
      <div class="custome-col-3 product_item">
        <div class="food-box relative non-description">
          <div class="food-pic relative">
            <?php
            $slide_items = restaurant_medias(['medias' => $restaurant->restaurantImage]);
            if(count($slide_items) == 0) {
              echo '<a href="' . url('restaurant-detail/'.($restaurant->slug ?? '')) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . WEBSITE_IMG_URL.'no-product-image.png' . '" alt="' . $restaurant->name . '" class="lazy" /> </a>';
            } else {
              $sit = $slide_items[0];
              if($sit['type'] == 'image') {
                echo '<a href="' . url('restaurant-detail/'.($restaurant->slug ?? '')) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . RESTAURANT_URL.'th_'. $sit['filename'] . '" alt="' . $restaurant->name . '" class="lazy" /> </a>';
              }
              if($sit['type'] == 'video') {
                $poster = $sit['image'];
                if($sit['image_filename'] != '') {
                  if(File::exists(RESTAURANT_ROOT_PATH.'th_'.$sit['image_filename']))
                    $poster = RESTAURANT_URL.'th_'. $sit['image_filename'];
                }
                echo '<a href="' . url('restaurant-detail/'.($restaurant->slug ?? '')) . '">
                <video width="100%" height="178px" muted loop  controls111 poster="' . $poster . '">
                  <source src="' . $sit['file'] . '" type="video/mp4">
                </video>
                </a>';
              }
            }
            ?>
            <?php
            /*
            <a href="{{url('restaurant-detail/'.($restaurant->slug ?? ''))}}"> @if($ext!='mp4')
            @if(!empty($restaurant->restaurantSingleImage->image) &&
            File::exists(RESTAURANT_ROOT_PATH.$restaurant->restaurantSingleImage->image))
            <?php $image = RESTAURANT_URL.$restaurant->restaurantSingleImage->image; ?>
            @else
            <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
            @endif <img src="{{ $image }}" alt=""> @endif </a>
            */
            ?>
          </div>
          <div class="food-name d-flex align-items-center justify-content-between">
            <div class="foodname-lft chef-name2">
              <h4><a href111="{{url('user-detail/'.$restaurant->userSlug->slug())}}" href="{{url('restaurant-detail/'.($restaurant->slug ?? ''))}}">{!! $restaurant->name !!}</a></h4>
            </div>
          </div>
          <div class="food-time-rvw-box">
            <p class="box-ftr-text">{!! isset($restaurant->restaurantBranch->description) ? Str::limit($restaurant->restaurantBranch->description, 82) : '' !!}</p>
          </div>
        </div>
      </div>
      @endif
      @endforeach
      @endif </div>
  </div>
</section>


<!-- Modal -->
<div id="chefModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Chef Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<?php 
$site_settings=App\Models\Settings\Site_setting::all();
$site_settings2 = [];
foreach ($site_settings as $key => $value) {
    $site_settings2[$value->key] = $value->value;
}
$site_settings = $site_settings2;
?>
@include('frontend.includes.new.home_counter')
<script>
    $(document).ready(function() {
        var bigimage = $("#big");
        var thumbs = $("#thumbs");
        //var totalslides = 10;
        var syncedSecondary = true;

        bigimage
            .owlCarousel({
                items: 1,
                slideSpeed: 2000,
                nav: true,
                autoplay: false,
                dots: false,
                loop: true,
                responsiveRefreshRate: 200,
                navText: [
                    '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                    '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
                ]
            })
            .on("changed.owl.carousel", syncPosition);

        thumbs
            .on("initialized.owl.carousel", function() {
                thumbs
                    .find(".owl-item")
                    .eq(0)
                    .addClass("current");
            })
            .owlCarousel({
                items: 4,
                dots: false,
                nav: true,
                navText: [
                    '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                    '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
                ],
                smartSpeed: 200,
                slideSpeed: 500,
                slideBy: 4,
                margin:8,
                responsiveRefreshRate: 100
            })
            .on("changed.owl.carousel", syncPosition2);

        function syncPosition(el) {
            //if loop is set to false, then you have to uncomment the next line
            //var current = el.item.index;

            //to disable loop, comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }
            //to this
            thumbs
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = thumbs.find(".owl-item.active").length - 1;
            var start = thumbs
                .find(".owl-item.active")
                .first()
                .index();
            var end = thumbs
                .find(".owl-item.active")
                .last()
                .index();

            if (current > end) {
                thumbs.data("owl.carousel").to(current, 100, true);
            }
            if (current < start) {
                thumbs.data("owl.carousel").to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
                var number = el.item.index;
                bigimage.data("owl.carousel").to(number, 100, true);
            }
        }

        thumbs.on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).index();
            bigimage.data("owl.carousel").to(number, 300, true);
        });
    });
</script> 
<script type="text/javascript">
  $(document).ready(function(){

    $(document).on('click', '.chef_details', function(e){
      e.preventDefault();
      var json_data = JSON.parse($(this).closest('.food-name').find('.json_data').html());
      var html = `<div class="row">
      <div class="col-md-12 mb-3"><img src="` + json_data.image + `" class="img-fluid" /></div>
      <div class="col-md-12">
        <h4>` + json_data.title + `</h4>
        ` + json_data.description.replace(/&lt;/g, "<").replace(/&gt;/g, ">") + `
      </div>
      </div>`;
      $('#chefModal .modal-body').html(html);
      $('#chefModal').modal('show');
    });

  });
</script>
@endsection