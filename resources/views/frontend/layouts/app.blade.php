<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', app_name())</title>
<meta name="description" content="@yield('meta_description', 'Laravel AdminPanel')">
<meta name="author" content="@yield('meta_author', 'Viral Solani')">
<meta name="keywords" content="@yield('meta_keywords', 'Laravel AdminPanel')">
<link rel="shortcut icon" type="image/x-icon" href="{{ Storage::disk('public')->url('app/public/img/favicon/' . $setting->favicon) }}">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
@yield('meta')
        @yield('before-styles')
        @include('frontend.includes.style')

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
<script src="{{ asset('js/jquery.min.js') }}"></script>
<div id="overlay" class="loading-hold" style="display:none;">
  <div class="loader"></div>
</div>
<div id="app"> @include('includes.partials.logged-in-as')
  @include('frontend.includes.nav')
  @include('frontend.includes.header')
  <?php /*@include('includes.partials.messages') */ ?>
  @yield('content')
  @include('frontend.includes.footer') </div>
@include('includes.partials.ga')
        @include('frontend.includes.script')
        @yield('after-script')
</body>
</html>