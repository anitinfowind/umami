@extends('frontend.layouts.app')
@section('content')
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<ul>
				<li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
				<li><a href="{{url('videos') }}"><span>Video</span></a><i class="fa fa-angle-right"></i></li>
				<li><span>Video-detail</span></li>
			</ul>
		</div>
	</div>
	<div class="video-play-section">
		<div class="container">
			<div class="play-video">
				<div class="embed-responsive embed-responsive-16by9">
					@if($videodetail->video_type == 'EMBEDDED_URL')
						<iframe class="embed-responsive-item" src="{{ $videodetail->embedded_url }}" allowfullscreen></iframe>
					@else
						<video width="auto" height="auto" controls>
							<source src="{{ url('uploads/video/'.$videodetail->video) }}" type="video/mp4">
						</video>
					@endif
				</div>
			</div>
			<div class="video-content">
				<h2>{{ $videodetail->title }}</h2>
				{!! strlen($videodetail->description) > 40 ? substr($videodetail->description,0,40) : $videodetail->description !!}
				<span id="dots">...</span> <span id="more"> {!! Str::limit($videodetail->description) !!}</span>
				<a href="javascript:void(0)" onclick="myFunction()" id="myBtn">Read more</a>
			</div>
		</div>
	</div>
	<div class="u-menu">
		<div class="container">
			<div class="video-menu">
				<h2>ORDER GRAMERCY TAVERN TO YOUR DOOR</h2>
				<div class="row">
					<div class="col-sm-3">
						<div class="product-box">
							<div class="product-img-box">
								<div class="product-img">
									<img src="{{ WEBSITE_IMG_URL.'product22.jpg' }}">
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
								<h4>Chicken Drumsticks</h4>
								<div class="cal-icon">
									<a href="#" data-toggle="tooltip" data-placement="top" title="calorie free">
										<img src="{{ WEBSITE_IMG_URL.'calorie.png' }}">
									</a>
									<a href="#" data-toggle="tooltip" data-placement="top" title="gluten free">
										<img src="{{ WEBSITE_IMG_URL.'gluten.png' }}">
									</a>
								</div>
								<p>American, Fast Food</p>
								<h6><span class="ofr-price">$89.95</span> $64.95</h6>
								<div class="rating-stars">
									<div class="rating-star">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="product-box">
							<div class="product-img-box">
								<div class="product-img">
									<img src="{{ WEBSITE_IMG_URL.'product19.jpg' }}">
								</div>
								<div class="view-detail">
									<button class="btn view-btn">View Details</button>
								</div>
								<div class="cart-d">
									<a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
								</div>
								<div class="sale-offer sold-out">
									<a href="#">Sold Out!</a>
								</div>
							</div>
							<div class="product-detail">
								<h4>Chicken Rice</h4>
								<div class="cal-icon">
									<a href="#" data-toggle="tooltip" data-placement="top" title="calorie free">
										<img src="{{ WEBSITE_IMG_URL.'calorie.png' }}">
									</a>
									<a href="#" data-toggle="tooltip" data-placement="top" title="gluten free">
										<img src="{{ WEBSITE_IMG_URL.'gluten.png' }}">
									</a>
								</div>
								<p>American, Fast Food</p>
								<h6><span class="ofr-price">$89.95</span> $64.95</h6>
								<div class="rating-stars">
									<div class="rating-star">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-o"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="product-box">
							<div class="product-img-box">
								<div class="product-img">
									<img src="{{ WEBSITE_IMG_URL.'product13.jpg' }}">
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
								<h4>Pizza Margherita</h4>
								<div class="cal-icon">
									<a href="#" data-toggle="tooltip" data-placement="top" title="calorie free">
										<img src="{{ WEBSITE_IMG_URL.'calorie.png' }}">
									</a>
									<a href="#" data-toggle="tooltip" data-placement="top" title="gluten free">
										<img src="{{ WEBSITE_IMG_URL.'gluten.png' }}">
									</a>
								</div>
								<p>American, Fast Food</p>
								<h6><span class="ofr-price">$89.95</span> $64.95</h6>
								<div class="rating-stars">
									<div class="rating-star">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-half-o"></i>
										<i class="fa fa-star-o"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="product-box">
							<div class="product-img-box">
								<div class="product-img">
									<img src="{{ WEBSITE_IMG_URL.'product11.jpg' }}">
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
								<h4>Juicy baked Burger</h4>
								<div class="cal-icon">
									<a href="#" data-toggle="tooltip" data-placement="top" title="calorie free">
										<img src="{{ WEBSITE_IMG_URL.'calorie.png' }}">
									</a>
									<a href="#" data-toggle="tooltip" data-placement="top" title="gluten free">
										<img src="{{ WEBSITE_IMG_URL.'gluten.png' }}">
									</a>
								</div>
								<p>American, Fast Food</p>
								<h6><span class="ofr-price">$89.95</span> $64.95</h6>
								<div class="rating-stars">
									<div class="rating-star">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-o"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="restaurent-section video-section">
				<h2>Latest Videos</h2>
				<div class="row">
					<div class="owl-demo1">
						@if($videos->isNotEmpty())
							@foreach($videos as $video)
								<div class="item">
									<div class="col-sm-12">
										<div class="restaurent-box">
											<div class="res-img">
												<a href="{{ route('frontend.video-detail',$video->slug) }}">
													<div class="embed-responsive embed-responsive-16by9">
														@if($video->video_type == 'EMBEDDED_URL')
															<iframe class="embed-responsive-item" src="{{ $video->embedded_url }}" allowfullscreen></iframe>
														@else
															<video width="320" height="240" controls>
																<source src="{{ url('uploads/video/'.$video->video) }}" type="video/mp4">
															</video>
														@endif
													</div>
												</a>
											</div>
											<div class="product-detail">
												<a href="{{ route('frontend.video-detail',$video->slug) }}">
													<h4>{{ $video->title }}</h4>
													<p> {!! Str::limit($video->description,40) !!} </p>
												</a>
												<div class="res-loc">
													<i class="fa fa-map-marker"></i>{{ isset($video->country) ? $video->country : ''}}
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection