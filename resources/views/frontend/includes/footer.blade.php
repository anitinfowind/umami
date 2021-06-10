<footer>
  <div class="footer">
    <div class="container-fluid">
      <div class="footer footer-collapse">
        <div class="accordion" id="accordionExample">
          <div class="card serv-link">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Categories </button>
              </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
                <ul>
                  @foreach($categorys as $category)
                  <li><a href="{{url('products/?category='.$category->slug)}}">{{$category->name}}</a> </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <div class="card serv-link">
            <div class="card-header" id="headingTwo">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Support </button>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
              <div class="card-body">
                <ul>
                  <li><a href="">Become a Partner restaurant</a> </li>
                  <li><a href="{{ url('blog') }}">Blog</a></li>
                  <li><a href="{{ url('/') }}">Invite a Friend</a></li>
                  <li><a href="{{ url('learn-about-rewards') }}">Rewards Points</a></li>
                  <li><a href="{{ url('faq') }}">Help & Support</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card serv-link">
            <div class="card-header" id="headingThree">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Policies </button>
              </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
              <div class="card-body">
                <ul>
                  <li><a href="{{url('pages/cookies-policy')}}">Cookies Policy</a></li>
                  <li><a href="{{url('pages/refund-policy')}}">Refund Policy</a></li>
                  <li><a href="{{url('pages/privacy-policy')}}">Privacy Policy</a></li>
                  <li><a href="{{url('pages/terms-of-use')}}">Terms Of Use</a></li>
                  <li><a href="{{url('pages/shipping-policy')}}">Shipping Policy</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card serv-link">
            <div class="card-header" id="headingFour">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> About </button>
              </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
              <div class="card-body">
                <ul>
                  <li><a href="{{url('pages/mission')}}">Mission</a></li>
                  <li><a href="{{url('pages/company')}}">Company</a></li>
                  <li><a href="{{url('contact-us')}}">Contact</a></li>
                  <li><a href="{{url('pages/press-and-news')}}">Press & News</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="newsletter-section">
        <div class="row">
          <div class="col-sm-8">
            <div class="newsletter-left">
              <h4>Sign up for our newsletter</h4>
              <div class="input-box">
                <input type="email" id="newsletter_email" class="form-control" placeholder="Enter your email...">
                <span class="newsletter_email error-msg" style="color:red"></span>
                <button class="btn subscribe-btn" onclick="subscribe()">Subscribe</button>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="social-footer">
              <ul>
                <li> <a target="_blank" href="{{ isset($setting->facebook) ? $setting->facebook :'javascript:void(0)' }}"> <i class="fa fa-facebook"></i> </a> </li>
                <li> <a target="_blank" href="{{ isset($setting->twitter) ? $setting->twitter : 'javascript:void(0)' }}"> <i class="fa fa-twitter"></i> </a> </li>
                <li> <a target="_blank" href="{{ isset($setting->instagram) ? $setting->instagram : 'javascript:void(0)' }}"> <i class="fa fa-instagram"></i> </a> </li>
                <li> <a  target="_blank"href="{{ isset($setting->google) ? $setting->google : 'javascript:void(0)' }}"> <i class="fa fa-google-plus"></i> </a> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-web-menu">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-sm-4">
                <div class="footer-title">
                  <h4>Categories</h4>
                  <ul>
                    @foreach($categorys as $category) 
                    <!-- <li><a href="{{ url('faq') }}">FAQ</a></li>
                            <li><a href="{{ url('about') }}">About</a></li> -->
                    <li><a href="{{url('products/?category='.$category->slug)}}">{{$category->name}}</a> </li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="footer-title">
                  <h4>Support</h4>
                  <ul>
                    <li><a href="">Become a Partner restaurant</a> </li>
                    <li><a href="{{ url('blog') }}">Blog</a></li>
                    <li><a href="{{ url('/') }}">Invite a Friend</a></li>
                    <!-- <li><a href="{{ url('videos') }}">Videos</a></li> --> 
                    <!--<li><a href="{{ url('learn-about-rewards') }}">Rewards Points</a></li>-->
                    <li><a href="{{ url('faq') }}">Help & Support</a></li>
                    <!-- <li><a href="{{ url('page/tree-donate') }}">Trees</a></li> -->
                    <li><a href="{{url('pages/terms-of-use')}}">Terms Of Use</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="footer-title">
                  <h4>About</h4>
                  <ul>
                    <li><a href="{{url('pages/mission')}}">Mission</a></li>
                    <li><a href="{{url('pages/company')}}">Company</a></li>
                    <li><a href="{{url('contact-us')}}">Contact</a></li>
                    <li><a href="{{url('pages/press-and-news')}}">Press & News</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3"> 
            <!--<div class="footer-app">
                 <h4>Umami square App</h4>
                 <p> Coming Soon</p>
                
                 <ul>
                   <li><a href="#"><img src='{{ WEBSITE_IMG_URL."google-play.png" }}'></a></li>
                   <li><a href="#"><img src='{{ WEBSITE_IMG_URL."app-store.png" }}'></a></li>
                 </ul>
                 <div class="footer-mobile-app">
                    <img src='{{ WEBSITE_IMG_URL."app-mobile.png" }}'>
                 </div>
              </div>--> 
          </div>
        </div>
      </div>
      <div class="copyright">
        <p> {{ isset($setting->copyright_text) ? $setting->copyright_text : 'Copyright@ 2020 Umami Square . All Rights Reserved.' }} </p>
        <div class="footer-title">
          <!-- <ul>
            <li><a href="{{url('pages/cookies-policy')}}">Cookies Policy</a></li>
            <li><a href="{{url('pages/refund-policy')}}">Refund Policy</a></li>
            <li><a href="{{url('pages/privacy-policy')}}">Privacy Policy</a></li>
            <li><a href="{{url('pages/terms-of-use')}}">Terms Of Use</a></li>
            <li><a href="{{url('pages/shipping-policy')}}">Shipping Policy</a></li>
          </ul> -->
        </div>
      </div>
    </div>
  </div>
</footer>
