@extends('frontend.layouts.app')
@section ('title', trans('Newly restaurant'))
@section('content')
    <div class="inner-breadcrumbs-menu">
        <div class="container">
           <div class="row">
             <div class="col-sm-9">
               <img src="{{url('images/blog-slider.jpg')}}">
             </div>
             <div class="col-sm-3">
             <h3> Newly Added Shops</h3>
              The Goldbelly tasting team takes its job pretty seriously. This month was no exception. Like any upstanding food explorer would do, we’re sharing some of the best new treats, eats, & meal kits from iconic American restaurants, ready to be Goldbelly’d right to your door! Now, that’s a whole lot of comfort food that’s heading straight for your belly.
             </div>
        </div>
      </div>
    </div>
    <div class="u-menu">
        <div class="container">
            <div class="restaurent-section">
                <div class="row">
                    @if($restaurants->isNotEmpty())
                        @foreach($restaurants as $restaurant)
                            @if(!empty($restaurant->restaurantSingleImage->image) && File::exists(RESTAURANT_ROOT_PATH
                            .$restaurant->restaurantSingleImage->image()))
                                <?php $image = RESTAURANT_URL.$restaurant->restaurantSingleImage->image(); ?>
                            @else
                                <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                            @endif
                            <div class="col-sm-6">
                                <div class="restaurent-box">
                                    <div class="res-img">
                                        <a href="{{ url('restaurant-detail', $restaurant->slug()) }}">
                                            <img class="resto" src="{{ $image }}" alt="{{ $restaurant->name() }}">
                                        </a>
                                    </div>
                                    <div class="product-detail">
                                        <a href="{{ url('restaurant-detail', $restaurant->slug()) }}">
                                            <h4>{{ $restaurant->name() }} (<i class="fa fa-star"></i> 4.0)</h4>
                                            <p> {{ Str::limit( strip_tags($restaurant->restaurantBranch->description()), SHORT_LIMIT) }}</p>
                                        </a>
                                        <div class="res-loc"><i class="fa fa-map-marker"></i>{{ $restaurant->restaurantLocation->country() }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <img style="width:100%" src="{{ WEBSITE_IMG_URL.'restro.jpg' }}">
                    @endif
                </div>
                @include('frontend.pagination.pagination', ['paginator' => $restaurants])
            </div>
        </div>
    </div>
@endsection