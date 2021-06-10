$(function() {

    /*-------------------------------------ScrollTop-------------------------*/
    // var ico = $('<span></span>');
    // $('li.sub_menu_open').append(ico);

    $("#menu_res").click(function() {
        $("#res_nav").toggleClass('left0');
    });

    $('li span').on("click", function(e) {
        if ($(this).hasClass('open')) {

            $(this).prev('ul').slideUp(300, function() {});

        } else {
            $(this).prev('ul').slideDown(300, function() {});
        }
        $(this).toggleClass("open");
    });
    $('#menu_res').click(function() {
        $(this).toggleClass('menu_responsiveTo')
    });

    $(".top-mobile-menu").click(function() {
        $(".top-header").toggleClass('top-header-show');
    });
    $(document).ready(function(){
        $("#menu_res").click(function(){
          $(".top-header").removeClass("top-header-show");
        });
      });

    /*-------------------------------------ScrollTop-------------------------*/
    /*$(window).scroll(function() {
    	if ($(this).scrollTop() > 200) {
    		$('.menu-sec').addClass("sticky");
    	} else {
    		$('.menu-sec').removeClass("sticky");
    	}
    });*/


    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $('.scrollup').fadeIn();
            $('.arrow-show').fadeIn();
        } else {
            $('.scrollup').fadeOut();
            $('.arrow-show').fadeOut();
        }
    });
    $('.scrollup').click(function(e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 300);
        return false;
    });



    /*-------------------------------------HOME_SLIDER-----------------------------------*/
    $(".homeslider").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        animateOut: 'fadeOut',
        margin: 1,
        dots: false,
        nav: false,

    });

    /*-------------------------------------boSlider-----------------------------------*/
    $(".boSlider").owlCarousel({
        items: 4,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        margin: 15,
        dots: false,
        nav: true,
        navElement: 'div',
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: { items: 1 },
            480: { items: 2 },
            600: { items: 2 },
            768: { items: 3 },
            992: { items: 4 }
        },
    });

    /*-------------------------------------newsSlider-----------------------------------*/
    $(".newsSlider").owlCarousel({
        items: 3,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        margin: 15,
        dots: false,
        nav: true,
        navElement: 'div',
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: { items: 1 },
            480: { items: 2 },
            600: { items: 2 },
            768: { items: 3 },
            992: { items: 3 }
        },
    });

    /*-------------------------------------Testimonial-----------------------------------*/
    $(".testimonial").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        margin: 1,
        dots: true,
        nav: false,
        responsive: {
            0: { items: 1 },
            480: { items: 1 },
            600: { items: 1 },
            768: { items: 1 },
            992: { items: 1 },
            1600: { items: 1 }
        },
    });

    /*-------------------------------------FEATURE-PRODUCT-----------------------------------*/
    $(".feature").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        margin: 1,
        dots: true,
        nav: false,
        navElement: 'div',
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: { items: 1 },
            480: { items: 1 },
            600: { items: 1 },
            768: { items: 1 },
            992: { items: 1 },
            1600: { items: 1 }
        },
    });
    /*-------------------------------------BLOG LIST-----------------------------------*/
    $(".blog-list").owlCarousel({
        items: 3,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        nav: true,
        navElement: 'div',
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: { items: 1 },
            480: { items: 1 },
            600: { items: 2 },
            768: { items: 2 },
            992: { items: 3 },
            1600: { items: 3 }
        },
    });
    /*-------------------------------------RATED-PRODUCT-----------------------------------*/
    $(".reated-product-box-main").owlCarousel({
        items: 1,
        loop: false,
        autoplay: false,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        //animateOut: 'slideOutUp',
        //animateIn: 'slideInUp',
        margin: 1,
        dots: false,
        nav: true,
        navElement: 'div',
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: { items: 1 },
            480: { items: 1 },
            600: { items: 1 },
            768: { items: 1 },
            992: { items: 1 },
            1600: { items: 1 }
        },
    });

    /*-------------------------------------RATED-PRODUCT DETAILS PAGE-----------------------------------*/
    $(".related-list").owlCarousel({
        items: 4,
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        nav: true,
        navElement: 'div',
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: { items: 1 },
            480: { items: 2 },
            600: { items: 2 },
            768: { items: 4 },
            992: { items: 4 },
            1600: { items: 4 }
        },
    });


});


$(document).ready(function(){

    /*$('.product_item .food-box .food-pic, .product_items .food-box .food-pic').on( "mouseenter", function(){
        if($(this).find('video').length)
            $(this).find('video')[0].play();
    });
    $('.product_item .food-box .food-pic, .product_items .food-box .food-pic').on( "mouseleave", function(){
        if($(this).find('video').length)
            $(this).find('video')[0].pause();
    });*/

    $(document).on('mouseenter', '.product_item .food-box .food-pic, .product_items .food-box .food-pic', function(){
        if($(this).find('video').length)
            $(this).find('video')[0].play();
    });

    $(document).on('mouseleave', '.product_item .food-box .food-pic, .product_items .food-box .food-pic', function(){
        if($(this).find('video').length) {
            $(this).find('video')[0].load();
            //$(this).find('video')[0].pause();
            //$(this).find('video')[0].currentTime = 0;
        }
    });

});