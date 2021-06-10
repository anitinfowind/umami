@extends('frontend.layouts.layout')
@section('content')
<?php //@include('frontend.includes.new.event_slider') ?>

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Event</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">EVENT GALLERY</h1>

<section class="event-search-sec">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-auto">
        <div class="sec-head">
          <h4>EVENT GALLERY</h4>
        </div>
      </div>
    </div>
    @if($events->isNotEmpty())
    <div class="product-section d-flex"> @foreach($events as $event)
      @if(!empty($event->image) && File::exists(EVENT_ROOT_PATH.$event->image))
      <?php $image = EVENT_URL.$event->image; ?>
      @else
      <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
      @endif
      <div class="custome-col-4">
        <div class="food-box relative">
          <div class="food-pic relative"> <img src="{{ $image }}" alt="{{ $event->title }}"> </div>
          <div class="events-des-box">
            <div class="events-head">
              <h4><a href="{{url('event-detail/'.$event->slug)}}">{{ Str::limit($event->title,15) }}</a></h4>
            </div>
          </div>
          <div class="event-des-text">
            <p>{!! isset($event->description) ? Str::limit($event->description,30) : '' !!}</p>
            <a class="event-btn" href="{{url('event-detail/'.$event->slug)}}">read more</a> </div>
        </div>
      </div>
      @endforeach </div>
    <!--<div class="row">
      <div class="col-12">
        <div class="load-more-btn"> <a href="#">load more</a> </div>
      </div>
    </div>--> 
    @endif </div>
</section>
<!--<section class="wedding-sec">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6 colsm-6 col-12">
        <div class="wedding-pic"> <img src="{{asset('public/latest/images/wedding-pic.jpg')}}" alt=""> </div>
      </div>
      <div class="col-lg-6 col-md-6 colsm-6 col-12">
        <div class="wedding-des-box">
          <h2>Wedding Of The Year</h2>
          <h4>FORMER MISS UNIVERSE, OLIVIA GROSH TIED THE KNOT WITH JOHN ANDERSON IN A DREAM WEDDING ON A CLIFF-TOP IN BALI.</h4>
          <p>Condime netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit. Nunc interdum ullamcorper lectus et pellentesque enim interdum at. Suspendisse malesuada dignissim facilisis ligula rutrum sed.Dolor nunc vule putateulr ips dol consec.</p>
          <p>Donec semp ertet lacinia ultri cie upien disse comete dolo lectus fgilla itollicil tua ludin dolor nec met quam accumsan dolore condime netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet.</p>
        </div>
      </div>
    </div>
  </div>
</section>-->

<?php 
$site_settings=App\Models\Settings\Site_setting::all();
$site_settings2 = [];
foreach ($site_settings as $key => $value) {
    $site_settings2[$value->key] = $value->value;
}
$site_settings = $site_settings2;
?>

@include('frontend.includes.new.home_counter')

@endsection