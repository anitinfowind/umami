@extends('frontend.layouts.app')
@section('content')
<div class="inner-breadcrumbs-menu">
  <div class="container-fluid">
    <ul>
      <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
      <li><span>Chefs</span></li>
    </ul>
  </div>
</div>
<div class="container-fluid">
  <div class="team product-section rest_chef_section">
    <h6>Chef Team</h6>
    <div class="row"> @if($chefslist->isNotEmpty())
      @foreach($chefslist as $chefs)
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="product-box">
          <div class="product-img-box"> <a href="{{url('user-detail/'.$chefs->getRestautentName->UserSlug->slug)}}">
            <div class="product-img"> @if(!empty($chefs->image) &&
              File::exists(CHEF_ROOT_PATH.$chefs->image))
              <?php $image = CHEF_URL.$chefs->image; ?>
              @else
              <?php $image = WEBSITE_IMG_URL.'ch1.jpg'; ?>
              @endif <img class="chefs_image" src="{{$image}}"> </div>
            </a>
            <div class="product-detail">
              <h4>{{$chefs->name}}</h4>
              <a href="{{url('chef-detail/'.$chefs->slug)}}">
              <p> {!! Str::limit($chefs->description,40)!!}</p>
              </a> </div>
          </div>
        </div>
      </div>
      @endforeach
      @else
      <h3 class="text-center"> Chefs Not Available. </h3>
      @endif </div>
    @include('frontend.pagination.pagination', ['paginator' => $chefslist]) </div>
</div>
@endsection