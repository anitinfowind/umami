@extends('frontend.layouts.app')
@section('content')
<div class="inner-breadcrumbs-menu">
	<div class="container">
		<ul>
			<li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
			<li><span>Product</span></li>
		</ul>
	</div>
</div>
@if($products->isNotEmpty())
<div class="u-menu">
	<div class="container">
		<div class="food-menu-tab">
			<div class="row">
				<div class="col-sm-12">
					<div class="filter-category">	
						<div class="filter-headiing">
							<h3>
								<label><input type="checkbox" name="free_shipping" class="search" value="free_shipping" @if(isset($_REQUEST['free_shipping']) && !empty($_REQUEST['free_shipping'])) checked="checked" @endif> <span>Free Shipping</span></label>
							</h3>
							  <div class="searchby-filter">
								<div class="filter-sort">
									<select class="form-control searchby" name="sort_by">
										<option value="">Sort By: Trending</option>
										<option value="lowest">Price: Lowest First</option>
										<option value="highest">Price: Highest First</option>
									</select>
								</div>
							</div>
						</div>
						<div class="accordion-list" id="accordion1">
					        <div class="card-header collapsed" data-toggle="collapse"  data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" class="mb-0">
					        	<a class="card-title">Category</a>
					        </div>
					        <div id="collapse1" class="collapse-box collapse" aria-labelledby="heading1" data-parent="#accordion1">
					            
				                <ul>
									@if($categorys->isNotEmpty())
									@foreach($categorys as $category)
									<li><input type="checkbox" class="search" name="category" value="{{$category->id}}"> {{ $category->name() }}</li>
									@endforeach
									@endif
								</ul>

					        </div>
					      </div>
					    <div class="accordion-list" id="accordion2">
					       <div class="card-header collapsed" data-toggle="collapse"  data-target="#collapse2" aria-expanded="true" aria-controls="collapse2" class="mb-0">
					        	<a class="card-title">Diet</a>
					        </div>
					        <div id="collapse2" class="collapse-box collapse" aria-labelledby="heading2" data-parent="#accordion2">
				                <ul>
									@if($diets->isNotEmpty())
									@foreach($diets as $diet)
									<li><input type="checkbox" class="search" name="diet" value="{{$diet->id}}"> {{ $diet->name() }}</li>
									@endforeach
									@endif
								</ul>
					        </div>
					    </div>
					    <div class="accordion-list" id="accordion3">
					       <div class="card-header collapsed" data-toggle="collapse"  data-target="#collapse3" aria-expanded="true" aria-controls="collapse3" class="mb-0">
					        	<a class="card-title">Price</a>
					        </div>
					        <div id="collapse3" class="collapse-box collapse" aria-labelledby="heading3" data-parent="#accordion3">
					            <div class="price-range">
									<div id="ranged-value" style="width: 100%;"></div>
								</div>
					        </div>
					    </div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="row loaddata">
						@foreach($products as $product)
                        @if(isset($product->singleProductImage->image)&& !empty($product->singleProductImage->image))
                       <?php 
                        $restaurantname=restaurantName($product->restaurant_id);
                            $info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
                           $ext = $info['extension'];
                            $productrating=App::make('App\Http\Controllers\Frontend\ProductController')->getRating($product->rating['product_id']);
                              $ratingreview='';
                              $totaluser='';
                              if(count($productrating)>0)
                              {
                                $totalsum=collect($productrating)->sum('average_rating');
                                $totaluser= count($productrating);
                                $ratingreview=($totalsum/$totaluser);
                              }
                          ?>
















					<div class="col-md-3 col-sm-6">
							<div class="product-box">
								<div class="product-img-box" data-productId="{{$product->id}}" data-image="{{PRODUCT_URL.$product->singleProductImage->image}}" data-title="{{ Str::limit($product->title,21) }}" data-price="{{$product->price()}}" data-slug="{{$product->slug}}"  data-rating="{{ round($ratingreview,1)}}" data-user="{{$totaluser}}"  data-quantity="{{$product->quantity}}" data-restautrant="{{$restaurantname}}" data-extension="{{$ext}}">
                                  @if($ext!='mp4')
									<div class="product-img">
										@if(!empty($product->singleProductImage->image) &&
										File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image))
										<?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
										@else
										<?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
										@endif
										<a href="{{url('product-detail/'.$product->slug)}}">
											<img class="product_image_resto" src="{{ $image }}" alt="{{ $product->title }}">
										</a>
									</div>
                                          @else
                                          <video width="100%" height="192px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                                          <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
                                          </video>
                                          @endif
									<!-- <div class="view-detail">
										<a href="{{ url('product-detail/'. $product->slug) }}">
											<button class="btn view-btn">
											View Details
											</button>
										</a>
										@if(auth()->check())
										@if(auth()->user()->isUser())
										<button class="btn view-btn btn-cart" onclick='addToCart("{{ $product->slug() }}")'>
										<i class="fa fa-shopping-cart"></i>
										</button>
										@endif
										@else
										<br/>
										<a href="{{ url('login') }}?key=products">
											<button class="btn view-btn btn-cart"><i class="fa fa-shopping-cart"></i></button>
										</a>
										@endif
									</div> -->
									<!-- <div class="cart-d">
										@if(auth()->check())
										@if(auth()->user()->isUser())
										<div class="like-img">
											@if(!empty($product->favorite))
											<a
												href="javascript:void(0)"
												class=" fav_{{ $product->id() }}"
												onclick='favourite("{{ $product->id() }}","unfavourite")'
												>
												<i class="food_tab_{{ $product->id() }} fa fa-heart" aria-hidden="true"
												id="fav_{{ $product->id() }}"></i>
											</a>
											@else
											<a
												href="javascript:void(0)"
												class="f-cart fav_{{ $product->id() }}"
												onclick='favourite("{{ $product->id() }}","favourite")'
												>
												<i class="food_tab_{{ $product->id() }} fa fa-heart-o" aria-hidden="true"
												id="fav_{{ $product->id() }}"></i>
											</a>
											@endif
										</div>
										@endif
										@else
										<div class="like-img">
											<a href="{{ url('login')}}?key=products" class="f-cart">
												<i class="fa fa-heart-o"></i>
											</a>
										</div>
										@endif
									</div> -->
                                    <!--  @if($product->shipping_type=='FREE')
									<div class="sale-offer">
										<a href="#">On Sale!</a>
									</div>
                                      @endif -->
								<!-- <div class="product-detail">
									<h4>{{ Str::limit($product->title,25) }}</h4>
									<div class="rating-btm">
										<b>
										<?php
											if ($product->discount()) {
												$discount = (int) $product->price() * (int) $product->discount() / 100;
												$price = (int) $product->price()- (int) $discount;
											} else {
												$price = $product->price();
											}
										?>
										<span class="">
											${{ $price }}
										</span>
										@if($product->discount())
										<span class="ofr-price dis">
											${{ $product->price() }}
										</span>
										<span class="discount per">{{ $product->discount() }}%</span>
										@endif
										</b>
                                        @if(!empty($ratingreview))
                                          <div class="rating-stars">
                                            <div class="rating-star">
                                              <i class="fa fa-star"></i>  {{ round($ratingreview,1)}} <span class="user_count">({{$totaluser}})</span>
                                            </div>
                                          </div>
                                         @endif
									</div>
								</div> -->
								</div>
							</div>
						</div>
                         @endif
						@endforeach
					</div>
					@include('frontend.pagination.pagination', ['paginator' => $products])
				</div>
			</div>
		</div>
	</div>
</div>
@else
<img src="{{ WEBSITE_IMG_URL.'no-product.jpg' }}">
@endif
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
         $('.append_div').html('<div class="recommended_product"><div class="product-img"> <a href="'+url+'/product-detail/'+slug+'"> <img class="product_image_resto" src="'+image+'" alt="'+title+'"></a></div><div class="append-detail"><div class="d-flex justify-content-between"><h3 title="'+title+'">'+title+'</h3><b><span class="">$ '+price+'</span></b></div><sapn class="quantity">'+quantity+'</span> '+ratingdata+'<div class="restaurant_name text-center">'+restaurant+'</div></div></div></div>');
       }
       else
       {
        $('.append_div').html('<div class="recommended_product"><div class="product-img"> <a href="'+url+'/product-detail/'+slug+'"> <video width="100%" height="192px" muted loop  controls autoplay poster="'+url+'/thimbnailimage.png"><source src="'+image+'" type="video/mp4"></video></a></div><div class="append-detail"><div class="d-flex justify-content-between"><h3 title="'+title+'">'+title+'</h3><b><span class="">$ '+price+'</span></b></div><sapn class="quantity">'+quantity+'</span> '+ratingdata+'<div class="restaurant_name text-center">'+restaurant+'</div></div></div></div>');

       } 
   });

    $(".append_div").on('mouseout',function(){
      $(this).html('').removeClass('open');
    });

  });
</script>
@endsection