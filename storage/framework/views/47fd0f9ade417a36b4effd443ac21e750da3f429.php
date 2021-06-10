<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php
$title = 'Umami Square';
$description = '';
$seg1 = Request::segment(1);
$seg2 = Request::segment(2);
$seg3 = Request::segment(3);
if($seg1 == '') {
  $title = 'Japanese Food Delivery Service | Umami Square';
  $description = 'Japanese One Stop Delivery platform in USA. Free Shipping from 40+ Japanese restaurants. Enjoy best chef- prepare meals across the country';
}
if($seg1 == 'pages') {
  if($seg2 == 'mission') {
    $title = 'Mission Umami Square | Meal Kit Delivery';
    $description = ' We help those hard-working chefs, cooks and owners who have dedicated their lives to serving up the finest dishes around.';
  }
  if($seg2 == 'about') {
    $title = 'About Umami Square | Food Delivery Service';
    $description = 'Umami Square is able to deliver the chef-prepared meal you’ll need to plate up authentic Japanese meals in your own home.';
  }
}
if($seg1 == 'contact-us') {
  $title = 'Contact Umami Square | Food Delivery Service';
  $description = 'You can order from the best Japanese restaurants, not only in New York but in other states as well.';
}
if($seg1 == 'restaurant') {
  $title = 'Restaurant List | Food Delivery Service';
  $description = 'Check restaurant list to order food online using food delivery service by Umami Square';
}
if($seg1 == 'products') {
  $title = 'Traditional Japanese Meal | Umami Square';
  $description = 'Order taditional Japanese meal online. Japanese One Stop Delivery platform in USA. Free Shipping from 40+ Japanese restaurants. ';
  $cat = $_GET['cat'] ?? '';
  if($cat == 2) {
    $title = 'Order Sweets Online | Food Delivery Service | Umami Square';
    $description = 'Order sweets online. Japanese One Stop Delivery platform in USA. Free Shipping from 40+ Japanese restaurants. ';
  }
}
if($seg1 == 'product-detail') {
  $title = $details->title;
  $description = $details->description;
}
if($seg1 == 'blog') {
  $title = 'Blog | Umami Square';
  $description = 'Check our blog for latest post on ordering food delivery online. Check latest tips on Japanese food delivery online.';
  if($seg2 == 'japanese-food-is-much-more-than-just-sushi') {
    $title = 'Japanese food is much more than just Sushi';
    $description = 'If Japanese food makes your taste buds dance with a perfect balance of salty, sweet, sour, and umami – you would love to try out the following dishes.';
  }
  if($seg2 == 'the-beauty-of-japanese-cuisine-lies-in-its-quality-and-simplicity') {
    $title = 'Japanese Cuisine | Umami Square';
    $description = 'Japanese food is much more than just Sushi. Authentic Japanese cuisine is an integral part of the Japanese culture as culinary practices reflect the overarching beliefs and practices integral to Japanese society. ';
  }
  if($seg2 == 'health-benefits-of-japanese-food') {
    $title = 'Health Benefits of Japanese Food | Umami Square';
    $description = 'We have listed some health benefits that will help you make the choice of shifting towards a diet that is known to have health benefits and longevity.';
  }
  if($seg2 == '5-best-traditional-japanese-foods') {
    $title = '5 Best Traditional Japanese Foods |Umami Square';
    $description = 'We bring you the 5 best and most commonly found traditional Japanese foods that you must need to try at your favorite Japanese restaurant.';
  }
  if($seg2 == 'the-increasing-interest-of-americans-in-japanese-food') {
    $title = 'Increasing Interest of Americans in Japanese Food';
    $description = 'Increasing popularity of Japanese food in America. Japanese restaurants in America indicate no signs of slowing down due to increasing demand in the local food market.';
  }
  if($seg2 == 'ramenology-101-a-complete-guide-to-the-perfect-ramen') {
    $title = 'Complete Guide To The Perfect Ramen | Authentic Ramen';
    $description = 'In short, authentic ramen is a decadent dish that involves hours of hard work and a whole host of ingredients. It is the ultimate comfort food, perfect for chilly winter evenings.';
  }
}
if($seg1 == 'event') {
  $title = 'Event | Umami Square';
  $description = 'Event - Super Side Festival In July, Sweets Festival In June, Gohan Festival In May.';
}
if($seg1 == 'event-detail') {
  if($seg2 == 'super-side-festival') {
    $title = 'Super Side Festival in July | Event | Umami Square';
    $description = 'Event Gallery - Super Side Festival in July ';
  }
  if($seg2 == 'sweets-festival-in-june') {
    $title = 'Sweets Festival in June | Event | Umami Square';
    $description = 'Event Gallery -Sweets Festival in June ';
  }
  if($seg2 == 'gohan-festival') {
    $title = 'Gohan Festival in May | Event | Umami Square';
    $description = 'Event Gallery - Gohan Festival in May';
  }
}
?>
<title><?php echo e($title); ?></title>
<meta name="keywords" content="">
<meta name="description" content="<?php echo e($description); ?>">
<?php if(Route::getCurrentRoute()->uri() == '/') { ?>
  <!-- <title>Japanese Food Delivery Service | Umami Square</title>
  <meta name="description" content="Japanese One Stop Delivery platform in USA. Free Shipping from 40+ Japanese restaurants. Enjoy best chef- prepare meals across the country "> -->
<?php } else { ?>
  <!-- <title><?php echo $__env->yieldContent('title', app_name()); ?></title>
  <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Laravel AdminPanel'); ?>"> -->
<?php } ?>
<meta name="author" content="<?php echo $__env->yieldContent('meta_author', 'Viral Solani'); ?>">
<!-- <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords', 'Laravel AdminPanel'); ?>"> -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo e(Storage::disk('public')->url('app/public/img/favicon/' . $setting->favicon)); ?>">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" media="all" rel="preload" as="style">
<!-- Global site tag (gtag.js) - Google Analytics --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-05VLZ8GC3X"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-05VLZ8GC3X'); </script>
<?php echo $__env->yieldContent('meta'); ?>
<?php echo $__env->yieldContent('before-styles'); ?>
<?php echo $__env->make('frontend.includes.modified_style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
  echo '<link rel="stylesheet" href="' . url('latest/css/iphone.css') . '">';
}
?>

<script src="<?php echo e(asset('latest/js/jquery-3.5.1.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('latest/js/bootstrap.min.js')); ?>"></script>

<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "service",
        "name": "Umami Square",
        "url": "https://umamisquare.com/"
    }
</script>

<!-- Global site tag (gtag.js) - Google Ads: 415093748 --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-415093748"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-415093748'); </script>

<!-- Event snippet for Purchase conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. --> <script> function gtag_report_conversion(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-415093748/zuo6CIzL2PgBEPSn98UB', 'transaction_id': '', 'event_callback': callback }); return false; } </script>

<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-415093748/a0awCLWrrvkBEPSn98UB',
      'value': 1.0,
      'currency': 'USD',
      'event_callback': callback
  });
  return false;
}
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5PGLTFC');</script>
<!-- End Google Tag Manager -->


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '646354352921307'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=646354352921307&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Hotjar Tracking Code for https://umamisquare.com/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2284325,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>

<script type="text/javascript">
var prop = <?php echo json_encode(array('url'=>url('/'), 'ajaxurl' => url('/ajaxpost'),  'csrf_token'=>csrf_token()));?>;
</script>


</head>

<body id="app-layout" class="eupopup eupopup-top side-navmenu">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5PGLTFC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="umami-loader " style="display: none;">
    <div class="loder">
        <div class="j">U</div>
        <div class="p">M</div>
        <div class="h">A</div>
        <div class="s">M</div>
        <div class="s">I</div>
    </div>
</div>

<div id="app"> 
  <?php echo $__env->make('includes.partials.logged-in-as', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('frontend.includes.new.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('frontend.includes.new.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->yieldContent('content'); ?>
  <?php echo $__env->make('frontend.includes.new.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php echo $__env->make('includes.partials.ga', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('frontend.includes.modified_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('after-script'); ?>


<div class="modal fade" id="messageModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Header</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		//$('.umami-loader').hide();
	});
</script>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages = document.querySelectorAll("img.lazy");    
  var lazyloadThrottleTimeout;
  
  function lazyload () {
    if(lazyloadThrottleTimeout) {
      clearTimeout(lazyloadThrottleTimeout);
    }    
    
    lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
    }, 20);
  }
  
  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);
});
</script>

<?php if($seg1 != '') { ?>
<!-- Start of j-fo Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=6dbfcd0e-212e-4784-8892-8394b7d16893"> </script>
<!-- End of j-fo Zendesk Widget script -->
<?php } ?>


</body>
</html><?php /**PATH F:\xampp\htdocs\umami\resources\views/frontend/layouts/layout.blade.php ENDPATH**/ ?>