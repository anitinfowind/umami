@extends('frontend.layouts.app')
@section ('title', trans('Restaurant'))
@section('content')



<div class="inner-breadcrumbs-menu">
    <div class="container">
        <ul>
            <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
            <li><span>Restaurent Detail</span></li>
        </ul>
    </div>
</div>
<div class="u-menu">
  <div class="container">
    <div class="restro-slider-section">
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
          
          <div class="restro-tabbing">
              <ul class="nav nav-pills menu-tab" id="pills-tab" role="tablist">
                  <li class="nav-item active">
                      <a class="nav-link" id="lunch-tab" data-toggle="pill" href="#res-menu" role="tab" aria-controls="lunch" aria-selected="false">
                          <img src="{{ WEBSITE_IMG_URL }}menu.png">Menu</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="dessert-tab" data-toggle="pill" href="#photos" role="tab" aria-controls="dessert" aria-selected="false">
                          <img src="{{ WEBSITE_IMG_URL }}photos.png">Photos</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="category-tab" data-toggle="pill" href="#res-chef" role="tab" aria-controls="category"
                         aria-selected="false">
                          <img src="{{ WEBSITE_IMG_URL }}brunch.png">Chefs
                      </a>
                  </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
               
                  <div class="tab-pane active" id="res-menu">
                    <div class="row">
                      @if($restaurantInfomation->product->isNotEmpty())
                      @foreach($restaurantInfomation->product as $product)
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
                      ?>
                        <div class="col-sm-3">
                          <div class="product-box">
                              <div class="product-img-box" data-productId="{{$product->id}}" data-image="{{PRODUCT_URL.$product->singleProductImage->image}}" data-title="{{ Str::limit($product->title,21) }}" data-description="{{ Str::limit($product->description,70) }}" data-price="{{$product->price()}}" data-slug="{{$product->slug}}"  data-rating="{{ round($ratingreview,1)}}" data-user="{{$totaluser}}"  data-quantity="{{$product->quantity}}" data-restautrant="{{$restaurantname}}" data-extension="{{$ext}}">
                             @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                              <div class="product-img">
                                @if(!empty($product->singleProductImage->image) &&
                                  File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image))
                                  <?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
                                @else
                                  <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                @endif
                                <a href="{{ url('product-detail/'.$product->slug) }}"> 
                                  <img class="product_image_resto" src="{{ $image }}" alt="{{ $product->title }}">
                                </a>
                              </div>
                               @else
                              <video width="100%" height="192px"  muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                              <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
                              </video>
                              @endif
                            </div>
                          </div>
                        </div>
                        @endif
                      @endforeach 
                     @else
                      <img src="{{ WEBSITE_IMG_URL.'no-product.jpg' }}">  
                     @endif 
                     </div>
                  </div>
                  <div class="tab-pane" id="res-chef">
                      <div class="restro-desc">
                              <div class="row">
                               @if($chefsData->isNotEmpty())
                                  @foreach($chefsData as $chefs)
                                    <div class="col-md-4">
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
                                          <div class="view-detail chef-detail">
                                            <p>Email: {{$chefs->email}}</p>
                                          </div>
                                        
                                        <div class="product-detail chf-info">
                                          <h4>{{$chefs->name}}</h4>
                                          <p>{{$chefs->designation}}</p>
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
                <div class="tab-pane" id="photos">
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
          font-weight: 500;
          text-transform: uppercase;
          margin: 0;
          display: inline-block;
          width: 75%;
          float: left;
        }
        .append-detail b {
            float: right;
            width: 25%;
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
          float: right;
          line-height: 20px;
        }
        .append-detail .rating-star {
      font-size: 11px;
      line-height: 26px;
    }
    .p-description {
    font-size: 13px;
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
      if(margin < 70){
        leftPos = leftPos - margin;
      }
      var topPos = $(this).offset().top;
      var rightPos = $(this).offset().right;
      if(leftPos < 90){
        leftPos = 90;
      }

      var ree=$(this).attr('data-productId');
      var image=$(this).attr('data-image');
      var title=$(this).attr('data-title');
      var description=$(this).attr('data-description');
      var price=$(this).attr('data-price');
      var slug=$(this).attr('data-slug');
      var rating=$(this).attr('data-rating');
      var user=$(this).attr('data-user');
      var quantity=$(this).attr('data-quantity');
      var restaurant=$(this).attr('data-restautrant');
      var ext =$(this).attr('data-extension');
      var url="<?php echo url('/');?>";
      var ratingdata='';
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
         $('.append_div').html('<div class="recommended_product"><div class="product-img"> <a href="'+url+'/product-detail/'+slug+'"> <img class="product_image_resto" src="'+image+'" alt="'+title+'"></a></div><div class="append-detail"><div class="d-flex justify-content-between"><h3 title="'+title+'">'+title+'</h3><b><span class="">$ '+price+'</span></b></div><sapn class="quantity">'+quantity+'</span> '+ratingdata+'<div class="p-description">'+description+'</div><div class="restaurant_name text-center">'+restaurant+'</div></div></div></div>');
       }
       else
       {
        $('.append_div').html('<div class="recommended_product"><div class="product-img"> <a href="'+url+'/product-detail/'+slug+'"> <video width="100%" height="192px" muted loop  controls autoplay poster="'+url+'/thimbnailimage.png"><source src="'+image+'" type="video/mp4"></video></a></div><div class="append-detail"><div class="d-flex justify-content-between"><h3 title="'+title+'">'+title+'</h3><b><span class="">$ '+price+'</span></b></div><sapn class="quantity">'+quantity+'</span> '+ratingdata+'<div class="p-description">'+description+'</div><div class="restaurant_name text-center">'+restaurant+'</div></div></div></div>');

       } 
   });

    $(".append_div").on('mouseout',function(){
      $(this).html('').removeClass('open');
    });

  });
</script>
@endsection