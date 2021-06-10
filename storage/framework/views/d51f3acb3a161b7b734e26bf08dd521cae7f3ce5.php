<?php $__env->startSection('title', trans('cart')); ?>
<?php $__env->startSection('content'); ?>

<?php
$cart = $carts['cart'];
$cart_infos = $carts['cart_infos'];
$coupon = $carts['coupon'];
//dd($site_settings);
?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Cart</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">Cart</h1>

<section>
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<!-- <ul class="d-flex">
				<li><a href="<?php echo e(url('/')); ?>">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>Your Cart</span></li>
			</ul> -->
		</div>
	</div>
</section>
<section class="cart-section">
	<div class="container">
		<div class="row record">
			<?php if(count($cart) == 0) { ?>
				<!-- <div class="empty-cart-item">
				   	 <div class="cart-img">
						<img src="<?php echo e(WEBSITE_IMG_URL.'cart-img.jpg'); ?>">
					 </div>
					 <h4>Empty Cart items?</h4>
					 
				  </div> -->
				  <h3 class="text-center">Your cart is empty!</h3>
			<?php } else { 
				$restaurant = App\Models\Restaurant\Restaurant::find($cart[0]['product']->restaurant_id);
				?>
				<div class="col-lg-8 col-md-8 col-sm-12 col-12">

					<?php
					foreach ($cart_infos as $key => $value) {
						echo '<div class="alert alert-secondary" role="alert">' . $value . '</div>';
					}
					?>

					<div class="item-table web-tbody table-gap">
						
						<table class="table">
							<thead>
								<tr>
									<th width="40%" style="padding-left: 25px;">Product</th>
									<th style="text-align: center;">Price</th>
									<th style="text-align: center;">Quantity</th>
									<th style="text-align: right;">Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$total_cart_price = 0;
								?>
								<?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
								$linetotal = number_format(($crt['product']->price * $crt['qty']),2, '.', '');
								$total_cart_price += $linetotal;
								?>
									<tr class="cart-item" product_id="<?php echo e($crt['product']->id); ?>">
										<td>
											<div class="d-flex align-items-center">
											<a class="meal-dlt delete_cart" product_id="<?php echo e($crt['product']->id); ?>" href="javascript:void()"> 
												<span>
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</span>
											</a>
											<?php
											$pdimg = WEBSITE_IMG_URL.'no-product-image.png';
                       foreach ($crt['product']->productImage as $ik => $iv) {
                       	$pathinfo = pathinfo($iv->image);
                       	if(in_array($pathinfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp'])) 
                       		$pdimg = PRODUCT_URL . $iv->image;
                       }
											?>
											<?php if(!empty($crt['product']->singleProductImage->image) && File::exists(PRODUCT_ROOT_PATH.$crt['product']->singleProductImage->image)): ?>
													<?php $image = PRODUCT_URL.$crt['product']->singleProductImage->image; ?>						
											<?php else: ?>
												<?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
											<?php endif; ?>
												<div class="cart-image">
													<img src="<?php echo e($pdimg); ?>">
												</div>
											<div class="cart-item-product-wrap">
												<a href="<?php echo e(url('product-detail/'.$crt['product']->slug)); ?>">	
													<h5><?php echo e($crt['product']->title); ?></h5></a>
											</div>
											</div>
										
									</td>
										<td style="text-align: center;"><?php echo e(CURRENCY); ?><?php echo e(number_format($crt['product']->price, 2)); ?></td>
										<td style="text-align: center;">
											<div class="qty-plus-minu d-flex align-items-center">
												<button type="button" class="qty_minus"><i class="fa fa-minus"></i></button>
												<input type="text" class="form-control qty-fld" name="qty" product_id="<?php echo e($crt['product']->id); ?>" value="<?php echo e($crt['qty']); ?>" readonly="readonly">
												<button type="button" class="qty_plus"><i class="fa fa-plus"></i></button>
											</div>
										</td>
										<td style="text-align: right;">
											<b><?php echo e(CURRENCY); ?><?php echo e($linetotal); ?></b>
										</td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
							<!-- <tfoot>
								<tr>
									<th colspan="4" class="text-right crt-update"><a href="javascript:;" class="btn btn-primary update_cart">Update Cart</a></th>
								</tr>
							</tfoot> -->
						</table>

					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-12 pay_ele">
					<?php
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
					?>
					<div class="checkout-box positition-sticky">
						<h5 class="mb-1" style="border-bottom: 1px solid #adadad;">Order From <a href="<?php echo e(url('/restaurant-detail/' . $restaurant->slug)); ?>"><?php echo $restaurant->name; ?></a></h5>
						<div class="apply-coupon">
							<a href="javascript:;" onclick="$('.coupon_block').toggle();" class="mb-2 toggle_coupon_block">Apply coupon code</a>
							<div class="coupon_block" style="display: none;">
								<div class="d-flex">
									<input type="text" class="form-control coupon-input" name="coupon_code" placeholder="Coupon code">
									<button class="btn apply-btn apply-coupon-btn apply_coupon" type="submit">Apply Coupon</button>
								</div>
							</div>
							<!-- <h4>Apply Coupon Code</h4> -->
							<div class="coupon-box">
								<!-- <div class="d-flex">
									<input type="text" class="form-control coupon-input" name="coupon_code" placeholder="Coupon code">
									<button class="btn apply-btn apply-coupon-btn apply_coupon" type="submit">Apply Coupon</button>
								</div> -->
								<?php if(isset($coupon->id)) { ?>
									<div class="coupon_info mt-4">
										<p><b><?php echo e($coupon->coupon_code); ?></b> coupon applied</p>
										<span class="remove_coupon">x</span>
									</div>
								<?php } ?>
							</div>
						</div>
						<span style="color: "></span>
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
								echo '<div class="reward_points_applied">
									<span class="close">x</span>
									<h4>$' . number_format($reward_point_applied['price'], 2, '.', '') . '</h4>
									<p>Redeemed ' . $reward_point_applied['points'] . ' points</p>
								</div>';
							}
						}
						?>
						<ul class="food-price-sec">
							<li class="d-flex justify-content-between align-items-center" total_cart_price=""><label>Subtotal</label><span><?php echo e(CURRENCY); ?><?php echo e(number_format($total_cart_price,2)); ?></span></li>
							<li class="d-flex justify-content-between align-items-center" discount_amount="<?php echo e($discount_price); ?>"><label>Discount</label><span><?php echo e(CURRENCY); ?><?php echo e(number_format(($discount_price + ($reward_point_applied['price'] ?? 0)),2)); ?></span></li>
							<li class="d-flex justify-content-between align-items-center" payable_amount=""><label>Payable Amount</label><span><?php echo e(CURRENCY); ?><?php echo e(number_format($payable_amount,2)); ?></span></li>
						</ul>
						<?php if(auth()->user()) { ?>
							<?php if($earnable_points > 0) { ?>
								<div class="reward_point_info text-center"><cite>You will earn <b><?php echo e($earnable_points); ?></b> reward points with this order</cite></div>
							<?php } ?>
							<div class="food-checkout-btn">
								<a href="<?php echo e(url('checkout')); ?>"> <button class="btn checkout-btn">Proceed To Checkout</button></a>
							</div>
						<?php } else { ?>
							<div class="food-checkout-btn d-flex justify-content-between">
								<a href="<?php echo e(url('checkout')); ?>"> <button class="btn checkout-btn">Guest Checkout</button></a>
								<a href="<?php echo e(url('login?redirect=' . url('/checkout'))); ?>"> <button class="btn checkout-btn">Checkout</button></a>
							</div>
						<?php } ?>
						
						<!-- <div class="payment-method">
							<h5>Accepted payment methods</h5>
							<a href="#"><img src="<?php echo e(url('public/images/mastercard.png')); ?>"></a>
							<a href="#"><img src="<?php echo e(url('public/images/visa.png')); ?>"></a>
							<a href="#"><img src="<?php echo e(url('public/images/american.png')); ?>"></a>
							<a href="#"><img src="<?php echo e(url('public/images/paypal.png')); ?>"></a>
						</div> -->
					</div>

				</div>
			<?php } ?>
		</div>
	</div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/frontend/cart/cart.blade.php ENDPATH**/ ?>