<div class="slider">
  <div id="demo" class="carousel slide" data-ride="carousel">
    <ul class="carousel-indicators">
      <li data-target="#demo" data-slide-to="0" class=" active "></li>
    </ul>
    <div class="carousel-inner">
      <div class="carousel-item  active ">
        <video width="100%" height="" preload="auto" muted="" loop="" controls="" autoplay="" playsinline="">
          <source src="http://design.wdptechnologies.com/umamisquare/public/uploads/slider/d6f8e976-a012-48fd-9d6c-687a31fd6d65.mp4" typ="">
          <source src="http://design.wdptechnologies.com/umamisquare/public/uploads/slider/d6f8e976-a012-48fd-9d6c-687a31fd6d65.mp4" type="video/mp4">
        </video>
        <div class="slider-text">
          <div class="slider-verticle-mid">
            <h2></h2>
            <h3></h3>
            <a href="http://design.wdptechnologies.com/umamisquare/public/products">
            <button class="btn slider-btn">See our menu</button>
            </a> </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--<div class="slider">
    @if($sliders->isNotEmpty())
        <div id="demo" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
                @foreach($sliders as $key => $slider)
                    <li data-target="#demo" data-slide-to="{{ $key }}" class="@if($key === ZERO) active @endif"></li>
                @endforeach
            </ul>
            <div class="carousel-inner">
                @foreach($sliders as $key =>$slider)
                 @php  $info = pathinfo(SLIDER_ROOT_PATH.$slider->slider_image);
                       $ext = $info['extension'];
                 @endphp
                 @if($ext=='mp4')
                    <div class="carousel-item @if($key === ZERO) active @endif">
                    @if(File::exists(SLIDER_ROOT_PATH.$slider->slider_image))
                       <video width="100%" height="" muted loop controls autoplay>
                        <source src="http://design.wdptechnologies.com/umamisquare/public/uploads/slider/d6f8e976-a012-48fd-9d6c-687a31fd6d65.mp4" type="video/mp4">
                        </video>
                      @else
                      <video width="100%" height="" muted loop controls autoplay>
                        <source src="http://design.wdptechnologies.com/umamisquare/public/uploads/slider/d6f8e976-a012-48fd-9d6c-687a31fd6d65.mp4" type="video/mp4">
                        </video>
                      @endif
                      <div class="slider-text">
                         <div class="slider-verticle-mid">
                            <h2>{{$slider->title}}</h2>
                            <h3>{!!$slider->description !!}</h3>
                           <a href="{{URL::to('products')}}"> <button class="btn slider-btn">See our menu</button></a>
                        </div>
                     </div>
                    </div>
                 @else
                    <div class="carousel-item @if($key === ZERO) active @endif">
                        @if ($slider->slider_image !=='' && File::exists(SLIDER_ROOT_PATH.$slider->slider_image))
                            <?php $sliderImage = SLIDER_URL . $slider->slider_image; ?>
                        @else
                            <?php $sliderImage = WEBSITE_IMG_URL . 'no-image.png'; ?>
                        @endif
                        <img src="{{ $sliderImage }}">
                         <div class="slider-text">
                            <div class="slider-verticle-mid">
                            <h2>{{$slider->title}}</h2>
                             <h3>{!!$slider->description !!}</h3>
                           <a href="{{URL::to('products')}}"> <button class="btn slider-btn">See our menu</button></a>
                        </div>
                        </div>
                    </div>
                  @endif
                  
                @endforeach
            </div>
           
        </div>
    @endif
</div>-->