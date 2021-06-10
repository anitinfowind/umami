@extends('frontend.layouts.app')
@section('content')
<style>
	.inner-breadcrumbs-menu{
		margin-bottom: 0px;
	}
</style>
	<div class="inner-breadcrumbs-menu">
		<div class="container">
			<ul>
				<li><a href="#">Home</a><i class="fa fa-angle-right"></i></li>
				<li><span>comming</span></li>
			</ul>
		</div>
	</div>
		<div class="commingsoon-section">
          <div class="main-banner">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="count-down-timer">
                                    <div id="timer">
                                        <div id="days"></div>
                                        <div id="hours"></div>
                                        <div id="minutes"></div>
                                        <div id="seconds"></div>
                                    </div>
                                </div>

                                <div class="main-banner-content">
                                    <h1>Umami Restaurant Website launch Coming Soon</h1>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit sed eiu sit amet consectetur adipisicing.</p>

                                    <form class="newsletter-form">
                                        <input type="email" class="input-newsletter" placeholder="Enter email address" name="EMAIL">
                                        <button class="btn" type="submit">Subscribe</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        		</div>
			</div>


<script> 
    // Count Time 
        function makeTimer() {
            var endTime = new Date("December 30, 2020 17:00:00 PDT");			
            var endTime = (Date.parse(endTime)) / 1000;
            var now = new Date();
            var now = (Date.parse(now) / 1000);
            var timeLeft = endTime - now;
            var days = Math.floor(timeLeft / 86400); 
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }
            $("#days").html(days + "<span>Days</span>");
            $("#hours").html(hours + "<span>Hours</span>");
            $("#minutes").html(minutes + "<span>Minutes</span>");
            $("#seconds").html(seconds + "<span>Seconds</span>");
        }
		setInterval(function() { makeTimer(); }, 300);
</script>



@endsection