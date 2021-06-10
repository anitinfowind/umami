@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $pages->title }}</li>
    </ol>
  </div>
</nav>

	<div class="inner-breadcrumbs-menu">
		<div class="container">
      <ul>
        <!-- <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
        <li><span>{{$pages->title}}</span></li> -->
        <li>&nbsp;</li>
      </ul>
		</div>
	</div>
	<div class="wdo stcpg_cont">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>{{$pages->title}}</h1>
					
            {!!$pages->description!!}
				</div>
			</div>
		</div>
	</div>
@endsection