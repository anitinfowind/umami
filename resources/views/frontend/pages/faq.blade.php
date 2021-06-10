@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Faq</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">FAQ</h1>


	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<!-- <ul>
				<li><a href="#">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>FAQS</span></li>
			</ul> -->
		</div>
	</div>
	@if($faqs->isNotEmpty())
		<section class="faq-section">
			<div class="container">

				<?php /* ?>
				<div id="accordion" class="accordion food-accordion">
					@foreach($faqs as $key => $faq)
						<div class="card">
							<div class="card-header collapsed" data-toggle="collapse" href="#collapse{{$key}}">
								<a class="card-title"> {{ $faq->question }} </a>
							</div>
							<div id="collapse{{$key}}" class="card-body collapse @if($key == ZERO) show @endif" data-parent="#accordion">
								<p>{!! $faq->answer !!}</p>
							</div>
						</div>
					@endforeach
				</div>
				<?php */ ?>

				


				<div class="accordion" id="accordionExample">
					@foreach($faqs as $key => $faq)
	        <div class="card">
	            <div class="card-header" id="heading{{ $key }}">
	                <h2 class="mb-0">
	                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $key }}"><i class="fas fa-plus"></i> {!! $faq->question !!}</button>
	                  </h2>
	            </div>
	            <div id="collapse{{ $key }}" class="collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $key }}" data-parent="#accordionExample">
	                <div class="card-body">
	                    {!! $faq->answer !!}
	                </div>
	            </div>
	        </div>
	        @endforeach
	        
	    </div>



			</div>
		</section>
	@endif


<script type="text/javascript">
$(document).ready(function(){
    // Add minus icon for collapse element which is open by default
    $(".collapse.show").each(function(){
    	$(this).prev(".card-header").find(".fas").addClass("fa-minus").removeClass("fa-plus");
    	$(this).closest('.card').addClass('active');
    });
    
    // Toggle plus minus icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function(){
    	$(this).prev(".card-header").find(".fas").removeClass("fa-plus").addClass("fa-minus");
    	//$(this).closest('.accordion').find('.card').removeClass('active');
    	$(this).closest('.card').addClass('active');
    }).on('hide.bs.collapse', function(){
    	$(this).prev(".card-header").find(".fas").removeClass("fa-minus").addClass("fa-plus");
    	$(this).closest('.card').removeClass('active');
    });
});
</script>


@endsection