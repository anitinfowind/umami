@extends('frontend.layouts.app')
@section('content')
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<ul>
				<li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>Video</span></li>
			</ul>
		</div>
	</div>
	<div class="u-menu">
		<div class="container">
			<div class="restaurent-section video-section">
				<div class="blog-img">
					<img src="{{ WEBSITE_IMG_URL.'blog-slider.jpg' }}">
				</div>
				<div class="row">
					@if($videos->isNotEmpty())
						@foreach($videos as $video)
							<div class="col-sm-4">
								<div class="restaurent-box">
									<div class="res-img">
										<a href="{{ route('frontend.video-detail', $video->slug) }}">
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
										<a href="{{ route('frontend.video-detail', $video->slug) }}">
											<h4>{{ $video->title }}</h4>
											<p>{!! Str::limit($video->description,40) !!}</p>
										</a>
										<div class="res-loc">
											<i class="fa fa-map-marker"></i>{{ isset($video->country) ? $video->country : '' }}
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
@endsection