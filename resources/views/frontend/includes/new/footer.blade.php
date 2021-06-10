<?php

/*$pages = App\Page::all();

print_r($pages);*/

$pages = Illuminate\Support\Facades\DB::table('pages')->get();

/*$pages2 = [];

$page_slugs = [];

foreach ($pages as $key => $value) {

  $pages2[] = $value;

  $page_slugs[] = $value->page_slug;

}*/

function get_page_status($slug, $pages) {

  $status = 0;

  foreach ($pages as $key => $value) {

    if($value->page_slug == $slug && $value->status == '1') $status = 1;

  }

  return $status;

}

$urlseg_1 = Request::segment(1);





$site_settings = App\Models\Settings\Site_setting::all();

$site_settings2 = [];

foreach ($site_settings as $key => $value) {

    $site_settings2[$value->key] = $value->value;

}

$site_settings = $site_settings2;

?>



<?php if(!in_array($urlseg_1, ['cart', 'checkout', 'register', 'login'])) { ?>

<section class="subdcribe-sec">

  <div class="container">

    <div class="row">

      <div class="col-12">

        <div class="subscribe-box">

          <p>Join Our Newsletter</p>

          <h4>Follow Us For Further Information</h4>

        </div>

        <div class="subscribeRight d-flex relative align-items-center relative">

          <input type="email" id="newsletter_email" class="form-control subscribeInput" placeholder="Enter your email...">

          <span class="newsletter_email error-msg" style="color:red"></span>

          <button class="subscribeBtn subscribe-btn" onclick="subscribe()">Subscribe</button>

        </div>

      </div>

    </div>

  </div>

</section>

<?php } ?>







<footer class="mainFooter ftr-sec-gap">

  <div class="container">

    <div class="ftop">

      <div class="row">

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mobile-none">

          <div class="ftr-lft">

            <div class="footer-logo">

              <a href="{{ url('/') }}"> 

                <img src="{{ url('public/images/logo.png') }}" alt=""> 

              </a>

            </div>

            <p>{!! nl2br($site_settings['footer_text_content'] ?? '') !!}</p>

          </div>

          <!--<h3 class="heading">UMAMI SQUARE APP</h3>

          <p>Downloaded over 1 million times</p>

          <div class="app-icon">

            <ul class="d-flex">

              <li> <a href="#"><img class="img-fluid" src="{{asset('public/latest/images/google.png')}}" alt=""></a> </li>

              <li> <a href="#"><img class="img-fluid" src="{{asset('public/latest/images/iso.png')}}" alt=""></a> </li>

            </ul>

          </div>-->

          <div class="fotter-social">

            <ul class="d-flex align-items-center">

              <li class="facebook11"><a target="_blank" href="{{ isset($setting->facebook) ? $setting->facebook :'javascript:void(0)' }}"><i class="fab fa-facebook-f"></i></a></li>

              <!--<li class="twitter"><a target="_blank" href="{{ isset($setting->twitter) ? $setting->twitter : 'javascript:void(0)' }}"><i class="fab fa-twitter"></i></a></li>

              <li class="google-plus"><a target="_blank"href="{{ isset($setting->google) ? $setting->google : 'javascript:void(0)' }}"><i class="fab fa-google-plus"></i></a></li>-->

              <li class="instagram11"><a target="_blank" href="{{ isset($setting->instagram) ? $setting->instagram : 'javascript:void(0)' }}"><i class="fab fa-instagram"></i></a></li>

            </ul>

          </div>

        </div>

        <div class="col-lg-8 col-md-8 col-sm-12 col-12">

          <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3 mobile-none">

              <h3 class="heading">Categories</h3>

              <div class="fnav">

                <ul>

                  @foreach($categorys as $category)

                  <li><a href="{{url('products/?category='.$category->slug)}}" title="">{{$category->name}}</a></li>

                  @endforeach

                  <li><a href="{{url('restaurant')}}" title="">RESTAURANT</a></li>

                  <li><a href="{{url('all-chefs')}}" title="">CHEF</a></li>

                </ul>

              </div>

            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-3">

              <h3 class="heading">Support</h3>

              <div class="fnav">

                <ul>

                  <li><a href="{{url('event')}}" title="">Event</a></li>

                  <!-- <li><a href="{{ url('learn-about-rewards') }}">Rewards Points</a></li> -->

                  @if(get_page_status('mission', $pages) == '1')

                    <li><a href="{{url('pages/learn-about-rewards')}}">Rewards Points</a></li>

                  @endif

                  <li><a href="{{ url('faq') }}">Help & Support</a></li>

                  <li><a href="{{url('pages/terms-of-use')}}">Terms Of Use</a></li>

                  <!-- <li><a href="{{url('pages/cookies-policy')}}">Cookies</a></li> -->

                  <li><a href="{{url('pages/refund-policy')}}">Refund</a></li>

                  <li><a href="{{url('pages/privacy-policy')}}">Privacy</a></li>

                  <li><a href="{{url('pages/shipping-policy')}}">Shipping</a></li>



                  @if(get_page_status('become-a-partner-restaurant', $pages) == '1')

                    <!-- <li><a href="{{url('pages/become-a-partner-restaurant')}}">Become a Partner restaurant</a></li> -->

                  @endif

                  <!-- <li><a href="{{ url('blog') }}">Blog</a></li> -->

                  <!-- <li><a href="{{ url('/') }}">Invite a Friend</a></li> -->

                  

                  

                  @if(get_page_status('terms-of-use', $pages) == '1')

                    <!-- <li><a href="{{url('pages/terms-of-use')}}">Terms Of Use</a></li> -->

                  @endif

                </ul>

              </div>

            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-3">

              <h3 class="heading">About</h3>

              <div class="fnav">

                <ul>

    

                  @if(get_page_status('mission', $pages) == '1')

                    <li><a href="{{url('pages/mission')}}">About Us</a></li>

                  @endif

                  @if(get_page_status('about', $pages) == '1')

                    <li><a href="{{url('pages/about')}}">How It Works</a></li>

                  @endif

                  <li><a href="{{ url('blog') }}">Blog</a></li>

                  <li><a href="{{url('contact-us')}}">Contact</a></li>

                  @if(get_page_status('press-and-news', $pages) == '1')

                    <!-- <li><a href="{{url('pages/press-and-news')}}">Press & News</a></li> -->

                  @endif

                </ul>

              </div>

              <div class="fotter-social m-none">

                <ul class="d-flex align-items-center">

                  <li class="facebook11"><a target="_blank" href="{{ isset($setting->facebook) ? $setting->facebook :'javascript:void(0)' }}"><i class="fab fa-facebook-f"></i></a></li>

                  <!--<li class="twitter"><a target="_blank" href="{{ isset($setting->twitter) ? $setting->twitter : 'javascript:void(0)' }}"><i class="fab fa-twitter"></i></a></li>

                  <li class="google-plus"><a target="_blank"href="{{ isset($setting->google) ? $setting->google : 'javascript:void(0)' }}"><i class="fab fa-google-plus"></i></a></li>-->

                  <li class="instagram11"><a target="_blank" href="{{ isset($setting->instagram) ? $setting->instagram : 'javascript:void(0)' }}"><i class="fab fa-instagram"></i></a></li>

                </ul>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <section class="copyright">

    <div class="container">

      <div class="row justify-content-between">

        <div class="col-auto footer-menu2">

          <?php /* ?>

          <ul class="d-flex align-items-center ftr-btm-menu flex-wrap">

            @if(get_page_status('cookies-policy', $pages) == '1')

              <li><a href="{{url('pages/cookies-policy')}}">Cookies Policy</a></li>

            @endif

            @if(get_page_status('refund-policy', $pages) == '1')

              <li><a href="{{url('pages/refund-policy')}}">Refund Policy</a></li>

            @endif

            @if(get_page_status('privacy-policy', $pages) == '1')

              <li><a href="{{url('pages/privacy-policy')}}">Privacy Policy</a></li>

            @endif

            @if(get_page_status('terms-of-use', $pages) == '1')

              <li><a href="{{url('pages/terms-of-use')}}">Terms Of Use</a></li>

            @endif

            @if(get_page_status('shipping-policy', $pages) == '1')

              <li><a href="{{url('pages/shipping-policy')}}">Shipping Policy</a></li>

            @endif

          </ul>

          <?php */ ?>

        </div>

        <div class="col-auto copyrightRight"> {{ isset($setting->copyright_text) ? $setting->copyright_text : 'Copyright@ 2020 Umami Square . All Rights Reserved.' }} </div>

      </div>

    </div>

  </section>


  <div id="subscriber-pop" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body">

       <div class="row">
         <div class="col-md-6 pop-left">
           <div class="modal-logo">
          <a href="https://umami.framework.infowindtech.biz"> <img src="https://umami.framework.infowindtech.biz/public/images/logo.png" alt=""> </a>
        </div>

            <div class="tess">
              Wait! Don’t miss out
            </div>

            <div class="get-free">
              Get $90 Off 
            </div>

            <div class="ind"> Including Free Shipping</div>

            <div class="whn-you">When you enter your email now</div>
          </div><!--col-md-6-->

           <div class="col-md-6  pop-right">
            <div class="pop-form">
              <div class="form-group">
                <label>Email address</label>
                <input type="text" class="sub-inp" placeholder="Enter email address" name="">
              </div>

               <div class="form-group">      
               
                <button class="res-button" data-toggle="modal" data-target="#getstarted-pop">Reserve Offer</button>
              </div>

              <div class="cont">
                <a href="#">Continue without offer</a>
              </div>


            </div><!--pop-form-->
          </div><!--col-md-6-->

         </div>
       </div>
      
    </div>

  </div>
</div><!--subscriber-pop-->


<div id="getstarted-pop" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body">

       <div class="row">
         <div class="col-md-6 pop-left">
           <div class="modal-logo">
          <a href="https://umami.framework.infowindtech.biz"> <img src="https://umami.framework.infowindtech.biz/public/images/logo.png" alt=""> </a>
        </div>

            <div class="tess">
              THANK YOU FOR SIGNING UP!
            </div>

            <div class="get-free">
                Offer Applied 
            </div>
           
          </div><!--col-md-6-->

           <div class="col-md-6  pop-right">
            <div class="pop-form">            

               <div class="form-group">        
               
                <button class="res-button1">GET STARTED NOW</button>
              </div>

              <div class="pop-footer">
                *exclusive for first time subscribers
              </div>


            </div><!--pop-form-->
          </div><!--col-md-6-->

         </div>
       </div>
      
    </div>

  </div>
</div><!--subscriber-pop-->


<script type="text/javascript">
  $(function() {
    $(window).on("load", function() {
         $('#subscriber-pop').modal('show');
    });
  });  

  // $(document).on("click","#getstarted-pop",function() {
  //    $(".close").click();
  // });

  $(document).ready(function(){
    $(".res-button").on("click", function(){
      $(".close").click();
      $("#getstarted-pop").click();
    });
  });


</script>
</footer>

