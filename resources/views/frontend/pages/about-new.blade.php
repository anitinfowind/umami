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

<section class="aboutbanner relative bCover">
    <div class="sliderBg overlay-new bg w-100 relative" style="background: url({{ url('public/uploads/page_meta/' . $page_meta['block_1_background_image']) }});"></div>
    <div class="new-about-slogan">
        <div class="new-about-sloganInner">
            <?php
            $txt = explode(' ', $page_meta['block_1_text_1']);
            $last_word = $txt[(count($txt) - 1)];
            unset($txt[(count($txt) - 1)]);
            $str = implode(' ', $txt);
            ?>
    <h3>{{ $str }} <span>{{ $last_word }}</span></h3>
            <h2>{{ $page_meta['block_1_text_2'] }}</h2>
            <h4>{{ $page_meta['block_1_text_3'] }}</h4>
        </div>
    </div>
</section>


<section class="about-work">    
<div class="container">
  <div class="row text-center align-items-center">
    <div class="col-12">
                <h3>{{ $page_meta['step_title'] }}</h3>
            </div>
    <div class="col-lg-6 col-md-6 col-sm-12 off-bdr order-box-1">
      <div class="about-work-box">
        <div class="step-mobile">
            <div class="work-step-mobile">
                <p>step</p>
                <div class="step-number">
                    <span>1</span>
                </div>
            </div>
        </div>
        <div class="work-img"><img class="img-fluid" src="{{ url('public/uploads/page_meta/' . $page_meta['step_1_image']) }}" alt=""></div>
        <div class="workimg-bdr"></div>
        <div class="work-step">
          <p>step</p>
          <div class="step-number">
            <span>1</span>
          </div>
        </div>
        <div class="work-box-bg1">
          <img class="img-fluid" src="{{ url('public/uploads/page_meta/' . $page_meta['step_1_background_image']) }}" alt="">
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 order-box-2">
      <div class="about-work-text">
        <!-- <h5>Pick a Plan</h5>
        <p>Whether cooking for yourself or your household, we have a flexible plan to match your lifestyle. Need to cancel, change meals, or skip a week? Not a problem.</p>
        <div class="slogan-one text-center">
                        <a href="#" class="all_btn">get started</a>
                    </div> -->
        {!! $page_meta['step_1_text'] !!}
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 order-box-4">
      <div class="about-work-text">
        <!-- <h5>Get your delivery</h5>
        <p>Each week, you’ll open simple step-by-step recipes complete with nutritional information and fresh, pre-measured ingredients to get you whipping up delicious dinners in no time.</p> -->
        {!! $page_meta['step_2_text'] !!}
        <div class="slogan-one text-center">
                    <!-- <a href="#" class="all_btn">get started</a> -->
        <div class="workimg-bdr-blk"></div>
          <div class="work-step">
          <p>step</p>
          <div class="step-number">
            <span>2</span>
          </div>
        </div>
                </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 order-box-3">
      <div class="about-work-box left-bdr">
        <div class="step-mobile">
            <div class="work-step-mobile">
                <p>step</p>
                <div class="step-number">
                    <span>2</span>
                </div>
            </div>
        </div>
        <div class="work-img"><img class="img-fluid" src="{{ url('public/uploads/page_meta/' . $page_meta['step_2_image']) }}" alt=""></div>    
        <div class="work-box-bg">
          <img class="img-fluid" src="{{ url('public/uploads/page_meta/' . $page_meta['step_2_background_image']) }}" alt="">
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 off-bdr1 order-box-5">
      <div class="about-work-box">
        <div class="step-mobile">
            <div class="work-step-mobile">
                <p>step</p>
                <div class="step-number">
                    <span>3</span>
                </div>
            </div>
        </div>
        <div class="work-img"><img class="img-fluid" src="{{ url('public/uploads/page_meta/' . $page_meta['step_3_image']) }}" alt=""></div>
        <div class="work-step">
          <p>step</p>
          <div class="step-number">
            <span>3</span>
          </div>
        </div>
        <div class="work-box-bg2">
          <img class="img-fluid" src="{{ url('public/uploads/page_meta/' . $page_meta['step_3_background_image']) }}" alt="">
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 order-box-6">
      <div class="about-work-text">
        <!-- <h5>Cook, eat, enjoy!</h5>
        <p>The old “what do you want to eat?” conversation is about to be banished from your life. Welcome to a world where dinner is always planned, simple, and delicious.</p>
        <div class="slogan-one text-center">
                    <a href="#" class="all_btn">get started</a>
                </div> -->
        {!! $page_meta['step_3_text'] !!}
      </div>
    </div>
  </div>
</div>
</section>

<section class="benefits">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h3>{!! $page_meta['hexa_title'] !!}</h3>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="fmInnert">
                    <span><img src="{{ url('public/uploads/page_meta/' . $page_meta['hexa_1_image']) }}" alt=""></span>
                    <h4>{!! $page_meta['hexa_1_title'] !!}</h4>
                    <!-- <p>Our chef-created recipes are tested 200 times to ensure your meals are as delicious to eat as they are easy to</p> -->
                    {!! $page_meta['hexa_1_text'] !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="fmInnert">
                    <span><img src="{{ url('public/uploads/page_meta/' . $page_meta['hexa_2_image']) }}" alt=""></span>
                    <h4>{!! $page_meta['hexa_2_title'] !!}</h4>
                    <!-- <p>From step-by-step recipes to no-hassle account changes, we make your life easier every way we can.</p> -->
                    {!! $page_meta['hexa_2_text'] !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="fmInnert">
                    <span><img src="{{ url('public/uploads/page_meta/' . $page_meta['hexa_3_image']) }}" alt=""></span>
                    <h4>{!! $page_meta['hexa_3_title'] !!}</h4>
                    <!-- <p>We accommodate every appetite, household size, and schedule. Need to skip a week or cancel? No problem.</p> -->
                    {!! $page_meta['hexa_3_text'] !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="fmInnert">
                    <span><img src="{{ url('public/uploads/page_meta/' . $page_meta['hexa_4_image']) }}" alt=""></span>
                    <h4>{!! $page_meta['hexa_4_title'] !!}</h4>
                    <!-- <p>Take back your evenings with fewer trips to the store, pre-planned meals, and little cleanup.</p> -->
                    {!! $page_meta['hexa_4_text'] !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="fmInnert">
                    <span><img src="{{ url('public/uploads/page_meta/' . $page_meta['hexa_5_image']) }}" alt=""></span>
                    <h4>{!! $page_meta['hexa_5_title'] !!}</h4>
                    <!-- <p>Picky appetites welcome! Tell us what you like and don’t like, and we’ll recommend something delicious.</p> -->
                    {!! $page_meta['hexa_5_text'] !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="fmInnert">
                    <span><img src="{{ url('public/uploads/page_meta/' . $page_meta['hexa_6_image']) }}" alt=""></span>
                    <h4>{!! $page_meta['hexa_6_title'] !!}</h4>
                    <!-- <p>It’s easy being green with our pre-measured ingredients and recyclable materials.</p> -->
                    {!! $page_meta['hexa_6_text'] !!}
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="slogan-one text-center">
                    <a href="{!! $page_meta['hexa_button_link'] !!}" class="all_btn">{!! $page_meta['hexa_button_text'] !!}</a>
                </div>
            </div>
        </div>
    </div>        
</section>

<section class="blog">
    <div class="container">
        <!-- <div class="row align-items-center">
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="blog-left-box blog-heading-left">
                    <h3>Our Blog</h3>   
                    <h2>Why start Healthy Ramen?</h2>    
                    <p>Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="smalloblog-box smalloblog-box-bg">
                            <h6>03 December, 2020</h6>
                            <h5><a href="#">Ramen Kings – The healthy Ramen experts</a></h5>                                    
                            <p>If we are to take a percentage of the people who a...</p>
                            <a href="#" class="blog-read-btn">read more</a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="blog-img-to w-100 rea">
                            <img src="{{ url('public/latest/images/new-pages/blog/2.png') }}" alt="" class="w-100 d-block">
                            <div class="videoBtnBox">
                                <button class="videoBtn video-btn" data-toggle="modal" data-src="https://www.youtube.com/embed/nV04zyfLyN4" data-target="#myModal"><i class="fa fa-play"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div> -->
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="blog-left-box blog-heading-left">
                    <h3>Our Blog</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $blog = $blogs[0] ?? new \stdClass;
            if(isset($blog->id)) {
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="blog-img">
                            @if ($blog->image() !=='' && File::exists(BLOG_ROOT_PATH.$blog->image()))
                            <?php $image = BLOG_URL.$blog->image(); ?>
                            @else
                            <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
                            @endif
                            <img src="{{ $image }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="smalloblog-box">
                            <h6>{{ date('F j, Y', strtotime($blog->publish_datetime)) }}</h6>
                            <h5><a href="{{ url('blog', $blog->slug) }}">{{ Str::limit($blog->name())  }}</a></h5>    
                            <p>{!! Str::limit(strip_tags($blog->content()), DESC_LIMIT) !!}</p>
                            <a href="{{ url('blog', $blog->slug) }}" class="blog-read-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            $blog = $blogs[1] ?? new \stdClass;
            if(isset($blog->id)) {
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="blog-img">
                            @if ($blog->image() !=='' && File::exists(BLOG_ROOT_PATH.$blog->image()))
                            <?php $image = BLOG_URL.$blog->image(); ?>
                            @else
                            <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
                            @endif
                            <img src="{{ $image }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="smalloblog-box">
                            <h6>{{ date('F j, Y', strtotime($blog->publish_datetime)) }}</h6>
                            <h5><a href="{{ url('blog', $blog->slug) }}">{{ Str::limit($blog->name())  }}</a></h5>    
                            <p>{!! Str::limit(strip_tags($blog->content()), DESC_LIMIT) !!}</p>
                            <a href="{{ url('blog', $blog->slug) }}" class="blog-read-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row">
            <?php
            $blog = $blogs[2] ?? new \stdClass;
            if(isset($blog->id)) {
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="blog-img">
                            @if ($blog->image() !=='' && File::exists(BLOG_ROOT_PATH.$blog->image()))
                            <?php $image = BLOG_URL.$blog->image(); ?>
                            @else
                            <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
                            @endif
                            <img src="{{ $image }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="smalloblog-box">
                            <h6>{{ date('F j, Y', strtotime($blog->publish_datetime)) }}</h6>
                            <h5><a href="{{ url('blog', $blog->slug) }}">{{ Str::limit($blog->name())  }}</a></h5>    
                            <p>{!! Str::limit(strip_tags($blog->content()), DESC_LIMIT) !!}</p>
                            <a href="{{ url('blog', $blog->slug) }}" class="blog-read-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            $blog = $blogs[3] ?? new \stdClass;
            if(isset($blog->id)) {
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="blog-img">
                            @if ($blog->image() !=='' && File::exists(BLOG_ROOT_PATH.$blog->image()))
                            <?php $image = BLOG_URL.$blog->image(); ?>
                            @else
                            <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
                            @endif
                            <img src="{{ $image }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="smalloblog-box">
                            <h6>{{ date('F j, Y', strtotime($blog->publish_datetime)) }}</h6>
                            <h5><a href="{{ url('blog', $blog->slug) }}">{{ Str::limit($blog->name())  }}</a></h5>    
                            <p>{!! Str::limit(strip_tags($blog->content()), DESC_LIMIT) !!}</p>
                            <a href="{{ url('blog', $blog->slug) }}" class="blog-read-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>                
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="slogan-one text-center">
                    <a href="{{ url('/blog') }}" class="all_btn">view our blog</a>
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