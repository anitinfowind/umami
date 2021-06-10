@extends('frontend.layouts.layout')
@section('content') 
<?php 
$useronly='';
if(auth()->user()){
    $useronly = auth()->user()->isUser();
}
?>

<?php
//dd($page);
$page_meta = [];
foreach ($page->page_meta as $key => $value) {
    $page_meta[$value->meta_key] = $value->meta_value;
}
//dd($page_meta);
?>

<h1 style="display: none;">{{ $page->title }}</h1>

<section class="aboutbanner relative">
    <div class="sliderBg overlay-new bg bCover w-100 relative" style="background: url({{ url('public/uploads/page_meta/' . $page_meta['block_1_background_image']) }});"></div>
    <div class="about-slogan2">
        <div class="about-sloganInner2">
            <h2>{{ $page_meta['block_1_text'] }}</h2>
        </div>
    </div>
</section>
<section class="about-sec-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="about-heading-wrap">
                    <!-- <h3>MISSION</h3>
                    <p>Hi. We're Impossible Foods, and we make meat, dairy and fish from plants. Our mission is to make the global food system truly sustainable by eliminating the need to make food from animals. Why? Animal agriculture uses a tremendous amount of the world's natural resources. In 2016, we launched our first product, the Impossible™ Burger. It's delicious, nutritious, and made using but a small fraction of the land, water and energy required to make meat from a cow.</p> -->
                    {!! $page_meta['top_text'] !!}
                </div>
            </div>
        </div>
    </div>
</section>

<section class="feeding-sec-wrap">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 order-box-1">
                <div class="mission-pic">
                    <img src="{{ url('public/uploads/page_meta/' . $page_meta['section_1_image']) }}">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 order-box-1">
                <div class="about-heading-wrap about-page-btn">
                    <h4>{!! $page_meta['section_1_title_1'] !!}</h4>
                    <h3>{!! $page_meta['section_1_title_2'] !!}</h3>
                    <!-- <p>During a sabbatical in 2009, Stanford University Professor Dr. Patrick O. Brown decided to switch the course of his career to address the urgent problem of climate change. In particular, he wanted to make the global food system sustainable. Pat brought together a team of top scientists to recreate the entire sensory experience of meat, dairy and fish using plants. We debuted our first product, Impossible Burger, in 2016. Since then, we've continued to blast ahead to preserve the planet we call home.</p>
                    <a href="#">About Our Mission</a> -->
                    {!! $page_meta['section_1_text'] !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 order-box-4">
                <div class="about-heading-wrap about-page-btn">
                    <h4>{!! $page_meta['section_2_title_1'] !!}</h4>
                    <h3>{!! $page_meta['section_2_title_2'] !!}</h3>
                    <!-- <p>Before Impossible Foods, there was meat and there were plants. Back in 2011, we started with a simple question: "What makes meat taste like meat?" Then we figured out how to make it with plants. You know our products. Now, meet the technology behind it all.</p> -->
                    {!! $page_meta['section_2_text'] !!}
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 order-box-3">
                <div class="mission-pic">
                    <img src="{{ url('public/uploads/page_meta/' . $page_meta['section_2_image']) }}">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="scientists-sec-wrap relative" style="background: url({{ url('public/uploads/page_meta/' . $page_meta['section_3_image']) }}) no-repeat center center">
    <div class="container">
        <div class="row">
            <div class="scientists-head-wrap">
                <div class="col-12">
                    <div class="about-heading-wrap clr-white">
                        <h4>{!! $page_meta['section_3_title_1'] !!}</h4>
                        <h3>{!! $page_meta['section_3_title_2'] !!}</h3>
                        <!-- <p>We need the best and brightest scientists in the world to help us turn back the clock on climate change. Does this sound like you? Apply today!</p> -->
                        {!! $page_meta['section_3_text'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Banner Paralax js -->
<script type="text/javascript">
    var lFollowX = 0,
        lFollowY = 0,
        x = 0,
        y = 0,
        friction = 1 / 30;

    function moveBackground() {
        x += (lFollowX - x) * friction;
        y += (lFollowY - y) * friction;

        translate = 'translate(' + x + 'px, ' + y + 'px)';

        $('.bg').css({
            '-webit-transform': translate,
            '-moz-transform': translate,
            'transform': translate
        });

        window.requestAnimationFrame(moveBackground);
    }

    $(window).on('mousemove click', function(e) {

        var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - e.clientX));
        var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - e.clientY));
        lFollowX = (20 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
        lFollowY = (10 * lMouseY) / 100;

    });

    moveBackground();
</script>
<!-- End Banner Paralax js -->

@endsection