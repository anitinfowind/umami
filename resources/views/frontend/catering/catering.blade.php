@extends('frontend.layouts.app')
@section('content')
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<ul>
				<li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>Catering</span></li>
			</ul>
		</div>
	</div>
	<div class="cate-service mb-5">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="service-bx">
						<img src="{{ WEBSITE_IMG_URL.'calendar.png' }}">
						<h4>Always Available</h4>
						<p>Lorem ipsum dolar sit amet.Aenean imperdiet aliquet hendrerit.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="service-bx">
						<img src="{{WEBSITE_IMG_URL.'meal.png' }}">
						<h4>Wide Offer</h4>
						<p>Lorem ipsum dolar sit amet.Aenean imperdiet aliquet hendrerit.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="service-bx">
						<img src="{{ WEBSITE_IMG_URL.'tray.png' }}">
						<h4>Professional Service</h4>
						<p>Lorem ipsum dolar sit amet.Aenean imperdiet aliquet hendrerit.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="eve-year wdo">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>The Best Catering Service <br> You can get</h2>
					<p>Lorem ipsum netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit. Nunc interdum ullamcorper lectus et pellentesque enim interdum at. Suspendisse malesuada dignissim facilisis ligula rutrum sed.Dolor nunc vule putateulr ips dol consec.</p>
					<p>Donec semp ertet lacinia ultri cie upien disse comete dolo lectus fgilla itollicil tua ludin dolor nec met quam accumsan dolore condime netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet.</p>
					<div class="">
						<!-- <button class="btn order-btn">Read More</button> -->
					</div>
				</div>
				<div class="col-md-6">
					<img src="{{ WEBSITE_IMG_URL.'catering.png' }}" class="img-fluid ml-5">
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="team">
			<h6>Our Team</h6>
			<h2>Specialized Chefs</h2>
			<div class="row">
        @if($chefslist->isNotEmpty())
          @foreach($chefslist as $chefs)
    				<div class="col-md-4">
    					<div class="product-box">
    						<div class="product-img-box">
    							<div class="product-img">
                     @if(!empty($chefs->image) &&
                        File::exists(CHEF_ROOT_PATH.$chefs->image))
                          <?php $image = CHEF_URL.$chefs->image; ?>
                      @else
                          <?php $image = WEBSITE_IMG_URL.'ch1.jpg'; ?>
                      @endif
    							   	<img class="chefs_image" src="{{$image}}">
    							</div>
    							<div class="view-detail chef-detail">
    								<p>Email: {{$chefs->email}}</p>
    								<!-- <div class="social-footer">
    									<ul class="text-center">
    										<li><a href="#"><i class="fa fa-facebook"></i></a></li>
    										<li><a href="#"><i class="fa fa-twitter"></i></a></li>
    										<li><a href="#"><i class="fa fa-instagram"></i></a></li>
    										<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
    									</ul>
    								</div> -->
    							</div>
    						
    						<div class="product-detail chf-info">
    							<h4>{{$chefs->name}}</h4>
    							<p>{{$chefs->designation}}</p>
    						</div>
    						</div>
    					</div>
    				</div>
          @endforeach
        @else
          <h3 class="text-center"> Chefs Not Available. </h3> 
        @endif  
			</div>
       @include('frontend.pagination.pagination', ['paginator' => $chefslist])
		</div>
	</div>
	<!-- <div class="bg-light cat-form">
		<div class="container">
			<div class="enq">
				<h2 class="text-center mb-4">Gourmet Catering for any Occasion</h2>
				<div class="row">
					<div class="col-md-6 form-group">
						<input type="text" class="form-control" name="username" placeholder="Name" required="">
					</div>
					<div class="col-sm-6 form-group">
						<input type="email" class="form-control" name="email" placeholder="Email" required="">
					</div>
					<div class="col-sm-6 form-group">
						<input type="text" class="form-control" name="phone" placeholder="Phone No" required="">
					</div>
					<div class="col-sm-6 form-group">
						<input type="date" class="form-control" name="phone" required="">
					</div>
					<div class="col-sm-6 form-group">
						<input type="text" class="form-control" name="Time" placeholder="Time" required="">
					</div>
					<div class="col-sm-6 form-group">
						<input type="text" class="form-control" name="phone" placeholder="Number of People" required="">
					</div>
					<div class="col-sm-12 form-group pull-right">
						<textarea name="message" class="form-control" placeholder="Message"></textarea>
					</div>
					<div class="col-sm-12 form-group text-center">
						<button type="submit" class="send-btn">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div> -->
@endsection