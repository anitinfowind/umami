@extends('frontend.layouts.app')
@section('content')
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<ul>
				<li><a href="#">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>Subscription</span></li>
			</ul>
		</div>
	</div>
	<div class="u-menu">
		<div class="container">
			<div class="subs-section">
				<div class="row">
					<div class="col-md-6">
						<div class="left-subs">
							<h2>Umami Square Subscriptions</h2>
							<div class="rating-star">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</div>
							<span class="pro-rating">59 reviews</span>
							<div class="res-loc"><i class="fa fa-map-marker"></i>USA</div>
							<div class="discription">
								<h4>The Ultimate Monthly Food Subscriptions</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scel<span id="dots">...</span><span id="more">erisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.</span></p>
								<button onclick="myFunction()" id="myBtn1">Read more</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="right-subs">
							<img src="{{ WEBSITE_IMG_URL.'blog-slider.jpg' }}">
						</div>
					</div>
				</div>
			</div>
			<div class="food-menu-tab">
				<div class="row">
					@if($subscriptions->isNotEmpty())
						@foreach($subscriptions as $key=>$subscription)
							<div class="col-sm-3">
								<div class="product-box">
									<div class="product-img-box">
										<div class="product-img">
											<img src="{{ URL::to('uploads/subscription/'.$subscription['subscriptionImage']->image) }}">
										</div>
										<div class="view-detail">
											<button class="btn view-btn">View Details</button>
										</div>
										<div class="cart-d">
											<a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
										</div>
										<div class="sale-offer">
											<a href="#">On Sale!</a>
										</div>
									</div>
									<div class="product-detail">
										<h4>{{ $subscription->title }}</h4>
										<h6>
											@if(!empty($subscription->discount))
												<span class="ofr-price">
													${{ $subscription->price }}
												</span>
												${{ $subscription->discount }}
											@endif
											@if(empty($subscription->discount))
												${{ $subscription->price }}
											@endif
										</h6>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection()