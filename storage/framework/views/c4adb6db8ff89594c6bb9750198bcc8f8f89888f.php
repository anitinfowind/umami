<?php $__env->startSection('content'); ?>
<?php 
$useronly='';
if(auth()->user()){
    $useronly = auth()->user()->isUser();
}
?>
<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo e(url('/restaurant')); ?>">Restaurant</a></li>
      <li class="breadcrumb-item"><a href="<?php echo e(url('restaurant-detail/'.$restaurant->slug)); ?>"><?php echo restaurantName($details->restaurant_id); ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo e($details->title()); ?></li>
    </ol>
  </div>
</nav>

<?php
/*$slide_items = [];
if($details->productImage->isNotEmpty()) {
  foreach($details->productImage as $k => $images) {
    $info = pathinfo(PRODUCT_ROOT_PATH.$images->image);
    $ext = $info['extension'];
    if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp') {
      $lit = $slide_items[(count($slide_items) - 1)] ?? [];
      if(isset($lit['type']) && $lit['type'] == 'video')
        continue;
      $slide_items[] = ['type' => 'image', 'file' => PRODUCT_URL.$images->image];
    } else {
      $img = ($details->productImage[($k + 1)]->image ?? '');
      $ext2 = '';
      if($img != '') {
        $info2 = pathinfo(PRODUCT_ROOT_PATH.$img);
        $ext2 = $info2['extension'];
      }
      $sit = ['type' => 'video', 'file' => PRODUCT_URL.$images->image, 'image' => url('public/thimbnailimage.png')];
      if($ext2=='jpeg'||$ext2=='jpg'||$ext2=='png' ||$ext2=='gif'||$ext2=='webp')
        $sit['image'] = PRODUCT_URL.$img;
      $slide_items[] = $sit;
    }
  }
}*/
//print_r($slide_items);

$slide_items = product_medias(['medias' => $details->productImage]);
?>

<section class="chef-details-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="outer">
          <div id="big" class="owl-carousel owl-theme"> 
            <?php
            foreach ($slide_items as $key => $value) {
              if($value['type'] == 'image') {
                echo '<div class="item"><img class="img-fluid" src="' . $value['file'] . '" alt=""></div>';
              }
              if($value['type'] == 'video') {
                echo '<div class="item">
                  <video width="100%" height111="178px" muted loop  controls poster="' . $value['image'] . '">
                    <source src="' . $value['file'] . '" type="video/mp4">
                  </video>
                </div>';
              }
            }
            ?>
          </div>
          <div id="thumbs" class="owl-carousel owl-theme" style="margin-top: 10px;">
            <?php
            foreach ($slide_items as $key => $value) {
              if($value['type'] == 'image') {
                echo '<div class="item"><img class="img-fluid" src="' . $value['file'] . '" alt=""></div>';
              }
              if($value['type'] == 'video') {
                echo '<div class="item"><img class="img-fluid" src="' . $value['image'] . '" alt=""></div>';
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="mealkit-deatils-sec">
          <div class="mealkit-deatils-box">
            <h1><?php echo e($details->title()); ?></h1>
            <p>From<a href="<?php echo e(url('restaurant-detail/'.$restaurant->slug)); ?>"><?php echo restaurantName($details->restaurant_id); ?></a>
              <?php
              $avg_ratings = ceil(($details->avgRating[0]->avg_rate ?? '0'));
              if($avg_ratings > 0) {
                echo ' <a href="javascript:;" class="ratingColor" onclick="$(\'#tab-D\').trigger(\'click\'); $(\'html, body\').animate({scrollTop: $(\'#content\').offset().top });">';
                for($i = 1; $i <= $avg_ratings; $i++) {
                  echo '<i class="fa fa-star"></i> ';
                }
                for($i = $avg_ratings; $i < 5; $i++) {
                  echo '<i class="fa fa-star-o"></i> ';
                }
                echo '<span>(' . $details->totalRating[0]->count_rate . ')</span></a>';
              }
              ?>
              </p>
          </div>
          <?php 
			if ($details->discount()) {
				$discount = (int) $details->price() * (int) $details->discount() / 100;
				$price = (int) $details->price()- (int) $discount;
			} else {
				$price = $details->price();
			}

            $per_price = number_format($price/$details->quantity, 2);
            $serving_for = (!empty($details->serving_for)) ? $details->serving_for : 'people';
		?>
        <div class="meal-price w-100 srv-text">
            <!-- <h5><i class="fas fa-utensils"></i>Serving For <?php echo e($details->quantity); ?></h5> -->
            <h2>$<span class="base_price" data-price="<?php echo e($price); ?>"><?php echo e($price); ?></span> <span data-serving="<?php echo e($serving_for); ?>" data-per-person="<?php echo e($per_price); ?>" class="per_person">($<?php echo e($per_price); ?>/<?php echo e($serving_for); ?>)</span></h2>

            <!-- <h2>$<span class="base_price" data-price="<?php echo e($price); ?>"><?php echo e($per_price); ?>/<?php echo e($serving_for); ?></span> <span style="display: none;" data-serving="<?php echo e($serving_for); ?>" data-per-person="<?php echo e($per_price); ?>" class="per_person">($<?php echo e($per_price); ?>/<?php echo e($serving_for); ?>)</span></h2> -->
            <?php if($details->discount()): ?> <span class="ofr-price pl-1"> $<?php echo e($details->price()); ?> </span> <span class="discount pl-1"><?php echo e($details->discount()); ?>%</span> 
            <?php endif; ?> 
        </div>
        
        <?php if(!empty($product_addons)): ?>
        <div class="meal-addon-prices">
            <?php $__currentLoopData = $product_addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="addon_label">
                <label><?php echo e($key); ?></label>
                    <select class="addon_price">
                        <option value="0">None</option>    
                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($row['price']); ?>"><?php echo e($row['option_name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
                    </select>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
          <div class="meal-description info-wrap">
            <?php if($details->sold_out == '0') { ?>
                <div class="w-100">
                  <div class="d-flex flex-wrap align-items-center mt-3">
                    <div class="qty-plus-minu d-flex align-items-center">
                      <button type="button" class="qty_minus"><i class="fa fa-minus"></i></button>
                      <input type="text" class="form-control qty-fld" name="qty" value="1" readonly="readonly">
                      <button type="button" class="qty_plus"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="crt-add-wrap">
                      <a href="javascript:;" class="addToCart add_to_cart" product_id="<?php echo e($details->id); ?>" onclick111='addToCart("<?php echo e($details->slug()); ?>")'> Add to Cart </a>
                    </div>
                  </div>            
              </div>
              <?php } elseif($details->sold_out == '1') { ?>
              <div class="w-100"><h5 class="text-danger">Sold Out</h5></div>
              <?php } ?>
            <!-- <h5><i class="fas fa-info-circle"></i>Shipping Policy</h5>
            <h5>Free</h5>
            <p>shipping. Orders from Alaska and Hawaii will incur an additional charge.
            <a href="<?php echo e(url('pages/terms-of-use')); ?>" target="_blank">[More...]</a></p> -->
            <div class="des-wrap">
              <h5>Description</h5>
            <div class="custome-scroll">
              <p><?php echo $details->description(); ?></p>
            </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
$tabact = $_GET['tab'] ?? 'A';
?>
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
                    <a id="tab-A" href="#pane-A" class="nav-link <?php echo e($tabact == 'A' ? 'active' : ''); ?>" data-toggle="tab" role="tab">Ingredients</a>
                </li>
                <li class="nav-item">
                    <a id="tab-B" href="#pane-B" class="nav-link <?php echo e($tabact == 'B' ? 'active' : ''); ?>" data-toggle="tab" role="tab">Instruction</a>
                </li>
                <li class="nav-item">
                    <a id="tab-C" href="#pane-C" class="nav-link <?php echo e($tabact == 'C' ? 'active' : ''); ?>" data-toggle="tab" role="tab">How To Store Food</a>
                </li>
                <li class="nav-item">
                    <a id="tab-D" href="#pane-D" class="nav-link <?php echo e($tabact == 'D' ? 'active' : ''); ?>" data-toggle="tab" role="tab">Reviews</a>
                </li>
            </ul>
          </div>
          <div id="content" class="tab-content" role="tablist">
            <div id="pane-A" class="card tab-pane fade <?php echo e($tabact == 'A' ? 'active show' : ''); ?>" role="tabpanel" aria-labelledby="tab-A">
              <div class="card-header" role="tab" id="heading-A">
                  <h5 class="mb-0">
                      <a class="<?php echo e($tabact == 'A' ? '' : 'collapsed'); ?>" data-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">Ingredients<i class="fa fa-angle-down"></i></a>
                  </h5>
              </div>
              <div id="collapse-A" class="collapse <?php echo e($tabact == 'A' ? 'show' : ''); ?>" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
                <div class="card-body">
                  <div class="food-inner-details"> <?php if($details->ingredients()): ?>
                  <p><?php echo $details->ingredients(); ?></p>
                    <?php endif; ?> </div>
                  </div>
                </div>
            </div>
            <div id="pane-B" class="card tab-pane fade <?php echo e($tabact == 'B' ? 'active show' : ''); ?>" role="tabpanel" aria-labelledby="tab-B">
              <div class="card-header" role="tab" id="heading-B">
                <h5 class="mb-0">
                    <a class="<?php echo e($tabact == 'B' ? '' : 'collapsed'); ?>" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">Instruction<i class="fa fa-angle-down"></i></a>
                </h5>
              </div>
              <div id="collapse-B" class="collapse <?php echo e($tabact == 'B' ? 'show' : ''); ?>" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
                <div class="card-body">
                  <div class="food-inner-details">
                    <p><?php echo $details->nutrition(); ?></p>
                    <?php if(isset($details->instruction_img) && !empty($details->instruction_img) && File::exists(PRODUCT_ROOT_PATH.$details->instruction_img)): ?>
                    <?php $instimg = PRODUCT_URL.$details->instruction_img; ?>
                    <img class="" src="<?php echo e($instimg); ?>"> <?php endif; ?> </div>
                  </div>
                </div>
            </div>
            <div id="pane-C" class="card tab-pane fade <?php echo e($tabact == 'C' ? 'active show' : ''); ?>" role="tabpanel" aria-labelledby="tab-C">
              <div class="card-header" role="tab" id="heading-C">
                <h5 class="mb-0">
                    <a class="<?php echo e($tabact == 'C' ? '' : 'collapsed'); ?>" data-toggle="collapse" href="#collapse-C" aria-expanded="false" aria-controls="collapse-C">How To Store Food<i class="fa fa-angle-down"></i></a>
                </h5>
              </div>
              <div id="collapse-C" class="collapse <?php echo e($tabact == 'C' ? 'show' : ''); ?>" data-parent="#content" role="tabpanel" aria-labelledby="heading-C">
                <div class="card-body">
                  <div class="food-inner-details"> <?php if($details->details()): ?>
                    <p><?php echo $details->details(); ?></p>
                    <?php endif; ?> </div>
                </div>
              </div>
            </div>
            <div id="pane-D" class="card tab-pane fade <?php echo e($tabact == 'D' ? 'active show' : ''); ?>" role="tabpanel" aria-labelledby="tab-D">
              <div class="card-header" role="tab" id="heading-D">
                <h5 class="mb-0">
                    <a class="<?php echo e($tabact == 'D' ? '' : 'collapsed'); ?>" data-toggle="collapse" href="#collapse-D" aria-expanded="false" aria-controls="collapse-D">Reviews<i class="fa fa-angle-down"></i></a>
                </h5>
              </div>
              <div id="collapse-D" class="collapse <?php echo e($tabact == 'D' ? 'show' : ''); ?>" data-parent="#content" role="tabpanel" aria-labelledby="heading-D">
                <div class="card-body">
                  <div class="food-inner-details">
                    <div class="review_list_block">
                      <h4>All Reviews</h4>
                    </div>
                    <div class="text-center"><a href="javascript:;" class="btn load_more_product_review" style="display: none;">See More</a></div>
                    <div class="review_form_block mt-4">
                      <h4>Your Review</h4>
                      <div class="row d-flex flex-wrap align-items-center justify-content-between">
                      <?php
                      $reviews_for = [
                        ['title' => 'Food', 'key' => 'food'],
                        ['title' => 'Shipping', 'key' => 'shipping'],
                        ['title' => 'Packaging', 'key' => 'packaging'],
                        ['title' => 'Instructions', 'key' => 'instructions']
                      ];
                      foreach ($reviews_for as $key => $value) {
                        ?>
                        <!-- <div class="revparam d-flex flex-wrap align-items-center">
                          <span><?php echo e($value['title']); ?>:</span>
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
                        </div> -->
                        <div class="revopt col-lg-3 col-md-6 col-sm-6 col-6 mb-2">
                          <span><?php echo e($value['title']); ?>:</span>
                          <label class="ratingColor" opt_key="rate_<?php echo e($value['key']); ?>" opt_rate="5">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                          </label>
                        </div>
                      <?php } ?>
                      </div>
                      <h5>Comment</h5>
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
          <a href="<?php echo e(url('pages/shipping-policy')); ?>" target="_blank">[More...]</a></p>
        </div>
      </div>
      
    </div>
  </div>
</section>
<?php if($productsrecommitems->isNotEmpty()): ?>
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
    <div class="product-section d-flex" id="recommended_section"> <?php if($productsrecommitems->isNotEmpty()): ?>
      <?php $i=0; foreach($productsrecommitems as $key=>$recommend){ ?>
      <?php if(isset($recommend->singleProductImage->image) && !empty($recommend->singleProductImage->image)): ?>
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

      $rec_serving_for = (!empty($recommend->serving_for)) ? $recommend->serving_for : 'people';
	  ?>
      <div class="custome-col-3 product_item">
        <div class="food-box relative">
          <div class="food-pic relative">
            <input type="hidden" class="recommends" value="<?php echo e($recommend->id); ?>">
            <?php
            $slide_items = product_medias(['medias' => $recommend->productImage]);
            if(count($slide_items) == 0) {
              echo '<a href="' . url('product-detail/'.$recommend->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . WEBSITE_IMG_URL.'no-product-image.png' . '" alt="' . $recommend->title . '" class="lazy" /> </a>';
            } else {
              $sit = $slide_items[0];
              if($sit['type'] == 'image') {
                echo '<a href="' . url('product-detail/'.$recommend->slug) . '"> <img src="' . WEBSITE_IMG_URL . 'blank2.jpg" data-src="' . PRODUCT_URL.'th_'. $sit['filename'] . '" alt="' . $recommend->title . '" class="lazy" /> </a>';
              }
              if($sit['type'] == 'video') {
                $poster = $sit['image'];
                if($sit['image_filename'] != '') {
                  if(File::exists(PRODUCT_ROOT_PATH.'th_'.$sit['image_filename']))
                    $poster = PRODUCT_URL.'th_'. $sit['image_filename'];
                }
                echo '<a href="' . url('product-detail/'.$recommend->slug) . '">
                <video width="100%" height="178px" muted loop  controls111 poster="' . $poster . '">
                  <source src="' . $sit['file'] . '" type="video/mp4">
                </video>
                </a>';
              }
            }
            ?>
            <?php if(auth()->user()): ?>
            <?php if($useronly== 1){ ?>
            <?php if ($favorite == 'yes') { ?>
            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_<?php echo e($recommend->id); ?>" data-fav-id="<?php echo e($recommend->id); ?>"><i class="dataamount food_tab_<?php echo e($recommend->id); ?> far fa-heart" id="fav_<?php echo e($recommend->id); ?>"></i></a></span>
            <?php }else{ ?>
            <span class="heart-icon"><a href="javascript:void(0)" class="unfavourite_token fav_<?php echo e($recommend->id); ?>" data-fav-id="<?php echo e($recommend->id); ?>"><i class="dataamount food_tab_<?php echo e($recommend->id); ?> fa fa-heart-o" id="fav_<?php echo e($recommend->id); ?>"></i></a></span>
            <?php } ?>
            <?php } ?>
            <?php else: ?> <span class="heart-icon"><a href="<?php echo e(url('/login')); ?>" class="unfavourite_token fav_<?php echo e($recommend->id); ?>"  data-fav-id="<?php echo e($recommend->id); ?>" data-fav-value="12"><i class="dataamount food_tab_<?php echo e($recommend->id); ?> fa fa-heart-o" id="fav_<?php echo e($recommend->id); ?>"></i></a></span> <span class="discount-percent">free shipping</span> <span class="trending"><?php echo e($recommend->category->name ?? ''); ?></span> <?php endif; ?> </div>
          <div class="food-name d-flex align-items-center">
            <div class="foodname-lft"> 
              <!--<h4><?php echo e(Str::limit($recommend->title,15)); ?></h4>
              <p><?php echo e(Str::limit($restaurantname,15)); ?></p>-->
              <h4><?php echo e($recommend->title); ?></h4>
              <p><?php echo $restaurantname; ?></p>
              <?php if ($ratingreview != 0) {?>
              <!-- <div class="foodname-rgt d-flex">
                <div class="food-rvw-star">
                  <ul class="d-flex rvw-stars">
                    <li><i class="fa fa-star"></i></li>
                  </ul>
                </div>
                <span class="rvw-rating"><?php echo e($ratingreview); ?></span> <span class="rvw-quantity">(<?php echo e($totaluser); ?>)</span> </div> -->
              <?php } ?>
            </div>
          </div>
          <div class="food-time-rvw-box">
            <div class="food-time d-flex align-items-center justify-content-between">
              <!-- <p><?php echo e(Str::limit($recommend->description,82)); ?></p> -->
              <p><?php echo Str::limit($recommend->description,82); ?></p>
            </div>
            <div class="price-box d-flex align-items-center justify-content-between">
              <?php if ($ratingreview != 0) {?>
              <?php if ($recommend->is_rating_show == 'Y') {?>
              <div class="foodname-rgt d-flex">
                <a href="<?php echo e(url('product-detail/' . $recommend->slug . '?tab=D#heading-D')); ?>" class="d-flex">
                <div class="food-rvw-star">
                  <ul class="d-flex rvw-stars">
                    <li><i class="fa fa-star"></i></li>
                  </ul>
                </div>
                <span class="rvw-rating"><?php echo e($ratingreview); ?></span> <span class="rvw-quantity">(<?php echo e($totaluser); ?>)</span>
                </a>
              </div>
              <?php } ?>
              <?php } ?>
              <div class="price-box-lft">
                <!-- <p><?php echo e($recommend->quantity); ?></p> -->
              </div>
              <div class="price-box-rgt">
                <p>Price $<?php echo e($recommend->price()); ?> <span class="per_person">($<?php echo e(number_format($recommend->price/$recommend->quantity, 2)); ?>/<?php echo e($rec_serving_for); ?>)</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $i++; ?>
      <?php endif; ?>
      <?php } ?>
      <?php endif; ?> </div>
    <?php if(count($productsrecomm)>5): ?> 
    <!--<div class="row">
      <div class="col-12">
        <div class="load-more-btn"> <a href="javascript:;" class="productsrecomm_load_more_btn" data-pg="1">load more</a> </div>
      </div>
    </div>--> 
    <?php endif; ?> </div>
</section>
<?php endif; ?>
<?php 
$site_settings=App\Models\Settings\Site_setting::all();
$site_settings2 = [];
foreach ($site_settings as $key => $value) {
    $site_settings2[$value->key] = $value->value;
}
$site_settings = $site_settings2;
?>
<?php echo $__env->make('frontend.includes.new.home_counter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 


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

    var base_price = parseInt($('.base_price').attr('data-price'));
    var qty = '<?php echo $details->quantity ?>';
    var per_person_price = $('.per_person').attr('data-per-person');
    var serving_for = $('.per_person').attr('data-serving');
  $(document).ready(function(){

    <?php
    $tab = $_GET['tab'] ?? '';
    if($tab != '')
      echo ' $("html, body").animate({
          scrollTop: $("#collapse-' . $tab . '").offset().top - 100
      }, 200); ';
    ?>

    onlyNumbers('input[name="qty"]');

    $(document).on('click', '.revparam label', function(){
      $(this).closest('.revparam').find('label').removeClass('active');
      $(this).addClass('active');
    });

    $(document).on('click', '.revopt label i', function(){
      $(this).closest('.revopt').find('i').removeClass('fa-star').removeClass('fa-star-o');
      var ind = $(this).index();
      for(var i = 0; i <= ind; i++) {
        $(this).closest('label').find('i:nth-of-type(' + (i + 1) + ')').addClass('fa-star');
      }
      for(var i = (ind + 1); i < 5; i++) {
        $(this).closest('label').find('i:nth-of-type(' + (i + 1) + ')').addClass('fa-star-o');
      }
      $(this).closest('label').attr('opt_rate', (ind + 1));
    });

    $(document).on('click', '.submit_product_review', function(){
      /*var rate_food = $('input[name="rate_food"]:checked').val();
      var rate_shipping = $('input[name="rate_shipping"]:checked').val();
      var rate_packaging = $('input[name="rate_packaging"]:checked').val();
      var rate_instructions = $('input[name="rate_instructions"]:checked').val();*/
      var rate_food = $('.revopt label[opt_key="rate_food"]').attr('opt_rate');
      var rate_shipping = $('.revopt label[opt_key="rate_shipping"]').attr('opt_rate');
      var rate_packaging = $('.revopt label[opt_key="rate_packaging"]').attr('opt_rate');
      var rate_instructions = $('.revopt label[opt_key="rate_instructions"]').attr('opt_rate');
      var comment = $.trim($('textarea[name="comment"]').val());
      var review_data = {'rate_food': rate_food, 'rate_shipping': rate_shipping, 'rate_packaging': rate_packaging, 'rate_instructions': rate_instructions, 'comment': comment};
      $(".umami-loader").show();
      var data = new FormData();
      data.append('action', 'submit_review');
      data.append('review_data', JSON.stringify(review_data));
      data.append('product_id', '<?php echo e($details->id); ?>');
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


    load_reviews({'product_id': '<?php echo e($details->id); ?>', 'page': 1});

    $(document).on('click', '.load_more_product_review', function(){
      var cur_page = parseInt($(this).attr('cur_page'));
      load_reviews({'product_id': '<?php echo e($details->id); ?>', 'page': (cur_page + 1)});
    });

    
    // calculations for addon price
    
    $(document).on('change', '.addon_price', function() {
        var addon_price = $(this).val();
        base_price = parseInt($('.base_price').attr('data-price'));
        console.log(base_price +'=='+ addon_price);
        //base_price = parseInt(base_price) + parseInt(addon_price);
        $(".addon_price option:selected").each(function() {
            base_price = parseInt(base_price) + parseInt($(this).val());
        });
        per_person_price = base_price/parseInt(qty);
        console.log(base_price);
        $('.base_price').text(base_price);
        $('.base_price').attr('data-price',base_price);
        $('.per_person').text('($'+ per_person_price + '/'+  serving_for +')');
        // $.ajax({
        //     type: 'POST',
        //     dataType: 'json',
        //     url: '<?php echo url('change-addon-price') ?>',
        //     data: 'base_price='+base_price + '&addon_price=' + addon_price,
        //     success: function(data){
                
        //     }
        // });
    });
  });
</script>
<style>
.meal-addon-prices label {
    width: 125px;
}
.addon_label {
    margin: 10px 0;
}
.meal-addon-prices select {
    width: 165px;
}
.meal-price h2 {
    margin-top: 15px;
    padding-bottom: 15px !important;
}
span.per_person {
    font-weight: normal;
    font-size: 18px;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/frontend/product/product-details.blade.php ENDPATH**/ ?>