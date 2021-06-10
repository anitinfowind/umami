@extends('frontend.layouts.layout')
@section('content')
<h1 style="display: none;">Umami Square</h1>
@include('frontend.includes.new.slider')
<?php 
$useronly='';
if(auth()->user()){
  $useronly = auth()->user()->isUser();
}
?>
@if(auth()->user())
<input type="hidden" name="isuservalid" value="{{auth()->user()->isUser()}}" class="userCheckAuth">
@endif

<section class="testimonial-sec">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="sec-head pb-2">
          <h4>What People are Saying</h4>
        </div>
      </div>
      <div class="col-12"> 
        <div class="loop testimonial-slider22 owl-carousel">  
          <?php
          foreach ($testimonials as $key => $value) {
            $ext = '';
            if(isset($value->post_image)) {
              //$info = pathinfo(PRODUCT_ROOT_PATH.$value->post_image);
              $info = pathinfo(url('public/uploads/testimonial/post_image/'.$value->post_image));
              $ext = $info['extension'];
            }

            $img = url('/public/images/profile-user-img.png');
            if($value->image != '')
              $img = url('public/uploads/testimonial/' . $value->image);
            ?>

            <!--  <div class="item w-100"> 
              <div class="testi-user d-flex align-items-center">
                <div class="user-pic">
                  <img src="{{ $img }}" alt="">
                </div> 
                <div class="user-name">
                  <h4>{{ $value->first_name . ' ' . $value->last_name }}</h4>
                  <p>{{ $value->title }}</p>
                </div>  
              </div>
              <div class="testi-description">
                <p>{!! nl2br($value->comment) !!}</p>
              </div>
            </div> old -->


            <div class="item w-100">
              <div class="testi-user d-flex align-items-center"> 
                <div class="user-pic">
                  <!-- <img src="{{ $img }}" alt=""> -->
                  <img src="{{ $img }}" alt="user-image">
                </div> 
                <div class="user-name">
                  <h4>{{ $value->first_name . ' ' . $value->last_name }}</h4>
                  <p>{{ $value->title }}</p> 
                </div>  
              </div>
              <div class="back-img"> 
                <!-- <img src="/public/uploads/testimonial/sun-img.jpg" alt=""> -->
                @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp') 
                  @if(!empty($value->post_image))
                      <?php $post_image = url('public/uploads/testimonial/post_image/'.$value->post_image);
                      ?>
                  @else
                      <?php $post_image = WEBSITE_IMG_URL.'no-product-image.png'; ?>  
                  @endif
                  <img class="resto product_list" src="{{ $post_image }}" alt="{{ $value->id }}">
                  @elseif($ext != '')
                  <?php $post_image = url('public/uploads/testimonial/post_image/'.$value->post_image);
                      ?>
                  <div class="video-sec">
                    <video width="" height="" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                      <source src="{{ $post_image }}" type="video/mp4"> 
                    </video>
                  </div> 
                @endif
              </div>
              <div class="testi-description"> 

                <p>{!! nl2br($value->comment) !!}</p>

              </div>
            </div>
          <?php } ?>

        </div>
      </div>
    </div>
  </div>
</section>

@foreach($categoryproduct as $p=>$pcategory)
<section class="noodles-items-sec">
  <div class="container">
    <div class="row justify-content-between align-items-center"> @if($pcategory['product']->isNotEmpty())
      <div class="col-auto">
        <div class="sec-head">
          <h4>{{$pcategory['category']}}</h4>
          <!-- <a href="javascript:;"><i class="fas fa-location-arrow"></i> Use my location</a>  --> 
        </div>
      </div>
      @if($pcategory['product']->isNotEmpty())
      <!-- <div class="col-auto forDesktop">
        <div class="view-all-btn"> <a href="{{url('products?cat='.$pcategory['category_id'])}}">view all</a> </div>
      </div> -->
      @endif
      @endif </div>

    @if($pcategory['product']->isNotEmpty())

    <div class="product-section d-flex" id="category_{{$pcategory['slug']}}">
      <?php $i=0;foreach($pcategory['product'] as $product){?>
      @if(isset($product->singleProductImage->image) && !empty($product->singleProductImage->image))

      <?php

		$restaurantname=restaurantName($product->restaurant_id);

		$info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);

		$ext = $info['extension'];

		//$productrating=App::make('App\Http\Controllers\Frontend\ProductController')->getRating($product->id);

		$ratingreview='';
		$totaluser='';
		/*if(count($productrating)>0){
			$totalsum=collect($productrating)->sum('taste');
			$totaluser= count($productrating);
			$ratingreview=($totalsum/$totaluser);
			$ratingreview	= round($ratingreview,1);
		}*/
    $ratingreview = ceil(($product->avgRating[0]->avg_rate ?? 0));
    $totaluser = (isset($product->totalRating[0]) ? $product->totalRating[0]->count_rate : 0);
		if(!empty($product->favorite)){
			$favorite='yes';
		} else{
			$favorite='no';
		}
	  ?>

      <?php 
		if ($product->discount()) {
		  $discount = (int) $product->price() * (int) $product->discount() / 100;
		  $price = (int) $product->price()- (int) $discount;
		} else {
		  $price = $product->price();
		}
    $serving_for = (!empty($product->serving_for)) ? $product->serving_for : 'people';
		?>

      <div class="custome-col-3 product_item" data-id="{{$product->id}}">

        <div class="food-box relative">

          <div class="food-pic relative"> 
            <?php
            $slide_items = product_medias(['medias' => $product->productImage]);

            if(count($slide_items) == 0) {
              if(!empty($product->video)){
                echo '<a href="'.url('product-detail/'.$product->slug).'">
                <video width="100%" height="178px" muted loop  controls111 preload="none" poster="'.url('uploads/product/thumb/'.$product->video_thumb).'">
                  <source src="'.url('uploads/product/'.$product->video).'" type="video/mp4">
                </video>
                </a>';
              }
              else{
              echo '<a href="' . url('product-detail/'.$product->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . WEBSITE_IMG_URL.'no-product-image.png' . '" alt="' . $product->title . '" class="lazy" /> </a>';
              }
            } else {
              $sit = $slide_items[0];
              if($sit['type'] == 'video') {
              if(!empty($sit['product_id']) && isset($sit['product_id'])){
                if($product->id == $sit['product_id'] && !empty($product->video)){
                  //print_r($product->video);
                  //echo '<h1>'.url('uploads/product/'.$product->video).'</h1>';die('hello');
                  echo '<a href="' . url('product-detail/'.$product->slug) . '">
                  <video width="100%" height="178px" muted loop  controls111 preload="none" poster="'.url('uploads/product/'.$product->video_thumb).'">
                    <source src="'.url('uploads/product/'.$product->video).'" type="video/mp4">
                  </video>
                  </a>';
                }
              }
              }else{
              if($sit['type'] == 'image') {
                  if(!empty($product->video)){
                    //print_r($product->video);die('hua');
                    //echo '<h1>'.url('uploads/product/'.$product->video).'</h1>';die('hello');
                    echo '<a href="' . url('product-detail/'.$product->slug) . '">
                    <video width="100%" height="178px" muted loop  controls111 preload="none" poster="'.url('uploads/product/thumb/'.$product->video_thumb).'">
                      <source src="'.url('uploads/product/'.$product->video).'" type="video/mp4">
                    </video>
                    </a>';
                  }else{
                   echo '<a href="' . url('product-detail/'.$product->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . PRODUCT_URL.'th_'. $sit['filename'] . '" alt="' . $product->title . '" class="lazy" /> </a>';
                  } 
              }

              // if($sit['type'] == 'video') {

              //   $poster = $sit['image'];

              //   if($sit['image_filename'] != '') {

              //     if(File::exists(PRODUCT_ROOT_PATH.'th_'.$sit['image_filename']))

              //       $poster = PRODUCT_URL.'th_'. $sit['image_filename'];

              //   }

              //   echo '<a href="' . url('product-detail/'.$product->slug) . '">

              //   <video width="100%" height="178px" muted loop  controls111 preload="none" poster="' . $poster . '">

              //     <source src="' . $sit['file'] . '" type="video/mp4">

              //   </video>

              //   </a>';

              // }
             }
            }

            ?>

            <?php 

            if($product->sold_out == '1') 

              echo '<div class="sold_out"><p>Sold Out</p></div>';

             ?>

            @if(auth()->user())

            <?php if($useronly== 1){ ?>

            <?php if ($favorite == 'yes') { ?>

            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $product->id }}" data-fav-id="{{ $product->id }}"><i class="dataamount food_tab_{{ $product->id }} far fa-heart" id="fav_{{ $product->id }}"></i></a></span>

            <?php }else{ ?>

            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $product->id }}" data-fav-id="{{ $product->id }}"><i class="dataamount food_tab_{{ $product->id }} fa fa-heart-o" id="fav_{{ $product->id }}"></i></a></span>

            <?php } ?>

            <?php } ?>

            @else <span class="heart-icon"><a href="{{url('/login')}}" class="unfavourite_token fav_{{ $product->id }}"  data-fav-id="{{ $product->id }}" data-fav-value="12"><i class="dataamount food_tab_{{ $product->id }} fa fa-heart-o" id="fav_{{ $product->id }}"></i></a></span> @endif <span class="discount-percent">free shipping</span> <span class="trending">{{$pcategory['category']}}</span> </div>

          <div class="food-name d-flex align-items-center">

            <div class="foodname-lft">
          
              <h4><a href="{{url('product-detail/'.$product->slug)}}">{{$product->title}}</a></h4>

              <div class="user-pic-name">
                <p class="user-pic user-pic2">
                  <?php
                  $slide_items = product_medias(['medias' => $product->productImage]);
                  if(count($slide_items) == 0) {
                    if(!empty($product->video)){
                        echo '<img src="'.url('uploads/product/thumb/'.$product->video_thumb).'" alt="user-image">';
                    }else{
                    echo '<img src="https://umami.framework.infowindtech.biz/public/uploads/testimonial/12-05-2021-05-42-42-02-04-2021-10-26-44-2.png" alt="user-image">';
                   }
                  } else {
                    $sit = $slide_items[0];
                    if($sit['type'] == 'image') { 
                      if(!empty($product->video)){
                        echo '<img src="'.url('uploads/product/thumb/'.$product->video_thumb).'" alt="user-image">';
                      }else{ 
                      echo '<img src="https://umami.framework.infowindtech.biz/public/uploads/testimonial/12-05-2021-05-42-42-02-04-2021-10-26-44-2.png" alt="user-image">';
                     }
                    }
                    if($sit['type'] == 'video') {
                      $poster = $sit['image'];
                       //echo $sit['image_filename'];
                      if($sit['image_filename'] != '') {
                        if(File::exists(url('public/uploads/product/th_'.$sit['image_filename'])))
                          $poster = url('public/uploads/product/th_'. $sit['image_filename']);
                         $thumb = url('uploads/product/th_'. $product->video_thumb);
                      }
                       //echo $sit['filename'];
                  echo '<video width="30px" height="30px" muted loop  controls111 preload="none" poster="' . $thumb . '">
                        <source src="' . $sit['file'] . '" type="video/mp4">
                        </video>';
                      // echo '<img src="https://umami.framework.infowindtech.biz/public/uploads/testimonial/12-05-2021-05-42-42-02-04-2021-10-26-44-2.png" alt="user-image">';
                    }
                  }
                  ?>

                  <!-- <img src="https://umami.framework.infowindtech.biz/public/uploads/testimonial/12-05-2021-05-42-42-02-04-2021-10-26-44-2.png" alt="user-image"> -->
                </p>
                <p>{!! $restaurantname !!}</p>
              </div>

               <div class="price-box d-flex align-items-center justify-content-between" style="margin-top: 16px;">

              <?php if ($ratingreview != 0) {?>

              <?php if ($product->is_rating_show == 'Y') {?>

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

              <?php } ?>

              <div class="price-box-lft">

                <!-- <p>{{$product->quantity}}</p> -->

              </div>

              <div class="price-box-rgt">
                <!--Price $<?=$price;?> -->
                <p><span class="per_person">${{number_format($price/$product->quantity, 2)}}/{{ $serving_for }}</span>

                </p>

              </div>

            </div>

              <!--<h4>{{Str::limit($product->title,20)}}</h4>

              <p>{{Str::limit($restaurantname,20)}}</p>--> 

              

            </div>

          </div>

         <!--  <div class="food-time-rvw-box">

            <div class="food-time d-flex align-items-center justify-content-between">

              <p>{{ Str::limit($product->description,82) }}</p>

              <?php /*<p>{!! $product->description !!}</p>*/ ?>

            </div>

            <div class="price-box d-flex align-items-center justify-content-between">

              <?php if ($ratingreview != 0) {?>

              <?php if ($product->is_rating_show == 'Y') {?>

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

              <?php } ?>

              <div class="price-box-lft">
                <p><span class="per_person">${{number_format($price/$product->quantity, 2)}}/{{ $serving_for }}</span>

                </p>

              </div>

            </div>

          </div> -->

        </div>

      </div>

      <?php $i++; ?>

      @endif

      <?php } ?>

    </div>

    @if($pcategory['product']->isNotEmpty())

    @if(count($pcategory['product'])>5) 

    <!--<div class="row">

      <div class="col-12">

        <div class="load-more-btn"> <a href="javascript:;" class="load_more_btn" data-categoty="{{$pcategory['slug']}}" data-category_id="{{$pcategory['category_id']}}" data-pg="1">load more</a> </div>

      </div>

    </div>--> 

    

    @endif

    @endif

    @endif 

    @if($pcategory['product']->isNotEmpty())

      <div class="text-center mt-3"><div class="view-all-btn"> <a href="{{url('products?cat='.$pcategory['category_id'])}}">view all</a> </div></div>

    @endif

  </div>

</section>

@endforeach 



<section  class="paralaxBg text-center bg-cover parallax relative"  id="parallax-5" data-image-src="{{ BANNER_URL.$unlimitedfree->image }}" data-height="350px">

  <div class="container">

    <div class="paralaxSlogan">

      <h2>{{isset($unlimitedfree->title)?$unlimitedfree->title:'Unlimited Free Delivery with'}}</h2>

      <a href="{{ isset($unlimitedfree->button_url)?$unlimitedfree->button_url: url('products')}}">order now</a> </div>

  </div>

</section>

<!-- <section>
  <div class="video-section">
   <div class="video-section-inner"> -->
    <!-- <img src="public/uploads/testimonial/11-05-2021-06-37-53-2899.jpg">-->
    @if(!empty($top_video->video))
      <!-- <video  loop="" muted="" playsinline="" autoplay="">
      <source src="{{ url('public/uploads/banner/'.$top_video->video) }}" type="video/mp4">
    </video> -->
    @else
    <!-- <video  loop="" muted="" playsinline="" autoplay="">
      <source src="{{ url('public/uploads/product/IMG_2400.mov') }}" type="video/mp4"> -->
        <!-- https://cdn.shopify.com/s/files/1/0484/7271/9526/files/Main_Page_Vid_full.mov?v=1618859384 -->
        
   <!--  </video> -->
    @endif
   <!-- </div> --><!--video-section-inner-->
  <!-- </div> --><!--video-section-->
<!-- </section> -->

<section class="restaurants-sec">

  <div class="container">

    <div class="row justify-content-between align-items-center">

      <div class="col-auto">

        <div class="sec-head">

          <h4>RESTAURANT</h4>

          <!-- <a href="javascript::"><i class="fas fa-location-arrow"></i> Use my location</a>  --> 

        </div> 

      </div>

      @if(count($restaurantList)>5)

      <!-- <div class="col-auto forDesktop">

        <div class="view-all-btn"> <a href="{{url('restaurant')}}">view all</a> </div>

      </div> -->

      @endif </div>

    @if($restaurantList->isNotEmpty())

    <div class="product-section d-flex" id="restaurant_section">

      <?php $i=0; foreach($restaurantList as $restaurant){ 

        $state_info=\App\Models\State::where('name',$restaurant->restaurantLocation->state)->select('state_code')->first();

        //$restaurant->restaurantImage

        ?>

      @if(isset($restaurant->restaurantSingleImage->image) && !empty($restaurant->restaurantSingleImage->image))

      <?php 

      if(File::exists(RESTAURANT_ROOT_PATH.'th_'.$restaurant->restaurantSingleImage->image))

        $restaurant_image = RESTAURANT_ROOT_PATH.'th_'.$restaurant->restaurantSingleImage->image; 

      else

        $restaurant_image = RESTAURANT_ROOT_PATH.$restaurant->restaurantSingleImage->image; 

      //$restaurant_image = url('public/uploads/restaurant/'.$restaurant->restaurantSingleImage->image);

      ?>

      @else

      <?php $restaurant_image = url('public/images/no-image.png'); ?>


      @endif

      <div class="custome-col-3 product_item">

        <div class="food-box relative">

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

                <video width="100%" height="178px" muted loop  controls111 preload="none" poster="' . $poster . '">

                  <source src="' . $sit['file'] . '" type="video/mp4">

                </video>

                </a>';

              }

            }

            ?>

            <!-- <a href="{{url('restaurant-detail/'.($restaurant->slug ?? ''))}}"><img src="{{ WEBSITE_IMG_URL.'blank2.jpg' }}" data-src="{{$restaurant_image}}" alt="{{$restaurant->name}}" class="lazy" /></a> -->

          </div>

          <div class="food-name d-flex align-items-center justify-content-between">

            <div class="foodname-lft">

              <h4><a href111="{{url('user-detail/'.($restaurant->userSlug->slug ?? ''))}}" href="{{url('restaurant-detail/'.($restaurant->slug ?? ''))}}">{!! $restaurant->name !!}</a></h4>

              <p><i class="fas fa-map-marker-alt"></i>{{ isset($restaurant->restaurantLocation->state)?$restaurant->restaurantLocation->state:'' }}

                <?php if(isset($state_info->state_code)){ echo ','.$state_info->state_code;} ?>

                <?php 

					/*$cities=isset($restaurant->restaurantLocation->city)?$restaurant->restaurantLocation->city:'College';

                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($cities)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";

                    $result_string = file_get_contents($url);

					if(isset($result_string)){

						if(!empty($result_string)){

							$result = json_decode($result_string, true);

							$dataresultcheck=$result['results'][0]['address_components'];

							if(in_array('administrative_area_level_1', $dataresultcheck[0]['types'])){

								echo  ','.$stateshort_code =$result['results'][0]['address_components'][1]['short_name'];

							}else if(in_array('administrative_area_level_1', $dataresultcheck[1]['types'])){

								echo  ','.$stateshort_code =$result['results'][0]['address_components'][1]['short_name'];

							}else if(in_array('administrative_area_level_1', $dataresultcheck[2]['types'])){

								echo   ','.$stateshort_code =$result['results'][0]['address_components'][2]['short_name'];

							}else if(in_array('administrative_area_level_1', $dataresultcheck[3]['types'])){

								echo  ','.$stateshort_code =$result['results'][0]['address_components'][3]['short_name'];

							} else if(in_array('administrative_area_level_1', $dataresultcheck[4]['types'])){

								echo   ','.$stateshort_code =$result['results'][0]['address_components'][4]['short_name'];

							}

						}

					} */

				?>

              </p>

            </div>

          </div>

          <div class="food-time-rvw-box">

            <p class="box-ftr-text"><?php echo isset($restaurant->restaurantBranch->description)?Str::limit($restaurant->restaurantBranch->description,82):'';?></p>

              <?php /*<p class="box-ftr-text">{!! $restaurant->restaurantBranch->description !!}</p>*/ ?>

          </div>

        </div>

      </div>

      <?php $i++; } ?>

    </div>

    @if(count($restaurantList)>5) 

    <!--<div class="row">

      <div class="col-12">

        <div class="load-more-btn"> <a href="javascript:;" class="restaurant_load_more_btn" data-pg="1">load more</a> </div>

      </div>

    </div>--> 

    @endif

    @endif 

      <div class="text-center mt-3">

        <div class="view-all-btn"> <a href="{{url('restaurant')}}">view all</a> </div>

      </div>

  </div>

</section>

<section class="recommended-sec">

  <div class="container">

    <div class="row justify-content-between align-items-center">

      <div class="col-auto">

        <div class="sec-head">

          <h4>CHEF</h4>

          <!-- <a href="javascript:;"><i class="fas fa-location-arrow"></i> Use my location</a>  --> 

        </div>

      </div>

      @if($chefs->isNotEmpty())

      <!-- <div class="col-auto forDesktop">

        <div class="view-all-btn"> <a href="{{url('all-chefs')}}">view all</a> </div>

      </div> -->

      @endif </div>

    <div class="product-section d-flex" id="recommended_section"> @if($chefs->isNotEmpty())

      <?php $i=0; foreach($chefs as $chef){?>

        <?php

        //dd($chef);

        if(File::exists(CHEF_ROOT_PATH.'th_'.$chef->image))

        $chef_image = 'th_'.$chef->image; 

      else

        $chef_image = $chef->image;

        ?>

      <div class="custome-col-3">

        <div class="food-box relative">

          <div class="food-pic relative"> <a href111="{{url('user-detail/'.$chef->slug)}}" href="{{url('restaurant-detail/'.($chef->getRestautent->slug ?? ''))}}"><img src="{{ WEBSITE_IMG_URL.'blank2.jpg' }}" data-src="{{url('public/uploads/chef/'.$chef_image)}}" class="lazy" alt=""></a> </div>

          <div class="food-name d-flex align-items-center justify-content-between">

            <div class="foodname-lft">

              <h4><a href="{{url('restaurant-detail/'.($chef->getRestautent->slug ?? ''))}}">{{$chef->name}}</a></h4>

              <p><i class="fas fa-map-marker-alt"></i>{{ $chef->getRestautent->restaurantLocation->city ?? '' }}, {{ $chef->getRestautent->restaurantLocation->country ?? '' }}</p> 

              <p class="name-edit"><a href="{{url('restaurant-detail/'.($chef->getRestautent->slug ?? ''))}}"><i class="fas fa-edit"></i>{!! $chef->getRestautent->name ?? ''  !!}</a></p>

              <!--<p>{{Str::limit($restaurantname,15)}}</p>--> 

            </div>

            <!-- <div class="foodname-rgt out-rating-qty">

              <p>4.1</p>

            </div> --> 

            <!-- <div class="foodname-rgt d-flex">

              <div class="food-rvw-star">

                <ul class="d-flex rvw-stars">

                  <li><i class="fa fa-star"></i></li>

                </ul>

              </div>

              <span class="rvw-rating">{{$ratingreview}}</span> <span class="rvw-quantity">({{$totaluser}})</span> 

            </div> --> 

          </div>

          <!-- <div class="food-time-rvw-box">

            <div class="food-time d-flex align-items-center justify-content-between">

              <?php if($chef->description!=''){?>

              <p><?php echo Str::limit($chef->description,81);?></p>

              <?php } ?>

            </div>

          </div> -->

          <div class="food-time-rvw-box"> 

            <!-- <div class="food-time align-items-center justify-content-between">

              <div class="food-time-rgt d-flex justify-content-between">

                <ul class="d-flex rvw-stars">

                    <li><i class="fa fa-star"></i></li>

                    <li><i class="fa fa-star"></i></li>

                    <li><i class="fa fa-star"></i></li>

                    <li><i class="fa fa-star"></i></li>

                    <li><i class="fa fa-star"></i></li>

                </ul>

                <p class="text-right">4225 ratings</p>

              </div>

            </div> -->

            <p class="box-ftr-text">{!! Str::limit($chef->description, 82) !!}</p>

          </div>

        </div>

      </div>

      <?php $i++; ?>

      <?php } ?>

      @endif </div>

      @if($chefs->isNotEmpty())

      <div class="text-center mt-3"> 

        <div class="view-all-btn"> <a href="{{url('all-chefs')}}">view all</a> </div>

      </div>

      @endif

  </div>

</section>

@include('frontend.includes.new.home_counter')

<section class="recommended-sec">

  <div class="container">

    <div class="row justify-content-between align-items-center">

      <div class="col-auto">

        <div class="sec-head">

          <h4>Recommended For You</h4>

          <!-- <a href="javascript:;"><i class="fas fa-location-arrow"></i> Use my location</a>  --> 

        </div>

      </div>

      <div class="col-auto"> </div>

    </div>

    <div class="product-section d-flex" id="recommended_section"> @if($productsrecomm->isNotEmpty())

      <?php $i=0; foreach($productsrecomm as $key=>$recommend){ ?>

      @if(isset($recommend->singleProductImage->image) && !empty($recommend->singleProductImage->image))

      <?php

	  

	  

	  $restaurantname=restaurantName($recommend->restaurant_id);

	  $info = pathinfo(PRODUCT_ROOT_PATH.$recommend->singleProductImage->image);

	  $ext = $info['extension'];



	  //$productrating=App::make('App\Http\Controllers\Frontend\ProductController')->getRating($recommend->id);

	  $ratingreview='';

	  $totaluser='';

	  /*if(count($productrating)>0)

	  {

    $totalsum=collect($productrating)->sum('taste');

		$totaluser		= count($productrating);

		$ratingreview	= ($totalsum/$totaluser);

		$ratingreview	= round($ratingreview,1);

	  }*/

    $ratingreview = ceil(($recommend->avgRating[0]->avg_rate ?? 0));

    $totaluser = (isset($recommend->totalRating[0]) ? $recommend->totalRating[0]->count_rate : 0);

	  if(!empty($recommend->favorite))

	  {

		$favorite= 'yes';

	  } else{

		$favorite= 'no';

	  }

	  ?>

      <div class="custome-col-3 product_item">

        <div class="food-box relative">

          <div class="food-pic relative">

            <input type="hidden" class="recommends" value="{{$recommend->id}}"> 

            <?php

            $slide_items = product_medias(['medias' => $recommend->productImage]);

            if(count($slide_items) == 0) {

              echo '<a href="' . url('product-detail/'.$recommend->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . WEBSITE_IMG_URL.'no-product-image.png' . '" alt="' . $recommend->title . '" class="lazy" /> </a>';

            } else {

              $sit = $slide_items[0];

              if($sit['type'] == 'image') {

                echo '<a href="' . url('product-detail/'.$recommend->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . PRODUCT_URL.'th_'. $sit['filename'] . '" alt="' . $recommend->title . '" class="lazy" /> </a>';

              }

              if($sit['type'] == 'video') {

                $poster = $sit['image'];

                if($sit['image_filename'] != '') {

                  if(File::exists(PRODUCT_ROOT_PATH.'th_'.$sit['image_filename']))

                    $poster = PRODUCT_URL.'th_'. $sit['image_filename'];

                }

                echo '<a href="' . url('product-detail/'.$recommend->slug) . '">

                <video width="100%" height="178px" muted loop  controls111 preload="none" poster="' . $poster . '">

                  <source src="' . $sit['file'] . '" type="video/mp4">

                </video>

                </a>';

              }

            }

            ?>

            

            @if(auth()->user())

            <?php if($useronly== 1){ ?>

            <?php if ($favorite == 'yes') { ?>

            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $recommend->id }}" data-fav-id="{{ $recommend->id }}"><i class="dataamount food_tab_{{ $recommend->id }} far fa-heart" id="fav_{{ $recommend->id }}"></i></a></span>

            <?php }else{ ?>

            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $recommend->id }}" data-fav-id="{{ $recommend->id }}"><i class="dataamount food_tab_{{ $recommend->id }} fa fa-heart-o" id="fav_{{ $recommend->id }}"></i></a></span>

            <?php } ?>

            <?php } ?>

            @else <span class="heart-icon"><a href="{{url('/login')}}" class="unfavourite_token fav_{{ $recommend->id }}"  data-fav-id="{{ $recommend->id }}" data-fav-value="12"><i class="dataamount food_tab_{{ $recommend->id }} fa fa-heart-o" id="fav_{{ $recommend->id }}"></i></a></span> <span class="discount-percent">free shipping</span> <span class="trending">{{ $recommend->category_data->name ?? '' }}</span> @endif </div>

          <div class="food-name d-flex align-items-center">

            <div class="foodname-lft"> 

              <!--<h4>{{Str::limit($recommend->title,15)}}</h4>

              <p>{{Str::limit($restaurantname,15)}}</p>-->

              <h4>{{$recommend->title}}</h4>

              <p>{!! $restaurantname !!}</p>

              <?php /*if ($ratingreview != 0) {?>

              <div class="foodname-rgt d-flex">

                <div class="food-rvw-star">

                  <ul class="d-flex rvw-stars">

                    <li><i class="fa fa-star"></i></li>

                  </ul>

                </div>

                <span class="rvw-rating">{{$ratingreview}}</span> <span class="rvw-quantity">({{$totaluser}})</span> </div>

              <?php }*/ ?>

            </div>

          </div>

          <div class="food-time-rvw-box">

            <div class="food-time d-flex align-items-center justify-content-between">

              <p>{!! Str::limit($recommend->description,82) !!}</p>

              <?php /*<p>{!! $recommend->description !!}</p>*/ ?>

            </div>

            <div class="price-box d-flex align-items-center justify-content-between">

              <?php if ($ratingreview != 0) {?>

              <?php if ($recommend->is_rating_show == 'Y') {?>

              <div class="foodname-rgt d-flex">

                <a href="{{ url('product-detail/' . $recommend->slug . '?tab=D#heading-D') }}" class="d-flex">

                <div class="food-rvw-star">

                  <ul class="d-flex rvw-stars">

                    <li><i class="fa fa-star"></i></li>

                  </ul>

                </div>

                <span class="rvw-rating">{{$ratingreview}}</span> <span class="rvw-quantity">({{$totaluser}})</span>

                </a>

              </div>

              <?php } ?>

              <?php } ?>

              <div class="price-box-lft">

                <!-- <p>{{$recommend->quantity}}</p> -->

              </div>

              <div class="price-box-rgt">

                <p>Price ${{$recommend->price()}}</p>

              </div>

            </div>

          </div>

        </div>

      </div>

      <?php $i++; ?>

      @endif

      <?php } ?>

      @endif </div>

    @if(count($productsrecomm)>5) 

    <!--<div class="row">

      <div class="col-12">

        <div class="load-more-btn"> <a href="javascript:;" class="productsrecomm_load_more_btn" data-pg="1">load more</a> </div>

      </div>

    </div>--> 

    @endif </div>



</section>

<section class="testimonial-sec testimonial-people">

  <div class="container">

    <div class="row">

      <div class="col-12">

        <div class="sec-head pb-2">

          <h4>What People are Saying</h4>

        </div>

      </div>

      <div class="col-12"> 

        <div class="loop testimonial-slider owl-carousel"> 

          <?php

          foreach ($testimonials as $key => $value) {

            $ext = '';
            if(isset($value->post_image)) {
              //$info = pathinfo(PRODUCT_ROOT_PATH.$value->post_image);
              $info = pathinfo(url('public/uploads/testimonial/post_image/'.$value->post_image));
              $ext = $info['extension'];
            }
                              
            $img = url('/public/images/profile-user-img.png');
            if($value->image != '')
              $img = url('public/uploads/testimonial/' . $value->image);
            ?>

            <div class="item w-100"> 
              <div class="testi-user d-flex align-items-center">
                <div class="user-pic">
                  <img src="{{ $img }}" alt="">
                </div> 
                <div class="user-name">
                  <h4>{{ $value->first_name . ' ' . $value->last_name }}</h4>
                  <p>{{ $value->title }}</p>
                </div>  
              </div>
              <div class="testi-description">
                <p>{!! nl2br($value->comment) !!}</p>
              </div>
            </div>
           
          <?php } ?>

          <!-- <div class="item">

            <div class="testi-user d-flex align-items-center">

              <div class="user-pic">

                <img src="https://manofmany.com/wp-content/uploads/2019/06/50-Long-Haircuts-Hairstyle-Tips-for-Men-5.jpg" alt="">

              </div>

              <div class="user-name">

                <h4>Kate Lawrence</h4>

                <p>Photographer</p>

              </div>  

            </div>

            <div class="testi-description">

              <p>Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

            </div>

          </div>

          <div class="item">

            <div class="testi-user d-flex align-items-center">

              <div class="user-pic">

                <img src="https://manofmany.com/wp-content/uploads/2019/06/50-Long-Haircuts-Hairstyle-Tips-for-Men-5.jpg" alt="">

              </div>

              <div class="user-name">

                <h4>Kate Lawrence</h4>

                <p>Photographer</p>

              </div>  

            </div>

            <div class="testi-description">

              <p>Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

            </div>

          </div>

          <div class="item">

            <div class="testi-user d-flex align-items-center">

              <div class="user-pic">

                <img src="https://manofmany.com/wp-content/uploads/2019/06/50-Long-Haircuts-Hairstyle-Tips-for-Men-5.jpg" alt="">

              </div>

              <div class="user-name">

                <h4>Kate Lawrence</h4>

                <p>Photographer</p>

              </div>  

            </div>

            <div class="testi-description">

              <p>Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae</p>

            </div>

          </div>

          <div class="item">

            <div class="testi-user d-flex align-items-center">

              <div class="user-pic">

                <img src="https://manofmany.com/wp-content/uploads/2019/06/50-Long-Haircuts-Hairstyle-Tips-for-Men-5.jpg" alt="">

              </div>

              <div class="user-name">

                <h4>Kate Lawrence</h4>

                <p>Photographer</p>

              </div>  

            </div>

            <div class="testi-description">

              <p>Curabitur mollis bibendum luctus. Duis suscipit vitae dui sed suscipit. Vestibulum auctor nunc vitae diam eleifend, in maximus metus sollicitudin. Quisque vitae sodales lectus. Nam porttitor justo sed mi finibus, vel tristique risus faucibus. </p>

            </div>

          </div> -->

        </div>

      </div>

    </div>

  </div>

</section>

<script>

  $(document).ready(function(){

    $('.testimonial-slider').owlCarousel({ 

        autoplay:true,

        stagePadding:5,

        autoplayTimeout:5000,

        autoplayHoverPause: true,

        loop:true,

        margin:15,

        //autoHeight:true,

        nav:true,

        dots:false,

        navElement: 'div',

        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],

        responsive:{

            0:{

                items:1

            },

            600:{

                items:2

            },

            1000:{

                items:3

            }

        }

    });

  });

  

</script>



<script>

  $(document).ready(function(){

    $('.testimonial-slider22').owlCarousel({ 

        autoplay:true,

        stagePadding:5,

        autoplayTimeout:5000,

        autoplayHoverPause: true,

        loop:true,

        margin:30,

        //autoHeight:true,

        nav:true,

        dots:false,

        navElement: 'div',

        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],

        responsive:{

            0:{

                items:1

            },

            600:{

                items:2

            },

            1000:{

                items:4

            }

        }

    });

  });
</script>

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

$(document).on('click', '.japanese_load_more_btn', function() {

	var pg	= $(this).attr('data-pg');

	pg 		=  Number(pg)+1;

	$(this).attr('data-pg',pg);

	var load_more_sec=$(this);

    $.ajax({

		type: 'POST',

        url: "{{ url('/ajaxpost') }}",

        data: {

            action: 'get_load_more_japanese_food',

			pg: pg,

			_token: $('meta[name="csrf-token"]').attr('content')

        },

        dataType: 'json',

        beforeSend: function() {

            //$("#overlay").show();

			load_more_sec.text('Loading...');

        },

        success: function(data) {

            //$("#overlay").hide();

			$('#japanese_food_section').append(data.html);

			if(data.is_load_more=='N'){

				load_more_sec.hide();

			}

			load_more_sec.text('load more');

        }

    });

});

$(document).on('click', '.restaurant_load_more_btn', function() {

	var pg	= $(this).attr('data-pg');

	pg 		=  Number(pg)+1;

	$(this).attr('data-pg',pg);

	var load_more_sec=$(this);

    $.ajax({

		type: 'POST',

        url: "{{ url('/ajaxpost') }}",

        data: {

            action: 'get_load_more_restaurant',

			pg: pg,

			_token: $('meta[name="csrf-token"]').attr('content')

        },

        dataType: 'json',

        beforeSend: function() {

            //$("#overlay").show();

			load_more_sec.text('Loading...');

        },

        success: function(data) {

            //$("#overlay").hide();

			$('#restaurant_section').append(data.html);

			if(data.is_load_more=='N'){

				load_more_sec.hide();

			}

			load_more_sec.text('load more');

        }

    });

});


$(document).on('click', '.chef_load_more_btn', function() {

	var pg	= $(this).attr('data-pg');

	pg 		=  Number(pg)+1;	

	$(this).attr('data-pg',pg);

	var load_more_sec=$(this);
	
    $.ajax({

		type: 'POST',

        url: "{{ url('/ajaxpost') }}",

        data: {

            action: 'get_load_more_chef',

			pg: pg,

			_token: $('meta[name="csrf-token"]').attr('content')

        },

        dataType: 'json',

        beforeSend: function() {

            //$("#overlay").show();

			load_more_sec.text('Loading...');

        },

        success: function(data) {

            //$("#overlay").hide();

			$('#chefs_section').append(data.html);

			if(data.is_load_more=='N'){

				load_more_sec.hide();

			}

			load_more_sec.text('load more');

        }

    });

});

$(document).on('click', '.productsrecomm_load_more_btn', function() {

	var pg	= $(this).attr('data-pg');

	pg 		=  Number(pg)+1;
	
	$(this).attr('data-pg',pg);

	var load_more_sec=$(this);

    $.ajax({

		type: 'POST',

        url: "{{ url('/ajaxpost') }}",

        data: {

            action: 'get_load_more_recommended',

			pg: pg,

			_token: $('meta[name="csrf-token"]').attr('content')

        },

        dataType: 'json',

        beforeSend: function() {

            //$("#overlay").show();

			load_more_sec.text('Loading...');

        },

        success: function(data) {

            //$("#overlay").hide();

			$('#recommended_section').append(data.html);

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
@endsection 