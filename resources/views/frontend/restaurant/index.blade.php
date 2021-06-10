@extends('frontend.layouts.layout')
@section('content')
<?php //@include('frontend.includes.new.slider') ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Restaurant</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">Restaurant</h1>

<section class="chef-search-sec">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-auto">
        <div class="sec-head">
          <h4>Restaurant</h4>
        </div>
      </div>
    </div>
    @if($restaurants->isNotEmpty())
    <div class="product-section d-flex"> @foreach($restaurants as $restaurant)
      <?php
	  	$state_info=\App\Models\State::where('name',$restaurant->restaurantLocation->state)->select('state_code')->first();
		
		//print_r($state_info);exit;
		
    	$rating=App::make('App\Http\Controllers\Frontend\RestaurantController')->restaurantRating($restaurant->user_id);
		$ratingreview='';
		$totaluser='';
		if($restaurant->is_rating_show=='Y'){
			if(count($rating)>0){
				$totalsum=collect($rating)->sum('average_rating');
				$totaluser= count($rating);
				$ratingreview=($totalsum/$totaluser);
			}
		}
		
		?>
      @if(!empty($restaurant->restaurantSingleImage->image) && File::exists(RESTAURANT_ROOT_PATH .$restaurant->restaurantSingleImage->image()))
      <?php $image = RESTAURANT_URL.$restaurant->restaurantSingleImage->image(); ?>
      @else
      <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
      @endif
      <div class="custome-col-3 product_item">
        <div class="food-box relative">
          <div class="food-pic relative"> 
            <!-- <a href111="{{ url('user-detail', (isset($restaurant->userSlug->id) ? $restaurant->userSlug->slug() : '')) }}" href="{{url('restaurant-detail/'.($restaurant->slug ?? ''))}}"><img src="{{ $image }}" alt="{{ $restaurant->name() }}"></a> -->
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
             @if(!empty($ratingreview))
            <div class="food-star-box d-flex align-items-center justify-content-center">
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
            </div>
            @endif </div>
            <?php
            //print_r($restaurant->userSlug); die;
            ?>
          <div class="food-name d-flex align-items-center justify-content-between">
            <div class="foodname-lft">
              <h4><a href="{{url('restaurant-detail/'.($restaurant->slug ?? ''))}}">{!! $restaurant->name() !!}</a></h4>
              <p><i class="fas fa-map-marker-alt"></i>{{ isset($restaurant->restaurantLocation->state)?$restaurant->restaurantLocation->state:'' }}
                <?php if(isset($state_info->state_code)){ echo ','.$state_info->state_code;} ?>
              </p>
            </div>
          </div>
          <div class="food-time-rvw-box">
            <p class="box-ftr-text">{!! Str::limit(isset($restaurant->restaurantBranch->description)?$restaurant->restaurantBranch->description:"", 82) !!}</p>
            <?php /*<p class="box-ftr-text">{!! $restaurant->restaurantBranch->description !!}</p>*/ ?>
          </div>
        </div>
      </div>
      @endforeach </div>
    
    @endif </div>
</section>
@endsection