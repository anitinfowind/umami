@extends('frontend.layouts.app')
@section('content')
<div class="inner-breadcrumbs-menu">
	<div class="container"></div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div id="c-carousel">
				<div id="wrapper">
					<div id="inner">
						<div id="caroufredsel_wrapper2">
							@if(auth()->check())
								@if(auth()->user()->isUser())
									<div class="like-img">
										@if(!empty($details->favorite))
											<a
												href="javascript:void(0)"
												class=" fav_{{ $details->id() }}"
												onclick='favourite("{{ $details->id() }}","unfavourite")'
											>
												<i class="food_tab_{{ $details->id() }} fa fa-heart" aria-hidden="true"
												id="fav_{{ $details->id() }}"></i>
											</a>
										@else
											<a
												href="javascript:void(0)"
												class="f-cart fav_{{ $details->id() }}"
												onclick='favourite("{{ $details->id() }}","favourite")'
											>
												<i class="food_tab_{{ $details->id() }} fa fa-heart-o" aria-hidden="true"
												id="fav_{{ $details->id() }}"></i>
											</a>
										@endif
									</div>
								@endif
							@else
								<div class="like-img">
									<a href="{{ url('login') }}?key=product-detail\{{$details->slug}}" class="f-cart">
										<i class="fa fa-heart-o"></i>
									</a>
								</div>
							@endif
							<div id="carousel">
								@if($details->productImage->isNotEmpty())
									@foreach($details->productImage as $images)
                  <?php
                  $info = pathinfo(PRODUCT_ROOT_PATH.$images->image);
                 $ext = $info['extension'];
                 ?>
                 @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
										@if(!empty($images->image) && File::exists(PRODUCT_ROOT_PATH.$images->image))
											<?php $image = PRODUCT_URL.$images->image; ?>
										@else
											<?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
										@endif
										<img src="{{ $image }}" alt="{{ $details->title() }}">
                   
                   <!--  <video height="230px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                  <source src="{{PRODUCT_URL.$images->image}}" type="video/mp4">
                  </video> -->

                    @endif
									@endforeach
								@else
									<img src="{{ WEBSITE_IMG_URL.'no-product-image.png' }}" alt="{{ $details->title() }}">
								@endif
							</div>
						</div>
						<div id="pager-wrapper">
							<div id="pager">
								@if($details->productImage->isNotEmpty())
									@foreach($details->productImage as $images)
                   <?php
                  $info = pathinfo(PRODUCT_ROOT_PATH.$images->image);
                 $ext = $info['extension'];
                 ?>
                  @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
										@if(!empty($images->image) && File::exists(PRODUCT_ROOT_PATH.$images->image))
											<?php $image = PRODUCT_URL.$images->image; ?>
										@else
											<?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
										@endif
										<img src="{{ $image }}" width="120" height="72" alt=""/>
                   
                   <!--  <video width="120" height="72p" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                  <source src="{{PRODUCT_URL.$images->image}}" type="video/mp4">
                  </video> -->
                    @endif
									@endforeach
								@endif
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<button id="prev_btn2" class="prev2"><img src="{{ WEBSITE_IMG_URL.'spacer.png' }}" alt=""/></button>
					<button id="next_btn2" class="next2"><img src="{{ WEBSITE_IMG_URL.'spacer.png' }}" alt=""/></button>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="gift-description">
				<h2>{{ $details->title() }}</h2>
				<span>From</span>
				<a href="{{ url('user-detail/'.$details->user->slug)}}">
					<span class="ml-2 theme-clr"> {{
          restaurantName($details->restaurant_id) }} </span>
				</a>
				<div class="rating-stars">
					<div class="rating-star">
            @for($i=1;$i<= $ratingreview; $i++)
						<i class="fa fa-star"></i>
            @endfor
					</div>
					<span class="pro-rating">
          @if(!empty($totaluser)){{isset($totaluser)?$totaluser:''}} reviews @endif</span>
				</div>
				
				@if($productAttrs->isNotEmpty())
					<br/>
					@foreach($productAttrs as $productAttr)
						@if(in_array($productAttr->id,explode(',',$details->attributeId())))
							<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{$productAttr->name}}">
								<img class="attribute_icon" src="{{ ATTRIBUTE_URL.$productAttr->icon}}">
							</a>
					   @endif
					@endforeach
				@endif
				<div class="product_price">
					<?php 
						if ($details->discount()) {
							$discount = (int) $details->price() * (int) $details->discount() / 100;
							$price = (int) $details->price()- (int) $discount;
						} else {
							$price = $details->price();
						}
					?>
					<span class="price-bold">
						${{ $price }}
					</span>
					@if($details->discount())
						<span class="ofr-price pl-1">
							${{ $details->price() }}
						</span>
						<span class="discount pl-1">{{ $details->discount() }}%</span>
					@endif
					
					@if(auth()->check())
						@if(auth()->user()->isUser())
							@if(!empty($details->order))
								<br/>
								<a href="{{ url('cart') }}">
									<button class="btn cart-btn">
										Go to Cart
									</button>
								</a>
							@else 
								<br/>
								<button class="btn cart-btn" onclick='addToCart("{{ $details->slug() }}")'>
									Add to Cart
								</button>
							@endif
						@endif
					@else
						<br/>
						<a href="{{ url('login') }}?key=product-detail\{{$details->slug}}">
							<button class="btn cart-btn">Add to Cart</button>
						</a>
					@endif
				</div>
				@if(isset($details->video) && !empty($details->video)) 
					<div class="video my-3">
						<video width="100%" controls>
							<source src="{{PRODUCT_URL.$details->video}}" type="video/mp4">
						</video>
					</div>
				@endif  
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="discription">
				<h4>Description</h4>
				<p>{!! $details->description() !!}</p>
			</div>
			<div class="product-info mb-5">
				<h4>Product Info</h4>
				<div id="accordion1" class="accordion">
					<div class="card mb-0">
						@if($details->ingredients())
							<div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
								<a class="card-title"> Ingredients </a>
							</div>
							<div id="collapseOne" class="card-body collapse" data-parent="#accordion">
								<p>{!! $details->ingredients() !!}</p>
							</div>
						@endif
            </div>
            </div> 
            <div id="accordion2" class="accordion">
              <div class="card mb-0">
						@if($details->nutrition())
							<div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
								<a class="card-title"> Instruction </a>
							</div>
							<div id="collapseTwo" class="card-body collapse" data-parent="#accordion">
								<p>{!! $details->nutrition() !!}</p>
							</div>
						@endif 
            </div>
            </div>
            <div id="accordion3" class="accordion">
          <div class="card mb-0"> 
						@if($details->details()) 
							<div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
								<a class="card-title"> How To Store Food </a>
							</div>
							<div id="collapseThree" class="collapse card-body" data-parent="#accordion">
								<p>{!! $details->details() !!}</p>
							</div>
						@endif 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="featured-dish">
	<div class="container">
		<div class="product-section">
			<h2>Recommended for you</h2>
			<div class="row">
				<div class="owl-demo12">
					@if($productsrecomm->isNotEmpty())
            @foreach($productsrecomm as $recommend)
            @if(isset($recommend->singleProductImage->image) && !empty($recommend->singleProductImage->image))
            <?php 
                  $restaurantname=restaurantName($recommend->restaurant_id);
                  $info = pathinfo(PRODUCT_ROOT_PATH.$recommend->singleProductImage->image);
                 $ext = $info['extension'];

                $productrating=App::make('App\Http\Controllers\Frontend\ProductController')->getRating($recommend->id);
                  $ratingreview='';
                  $totaluser='';
                  if(count($productrating)>0)
                  {
                    $totalsum=collect($productrating)->sum('average_rating');
                    $totaluser= count($productrating);
                    $ratingreview=($totalsum/$totaluser);
                  }
              ?>
              <div class="item">
                <div class="product-box col-sm-12">
                  <div class="product-img-box" data-productId="{{$recommend->id}}" data-image="{{PRODUCT_URL.$recommend->singleProductImage->image}}" data-title="{{ Str::limit($recommend->title,21) }}" data-price="{{$recommend->price()}}" data-slug="{{$recommend->slug}}" 
                  data-description="{{ Str::limit($recommend->description,70) }}" data-rating="{{ round($ratingreview,1)}}" data-user="{{$totaluser}}"  data-quantity="{{$recommend->quantity}}" data-restautrant="{{$restaurantname}}" data-extension="{{$ext}}">
                   @if($ext!='mp4')
                    <div class="product-img">
                      @if(!empty($recommend->singleProductImage->image) && File::exists(PRODUCT_ROOT_PATH.$recommend->singleProductImage->image))
                        <?php $image = PRODUCT_URL.$recommend->singleProductImage->image; ?>
                      @else
                        <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                      @endif
                      <a href="{{url('product-detail/'.$recommend->slug)}}"> 
                        <img class="product_image_resto" src="{{ $image }}" alt="{{ $recommend->title }}">
                      </a>
                    </div>
                    @else
                    <video width="100%" height="192px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                  <source src="{{PRODUCT_URL.$recommend->singleProductImage->image}}" type="video/mp4">
                  </video>

                    @endif
                    <!-- <div class="view-detail">
                      <a href="{{ url('product-detail/'. $recommend->slug) }}"> 
                        <button class="btn view-btn">View Details</button>
                      </a>
                      @if(auth()->check())
                        @if(auth()->user()->isUser())
                          
                              <button class="btn view-btn btn-cart"  onclick='addToCart("{{ $recommend->slug }}")'><i class="fa fa-shopping-cart"></i></button>
                          @endif
                        @else
                        <a href="{{ url('login') }}"> 
                            <button class="btn view-btn btn-cart"><i class="fa fa-shopping-cart"></i></button>
                        </a>
                      @endif
                    </div>
                  
                  <div class="product-detail">
                    <h4 title="{{$recommend->title}}">{{ Str::limit($recommend->title,21) }}</h4>
                    <b>
                      <?php 
                        if ($recommend->discount()) {
                          $discount = (int) $recommend->price() * (int) $recommend->discount() / 100;
                          $price = (int) $recommend->price()- (int) $discount;
                        } else {
                          $price = $recommend->price();
                        }
                      ?>
                      <span class="">
                        ${{ $price }}
                      </span>
                      @if($recommend->discount())
                        <span class="ofr-price dis">
                          ${{ $recommend->price() }}
                        </span>
                        <span class="discount per">{{ $recommend->discount() }}%</span>
                      @endif
                    </b>
                  </div> -->
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
<script src="{{url('js/owl.carousel.min.js') }}"></script>
<script src="{{url('js/jquery.carouFredSel-6.2.1-packed.js')}}"></script>
<script src="{{url('js/initialize-carousel-detailspage.js')}}"></script>
<script type="text/javascript">
	var width = 100;
	var animation_speed = 800;
	var time_val = 5000;
	var current_slide = 1;
	var $sliderText = $('#sliderText');
	var $slide_container = $('.slides');
	var $slides = $('.slide');
	var interval;
	
	$slides.each(function(index){
		$(this).css('left',(index*100)+'%');
	});
	
	function startsliderText() {
		interval = setInterval(function() {
			$slide_container.animate({'left': '-='+(width+'%')}, animation_speed, function() {
				if (++current_slide === $slides.length) {
					current_slide = 1;
					$slide_container.css('left', 0);
				}
			});
		}, time_val);
	}
	
	startsliderText();
</script>
<script>
	$('.owl-demo12').owlCarousel({
		items: 4,
		itemsDesktop : [1199, 4],
		itemsDesktopSmall : [991, 3],
		itemsTablet : [768, 2],
		itemsTabletSmall : false,
		itemsMobile : [479, 1],
		navigation : true,
		pagination : false,
		navigationText : ["",""],
	});
</script>


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