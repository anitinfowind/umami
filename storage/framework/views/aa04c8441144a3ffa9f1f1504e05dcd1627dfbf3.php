<!--<section class="counter-section counter-bg relative d-flex align-items-center" style="background: url(<?php echo e(asset('public/latest/images/counter-bg.jpg')); ?>);">
  <div class="container">
    <div class="count-down w-100">
      <div id="counter" class="justify-content-between d-flex align-items-center w-100">
        <?php
        $home_counter_1 = $site_settings['home_counter_1'] ?? '|';
        $home_counter_1 = explode('|', $home_counter_1);
        ?>
        <div class="counter-box"> <span class="home_counter_img"><img src="<?php echo e(asset('public/latest/images/home_counter_1.png')); ?>"></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_1[1]); ?>" data-count="<?php echo e($home_counter_1[1]); ?>"></div>
          <p><?php echo e($home_counter_1[0]); ?></p>
        </div>
        <?php
        $home_counter_2 = $site_settings['home_counter_2'] ?? '|';
        $home_counter_2 = explode('|', $home_counter_2);
        ?>
        <div class="counter-box"> <span><i class="flaticon-rating"></i></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_2[1]); ?>" data-count="<?php echo e($home_counter_2[1]); ?>"></div>
          <p><?php echo e($home_counter_2[0]); ?></p>
        </div>
        <?php
        $home_counter_3 = $site_settings['home_counter_3'] ?? '|';
        $home_counter_3 = explode('|', $home_counter_3);
        ?>
        <div class="counter-box"> <span><i class="flaticon-coffee-cup"></i></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_3[1]); ?>" data-count="<?php echo e($home_counter_3[1]); ?>"></div>
          <p><?php echo e($home_counter_3[0]); ?></p>
        </div>
        <?php
        $home_counter_4 = $site_settings['home_counter_4'] ?? '|';
        $home_counter_4 = explode('|', $home_counter_4);
        ?>
        <div class="counter-box"> <span><i class="flaticon-trophy"></i></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_4[1]); ?>" data-count="<?php echo e($home_counter_4[1]); ?>"></div>
          <p><?php echo e($home_counter_4[0]); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>-->

<section class="counter-section counter-bg relative d-flex align-items-center" style="background: url(<?php echo e(asset('public/latest/images/counter-bg.jpg')); ?>);">
  <div class="container">
    <div class="count-down w-100">
      <div id="counter" class="justify-content-between d-flex align-items-center w-100">
        <?php
        $home_counter_1 = $site_settings['home_counter_1'] ?? '|';
        $home_counter_1 = explode('|', $home_counter_1);
        ?>
        <div class="counter-box"> <span class="home_counter_img"><img src="<?php echo e(asset('public/latest/images/home_counter_1.png')); ?>"></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_1[1]); ?>" data-count="<?php echo e($home_counter_1[1]); ?>"></div>
          <p><?php echo e($home_counter_1[0]); ?></p>
        </div>
        <?php
        $home_counter_2 = $site_settings['home_counter_2'] ?? '|';
        $home_counter_2 = explode('|', $home_counter_2);
        ?>
        <div class="counter-box"> <span class="home_counter_img"><img src="<?php echo e(asset('public/latest/images/home_counter_2.png')); ?>"></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_2[1]); ?>" data-count="<?php echo e($home_counter_2[1]); ?>"></div>
          <p><?php echo e($home_counter_2[0]); ?></p>
        </div>
        <?php
        $home_counter_3 = $site_settings['home_counter_3'] ?? '|';
        $home_counter_3 = explode('|', $home_counter_3);
        ?>
        <div class="counter-box"> <span class="home_counter_img"><img src="<?php echo e(asset('public/latest/images/home_counter_3.png')); ?>"></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_3[1]); ?>" data-count="<?php echo e($home_counter_3[1]); ?>"></div>
          <p><?php echo e($home_counter_3[0]); ?></p>
        </div>
        <?php
        $home_counter_4 = $site_settings['home_counter_4'] ?? '|';
        $home_counter_4 = explode('|', $home_counter_4);
        ?>
        <div class="counter-box"> <span class="home_counter_img"><img src="<?php echo e(asset('public/latest/images/home_counter_4.png')); ?>"></span>
          <div class="counter-value" data-to="<?php echo e($home_counter_4[1]); ?>" data-count="<?php echo e($home_counter_4[1]); ?>"></div>
          <p><?php echo e($home_counter_4[0]); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php /**PATH F:\xampp\htdocs\umami\resources\views/frontend/includes/new/home_counter.blade.php ENDPATH**/ ?>