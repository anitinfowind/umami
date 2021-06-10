<div class="header header-besktop" id="header-sticky">
    <nav class="navbar navbar-expand-md navbar-dark py-2 web-menu">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}"><img src='{{ WEBSITE_IMG_URL."logo.png" }}'></a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ url('products') }}">JAPANESE MEAL</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a class="dropdown-item" href="{{ url('products') }}">ALL( 全て)</a></li>
                            @if($categorys->isNotEmpty())
                            @foreach($categorys as $category)
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{url('products/?cat='.$category->id)}}">{{$category->name}}</a>
                            </li>
                             @endforeach
                             @endif
                        </ul>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('pages/about') }}">HOW IT WORKS</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('pages/mission') }}">ABOUT US</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('contact-us') }}">CONTACT</a> </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('restaurant') }}">Restaurant</a>
                    </li> -->
                    <!-- </li>
                       <li class="nav-item">
                        <a class="nav-link" href="{{ url('all-chefs') }}">Chef</a>
                    </li> -->
                   <!--  <li class="nav-item">
                        <a class="nav-link" href="{{ url('products') }}"> Product</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('event') }}">Event</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('catering') }}">Catering</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('contact-us') }}">Contact</a>
                    </li> -->
                </ul>
                  <div class="search-box">
                <form method="get" action="{{url('products')}}">
                      <input type="text" class="form-control" name="search" placeholder="Ramen Sushi Sweet">
                      <span><img src="{{ WEBSITE_IMG_URL.'search.png' }}"></span>
                </form>
                  </div>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-dark py-2 mobile-menu">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}"><img src='{{ WEBSITE_IMG_URL."logo.png" }}'></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('products') }}">JAPANESE MEAL</a>
                        <ul>
                            <li class="nav-item"><a class="nav-link" href="{{ url('products') }}">ALL( 全て)</a></li>
                            @if($categorys->isNotEmpty())
                            @foreach($categorys as $category)
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('products/?cat='.$category->id)}}">{{$category->name}}</a>
                            </li>
                             @endforeach
                             @endif
                        </ul>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('pages/about') }}">HOW IT WORKS</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('pages/mission') }}">ABOUT US</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('contact-us') }}">CONTACT</a> </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('products') }}">Mealkit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('restaurant') }}">Restaurant</a>
                    </li>
                    </li>
                       <li class="nav-item">
                        <a class="nav-link" href="{{ url('all-chefs') }}">Chef</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('event') }}">Events</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('catering') }}">Catering</a>
                    </li> -->
                   <!--  <li class="nav-item">
                        <a class="nav-link" href="#">New</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Noodle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Rice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sweets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Others</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('contact-us') }}">Contact</a>
                    </li> -->
                    @if($categorys->isNotEmpty())
                     @foreach($categorys as $category)
                      <!-- <li class="nav-item">
                        <a class="nav-link" href="{{url('products/?category='.$category->slug)}}">{{$category->name}}</a>
                      </li> -->

                     @endforeach
                     @endif
                </ul>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-dark bg-mega-menu">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mm-navbar" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mm-navbar">
              @if($categorys->isNotEmpty())
               @foreach($categorys as $category)
                <li class="nav-item">
                  <a class="nav-link" href="{{url('products/?cat='.$category->id)}}">{{$category->name}}</a>
                </li>

               @endforeach
               @endif
               <?php /** <li class="nav-item">
                 <!--   <a class="nav-link" href="{{url('new-shops')}}">New</a> -->
                   <a class="nav-link" href="#">New</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Noodle
                    </a>
                   <!--  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <span class="mm-heading">Category 2</span>
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <a href="">
                                        <img src="https://dummyimage.com/200x100/ccc/000&text=image+link" alt="" class="img-fluid">
                                    </a>
                                    <p class="">Short image call to action</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Rice
                    </a>
                    <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <span class="mm-heading">Top Gifts</span>
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Active</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Link item</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Sweets
                    </a>
                    <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-2">
                                    <span class="mm-heading">Categories</span>
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">cookies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">pies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ice creame</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Chocolates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pastries</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Cakes</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">cookies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Chocolates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pastries</a>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">cookies</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <span class="mm-heading">Categories</span>
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">cookies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">pies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ice creame</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Chocolates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pastries</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <span class="mm-heading">Categories</span>
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">cookies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">pies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ice creame</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Chocolates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pastries</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <span class="mm-heading">Categories</span>
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">cookies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">pies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ice creame</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Chocolates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pastries</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <span class="mm-heading">Categories</span>
                                    <ul class="nav flex-column mm-list">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">cookies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">pies</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">ice creame</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Chocolates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Pastries</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Others</a>
                </li>
                **/?>
                
                
             <!--    <li class="nav-item">
                    <a class="nav-link" href="#">Bread & Bagels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pizza</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Seafood</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sides</a>
                </li> -->
            </ul>
        </div>
    </nav>
</div>
