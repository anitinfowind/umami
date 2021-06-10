@extends('frontend.layouts.app')
@section('content')
<?php

  $backgroundImage=isset($restaurantInfomation->restaurantBranch->background_image)?$restaurantInfomation->restaurantBranch->background_image:'sea-food-banner.jpg';

?>
@if(auth()->user())
<input type="hidden" name="isuservalid" value="{{auth()->user()->isUser()}}" class="userCheckAuth">
@endif
<div class="menu-detail-banner food-inner-banner p-0" style="background: url({{url('uploads/restaurant/'.$backgroundImage)}});">
    <div class=" p-">
        <div class="row product-detail-profile">
            <div class="col-12 col-sm-12">
              <div class="user-div">
                    @if($user->image !=='' &&  File::exists(USER_PROFILE_IMAGE_ROOT_PATH.$user->slug.DS.$user->image))
                    <img  src="{{ USER_PROFILE_IMAGE_URL.$user->slug.DS.$user->image }}">
                    @else
                    <img  src="{{url('noimage.png')}}">
                    @endif
                </div>
                <div class="spec-description food-right-desc">
                    <!-- <h1>{{isset($user->name)?$user->name:''}}</h1> -->
                    @if(!empty($user->isRestaurantLocation->country))
                   <h1><span>{{isset($user->isRestaurant->name)?$user->isRestaurant->name:''}} </span> </h1> <h5 class="d-inline-block ml-3"><!-- <i class="fa fa-map-marker"></i> {{isset($user->isRestaurantLocation->country)?$user->isRestaurantLocation->country:''}} --></h5> @endif
                    <!-- <p>{!!isset($user->isRestaurantBranchs->description)?$user->isRestaurantBranchs->description:''!!}</p> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="u-menu">
    <div class="container-fluid">

      <div class="restro-slider-section company-slider-section">
         <div class="row">
      <div class="col-md-6 pd-r">
          <div id="custCarousel" class="carousel restro-slide" data-ride="carousel" align="center">
                <div class="main-slider">
                  <div class="carousel-inner">
                    @if($restaurantInfomation->restaurantImage->isNotEmpty())

                      <?php $i = ONE ?>
                      @foreach($restaurantInfomation->restaurantImage as $restaurantImage)
                          @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
                              <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
                          @else
                              <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                          @endif

                          <div class="carousel-item @if($i == ONE) active @endif">
                              <img src="{{ $image }}" alt="{{ $restaurantInfomation->name() }}">
                          </div>
                          <?php $i++; ?>
                      @endforeach
                      @else
                       <div class="carousel-item  active">
                              <img src="{{ WEBSITE_IMG_URL.'no-image.png' }}">
                          </div>

                      @endif
                  </div>
                   <a class="carousel-control-prev" href="#custCarousel" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#custCarousel" data-slide="next"> <span class="carousel-control-next-icon"></span> </a>
                </div>
                <!-- Thumbnails -->
                  <div class="thumb-slider">
                      <ol class="carousel-indicators list-inline">
                          <?php $j = ONE;
                              $totalImage = $restaurantInfomation->restaurantImage->count();
                              $class = '';
                              if($totalImage <= FOUR) {
                                  $class = '';
                              } elseif($totalImage <= SIX) {
                                  $class = 'six';
                              } elseif($totalImage <= EIGHT) {
                                  $class = 'eight';
                              } elseif($totalImage <= TEN) {
                                  $class = 'ten';
                              }
                          ?>
                          @foreach($restaurantInfomation->restaurantImage as $restaurantImage)
                              @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
                                  <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
                              @else
                                  <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                              @endif
                              <li class="list-inline-item @if($j == ONE) active @endif">
                                  <a id="carousel-selector-{{$j}}" class="selected" data-slide-to="{{$j}}" data-target="#custCarousel">
                                      <img src="{{$image}}" class="img-fluid {{ $class }}"> </a>
                              </li>
                              <?php $j++; ?>
                          @endforeach
                      </ol>
                  </div>
               </div>
           </div>
         
          <div class="col-md-6">
            <div class="restro-info">
              <h3>{{ $restaurantInfomation->name() }}</h3>
              <label><span>Country : </span>{{ $restaurantInfomation->restaurantLocation->country() }}</label>
              <label><span>State : </span>{{ $restaurantInfomation->restaurantLocation->state() }}</label>
              <label><span>City : </span>{{ $restaurantInfomation->restaurantLocation->city() }}</label>
              <label><span>Description : </span> <p>{!! $restaurantInfomation->restaurantBranch->description()  !!}</p></label>
              
            </div>
          </div>
        </div>
      </div>
        <div class="food-menu-tab">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <div class="filter-sort">
                        <select class="form-control company_product">
                            <option value="best_sellers">Sort By: <b>Best Sellers</b></option>
                            <option value="trending">Trending</option>
                            <option value="lowest_first">Price: Lowest First</option>
                            <option value="highest_first">Price: Highest First</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row loaddata">
                        @if($products->isNotEmpty())
                        @foreach($products as $product)
                        @if(isset($product->singleProductImage->image) && !empty($product->singleProductImage->image))
                        <?php 
                        $restaurantname=restaurantName($product->restaurant_id);
                            $info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
                           $ext = $info['extension'];
                            $productrating=App::make('App\Http\Controllers\Frontend\ProductController')->getRating($product->id);
                              $ratingreview='';
                              $totaluser='';
                              if(count($productrating)>0)
                              {
                                $totalsum=collect($productrating)->sum('average_rating');
                                $totaluser= count($productrating);
                                $ratingreview=($totalsum/$totaluser);
                              }
                               if(!empty($product->favorite))
                                {
                                  $favorite= 'yes';
                                } else{
                                  $favorite= 'no';
                                }
                          ?>
                        <div class="col-sm-3 product-box">
  
                               <div class="product-img-box" data-productId="{{$product->id}}" data-image="{{PRODUCT_URL.$product->singleProductImage->image}}" data-title="{{ Str::limit($product->title,15) }}" data-description="{{ Str::limit($product->description,137) }}" data-price="{{$product->price()}}" data-slug="{{$product->slug}}"  data-rating="{{ round($ratingreview,1)}}" data-user="{{$totaluser}}"  data-quantity="{{$product->quantity}}" data-restautrant="{{$restaurantname}}" data-extension="{{$ext}}" data-userfavorite="{{$favorite}}">
                              @if($ext!='mp4')
                              <div class="product-img">
                                @if(!empty($product->singleProductImage->image) &&
                                File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image))
                                <?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
                                @else
                                <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                @endif
                                <a href="{{url('product-detail/'.$product->slug)}}">
                                  <div class="img-box-overlay"></div>
                                  <img class="product_image_resto" src="{{ $image }}" alt="{{ $product->title }}">
                                </a>
                              </div>
                              @else
                              <video width="300px" height="200px" margin-bottom="20px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                              <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
                              </video>
                              @endif
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @else
                        <img src="{{ WEBSITE_IMG_URL.'no-product.jpg' }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="product-section">
            <div class="container">
                <h2>Restaurant Photo</h2>
                <div class="photo-gallery">
                    <ul>
                        @if($restaurantInfomation->restaurantImage->isNotEmpty())
                            @foreach($restaurantInfomation->restaurantImage as $restaurantImage)
                                @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
                                    <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
                                @else
                                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                                @endif
                                <li>
                                    <img src="{{ $image }}">
                                </li>
                            @endforeach
                        @else
                            <li>
                                <img src="{{ WEBSITE_IMG_URL.'no-image.png' }}">
                            </li>
                        @endif
                    </ul>
                  </div>
            </div>
        </div> -->
        <div class="product-section rest_chef_section">
            <div class="">
                <h2>Chefs</h2>
                <div class="row">
                   @if($chefsData->isNotEmpty())
                      @foreach($chefsData as $chefs)
                        <div class="col-md-3 col-sm-6">
                          <div class="product-box">
                              <div class="product-img">
                                 @if(!empty($chefs->image) &&
                                    File::exists(CHEF_ROOT_PATH.$chefs->image))
                                      <?php $image = CHEF_URL.$chefs->image; ?>
                                  @else
                                      <?php $image = WEBSITE_IMG_URL.'ch1.jpg'; ?>
                                  @endif
                                  <img class="chefs_image" src="{{$image}}">
                              </div>
                            
                            <div class="product-detail chf-info">
                              <h4>{{$chefs->name}}</h4>
                             <a href="{{url('chef-detail/'.$chefs->slug)}}"> <p> {!! Str::limit($chefs->description,40)!!}</p></a>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <h3 class="text-center"> Chefs Not Available. </h3> 
                    @endif  
                </div>
            </div>
        </div>
        <div class="product-section">
                  <h2>Recommended For You</h2>
                    <div class="owl-demo">
                        @if($productsrecomm->isNotEmpty())
                        @foreach($productsrecomm as $restaurant)
                        @if(isset($restaurant->restaurantSingleImage->image) && !empty($restaurant->restaurantSingleImage->image))
                         <?php 

                            $info = pathinfo(RESTAURANT_ROOT_PATH.$restaurant->restaurantSingleImage->image);
                           $ext = $info['extension'];
                          ?>
                        <div class="item">
                          <div class="product-box col-sm-12 recommonded_rest">
                           <div class="product-img-box2 product-box"  data-name="{{$restaurant->name}}" data-description="{{isset($restaurant->restaurantBranch->description)?$restaurant->restaurantBranch->description:''}}" data-image="{{url('uploads/restaurant/'.$restaurant->restaurantSingleImage->image)}}" data-slug="{{$restaurant->userSlug->slug}}">
                              @if($ext!='mp4')
                              <div class="product-img">
                                @if(!empty($restaurant->restaurantSingleImage->image) &&
                                File::exists(RESTAURANT_ROOT_PATH.$restaurant->restaurantSingleImage->image))
                                <?php $image = RESTAURANT_URL.$restaurant->restaurantSingleImage->image; ?>
                                @else
                                <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                @endif
                                <a href="{{url('product-detail/'.$restaurant->slug)}}">
                                  <div class="img-box-overlay"></div>
                                  <img class="product_image_resto" src="{{ $image }}" alt="{{ $restaurant->name }}">
                                </a>
                              </div>
                              @endif
                            </div>
                          </div>
                        </div>
                      @endif
                    @endforeach
                    @endif
                    </div>
        </div>
     </div>
    </div>
</div>


  <div class="append_div open"> </div>

    <style type="text/css">
    .recommended_product.recommended_product_12 {
            position: relative;
            bottom: 189px;
        }

    .append_div {
      position: absolute;
      width: 270px;
      visibility: hidden;
      opacity: 0;
      transition: visibility 0s, opacity 0.5s linear;
      background: #fff;
      box-shadow: none;
      z-index: 9999;
      border-radius: 3px;
    }
    .append_div.open{
       visibility: visible;
       transition: all .2s ease-in-out;
       transform: scale(1.3);
      opacity: 1;                    
    }
    .append_div .product-img img.product_image_resto {
      border: none;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }
    .append-detail {
        display: inline-block;
        width: 100%;
        box-shadow: 0px 2px 5px #494949;
      }
      .append-detail {
        display: inline-block;
        width: 100%;
        box-shadow: 0px 2px 5px #494949;
        padding: 5px 10px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
      }
      .append-detail h3 {
          font-size: 11px;
          text-transform: uppercase;
          margin: 0;
          display: inline-block;
          width: 50%;
          float: left;
          font-weight: bolder;
          line-height: 14px;
      }
        .append-detail b {
            float: right;
            width: 50%;
            text-align: right;
            line-height: 14px;
          }
        .append-detail span {
          font-size: 11px;
        }
        .append-detail .rating-star {
           font-size: 11px;
           line-height: 18px;
          }
        .append-detail .rating-stars {
            margin-left: 0;
            float: left;
            line-height: 14px;
            position: absolute;
            left: 10px;
        }
        .append-detail .rating-star {
      font-size: 11px;
      line-height: 26px;

    }


    </style>
<script>
  $(document).ready(function(){
    $(".product-img-box").hover(function(){
      docWith = $(document).width();
      w = $(this).width();
      var leftPos = $(this).offset().left;
      totalLeft = leftPos + w;
      margin = docWith - totalLeft;
      if(window.innerWidth > 575 && margin < 70)
      {
        leftPos = leftPos+5;
      } 
      else if(window.innerWidth < 575 && margin > 200)
      {        
          console.log('left '+margin)
         leftPos = leftPos+10;
      }
      else if(window.innerWidth < 575 && (margin < 150 || margin < 30))
      {
         console.log('right '+margin)
         leftPos = leftPos-10;
      }
      
     
      var topPos = $(this).offset().top;
      var rightPos = $(this).offset().right;
     if(window.innerWidth > 575 && rightPos < 70){
        leftPos = 70;
      }
      var ree=$(this).attr('data-productId');
      var image=$(this).attr('data-image');
      var title=$(this).attr('data-title');
      var authuser="<?php echo auth()->check(); ?>";
      var description=$(this).attr('data-description');
      var price=$(this).attr('data-price');
      var slug=$(this).attr('data-slug');
      var rating=$(this).attr('data-rating');
      var user=$(this).attr('data-user');
      var quantity=$(this).attr('data-quantity');
      var restaurant=$(this).attr('data-restautrant');
      var ext =$(this).attr('data-extension');
      var userFavorite =$(this).attr('data-userfavorite');
      var url="<?php echo url('/');?>";
      var ratingdata='';
      favouriteData='';
       if(authuser)
       {
        var useronly=$('.userCheckAuth').val();
         if(useronly==1)
         {
          if(userFavorite=='yes'){
           var favouriteData='<a href="javascript:void(0)" class="unfavourite_token fav_'+ree+'" data-fav-id="'+ree+'" data-fav-value="12"><i class="dataamount food_tab_'+ree+' fa fa-heart"  id="fav_'+ree+'"></i></a>';
          }
          else{
             var favouriteData='<a href="javascript:void(0)" class="unfavourite_token fav_'+ree+'" data-fav-id="'+ree+'" data-fav-value="12"><i class="dataamount food_tab_'+ree+' fa fa-heart-o"  id="fav_'+ree+'"></i></a>';
          }
        }
       }else{
          var favouriteData='<a href="'+url+'/login" class="unfavourite_token fav_'+ree+'" data-fav-id="'+ree+'" data-fav-value="12"><i class="dataamount food_tab_'+ree+' fa fa-heart-o"  id="fav_'+ree+'"></i></a>';
       }

       if(rating!=0)
       {
        var ratingdata= '<div class="rating-stars"><div class="rating-star text-right"><i class="fa fa-star"> '+rating+'</i> <span class="user_count">('+user+')</span></div></div>'
       }
      setTimeout(function(){

        $('.append_div').addClass('open');
      },200);
      $('.append_div').css({'top':topPos+'px','left':leftPos+'px','width':w+'px'});

       if(ext=='jpeg'|| ext=='jpg'|| ext=='png' ||ext=='gif'||ext=='webp')
       {
         $('.append_div').html('<div class="recommended_product"><div class="product-img"> <a href="'+url+'/product-detail/'+slug+'"> <img class="product_image_resto" src="'+image+'" alt="'+title+'"></a></div><div class="append-detail"><div class="d-flex justify-content-between"><h3 title="'+title+'">'+title+'</h3><b><span class="">'+quantity+' SERVINGS $ '+price+'</span></b></div><div class="p-description">'+description+'</div> '+ratingdata+'<div class="restaurant_name text-center">'+restaurant+''+favouriteData+'</div></div></div></div>');
       }
       else
       {
         $('.append_div').html('<div class="recommended_product"><div class="product-img"> <a href="'+url+'/product-detail/'+slug+'"> <video width="100%" height="192px" muted loop  controls autoplay poster="'+url+'/thimbnailimage.png"><source src="'+image+'" type="video/mp4"></video></a></div><div class="append-detail"><div class="d-flex justify-content-between"><h3 title="'+title+'">'+title+'</h3><b><span class="">'+quantity+' SERVINGS $ '+price+'</span></b></div><div class="p-description">'+description+'</div>'+ratingdata+'<div class="restaurant_name text-center">'+restaurant+''+favouriteData+'</div></div></div></div>');

       } 
   });



     $(".product-img-box2").hover(function(){
      docWith = $(document).width();
      w = $(this).width();
      var leftPos = $(this).offset().left;
      totalLeft = leftPos + w;
      margin = docWith - totalLeft;
      if(window.innerWidth > 575 && margin < 70)
      {
        leftPos = leftPos-10;
      } 
      else if(window.innerWidth < 575 && margin > 200)
      {        
          console.log('left '+margin)
         leftPos = leftPos+10;
      }
      else if(window.innerWidth < 575 && (margin < 150 || margin < 30))
      {
         console.log('right '+margin)
         leftPos = leftPos-10;
      }
      
     
      var topPos = $(this).offset().top;
      var rightPos = $(this).offset().right;
     if(window.innerWidth > 575 && rightPos < 70){
        leftPos = 70;
      }
      var url="<?php echo url('/');?>";
      var description=$(this).attr('data-description');
      var image=$(this).attr('data-image');
      var slug=$(this).attr('data-slug');
      var name=$(this).attr('data-name');
        setTimeout(function(){
              $('.append_div').addClass('open');
            },200);
            $('.append_div').css({'top':topPos+'px','left':leftPos+'px','width':w+'px'});
       $('.append_div').html('<div class="recommended_product"><div class="product-img"> <a href="'+url+'/user-detail/'+slug+'"> <img class="product_image_resto" src="'+image+'"></a></div><div class="append-detail"><div class="d-flex justify-content-between"><h3 title="'+name+'">'+name+'</h3></div><div class="p-description">'+description+'</div></div></div></div>');


    });

    $(document).on('mouseleave',".append_div",function(e){
      $(this).removeClass('open');
    });
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
</script>
@endsection
