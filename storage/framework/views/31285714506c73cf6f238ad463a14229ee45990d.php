<?php $__env->startSection('content'); ?>

<?php
$cart = $carts['cart'];
$cart_infos = $carts['cart_infos'];
$coupon = $carts['coupon'];
?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo e(url('/cart')); ?>">Cart</a></li>
      <li class="breadcrumb-item active" aria-current="page">Checkout</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">Checkout</h1>

<?php
$total_cart_price = 0;
foreach($cart as $crt) {
	$linetotal = number_format(($crt['product']->price * $crt['qty']),2, '.', '');
	$total_cart_price += $linetotal;
}
$discount_price = 0;
if(isset($coupon->id)) {
	if($coupon->discount_type == 'FIXED')
		$discount_price = $coupon->discount;
	if($coupon->discount_type == 'PERCENTAGE') {
		$discount_price = $total_cart_price * $coupon->discount / 100;
		$discount_price = number_format($discount_price, 2, '.', '');
	}
}
$payable_amount = $total_cart_price - $discount_price;
/*$reward_discount_amt = $reward_discount = 0;
if(auth()->user()) {
	$max_reward_discount_amt = $payable_amount / 2;
	$max_reward_discount_point = ceil(($max_reward_discount_amt * 100) / $site_settings['point_to_amount_discount_percentage']);
	$reward_discount = $max_reward_discount_point;
	if(auth()->user()->reward_point < $max_reward_discount_point)
		$reward_discount = auth()->user()->reward_point;
	$reward_discount_amt = ($reward_discount * $site_settings['point_to_amount_discount_percentage'] / 100);
}
$payable_amount -= $reward_discount_amt;*/
$reward_point = $_COOKIE['reward_point'] ?? '';
if(auth()->user()) {
		$reward_point_applied = [];
		$reward_arr = [5, 10, 15, 20];
		foreach ($reward_arr as $key => $value) {
			$points = ceil(($value * 100) / $site_settings['point_to_amount_discount_percentage']);
			if($reward_point == ($key + 1)) $reward_point_applied = ['price' => $value, 'points' => $points];
		}
	if(isset($reward_point_applied['points'])) {
		$payable_amount -= $reward_point_applied['price'];
	}
}
$earnable_points = round($payable_amount * $site_settings['amount_to_point_percentage'] / 100);
$processing_fee = ($payable_amount * 3 / 100); // 3%
$payable_amount += $processing_fee;
?>
	

<section class="inner-breadcrumbs-menu">
	<div class="container">
		<!-- <ul class="d-flex">
			<li><a href="<?php echo e(url('/')); ?>">Home</a><i class="fa fa-angle-right"></i></li>
			<li><a href="<?php echo e(url('cart')); ?>">Cart</a><i class="fa fa-angle-right"></i></li>
			<li><span>Checkout</span></li>
		</ul> -->
	</div>
</section>
<section class="cart-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-6 col-sm-12 col-12">

				<?php //dd($userAddress); ?>

				<?php
				foreach ($cart_infos as $key => $value) {
					echo '<div class="alert alert-secondary" role="alert">' . $value . '</div>';
				}
				?>

				<div class="cho_block step1_content">
					<h2>Personal Info</h2>
					<?php if(!auth()->user()) { ?>
						<div class="row">
							<div class="col-12">
								Already have an account? <a href="<?php echo e(url('login?redirect=' . url('/checkout'))); ?>">Login</a>
							</div>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>Email</label>
								<input class="form-control chk-input-style" placeholder="Email" name="email" type="text" value="<?php echo e(auth()->user() ? auth()->user()->email() : ''); ?>">
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>Phone</label>
								<input class="form-control chk-input-style" placeholder="Phone" name="phone" type="text" value="<?php echo e(auth()->user() ? auth()->user()->phone : ''); ?>">
							</div>
						</div>
					</div>
					<h2>Shipping Address</h2>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>First Name</label>
								<input class="form-control chk-input-style" placeholder="First Name" name="first_name" type="text" value="<?php echo e(auth()->user() ? auth()->user()->firstName() : ''); ?>">
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>Last Name</label>
							<input class="form-control chk-input-style" placeholder="Last Name" name="last_name" type="text" value="<?php echo e(auth()->user() ? auth()->user()->lastName() : ''); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>Street Address</label>
							<input class="form-control chk-input-style" placeholder="Street Address" name="street_address" type="text" value="<?php echo e(isset($userAddress->id) ? $userAddress->streetAddress() : ''); ?>">
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>Apt / Suit / Other</label>
								<input class="form-control chk-input-style" placeholder="Apt / Suit / Other" name="address_line_2" type="text" value="<?php echo e(''); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>City</label>
								<input class="form-control chk-input-style" placeholder="City" name="city" type="text" value="<?php echo e($city_name); ?>">
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>State</label>
							<select class="form-control chk-input-style" name="state_id">
								<option value="">Select State</option>
								<?php
								foreach($states as $key => $value) {
									$sel = '';
									if(isset($userAddress->id)) {
										if($userAddress->stateId() == $key)
											$sel = 'selected="selected"';
									}
									echo '<option value="' . $key . '" ' . $sel . '>' . $value . '</option>';
								}
								?>
							</select>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>Zipcode</label>
							<input class="form-control chk-input-style number-field" placeholder="Zipcode" name="zip_code" type="text" value="<?php echo e(isset($userAddress->id) ? $userAddress->pincode : ''); ?>">
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-12">
							<div class="form-group chk-input">
								<label>Country</label>
							<select class="form-control chk-input-style" name="country_id" style="display: none;">
								<?php
								foreach($countries as $key => $value) {
									echo '<option value="' . $key . '">' . $value . '</option>';
								}
								?>
							</select>
								<?php
								foreach($countries as $key => $value) {
									//echo '<br><small>United States</small>';
									echo '<small class="form-control">United States</small>';
								}
								?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group chk-input">
								<label>Do you want to add a gift message? <input type="checkbox" name="is_gift" value="ACTIVE" /></label>
							</div>
						</div>
					</div>
					<div class="gift_message" style="display: none;">
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Gift Message</label>
								<textarea class="form-control textarea" placeholder="Add Message" name="gift_message"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group chk-input">
									<label>Gift From</label>
								<input class="form-control chk-input-style" placeholder="Gift From" name="gift_message_name" type="text" value="">
								</div>
							</div>
						</div>
					</div>
					
					<div class="upto767">
						<div class="next-prv-btn">
							<a href="javascript:;" class="btn btn-primary calculate_shipping">Next</a>
						</div>
					</div>
				</div><!-- step1_content ends -->

				<div class="cho_block step2_content" style="display: none;">
					<div class="checkout_address_details mb-3"></div>
					<div class="payment-info-details">
						<h2>Payment Info</h2>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="form-group">
									<label class="title">Card Number</label>
									<input type="text" name="card_number" class="form-control" id="card_number" placeholder="1234 1234 1234 1234" value="" maxlength="16" autocomplete="off" required="" aria-required="true">
								</div>
						  </div>
						</div>       
						<div class="row">
						  <div class="col-lg-8 col-md-8 col-sm-8 col-12">
							  <label class="title">Expiry Date</label>
							  <div class="row">
								 <div class="col-lg-6 col-md-6 col-sm-6 col-6">
								<div class="form-group">
									<input type="text" name="card_exp_month" class="form-control" id="card_exp_month" placeholder="MM" value="" maxlength="2" required="" aria-required="true">
								</div>
							  </div>
							  <div class="col-lg-6 col-md-6 col-sm-6 col-6">
								<div class="form-group">
									<input type="text" name="card_exp_year" class="form-control" id="card_exp_year" placeholder="YYYY" value="" maxlength="4" required="" aria-required="true">
								</div>
							  </div>
							  </div> 
						  </div>
						  <div class="col-lg-4 col-md-4 col-sm-4 col-12">
							<div class="form-group">
							  <label class="title">CVC Code</label>
							  <input type="password" name="card_cvc" class="form-control" id="card_cvc" placeholder="CVC" value="" maxlength="3" autocomplete="off" required="" aria-required="true">
							</div>
						  </div>
						</div>	
						<div class="upto767">				 
							<div class="row">
								<div class="col-12">
									<button type="button" class="btn apply-btn save-cont-btn checkout_pay">Pay <?php echo e(CURRENCY); ?><?php echo e(number_format($payable_amount, 2)); ?></button>
								</div>
							</div>
						</div>
					</div>
				</div><!-- step2_content ends -->

				
			</div>

			<div class="col-lg-5 col-md-6 col-sm-12 col-12">
				<div class="checkout-box positition-sticky">
					<h5>Order From <a href="<?php echo e(url('/restaurant-detail/' . $restaurant->slug)); ?>"><?php echo e($restaurant->name); ?></a></h5>
					<div class="cho_pdwrap">
					<?php
					$total_cart_price = 0;
					foreach($cart as $crt) {
						$linetotal = number_format(($crt['product']->price * $crt['qty']),2, '.', '');
						$total_cart_price += $linetotal;
					?>
						<div class="cho_pdbx d-flex align-items-center">
							<div class="cho_pd">
								<div class="cho_img">
									<?php /*if(!empty($crt['product']->singleProductImage->image) && File::exists(PRODUCT_ROOT_PATH.$crt['product']->singleProductImage->image)) {
										echo '<img src="' . PRODUCT_URL.$crt['product']->singleProductImage->image . '" />';
									} else {
										echo '<img src="' . WEBSITE_IMG_URL.'no-product-image.png' . '" class="img-fluid" />';
									}*/ 
									$pdimg = WEBSITE_IMG_URL.'no-product-image.png';
									foreach ($crt['product']->productImage as $ik => $iv) {
										$pathinfo = pathinfo($iv->image);
										if(in_array($pathinfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp'])) 
											$pdimg = PRODUCT_URL . $iv->image;
									}
									echo '<img src="' . $pdimg . '" class="img-fluid" />';
									?>
								</div>
							</div>							
							<div class="cho_meta">
									<a href="<?php echo e(url('product-detail/'.$crt['product']->slug)); ?>">	
									<h5><?php echo e($crt['product']->title); ?></h5></a>
									<p>Qty: <?php echo e($crt['qty']); ?></p>
								</div>
							<div class="cho_price">$<?php echo e($linetotal); ?></div>
						</div>
					<?php } ?>
					</div>
					<?php
					if(auth()->user()) {
						$urpoint = auth()->user()->reward_point;
						echo '<a href="javascript:;" class="show_reward_points">Redeem Points +</a>';
						echo '<div class="reward_point_opts"><p class="mt-1 mb-2">You have <b>' . $urpoint . '</b> reward points</p>
							<div class="row">';
							//$reward_point = $_COOKIE['reward_point'] ?? '';
							//$reward_point_applied = [];
							//$reward_arr = [5, 10, 15, 20];
							foreach ($reward_arr as $key => $value) {
								$points = ceil(($value * 100) / $site_settings['point_to_amount_discount_percentage']);
								$disabled = '';
								if($urpoint < $points) $disabled = 'disabled';
								if($payable_amount < $value) $disabled = 'disabled';
								//if($reward_point == ($key + 1)) $reward_point_applied = ['price' => $value, 'points' => $points];
								echo '<div class="col-md-6"><div class="rpo_item ' . $disabled . '" type="' . ($key + 1) . '"><h4>$' . $value . '</h4><p>' . $points . ' points</p></div></div>';
							}
							echo '</div>
							<p class="text-center mb-2">Read <a href="' . url('pages/learn-about-rewards') . '" target="_blank">how the point work</a></p>
						</div>';
						if(isset($reward_point_applied['points'])) {
							echo '<div class="reward_points_applied mb-1">
								<span class="close">x</span>
								<h4>$' . number_format($reward_point_applied['price'], 2, '.', '') . '</h4>
								<p>Redeemed ' . $reward_point_applied['points'] . ' points</p>
							</div>';
						}
					}
					?>
					<ul class="food-price-sec pt-0">
						<li class="d-flex justify-content-between align-items-center"><label>Subtotal</label><span><?php echo e(CURRENCY); ?><?php echo e(number_format($total_cart_price,2)); ?></span></li>
						<?php
						/*if(($discount_price + $reward_discount_amt) > 0) {
							echo '<li class="d-flex justify-content-between align-items-center"><label>Discount' . ($discount_price > 0 ? ' (' . $coupon->coupon_code . ')' : '') . ($reward_discount > 0 ? ' (used ' . $reward_discount . ' points)' : '') . '</label><span>' . CURRENCY . number_format(($discount_price + $reward_discount_amt),2) . '</span></li>';
						}*/
						if(($discount_price + ($reward_point_applied['price'] ?? 0)) > 0) {
							echo '<li class="d-flex justify-content-between align-items-center"><label>Discount' . ($discount_price > 0 ? ' (' . $coupon->coupon_code . ')' : '') . '</label><span>' . CURRENCY . number_format(($discount_price + ($reward_point_applied['price'] ?? 0)),2) . '</span></li>';
						}
						?>
						<li class="d-flex justify-content-between align-items-center"><label>Processing Fee</label><span><?php echo e(CURRENCY); ?><?php echo e(number_format($processing_fee,2)); ?></span></li>
						<li class="d-flex justify-content-between align-items-center shipping_charge"><label>Shipping Charge</label><span price="0.00"><?php echo e(CURRENCY); ?>0.00</span></li>
						<li class="d-flex justify-content-between align-items-center"><label>Payable Amount</label><span class="payable_ammount" price="<?php echo e(number_format($payable_amount, 2)); ?>"><?php echo e(CURRENCY); ?><?php echo e(number_format($payable_amount, 2)); ?></span></li>
						<!-- <li class="d-flex justify-content-between align-items-center"><br></li> -->
						<?php
			      $estimated_delivery_date = estimated_delivery_date(['restaurant' => $restaurant]);
						$delivery_date = date('m-d-Y', strtotime($estimated_delivery_date['delivery_date']));
						$shipping_info = json_decode($restaurant->shipping_info, true);
						$days = [];
						foreach ($shipping_info['pickuptime'] as $key => $value) {
							if(isset($value['enabled']) && $value['enabled'] == 1) {
								//if($days != '') $days .= ',';
								$days[] = ($key + $shipping_info['delivery_days']) + 1;
							}
						}
						$dp_format_date = date('m/d/Y', strtotime($estimated_delivery_date['delivery_date']));
			      		?>
			      		<!-- <li class="d-flex justify-content-between align-items-center"><label>Estimated Delivery Date <a href="javascript:;" class="change_delivery_date" delivery_date="<?php echo e($estimated_delivery_date['delivery_date']); ?>"><i class="fa fa-edit"></i></a></label><span><?php echo e($delivery_date); ?></span></li> -->
					</ul>

					<?php if(auth()->user()) { ?>
						<?php if($earnable_points > 0) { ?>
							<div class="reward_point_info text-center" reward_point="<?php echo e($earnable_points); ?>"><cite>You will earn <b><?php echo e($earnable_points); ?></b> reward points with this order</cite></div>
						<?php } ?>
					<?php } ?>
					<br>

					<div class="hobb">
						<!-- <h5>Estimated Delivery Date</h5>
						<p><a href="javascript:;" class="change_delivery_date" delivery_date="<?php echo e($estimated_delivery_date['delivery_date']); ?>"><span><?php echo e($delivery_date); ?></span> <i class="fa fa-calendar"></i></a></p> -->

						<h5>Estimated Delivery Date <a href="javascript:;" class="change_delivery_date" delivery_date="<?php echo e($estimated_delivery_date['delivery_date']); ?>"><span><?php echo e($delivery_date); ?></span> <i class="fa fa-calendar"></i></a></h5>
					</div>

	        		<!-- <div class="payment-method">
	        			<h5>Accepted payment methods</h5>
	        			<a href="#"><img src="<?php echo e(url('public/images/mastercard.png')); ?>"></a>
	        			<a href="#"><img src="<?php echo e(url('public/images/visa.png')); ?>"></a>
	        			<a href="#"><img src="<?php echo e(url('public/images/american.png')); ?>"></a>
	        			<a href="#"><img src="<?php echo e(url('public/images/paypal.png')); ?>"></a>
	        		</div> -->

	        		<div class="from767">
	        			<div class="cho_block step1_content text-center">
	        				<div class="next-prv-btn">
		        				<a href="javascript:;" class="btn btn-primary calculate_shipping">Next</a>
		        			</div>
	        			</div>
	        			<div class="cho_block step2_content text-center" style="display: none;">
		        			<button type="button" class="btn apply-btn save-cont-btn checkout_pay">Pay <?php echo e(CURRENCY); ?><?php echo e(number_format($payable_amount, 2)); ?></button>
		        		</div>
	        		</div>

		        </div>
			</div>
		</div>
	</div>
</section>



<div class="modal fade" id="deliverDateModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delivery Date</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="delivery_datepicker"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default set_delivery_date" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
function validate_checkout(params) {
	var step = params.step;
	var first_name = $.trim($('.cho_block.step1_content input[name="first_name"]').val());
	var last_name = $.trim($('.cho_block.step1_content input[name="last_name"]').val());
	var country_id = $('.cho_block.step1_content select[name="country_id"]').val();
	var country = $('.cho_block.step1_content select[name="country_id"] option:selected').text();
	var street_address = $.trim($('.cho_block.step1_content input[name="street_address"]').val());
	var address_line_2 = $.trim($('.cho_block.step1_content input[name="address_line_2"]').val());
	var alternative_address = $.trim($('.cho_block.step1_content textarea[name="alternative_address"]').val());
	var state_id = $('.cho_block.step1_content select[name="state_id"]').val();
	var state = $('.cho_block.step1_content select[name="state_id"] option:selected').text();
	var city = $.trim($('.cho_block.step1_content input[name="city"]').val());
	var zip_code = $.trim($('.cho_block.step1_content input[name="zip_code"]').val());
	var email = $.trim($('.cho_block.step1_content input[name="email"]').val());
	var phone = $.trim($('.cho_block.step1_content input[name="phone"]').val());
	var is_gift = $('.cho_block.step1_content input[name="is_gift"]:checked').length;
	var gift_message = $.trim($('.cho_block.step1_content textarea[name="gift_message"]').val());
	var gift_message_name = $.trim($('.cho_block.step1_content input[name="gift_message_name"]').val());
	var card_number = $.trim($('.cho_block.step2_content input[name="card_number"]').val());
	var card_exp_month = $.trim($('.cho_block.step2_content input[name="card_exp_month"]').val());
	var card_exp_year = $.trim($('.cho_block.step2_content input[name="card_exp_year"]').val());
	var card_cvc = $.trim($('.cho_block.step2_content input[name="card_cvc"]').val());
	var restaurant_id = '<?php echo e($restaurant->id); ?>';
	var delivery_date = $('.change_delivery_date').attr('delivery_date');
	var email_pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
	var error = 0;
	$('.cho_block.step1_content .border-red').removeClass('border-red');
	$('.cho_block.step1_content .error').remove();
	if(first_name == "") {
	    $('.cho_block.step1_content input[name="first_name"]').addClass('border-red');
	    $('.cho_block.step1_content input[name="first_name"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
	    error = 1;
	}
    if(last_name == "") {
	    $('.cho_block.step1_content input[name="last_name"]').addClass('border-red');
	    $('.cho_block.step1_content input[name="last_name"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
	    error = 1;
	}
  if(country_id == "") {
    $('.cho_block.step1_content select[name="country_id"]').addClass('border-red');
    $('.cho_block.step1_content select[name="country_id"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
    error = 1;
  }
  if(street_address == "") {
    $('.cho_block.step1_content input[name="street_address"]').addClass('border-red');
    $('.cho_block.step1_content input[name="street_address"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
    error = 1;
  }
  if(state_id == "") {
    $('.cho_block.step1_content select[name="state_id"]').addClass('border-red');
    $('.cho_block.step1_content select[name="state_id"').closest('.form-group').append('<div class="error text-danger">Required</div>');
    error = 1;
  }
  if(city == "") {
    $('.cho_block.step1_content input[name="city"]').addClass('border-red');
    $('.cho_block.step1_content input[name="city"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
    error = 1;
  }
  if(zip_code == "") {
    $('.cho_block.step1_content input[name="zip_code"]').addClass('border-red');
    $('.cho_block.step1_content input[name="zip_code"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
    error = 1;
  }
  if(!email_pattern.test(email)) {
    $('.cho_block.step1_content input[name="email"]').addClass('border-red');
    $('.cho_block.step1_content input[name="email"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
    error = 1;
  }
  if(phone == "") {
    $('.cho_block.step1_content input[name="phone"]').addClass('border-red');
    $('.cho_block.step1_content input[name="phone"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
    error = 1;
  }
  if(step == 2) {
  	if(card_number == "") {
	    $('.cho_block.step2_content input[name="card_number"]').addClass('border-red');
	    $('.cho_block.step2_content input[name="card_number"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
	    error = 1;
	}
	if(card_exp_month == "") {
	    $('.cho_block.step2_content input[name="card_exp_month"]').addClass('border-red');
	    $('.cho_block.step2_content input[name="card_exp_month"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
	    error = 1;
	}
	if(card_exp_year == "") {
	    $('.cho_block.step2_content input[name="card_exp_year"]').addClass('border-red');
	    $('.cho_block.step2_content input[name="card_exp_year"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
	    error = 1;
	}
	if(card_cvc == "") {
	    $('.cho_block.step2_content input[name="card_cvc"]').addClass('border-red');
	    $('.cho_block.step2_content input[name="card_cvc"]').closest('.form-group').append('<div class="error text-danger">Required</div>');
	    error = 1;
	}
  }
  return {'error': error, 'field_data': {'first_name': first_name, 'last_name': last_name, 'country_id': country_id, 'country': country, 'street_address': street_address, 'address_line_2': address_line_2, 'alternative_address': alternative_address, 'state_id': state_id, 'state': state, 'city': city, 'zip_code': zip_code, 'email': email, 'phone': phone, 'is_gift': is_gift, 'gift_message': gift_message, 'gift_message_name': gift_message_name, 'card_number': card_number, 'card_exp_month': card_exp_month, 'card_exp_year': card_exp_year, 'card_cvc': card_cvc, 'restaurant_id': restaurant_id, 'delivery_date': delivery_date}};
}

	$(document).ready(function(){

		$(".delivery_datepicker").datepicker({
			firstDay: 1,
			minDate: '<?php echo e($dp_format_date); ?>',
			beforeShowDay: function(date) {
		        var day = date.getDay();
		        var dys = '<?php echo e(implode(',', $days)); ?>';
		        dys = dys.split(',');
		        if($.inArray(String(day), dys) >= 0)
		        	return [true, '', ''];
		        else
		        	return [false, '', ''];
		    },
		    onSelect: function (dateText, inst) {
		    	console.log(dateText);
		    	console.log(inst);
		    	var day = (inst.selectedDay < 10 ? '0' : '') + inst.selectedDay;
		    	var month = (inst.selectedMonth < 9 ? '0' : '') + (inst.selectedMonth + 1);
		    	var year = inst.selectedYear;
		    	$('.change_delivery_date').attr('delivery_date', (year + '-' + month + '-' + day));
		    	//$('.change_delivery_date').closest('li').find('span').text((month + '-' + day + '-' + year));
		    	$('.change_delivery_date span').text((month + '-' + day + '-' + year));
		    	$('#deliverDateModal').modal('hide');
		    }
		});
		$(document).on('click', '.change_delivery_date', function(){
			$('#deliverDateModal').modal('show');
		});

		$(document).on('change', 'input[name="is_gift"]', function(){
			$('.gift_message').hide();
			if($(this).is(':checked'))
				$('.gift_message').show();
		});

		$(document).on('click', '.calculate_shipping', function(){
		 var validate = validate_checkout({'step': 1});
		 var fields = validate.field_data;
		  if(validate.error == 1) return false;
		$('.umami-loader').show();
		var data = new FormData();
		data.append('first_name', fields.first_name);
		data.append('last_name', fields.last_name);
	      data.append('street_address', fields.street_address);
	      data.append('address_line_2', fields.address_line_2);
	      data.append('state_id', fields.state_id);
	      data.append('city', fields.city);
	      data.append('zip_code', fields.zip_code);
	      data.append('country_id', fields.country_id);
	      data.append('restaurant_id', fields.restaurant_id);
	      data.append('_token', $('meta[name="csrf-token"]').attr('content'));
	      $.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: '<?php echo e(url('get_shipping_price')); ?>',
	        data: data,
	        processData: false,
	        contentType: false,
	        error: function(data) {
	        	$('.umami-loader').hide();
	        	var html = '<h5>There some error happend in checkout. Please try again.</h5>';
						$("#messageModal .modal-header .modal-title").text('Calculate Shipping');
				  	$("#messageModal .modal-body").html(html);
				  	$("#messageModal").modal('show');
			  		/*$("#messageModal").on('hide.bs.modal', function(){
					    location.reload();
						});*/
	        },
	        success: function(data) {
	        	$('.umami-loader').hide();
	        	if(data.success) {
	        		var shipping_charge = parseFloat($('.shipping_charge span').attr('price'));
	        		var payment_ammount = parseFloat($('.payable_ammount').attr('price'));
	        		var shipping_charge = shipping_charge + parseFloat(data.data.shipping_price);
	        		payment_ammount += parseFloat(data.data.shipping_price);
	        		//$('input[name="payment_ammount"]').val(payment_ammount);
	        		//$('input[name="shipping_charge"]').val(shipping_charge);
	        		$('.shipping_charge span').text('$' + shipping_charge.toFixed(2)).attr('price', shipping_charge.toFixed(2));
	        		if(shipping_charge > 0)
	        			$('.shipping_charge').addClass('d-flex');
	        		$('.payable_ammount').text('$' + payment_ammount.toFixed(2)).attr('price', payment_ammount.toFixed(2));
	        		$('.save-cont-btn').text('Pay $' + payment_ammount.toFixed(2));
	        		var address_html = '<h2>Shipping Info</h2><h5><b>Name: </b>' + fields.first_name + ' ' + fields.last_name + '</h5>';
	        		address_html += '<h5><b>Email: </b>' + fields.email + '</h5>';
	        		address_html += '<h5><b>Phone: </b>' + fields.phone + '</h5>';
	        		address_html += '<h5><b>Address: </b>' + fields.street_address + ', ' + (fields.address_line_2 != '' ? (fields.address_line_2 + ', ') : '') + fields.city + ', ' + fields.state + ' ' + fields.zip_code + ', ' + fields.country + '</h5>';
	        		if(fields.is_gift == 1) {
	        			address_html += '<h5><b>Gift Message: </b>' + fields.gift_message + '</h5>';
	        			address_html += '<h5><b>Gift From: </b>' + fields.gift_message_name + '</h5>';
	        		}
	        		$('.step2_content .checkout_address_details').html(address_html);
					$('.step1_content').hide();
	        		$('.step2_content').show();
	        	} else {
	        		var html = '<h5>' + data.message + '</h5>';
							$("#messageModal .modal-header .modal-title").text('Calculate Shipping');
						  	$("#messageModal .modal-body").html(html);
						  	$("#messageModal").modal('show');
					  		/*$("#messageModal").on('hide.bs.modal', function(){
							    location.reload();
								});*/
	        	}
	        }
	      });
		});

	
	$(document).on('click', '.checkout_pay', function(){
		var validate = validate_checkout({'step': 2});
		var fields = validate.field_data;
		if(validate.error == 1) return false;
		$('.umami-loader').show();
		var data = new FormData();
		data.append('first_name', fields.first_name);
		data.append('last_name', fields.last_name);
	      data.append('street_address', fields.street_address);
	      data.append('address_line_2', fields.address_line_2);
	      data.append('state_id', fields.state_id);
	      data.append('city', fields.city);
	      data.append('zip_code', fields.zip_code);
	      data.append('country_id', fields.country_id);
	      data.append('restaurant_id', fields.restaurant_id);
	      data.append('email', fields.email);
	      data.append('phone', fields.phone);
	      data.append('is_gift', fields.is_gift);
	      data.append('gift_message', fields.gift_message);
	      data.append('gift_message_name', fields.gift_message_name);
	      data.append('card_number', fields.card_number);
	      data.append('card_exp_month', fields.card_exp_month);
	      data.append('card_exp_year', fields.card_exp_year);
	      data.append('card_cvc', fields.card_cvc);
	      data.append('delivery_date', fields.delivery_date);
	      data.append('_token', $('meta[name="csrf-token"]').attr('content'));
	      $.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: '<?php echo e(url('checkout_pay')); ?>',
	        data: data,
	        processData: false,
	        contentType: false,
	        error: function(data) {
	        	$('.umami-loader').hide();
	        	var html = '<h5>There some error happend in checkout. Please try again.</h5>';
						$("#messageModal .modal-header .modal-title").text('Checkout');
					  	$("#messageModal .modal-body").html(html);
					  	$("#messageModal").modal('show');
				  		/*$("#messageModal").on('hide.bs.modal', function(){
						    location.reload();
							});*/
	        },
	        success: function(data) {
	        	if(data.success == 1)
	        		window.location.href = '<?php echo e(url('/thank-you')); ?>';
	        	if(data.success == 0) {
	        		$('.umami-loader').hide();
	        		var html = '<h5>' + data.message + '</h5>';
							$("#messageModal .modal-header .modal-title").text('Checkout');
					  	$("#messageModal .modal-body").html(html);
					  	$("#messageModal").modal('show');
				  		/*$("#messageModal").on('hide.bs.modal', function(){
						    location.reload();
							});*/
	        	}
	        }
	    });
	});

	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/frontend/checkout/checkout.blade.php ENDPATH**/ ?>