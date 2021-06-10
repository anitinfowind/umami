@extends('frontend.layouts.app')
@section('content')
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<ul>
				<li><a href="#">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>Donate</span></li>
			</ul>
		</div>
	</div>

	<div class="donate-section">
	   <div class="container">
	   	  <div class="donate-logo">
	   	  	<img src="../images/logo.png">
	   	  </div>
	   	  <div class="search-tree">
	   	  	 <input type="text" class="form-control" placeholder="Search the web to plant trees...">
	   	  	 <button class="btn donate-btn"><i class="fa fa-search"></i></button>
	   	  </div>
	   	   <div class="next-countdown">
			  <ul>
			    <li><span id="days"></span></li>
			    <li><span id="hours"></span></li>
			    <li><span id="minutes"></span></li>
			    <li><span id="seconds"></span></li>
			  </ul>
			  <p> Trees planted by Umami square users </p>
		  </div>
		  <h2> Let's plant some trees! </h2>
		  <h4> Make Umami your new search engine and plant trees<br> with your searches - for free! </h4>
		  <button class="btn umami-btn">Add Umami to Firefox</button>
		  <div class="donate-grid-box">
		   <div class="row">
		   	 <div class="col-sm-4">
				<div class="product-box">
				<div class="product-img-box">
					<div class="product-img">
						<img class="chefs_image" src="http://localhost/umami-square/www/public/images/blog5.jpg">
					</div>
				</div>
				<div class="product-detail chf-info">
					<h3>Completely transparent</h3>
					<p>Lorem ipsum netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit.</p>
				</div>
			  </div>
		   </div>
		   <div class="col-sm-4">
				<div class="product-box">
				<div class="product-img-box">
					<div class="product-img">
						<img class="chefs_image" src="http://localhost/umami-square/www/public/images/blog6.jpg">
					</div>
				</div>
				<div class="product-detail chf-info">
					<h3>More than CO<sub>2</sub> neutral</h3>
					<p>Lorem ipsum netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit.</p>
				</div>
			  </div>
		   </div>
		   <div class="col-sm-4">
				<div class="product-box">
				<div class="product-img-box">
					<div class="product-img">
						<img class="chefs_image" src="http://localhost/umami-square/www/public/images/blog7.jpg">
					</div>
				</div>
				<div class="product-detail chf-info">
					<h3>Privacy friendly</h3>
					<p>Lorem ipsum netus lullam utlacus adipiscing ipsum molestie euismod estibulum vel libero ipsum sit amet. Aenean imperdiet aliquet hendrerit.</p>
				</div>
			  </div>
		   </div>
		  </div>
		</div>

	  <div class="who-youll-help">
	    <div class="row align-items-center">
	      <div class="col-md-5">
	      	<div class="plant-img">
	            <img src="https://index-assets-cdn.ecosia.org/img/4c7aeca.jpg">
	       </div>
	      </div>
	      <div class="col-5 pr-40">
	      	<div class="plant-detail">
	        <h2>You search the web,<br> we plant trees</h2>
	        <h4>Ecosia is like any other search engine, with one major difference: we use our profits to plant trees.</h4>
	        <button class="btn umami-btn">Add Umami to Firefox</button>
	    </div>
	      </div>
	    </div>
	  </div>
  </div>
  <div class="donate-video-section">
  	 <div class="container">
  	 	<div class="video-donate">
  	 		<h2> Every search counts </h2>
  	 		<h4> See how Umami users are changing the world. </h4>
  	 		<span><i class="fa fa-play-circle"></i></span>
  	 	</div>
  	 </div>
  </div>
</div>

<script> 
   const second = 1000,
	  minute = second * 60,
	  hour = minute * 60,
	  day = hour * 24;

	let countDown = new Date("Sep 30, 2020 00:00:00").getTime(),
	  x = setInterval(function () {
	    let now = new Date().getTime(),
	      distance =  now-countDown ;

	    (document.getElementById("days").innerText = Math.floor(distance / day)),
	      (document.getElementById("hours").innerText = Math.floor(
	        (distance % day) / hour
	      )),
	      (document.getElementById("minutes").innerText = Math.floor(
	        (distance % hour) / minute
	      )),
	      (document.getElementById("seconds").innerText = Math.floor(
	        (distance % minute) / second
	      ));

	  }, second);

</script>

@endsection