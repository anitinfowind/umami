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
    <div class="col-sm-3">
       <div class="product-box">
         <div class="product-img-box" data-productId="{{$product->id}}" data-image="{{PRODUCT_URL.$product->singleProductImage->image}}" data-title="{{ Str::limit($product->title,15) }}" data-description="{{ Str::limit($product->description,137) }}" data-price="{{$product->price()}}" data-slug="{{$product->slug}}"  data-rating="{{ round($ratingreview,1)}}" data-user="{{$totaluser}}"  data-quantity="{{$product->quantity}}" data-restautrant="{{$restaurantname}}" data-extension="{{$ext}}" data-userfavorite="{{$favorite}}">
         @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
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
          <video width="300px" height="230px" margin-bottom="20px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
          <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
          </video>
          @endif
<!--           <div class="view-detail">
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
          </div>
          <div class="cart-d">
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
          </div>
          @if($product->shipping_type=='FREE')
          <div class="sale-offer">
            <a href="#">On Sale!</a>
          </div>
          @endif    
          <div class="product-detail">
          <h4>{{ Str::limit($product->title,21) }}</h4>
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
@endif    

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

</script>