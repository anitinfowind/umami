jQuery(function($) {

    "use strict";
    /* ===================================
           Header appear
        ====================================== */
    // if ($('.slider-area').length) {
    //     var slider_top = $(".slider-area").offset().top;

    //     $(window).on('scroll', function() {

    //         if ($(this).scrollTop() > 260) { // Set position from top to add class
    //             if ($('.slider-area').css({ "margin-top": slider_top })) {
    //                 $('.inner-header').addClass('header-appear');
    //             }
    //         } else {
    //             if ($('.slider-area').css({ "margin-top": "-40px" })) {
    //                 $('.inner-header').removeClass('header-appear');
    //             }
    //         }
    //     });
    // }
    // if ($('.slider-sec').length) {
    //     var slider_height = $(".slider-sec").offset().top;
    //     $(window).on('scroll', function() {

    //         if ($(this).scrollTop() > 260) { // Set position from top to add class
    //             if ($('.slider-sec').css({ "margin-top": slider_height })) {
    //                 $('.inner-header').addClass('header-appear');
    //             }
    //         } else {
    //             if ($('.slider-sec').css({ "margin-top": "-40px" })) {
    //                 $('.inner-header').removeClass('header-appear');
    //             }
    //         }
    //     });
    // }


    /* ===================================
                Mouse parallax
    ====================================== */

    // if ($(window).width() > 780) {
    //     $('.slider-area,.slider-sec,header').mousemove(function(e) {
    //         $('[data-depth]').each(function() {
    //             var depth = $(this).data('depth');
    //             var amountMovedX = (e.pageX * -depth / 4);
    //             var amountMovedY = (e.pageY * -depth / 4);

    //             $(this).css({
    //                 'transform': 'translate3d(' + amountMovedX + 'px,' + amountMovedY + 'px, 0)',
    //             });
    //         });
    //     });
    // }


    /* =====================================
             slick for slider
     ====================================== */
    $(document).ready(function() {
        $('.slider-detail').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            active: true,
            autoplay: true,
            // fade: true,
            asNavFor: '.slider-img'
        });
        $('.slider-img').slick({
            vertical: true,
            verticalSwiping: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '.slider-detail',
            dots: true,
            arrows: false,
            focusOnSelect: true,
            autoplay: true,
        });
        // $('.slider-arr-up').click(function() {
        //     $('.slider-img').slick('slickNext');
        // });
        // $('.slider-arr-down').click(function() {
        //     $('.slider-img').slick('slickPrev');
        // });

    });




    /* ===================================
                 Wow Effects
       ======================================*/
    var wow = new WOW({
        boxClass: 'wow', // default
        animateClass: 'animated', // default
        offset: 0, // default
        mobile: false, // default
        live: true // default
    });
    wow.init();






});