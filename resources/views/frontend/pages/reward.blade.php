@extends('frontend.layouts.layout') @section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reward</li>
        </ol>
    </div>
</nav>

<?php
//dd($page);
$page_meta = [];
foreach ($page->page_meta as $key => $value) {
    $page_meta[$value->meta_key] = $value->meta_value;
}
//dd($page_meta);
?>

<!-- <div class="inner-breadcrumbs-menu">
    <div class="container">
        <ul>
			<li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
			<li><span>Reward</span></li>
		</ul>
    </div>
</div> -->
<!-- <section class="howWork">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="reward-header text-center">
                    <h4>HOW IT WORKS</h4>
                    <p>It’s so simple, you might not even know you are getting Rewards Points!</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="rewardInner">
                    <span><img src="{{ WEBSITE_IMG_URL.'premium.png' }}" class=""></span>

                    <h4>Earn Rewards Points On Every Purchase</h4>
                    <p>Earn 10 points for every dollar you spend once your food ships (excludes the use of gift cards).</p>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="rewardInner">
                    <span><img src="{{ WEBSITE_IMG_URL.'redeem-points.png' }}" class=""></span>

                    <h4>Redeem Points for Discounted Eats</h4>
                    <p>Cash in your points for steep discounts on any future food purchase at checkout.</p>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="rewardInner">
                    <span><img src="{{ WEBSITE_IMG_URL.'reward-gift.png' }}"></span>

                    <h4>Points NEVER Have To Expire</h4>
                    <p>Just purchase at least once every 12 months and your points won’t ever expire!</p>
                </div>

            </div>
        </div>
    </div>
</section> -->

<section class="signingUpMd text-center d-flex align-items-center" style="background: url({{ url('public/uploads/page_meta/' . $page_meta['block_1_background_image']) }});">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="signingUpMdInner">
                    <!-- <p>Signing up is easy. Once you create your account, we’ll automatically give you Rewards Points for every puchase you make.<span class="font-weight-bold">Earn your Rewards Points now!</span></p> -->
                    <p>{!! nl2br($page_meta['block_1_text']) !!}</p>
                    <?php if(!auth()->user()) { ?>
                        <p><a href="{{ url('/register') }}" class="order-btn">Create Account</a></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="reward-work relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-12 d-flex align-items-center">
                <div class="pointaNever">
                    <div class="sign-up-rew">
                        <h4>{!! $page_meta['sqblock_head_1'] !!}</h4>
                        <p>{!! $page_meta['sqblock_text_1'] !!}</p>
                    </div>
                    <div class="sign-up-rew">
                        <h4>{!! $page_meta['sqblock_head_2'] !!}</h4>
                        <p>{!! $page_meta['sqblock_text_2'] !!}</p>
                    </div>
                    <div class="sign-up-rew">
                        <h4>{!! $page_meta['sqblock_head_3'] !!}</h4>
                        <p>{!! $page_meta['sqblock_text_3'] !!}</p>
                        
                        <?php if(!auth()->user()) { ?>
                            <a class="createAccountBtn" href="{{url('register')}}">Create Account</a>
                        <?php } ?>
                    </div>


                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                <div class="redemRewards d-flex align-items-center justify-content-center">
                    <div class="row">
                        <?php /* ?>
                        @if($rewards->isNotEmpty()) @foreach($rewards as $reward)
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="points-btn">
                                <div class="pointsRreward">
                                    ${{$reward->discount_price}}&nbsp;OFF
                                </div>
                                <div class="pointsValue">
                                    {{$reward->earn_point}} points
                                </div>
                            </div>
                        </div>
                        @endforeach @endif
                        <?php */ ?>
                        <?php
                        for($i = 1; $i <= 4; $i++) {
                            $sqblock_red = explode('|', $page_meta['sqblock_red_' . $i]);
                            echo '<div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="points-btn">
                                    <div class="pointsRreward">' . $sqblock_red[0] . '</div>
                                    <div class="pointsValue">' . $sqblock_red[1] . '</div>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12">
                <div class="sign-up-rew">
                    
                    <p>* Your cart should have a minimum of $50 worth of purchasing items before Rewards Points can be applied.
                        <a class="text-reset" href="{{ url('/pages/terms-of-use') }}">Restrictions apply.</a></p>
                </div>
            </div> -->
        </div>
    </div>
    <div class="reward-work-bg" style="background: url({{ url('public/uploads/page_meta/' . $page_meta['sqblock_right_background_image']) }}) 0 0 no-repeat;
    -moz-background-size: cover;
    -webkit-background-size: cover;
    background-size: cover;"></div>
</section>



@endsection