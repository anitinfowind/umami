@extends('frontend.layouts.app')
@section ('title', trans('Restaurant'))
@section('content')
    <div class="inner-breadcrumbs-menu">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
                <li><span>Restaurent</span></li>
            </ul>
        </div>
    </div>
    <div class="u-menu">
        <div class="container">
            <div class="restaurent-section">
                <div class="row">
                    @if($restaurants->isNotEmpty())
                        @foreach($restaurants as $restaurant)
                         <?php 
                            $rating=App::make('App\Http\Controllers\Frontend\RestaurantController')->restaurantRating($restaurant->user_id);
                             $ratingreview='';
                              $totaluser='';
                              if(count($rating)>0)
                              {
                                $totalsum=collect($rating)->sum('average_rating');
                                $totaluser= count($rating);
                                $ratingreview=($totalsum/$totaluser);
                              }
                          ?>
                            @if(!empty($restaurant->restaurantSingleImage->image) && File::exists(RESTAURANT_ROOT_PATH
                            .$restaurant->restaurantSingleImage->image()))
                                <?php $image = RESTAURANT_URL.$restaurant->restaurantSingleImage->image(); ?>
                            @else
                                <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                            @endif
                            <div class="col-sm-6">
                                <div class="restaurent-box">
                                    <div class="res-img">
                                        <a href="{{ url('user-detail', $restaurant->userSlug->slug()) }}">
                                            <img class="resto" src="{{ $image }}" alt="{{ $restaurant->name() }}">
                                        </a>
                                    </div>
                                    <div class="product-detail">
                                        <a href="{{ url('user-detail', $restaurant->userSlug->slug()) }}">
                                            <h4>{{ $restaurant->name() }} 
                                            @if(!empty($ratingreview))
                                             <i class="fa fa-star"></i> {{$ratingreview}} ({{$totaluser}})
                                             @endif
                                           </h4>
                                            <p> {{ Str::limit(isset($restaurant->restaurantBranch->description)?$restaurant->restaurantBranch->description:"", SHORT_LIMIT) }}</p>
                                        </a>
                                        <div class="res-loc"><i class="fa fa-map-marker"></i>{{ isset($restaurant->restaurantLocation->state)?$restaurant->restaurantLocation->state:'' }}, <?php 
                                        $cities=isset($restaurant->restaurantLocation->city)?$restaurant->restaurantLocation->city:'College';
                                  $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($cities)."&sensor=false&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
                                            
                                    $result_string = file_get_contents($url);
                                      $result = json_decode($result_string, true);
                                      $dataresultcheck=$result['results'][0]['address_components'];
                                       if(in_array('administrative_area_level_1', $dataresultcheck[0]['types'])){
                                            echo  $stateshort_code =$result['results'][0]['address_components'][1]['short_name'];
                                           }else if(in_array('administrative_area_level_1', $dataresultcheck[1]['types'])){
                                           echo  $stateshort_code =$result['results'][0]['address_components'][1]['short_name'];
                                           }else if(in_array('administrative_area_level_1', $dataresultcheck[2]['types'])){
                                          echo   $stateshort_code =$result['results'][0]['address_components'][2]['short_name'];
                                           }else if(in_array('administrative_area_level_1', $dataresultcheck[3]['types'])){
                                           echo  $stateshort_code =$result['results'][0]['address_components'][3]['short_name'];
                                           } else if(in_array('administrative_area_level_1', $dataresultcheck[4]['types'])){
                                          echo   $stateshort_code =$result['results'][0]['address_components'][4]['short_name'];
                                           } 
                                        
                                        ?></div>

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