@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/event') }}">Event</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $detail->title }}</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">{{ $detail->title }}</h1>

<section class="event-details-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-6 col-12">
        <div class="blog-des-Title w-100 m-b-15">
          <h4>event</h4>
        </div>
        <div class="event-details-page"> @if ($detail->image !=='' && File::exists(EVENT_ROOT_PATH.$detail->image))
          <?php $image = EVENT_URL.$detail->image; ?>
          @else
          <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
          @endif <img src="{{ $image }}">
          <h2>{{ $detail->title }}</h2>
          {!! $detail->description !!}
        </div>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        
          <div class="recent_posts">
            <h3>Events</h3>
            <ul>
              @foreach($events as $event)
              <li>
                <a href="{{url('event-detail/'.$event->slug)}}">
                  <div class="blog-left">
                    @if(!empty($event->image) && File::exists(EVENT_ROOT_PATH.$event->image))
                    <?php $image = EVENT_URL.$event->image; ?>
                    @else
                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                    @endif
                    <img src="<?php echo $image; ?>" alt="" class="w-100 d-block">
                  </div>
                  <div class="blog-right">
                      <h5>{{ Str::limit($event->title, TITLE_LIMIT)  }}</h5>
                      <p>{!! trim(Str::limit(strip_tags($event->description), DESC_LIMIT)) !!}</p>
                  </div>
                </a>
              </li>
              @endforeach
            </ul>
          </div>

      </div>
      
    </div>
  </div>
</section>

<?php 
$site_settings=App\Models\Settings\Site_setting::all();
$site_settings2 = [];
foreach ($site_settings as $key => $value) {
    $site_settings2[$value->key] = $value->value;
}
$site_settings = $site_settings2;
?>
@include('frontend.includes.new.home_counter')

<!-- <section class="counter-section counter-bg relative d-flex align-items-center" style="background: url({{asset('public/latest/images/counter-bg.jpg')}});">
  <div class="container">
    <div class="count-down w-100">
      <div id="counter" class="justify-content-between d-flex align-items-center w-100">
        <div class="counter-box"> <span><i class="flaticon-layers"></i></span>
          <div class="counter-value" data-to="230" data-count="230"></div>
          <p>Projects Done</p>
        </div>
        <div class="counter-box"> <span><i class="flaticon-rating"></i></span>
          <div class="counter-value" data-to="789" data-count="789"></div>
          <p>Satisfied Clients</p>
        </div>
        <div class="counter-box"> <span><i class="flaticon-coffee-cup"></i></span>
          <div class="counter-value" data-to="580" data-count="580"></div>
          <p>Cup Of Coffee</p>
        </div>
        <div class="counter-box"> <span><i class="flaticon-trophy"></i></span>
          <div class="counter-value" data-to="129" data-count="129"></div>
          <p>Awards Win</p>
        </div>
      </div>
    </div>
  </div>
</section> -->
@endsection