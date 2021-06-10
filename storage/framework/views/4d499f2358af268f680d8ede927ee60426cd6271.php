<?php /* ?>

<!--SLider sec start-->

<section class="slider-area">

  <div class="bg-overlay"></div>

  <div class="container position-relative">

    <div class="inner-bg-overlay"></div>

    <div class="row">

      <div class="slider-img col-12 col-lg-6 wow fadeInRight" data-wow-delay=".8s" data-depth="0.1">

        <?php

        foreach ($sliders as $key => $value) {

          ?>

          <div class="img-slide"> <img src="{{ url('public/uploads/slider/' . $value->slider_image) }}"> </div>

        <?php } ?>

      </div>

      <div class="slider-detail col-12 col-lg-6 text-center text-lg-left wow fadeInLeft" data-wow-delay=".8s">

        <?php

        foreach ($sliders as $key => $value) {

          ?>

          <div class="slider-slide">

            <div class="slider-inner-content sic-con-bnr">{!! $value->description !!}</div>

          </div>

        <?php } ?>

      </div>

    </div> 

  </div>

</section>

<!--SLider sec End-->

<?php */ ?>







        <?php //} ?>

        

        <!-- <div class="carousel-item active">

          <img src="https://www.w3schools.com/bootstrap4/la.jpg" alt="Los Angeles">

        </div>

        <div class="carousel-item">

          <img src="https://www.w3schools.com/bootstrap4/chicago.jpg" alt="Chicago">

        </div>

        <div class="carousel-item">

          <img src="https://www.w3schools.com/bootstrap4/ny.jpg" alt="New York">

        </div> -->

     <!--  </div>

    </div>



  </div>

</section> -->



<section>

  <div class="video-section">

   <div class="video-section-inner">

    <!-- <img src="public/uploads/testimonial/11-05-2021-06-37-53-2899.jpg">-->

    <?php if(!empty($top_video->video)): ?>

      <video  loop="" muted="" playsinline="" autoplay="">

      <source src="<?php echo e(url('public/uploads/banner/'.$top_video->video)); ?>" type="video/mp4">  

    </video>

    <?php else: ?>



    <video autoplay="" loop="" muted="" playsinline="">

      <source src="<?php echo e(url('public/uploads/banner/umami.mp4')); ?>" type="video/mp4">

        

        <!-- url('public/uploads/product/IMG_2400.mov') -->

        <!-- https://cdn.shopify.com/s/files/1/0484/7271/9526/files/Main_Page_Vid_full.mov?v=1618859384 -->

    </video>

    <?php endif; ?>

   </div><!--video-section-inner-->

   <div class="video-text">
    <div class="chef">CHEF-PREPARED JAPANESE MEALKIT PLATFORM</div>
    <div class="just">Just 5-10 minutes in your kitchen! FREE shipping 
    from Best Japanese Restaurants to 50 States!</div>
    <div class="how-button"><a href="#">How it works</a></div>
   </div><!--video-text-->

  </div><!--video-section-->

</section>

<?php /**PATH F:\xampp\htdocs\umami\resources\views/frontend/includes/new/slider.blade.php ENDPATH**/ ?>