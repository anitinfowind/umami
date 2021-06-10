@extends('frontend.layouts.layout') @section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reward</li>
        </ol>
    </div>
</nav>

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

<section class="signingUpMd text-center d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="signingUpMdInner">
                    <p>Signing up is easy. Once you create your account, we’ll automatically give you Rewards Points for every puchase you make.<span class="font-weight-bold">Earn your Rewards Points now!</span></p>
                    <p><a href="{{ url('/register') }}" class="order-btn">Create Account</a></p>
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
                        <h4>Your Rewards Points Never Have to Expire</h4>
                        <p>Extend the life of your Rewards Points by making at least</p>
                    </div>
                    <div class="sign-up-rew">
                        <h4>1 Purchase a&nbsp;Year</h4>
                        <p>If you don’t, your Rewards Points will expire 365 days after your last purchase.</p>
                    </div>
                    <div class="sign-up-rew">
                        <h4>Redeem Your Rewards</h4>
                        <p>Instantly redeem one of these Rewards at checkout</p>
                        <a class="createAccountBtn" href="{{url('register')}}">Create Account</a>
                    </div>


                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                <div class="redemRewards d-flex align-items-center justify-content-center">
                    <div class="row">
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

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="sign-up-rew">
                    
                    <p>* Your cart should have a minimum of $50 worth of purchasing items before Rewards Points can be applied.
                        <a class="text-reset" href="{{ url('/pages/terms-of-use') }}">Restrictions apply.</a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="reward-work-bg"></div>
</section>



@endsection