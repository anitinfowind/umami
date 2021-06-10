@extends('frontend.layouts.layout')
@section('content')
<?php 
$useronly='';
if(auth()->user()){
    $useronly = auth()->user()->isUser();
}
?>
<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/restaurant') }}">Restaurant</a></li>
      <li class="breadcrumb-item"><a href="{{ url('restaurant-detail/'.$restaurant->slug) }}">{!! restaurantName($details->restaurant_id) !!}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $details->title() }}</li>
    </ol>
  </div>
</nav>

<?php
/*$slide_items = [];
if($details->productImage->isNotEmpty()) {
  foreach($details->productImage as $k => $images) {
    $lit = $slide_items[(count($slide_items) - 1)] ?? [];
    if(isset($lit['type']) && $lit['type'] == 'video')
      continue;
    $info = pathinfo(PRODUCT_ROOT_PATH.$images->image);
    $ext = $info['extension'];
    if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp') {
      $slide_items[] = ['type' => 'image', 'file' => PRODUCT_URL.$images->image];
    } else {
      $img = ($details->productImage[($k + 1)]->image ?? '');
      $ext2 = '';
      if($img != '') {
        $info2 = pathinfo(PRODUCT_ROOT_PATH.$img);
        $ext2 = $info2['extension'];
      }
      $sit = ['type' => 'video', 'file' => PRODUCT_URL.$images->image, 'image' => ''];
      if($ext2=='jpeg'||$ext2=='jpg'||$ext2=='png' ||$ext2=='gif'||$ext2=='webp')
        $sit['image'] = PRODUCT_URL.$img;
      $slide_items[] = $sit;
    }
  }
}*/
//print_r($slide_items);
?>

<section class="chef-details-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="outer">
          <div id="big" class="owl-carousel owl-theme"> 
            <?php $img_count = 0; ?>
            @if($details->productImage->isNotEmpty())
            @foreach($details->productImage as $images)
            <?php
           	$info = pathinfo(PRODUCT_ROOT_PATH.$images->image);
      			$ext = $info['extension'];
      			?>
            @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
            @if(!empty($images->image) && File::exists(PRODUCT_ROOT_PATH.$images->image))
            <?php $image = PRODUCT_URL.$images->image; ?>
            <div class="item"> <img class="img-fluid" src="{{ $image }}" alt=""> </div>
            <?php $img_count++; ?>
            @else
            <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
            @endif

            @else
            <div class="item">
              <video width="100%" height111="178px" muted loop  controls poster11="{{url('public/thimbnailimage.png')}}">
                <source src="{{ PRODUCT_URL.$images->image }}" type="video/mp4">
              </video>
            </div>
            @endif
            @endforeach
            @endif </div>
          <div id="thumbs" class="owl-carousel owl-theme" style="<?php echo ($img_count == 1 ? 'margin-top: 10px;' : '') ?>"> @if($details->productImage->isNotEmpty())
            @foreach($details->productImage as $images)
            <?php
           	$info = pathinfo(PRODUCT_ROOT_PATH.$images->image);
      			$ext = $info['extension'];
      			?>
            @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
            @if(!empty($images->image) && File::exists(PRODUCT_ROOT_PATH.$images->image))
            <?php $image = PRODUCT_URL.$images->image; ?>
            <div class="item"> <img class="img-fluid" src="{{ $image }}" alt=""> </div>
            @else
            <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
            @endif
            
            @endif
            @endforeach
            @endif </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="mealkit-deatils-sec">
          <div class="mealkit-deatils-box">
            <h4>{{ $details->title() }}</h4>
            <p>From<a href="{{ url('restaurant-detail/'.$restaurant->slug)}}">{!!
              restaurantName($details->restaurant_id) !!}</a></p>
          </div>
          <?php 
			if ($details->discount()) {
				$discount = (int) $details->price() * (int) $details->discount() / 100;
				$price = (int) $details->price()- (int) $discount;
			} else {
				$price = $details->price();
			}
		?>
          <div class="meal-price w-100 srv-text">
            <h5><i class="fas fa-utensils"></i>Serving For {{$details->quantity}}</h5>
            <h2>${{ $price }}</h2>
            @if($details->discount()) <span class="ofr-price pl-1"> ${{ $details->price() }} </span> <span class="discount pl-1">{{ $details->discount() }}%</span> @endif </div>
          <div class="meal-description info-wrap">
            <?php if($details->sold_out == '0') { ?>
                <div class="w-100">
                  <div class="d-flex flex-wrap align-items-center mt-3">
                    <div class="qty-plus-minu d-flex align-items-center">
                      <button type="button" class="qty_minus"><i class="fa fa-minus"></i></button>
                      <input type="text" class="form-control qty-fld" name="qty" value="1">
                      <button type="button" class="qty_plus"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="crt-add-wrap">
                      <a href="javascript:;" class="addToCart add_to_cart" product_id="{{ $details->id }}" onclick111='addToCart("{{ $details->slug() }}")'> Add to Cart </a>
                    </div>
                  </div>            
              </div>
              <?php } elseif($details->sold_out == '1') { ?>
              <div class="w-100"><h5 class="text-danger">Sold Out</h5></div>
              <?php } ?>
            <!-- <h5><i class="fas fa-info-circle"></i>Shipping Policy</h5>
            <h5>Free</h5>
            <p>shipping. Orders from Alaska and Hawaii will incur an additional charge.
            <a href="{{ url('pages/terms-of-use') }}" target="_blank">[More...]</a></p> -->
            <div class="des-wrap">
              <h5>Description</h5>
            <div class="custome-scroll">
              <p>{!! $details->description() !!}</p>
            </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="product-info-sec mt-4">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="product-info-head">
          <h4>Product Info</h4>
        </div>
      </div>
      <div class="col-12">
        <div class="mealkit-food-tabs">
          <div class="accoutTabs">
            <!-- <ul id="tabs" class="nav nav-tabs nav-justified" role="tablist">
              <li class="nav-item"> <a id="tab-A" href="#pane-A" class="nav-link active show" data-toggle="tab" role="tab" aria-selected="true">Ingredients</a> </li>
              <li class="nav-item"> <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">Instruction</a> </li>
              <li class="nav-item"> <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">How To Store Food</a> </li>
              <li class="nav-item"> <a id="tab-C" href="#pane-D" class="nav-link" data-toggle="tab" role="tab" aria-selected="false">Review</a> </li>
            </ul> -->
            <ul id="tabs" class="nav nav-tabs nav-justified" role="tablist">
                <li class="nav-item">
                    <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">Ingredients</a>
                </li>
                <li class="nav-item">
                    <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">Instruction</a>
                </li>
                <li class="nav-item">
                    <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab">How To Store Food</a>
                </li>
                <li class="nav-item">
                    <a id="tab-D" href="#pane-D" class="nav-link" data-toggle="tab" role="tab">Reviews</a>
                </li>
            </ul>
          </div>
          <div id="content" class="tab-content" role="tablist">
            <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
              <div class="card-header" role="tab" id="heading-A">
                  <h5 class="mb-0">
                      <a data-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">Ingredients<i class="fa fa-angle-down"></i></a>
                  </h5>
              </div>
              <div id="collapse-A" class="collapse show" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
                <div class="card-body">
                  <div class="food-inner-details"> @if($details->ingredients())
                  <p>{!! $details->ingredients() !!}</p>
                    @endif </div>
                  </div>
                </div>
            </div>
            <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
              <div class="card-header" role="tab" id="heading-B">
                <h5 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">Instruction<i class="fa fa-angle-down"></i></a>
                </h5>
              </div>
              <div id="collapse-B" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
                <div class="card-body">
                  <div class="food-inner-details">
                    <p>{!! $details->nutrition() !!}</p>
                    @if(isset($details->instruction_img) && !empty($details->instruction_img) && File::exists(PRODUCT_ROOT_PATH.$details->instruction_img))
                    <?php $instimg = PRODUCT_URL.$details->instruction_img; ?>
                    <img class="" src="{{ $instimg }}"> @endif </div>
                  </div>
                </div>
            </div>
            <div id="pane-C" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
              <div class="card-header" role="tab" id="heading-C">
                <h5 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapse-C" aria-expanded="false" aria-controls="collapse-C">How To Store Food<i class="fa fa-angle-down"></i></a>
                </h5>
              </div>
              <div id="collapse-C" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-C">
                <div class="card-body">
                  <div class="food-inner-details"> @if($details->details())
                    <p>{!! $details->details() !!}</p>
                    @endif </div>
                </div>
              </div>
            </div>
            <div id="pane-D" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-D">
              <div class="card-header" role="tab" id="heading-D">
                <h5 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapse-D" aria-expanded="false" aria-controls="collapse-D">Reviews<i class="fa fa-angle-down"></i></a>
                </h5>
              </div>
              <div id="collapse-D" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-D">
                <div class="card-body">
                  <div class="food-inner-details">
                    <div class="review_form_block">
                      <?php
                      $reviews_for = [
                        ['title' => 'Food', 'key' => 'food'],
                        ['title' => 'Shipping', 'key' => 'shipping'],
                        ['title' => 'Packaging', 'key' => 'packaging'],
                        ['title' => 'Instructions', 'key' => 'instructions']
                      ];
                      foreach ($reviews_for as $key => $value) {
                        ?>
                        <div class="revparam d-flex flex-wrap align-items-center">
                          <span>{{ $value['title'] }}:</span>
                          <?php
                          for($i = 1; $i <= 5; $i++) {
                            $chk = ''; $act = '';
                            if($i == 5) {
                              $chk = 'checked="checked"';
                              $act = 'active';
                            }
                            echo '<label class="' . $act . ' d-flex align-items-center"><input type="radio" name="rate_' . $value['key'] . '" value="' . $i . '" ' . $chk . ' />';
                              for($j = 1; $j <= $i; $j++) {
                                echo ' <i class="fa fa-star"></i>';
                              }
                            echo '</label>';
                          }
                          ?>
                        </div>
                      <?php } ?>
                      <h5>Your Review</h5>
                      <div class="form-group">
                        <textarea class="form-control review_comment" name="comment"></textarea>
                      </div>
                      <?php
                      if(auth()->user()) {
                        echo '<a href="javascript:;" class="btn submit_product_review">Submit Review</a>';
                      } else {
                        echo '<p class="text-danger"><i>You need to login to give review</i></p>';
                      }
                      ?>
                    </div>
                    <div class="review_list_block">
                      <h5>All Reviews</h5>
                    </div>
                    <div class="text-center"><a href="javascript:;" class="btn load_more_product_review" style="display: none;">See More</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="shipping_policy mt-3">
          <!-- <div class="product-info-head">
            <h4>Shipping Policy</h4>
          </div> -->
          <h5><i class="fas fa-info-circle"></i> Free Shipping</h5>
          <p>Orders from Alaska and Hawaii will incur an additional charge.
          <a href="{{ url('pages/shipping-policy') }}" target="_blank">[More...]</a></p>
        </div>
      </div>
      
    </div>
  </div>
</section>
@if($productsrecommitems->isNotEmpty())
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
    <div class="product-section d-flex" id="recommended_section"> @if($productsrecommitems->isNotEmpty())
      <?php $i=0; foreach($productsrecommitems as $key=>$recommend){ ?>
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
      <div class="custome-col-3">
        <div class="food-box relative">
          <div class="food-pic relative">
            <input type="hidden" class="recommends" value="{{$recommend->id}}">
            @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
            @if(!empty($recommend->singleProductImage->image) && File::exists(PRODUCT_ROOT_PATH.$recommend->singleProductImage->image))
            <?php $image = PRODUCT_URL.$recommend->singleProductImage->image; ?>
            @else
            <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
            @endif <a href="{{url('product-detail/'.$recommend->slug)}}"><img src="{{ $image }}" alt=""></a> @else
            <video width="300px" height="200px" muted loop  controls poster="{{url('public/thimbnailimage.png')}}">
              <source src="{{PRODUCT_URL.$recommend->singleProductImage->image}}" type="video/mp4">
            </video>
            @endif @if(auth()->user())
            <?php if($useronly== 1){ ?>
            <?php if ($favorite == 'yes') { ?>
            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $recommend->id }}" data-fav-id="{{ $recommend->id }}"><i class="dataamount food_tab_{{ $recommend->id }} far fa-heart" id="fav_{{ $recommend->id }}"></i></a></span>
            <?php }else{ ?>
            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_{{ $recommend->id }}" data-fav-id="{{ $recommend->id }}"><i class="dataamount food_tab_{{ $recommend->id }} fa fa-heart-o" id="fav_{{ $recommend->id }}"></i></a></span>
            <?php } ?>
            <?php } ?>
            @else <span class="heart-icon"><a href="{{url('/login')}}" class="unfavourite_token fav_{{ $recommend->id }}"  data-fav-id="{{ $recommend->id }}" data-fav-value="12"><i class="dataamount food_tab_{{ $recommend->id }} fa fa-heart-o" id="fav_{{ $recommend->id }}"></i></a></span> <span class="discount-percent">free shipping</span> <span class="trending">{{ $recommend->category->name ?? '' }}</span> @endif </div>
          <div class="food-name d-flex align-items-center">
            <div class="foodname-lft"> 
              <!--<h4>{{Str::limit($recommend->title,15)}}</h4>
              <p>{{Str::limit($restaurantname,15)}}</p>-->
              <h4>{{$recommend->title}}</h4>
              <p>{!! $restaurantname !!}</p>
              <?php if ($ratingreview != 0) {?>
              <!-- <div class="foodname-rgt d-flex">
                <div class="food-rvw-star">
                  <ul class="d-flex rvw-stars">
                    <li><i class="fa fa-star"></i></li>
                  </ul>
                </div>
                <span class="rvw-rating">{{$ratingreview}}</span> <span class="rvw-quantity">({{$totaluser}})</span> </div> -->
              <?php } ?>
            </div>
          </div>
          <div class="food-time-rvw-box">
            <div class="food-time d-flex align-items-center justify-content-between">
              <p>{{Str::limit($recommend->description,82)}}</p>
            </div>
            <div class="price-box d-flex align-items-center justify-content-between">
              <?php if ($ratingreview != 0) {?>
              <?php if ($recommend->is_rating_show == 'Y') {?>
              <div class="foodname-rgt d-flex">
                <div class="food-rvw-star">
                  <ul class="d-flex rvw-stars">
                    <li><i class="fa fa-star"></i></li>
                  </ul>
                </div>
                <span class="rvw-rating">{{$ratingreview}}</span> <span class="rvw-quantity">({{$totaluser}})</span> </div>
              <?php } ?>
              <?php } ?>
              <div class="price-box-lft">
                <p>{{$recommend->quantity}} Meals</p>
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
@endif
<?php 
$site_settings=App\Models\Settings\Site_setting::all();
$site_settings2 = [];
foreach ($site_settings as $key => $value) {
    $site_settings2[$value->key] = $value->value;
}
$site_settings = $site_settings2;
?>
@include('frontend.includes.new.home_counter') 


<script>
    $(document).ready(function() {
        var bigimage = $("#big");
        var thumbs = $("#thumbs");
        //var totalslides = 10;
        var syncedSecondary = true;

        bigimage
            .owlCarousel({
                items: 1,
                slideSpeed: 2000,
                nav: true,
                autoplay: false,
                dots: false,
                loop: true,
                responsiveRefreshRate: 200,
                navText: [
                    '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                    '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
                ]
            })
            .on("changed.owl.carousel", syncPosition);

        thumbs
            .on("initialized.owl.carousel", function() {
                thumbs
                    .find(".owl-item")
                    .eq(0)
                    .addClass("current");
            })
            .owlCarousel({
                items: 4,
                dots: false,
                nav: true,
                navText: [
                    '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                    '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
                ],
                smartSpeed: 200,
                slideSpeed: 500,
                slideBy: 4,
                margin:8,
                responsiveRefreshRate: 100
            })
            .on("changed.owl.carousel", syncPosition2);

        function syncPosition(el) {
            //if loop is set to false, then you have to uncomment the next line
            //var current = el.item.index;

            //to disable loop, comment this block
            var count = el.item.count - 1;
            var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

            if (current < 0) {
                current = count;
            }
            if (current > count) {
                current = 0;
            }
            //to this
            thumbs
                .find(".owl-item")
                .removeClass("current")
                .eq(current)
                .addClass("current");
            var onscreen = thumbs.find(".owl-item.active").length - 1;
            var start = thumbs
                .find(".owl-item.active")
                .first()
                .index();
            var end = thumbs
                .find(".owl-item.active")
                .last()
                .index();

            if (current > end) {
                thumbs.data("owl.carousel").to(current, 100, true);
            }
            if (current < start) {
                thumbs.data("owl.carousel").to(current - onscreen, 100, true);
            }
        }

        function syncPosition2(el) {
            if (syncedSecondary) {
                var number = el.item.index;
                bigimage.data("owl.carousel").to(number, 100, true);
            }
        }

        thumbs.on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).index();
            bigimage.data("owl.carousel").to(number, 300, true);
        });
    });
</script> 

<script type="text/javascript">
function product_review_html(data) {
  var html = '';
  $(data).each(function(i, v){
    html += `<div class="product_review">
      <div class="review_head">
        <h6>` + v.user.first_name + ` ` + v.user.last_name + `</h6>
        <div class="reviews d-flex flex-wrap align-items-center justify-content-between">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="revitem"><b>Food: </b>`;
          for(var i = 1; i <= v.rate_food; i++) { html += `<i class="fa fa-star"></i>`; }
          html += `</div></div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="revitem"><b>Shipping: </b>`;
          for(var i = 1; i <= v.rate_shipping; i++) { html += `<i class="fa fa-star"></i>`; }
          html += `</div></div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="revitem"><b>Packaging: </b>`;
          for(var i = 1; i <= v.rate_packaging; i++) { html += `<i class="fa fa-star"></i>`; }
          html += `</div></div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="revitem"><b>Instructions: </b>`;
          for(var i = 1; i <= v.rate_instructions; i++) { html += `<i class="fa fa-star"></i>`; }
          html += `</div></div>
        </div>
        </div>`;
      if(v.comment != '')  
        html += `<div class="review_comment w-100">` + v.comment.replace(/(?:\r\n|\r|\n)/g, '<br>') + `</div>`;
    html += `</div>`;
  });
  return html;
}

function load_reviews(params) {
  var product_id = params.product_id;
  var page = parseInt(params.page);
  if(page > 1)
    $(".umami-loader").show();
  var data = new FormData();
  data.append('action', 'get_reviews');
  data.append('product_id', product_id);
  data.append('page', page);
  data.append('_token', $('meta[name="csrf-token"]').attr('content'));
  $.ajax({
    type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
      $(".umami-loader").hide();
      $('.load_more_product_review').attr('cur_page', page);
      $('.review_list_block').append(product_review_html(data.data.product_reviews));
      if(data.data.total_page > page)
        $('.load_more_product_review').show();
      else
        $('.load_more_product_review').hide();
    }
  });
}

  $(document).ready(function(){

    onlyNumbers('input[name="qty"]');

    $(document).on('click', '.revparam label', function(){
      $(this).closest('.revparam').find('label').removeClass('active');
      $(this).addClass('active');
    });

    $(document).on('click', '.submit_product_review', function(){
      var rate_food = $('input[name="rate_food"]:checked').val();
      var rate_shipping = $('input[name="rate_shipping"]:checked').val();
      var rate_packaging = $('input[name="rate_packaging"]:checked').val();
      var rate_instructions = $('input[name="rate_instructions"]:checked').val();
      var comment = $.trim($('textarea[name="comment"]').val());
      var review_data = {'rate_food': rate_food, 'rate_shipping': rate_shipping, 'rate_packaging': rate_packaging, 'rate_instructions': rate_instructions, 'comment': comment};
      $(".umami-loader").show();
      var data = new FormData();
      data.append('action', 'submit_review');
      data.append('review_data', JSON.stringify(review_data));
      data.append('product_id', '{{ $details->id }}');
      data.append('_token', $('meta[name="csrf-token"]').attr('content'));
      $.ajax({
        type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
          $(".umami-loader").hide();
          $('textarea[name="comment"]').val('');
          $("#messageModal .modal-header .modal-title").text('Product Review');
          $("#messageModal .modal-body").html(data.message);
          $("#messageModal").modal('show');
          /*$("#messageModal").on('hide.bs.modal', function(){
            location.reload();
          });*/
        }
      });
    });


    load_reviews({'product_id': '{{ $details->id }}', 'page': 1});

    $(document).on('click', '.load_more_product_review', function(){
      var cur_page = parseInt($(this).attr('cur_page'));
      load_reviews({'product_id': '{{ $details->id }}', 'page': (cur_page + 1)});
    });

    

  });
</script>

@endsection