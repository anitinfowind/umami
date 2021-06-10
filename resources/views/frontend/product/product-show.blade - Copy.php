@extends('frontend.layouts.app')
@section('content')
<div class="inner-breadcrumbs-menu">
	<div class="container-fluid">
		<ul>
			<li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
			<li><span>Product</span></li>
		</ul>
	</div>
</div>
@if(auth()->user())
<input type="hidden" name="isuservalid" value="{{auth()->user()->isUser()}}" class="userCheckAuth">
@endif
@if($products->isNotEmpty())
<div class="u-menu">
	<div class="container-fluid">
		<div class="food-menu-tab">
					<div class="filter-category">	
						<div class="filter-headiing">
							<h3>
								<!-- <label><input type="checkbox" name="free_shipping" class="search" value="free_shipping" @if(isset($_REQUEST['free_shipping']) && !empty($_REQUEST['free_shipping'])) checked="checked" @endif> <span>Free Shipping</span></label> -->
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
                              if(!empty($product->favorite))
                                {
                                  $favorite= 'yes';
                                } else{
                                  $favorite= 'no';
                                }
                          ?>
					     <div class="col-md-3 col-sm-6 product-box">
							    <div class="product-img-box" data-productId="{{$product->id}}" data-image="{{PRODUCT_URL.$product->singleProductImage->image}}" data-title="{{ Str::limit($product->title,15) }}" data-price="{{$product->price()}}" data-slug="{{$product->slug}}"  data-rating="{{ round($ratingreview,1)}}" data-user="{{$totaluser}}"  data-quantity="{{$product->quantity}}" data-restautrant="{{$restaurantname}}" data-extension="{{$ext}}" data-description="{{ Str::limit($product->description,137) }}"data-userfavorite="{{$favorite}}">
                  @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
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
                <video width="100%" height="200px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
                </video>
                @endif
							</div>
						</div>
                         @endif
						@endforeach
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