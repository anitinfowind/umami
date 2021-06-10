@extends('frontend.layouts.app')
@section('content')

<div class="inner-breadcrumbs-menu">
  <div class="container">
  <ul>
  	<li><a href="{{URL::to('/')}}">Home</a><i class="fa fa-angle-right"></i></li>
  	<li><span>Events</span></li>
  </ul>
  </div>
</div>
<div class="container">
	<div class="event-bx">
		<h2>EVENT GALLERY</h2>
		<div class="row">
      @if($events->isNotEmpty())
        @foreach($events as $event)
  			<div class="col-md-4 col-sm-6">
  				<div class="eve-bx">
					  <div class="product-box">
  	 	  	  		<div class="product-img-box">
                  @if(!empty($event->image) && File::exists(EVENT_ROOT_PATH.$event->image))
                    <?php $image = EVENT_URL.$event->image; ?>
                   @else
                     <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                  @endif
                   <img class="" src="{{ $image }}" alt="{{ $event->title }}">
  	 	  	  		</div>
  	 	  	  		<div class="product-detail">
  	 	  	  	  	<h4>{{ Str::limit($event->title,30) }}</h4>
                  {!! isset($event->description) ? $event->description : '' !!}
  	 	  	  	 		<a href="{{url('event-detail/'.$event->slug)}}" class="circle-more">more</a>
  	 	  	  		</div>
	  	 	  	</div>
  				</div>
  			</div>
        @endforeach
      @endif
		</div>
	</div>
</div>

<div class="eve-year">
	<div class="container">
		<h2>WEDDING OF THE YEAR</h2>
		<div class="row">
			<div class="col-md-6">
				<img src="public/images/eve-wedding.jpg" class="img-fluid">
			</div>
			<div class="col-md-6">
				<h4>FORMER MISS UNIVERSE, OLIVIA GROSH TIED THE KNOT WITH JOHN ANDERSON IN A DREAM WEDDING ON A CLIFF-TOP IN BALI.</h4>
				<p>Condime netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit. Nunc interdum ullamcorper lectus et pellentesque enim interdum at. Suspendisse malesuada dignissim facilisis ligula rutrum sed.Dolor nunc vule putateulr ips dol consec.</p>
				<p>Donec semp ertet lacinia ultri cie upien disse comete dolo lectus fgilla itollicil tua ludin dolor nec met quam accumsan dolore condime netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet.</p>
			</div>
		</div>
	</div>
</div>
@endsection