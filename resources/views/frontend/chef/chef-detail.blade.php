@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/all-chefs') }}">Chef</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $chefsDetail->name }}</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">{{ $chefsDetail->name }}</h1>

    <div class="inner-breadcrumbs-menu">
        <div class="container">
            <!-- <ul>
                <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
                <li><a href="{{ url('all-chefs') }}">Chef</a><i class="fa fa-angle-right"></i></li>
            </ul> -->
        </div>
    </div>

    <div class="blog-detail-section">
        <div class="container">
            <div class="blog-view-page">
                <div class="row">
                    <div class="col-md-4">
                        @if ($chefsDetail->image !=='' && File::exists(CHEF_ROOT_PATH.$chefsDetail->image))
                            <?php $image = CHEF_URL.$chefsDetail->image; ?>
                        @else
                            <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
                        @endif
                        <img src="{{ $image }}" class="img-fluid">
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $chefsDetail->name }}</h3>
                        {!! $chefsDetail->description !!}
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </div>
@endsection