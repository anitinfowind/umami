@extends('frontend.layouts.app')
@section('content')
    <div class="inner-breadcrumbs-menu">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
                <li><a href="{{ url('event') }}">Event</a><i class="fa fa-angle-right"></i></li>
                <li><span>Event detail</span></li>
            </ul>
        </div>
    </div>
    <div class="blog-detail-section">
        <div class="container">
            <div class="blog-view-page">
                <div class="blog-img">
                    @if ($detail->image !=='' && File::exists(EVENT_ROOT_PATH.$detail->image))
                        <?php $image = EVENT_URL.$detail->image; ?>
                    @else
                        <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
                    @endif
                    <img src="{{ $image }}">
                </div>
                <div class="blog-detail">
                    <h3>{{ $detail->title }}</h3>
                    {!! $detail->description !!}
                </div>
            </div>
        </div>
    </div>
@endsection