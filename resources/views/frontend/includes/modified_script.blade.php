<script src="{{ asset('latest/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('latest/js/owl.carousel2.thumbs.js') }}"></script>
<script defer src="{{ asset('latest/js/custom.js?t=' . time()) }}"></script>
<script src="{{ asset('latest/js/date-picker-js.js') }}"></script>
<script src="{{ asset('latest/js/paralax.js') }}"></script>
<script src="{{ asset('latest/js/slick.js') }}"></script>
<script src="{{ asset('latest/js/slick.min.js') }}"></script>
<script src="{{ asset('latest/js/script.js') }}"></script>
<script src="{{ asset('latest/js/wow.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('js/pnotify.core.js') }}"></script>
<script src="{{ asset('js/bootbox.js') }}"></script>
<script src="{{ asset('js/freshslider.1.0.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('latest/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('js/jquery.oauthpopup.js') }}"></script>
<script src="{{ asset('js/jquery-eu-cookie-law-popup.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI&libraries=places,drawing,geometry&language=en&callback=initialize"></script>

<script src="{{ asset('latest/js/sudipta.js?t=' . time()) }}"></script>

<script>
new WOW().init();
</script>
<script>
$(window).scroll(function() {
	if ($(this).scrollTop() > $('header').height()) {
		$('.btm-header').addClass("sticky");
	} else {
		$('.btm-header').removeClass("sticky");
	}
});
</script> 
<script>
$(document).ready(function() {
	$('.dropdown-user').on('click', function(e) {
	   $('.dropdown-open').toggleClass('open');
	   //alert("Hello! I am an alert box!");
	});            
});
</script>
<script>
$(document).ready(function(){
$('.browse-cuisine-slider').owlCarousel({
autoplay:false,
stagePadding:15,
autoplayTimeout:5000,
loop:true,
margin:15,
nav:true,
dots:false,
responsive:{
	0:{
		items:3
	},
	600:{
		items:6
	},
	1000:{
		items:7
	}
}
});
});
</script>
<script>
var a = 0;
$(window).scroll(function() {

var oTop = $('#counter').offset().top - window.innerHeight;
if (a == 0 && $(window).scrollTop() > oTop) {
$('.counter-value').each(function() {
var $this = $(this),
countTo = $this.attr('data-count');
$({
countNum: $this.text()
}).animate({
  countNum: countTo
},

{

  duration: 2000,
  easing: 'swing',
  step: function() {
	$this.text(Math.floor(this.countNum));
  },
  complete: function() {
	$this.text(this.countNum);
	//alert('finished');
  }

});
});
a = 1;
}

});
</script>
<script>

  $(document).ready(function() {
    initialize();
      @if(session()->has('account-verification'))
        <?php
        $session = session()->get('account-verification');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('account-verification') }}
      @endif

      @if(session()->has('send-verification-link'))
        <?php
        $session = session()->get('send-verification-link');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('send-verification-link') }}
      @endif

      @if(session()->has('reset-password'))
        <?php
        $session = session()->get('reset-password');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('reset-password') }}
      @endif

      @if(session()->has('errors'))
        <?php
        $session = session()->get('errors');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'error');

        {{ session()->forget('errors') }}
      @endif

      @if(session()->has('update-profile'))
        <?php
        $session = session()->get('update-profile');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('update-profile') }}
      @endif

      @if(session()->has('address'))
        <?php
        $session = session()->get('address');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('address') }}
      @endif

      @if(session()->has('restaurant'))
        <?php
        $session = session()->get('restaurant');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('restaurant') }}
      @endif

      @if(session()->has('product'))
        <?php
        $session = session()->get('product');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('product') }}
      @endif

      @if(session()->has('product_update'))
        <?php
        $session = session()->get('product_update');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('product_update') }}
      @endif

      @if(session()->has('branch'))
        <?php
        $session = session()->get('branch');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('branch') }}
      @endif

      @if(session()->has('chefs'))
        <?php
        $session = session()->get('chefs');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('chefs') }}
      @endif

      @if(session()->has('chefs-update'))
        <?php
        $session = session()->get('chefs-update');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('chefs-update') }}
      @endif
      @if(session()->has('chefs-delete'))
        <?php
        $session = session()->get('chefs-delete');
        $title = $session['title'];
        $msg = $session['msg'];
        ?>
        notice("{{ $title }}", "{{ $msg }}", 'success');

        {{ session()->forget('chefs-delete') }}
      @endif

     @if(session()->has('coupon'))
      <?php
      $session = session()->get('coupon');
      $title = $session['title'];
      $msg = $session['msg'];
      ?>
      notice("{{ $title }}", "{{ $msg }}", 'success');

      {{ session()->forget('coupon') }}
    @endif
	
	@if(session()->has('order'))
      <?php
      $session = session()->get('order');
      $title = $session['title'];
      $msg = $session['msg'];
      ?>
      notice("{{ $title }}", "{{ $msg }}", 'success');

      {{ session()->forget('order') }}
    @endif

    @if(session()->has('rating'))
      <?php
      $session = session()->get('rating');
      $title = $session['title'];
      $msg = $session['msg'];
      ?>
      notice("{{ $title }}", "{{ $msg }}", 'success');

      {{ session()->forget('rating') }}
    @endif



  $('.emailcheck').click(function() {
     bootbox.confirm("Are you sure? You want to this status change",
          function(result) {
            if(result){
               var status= $('.email-notifi').val();
              $.ajax({
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('email-status') }}",
                data: {'status' : status},
                method: 'POST',
                beforeSend: function () {
                  $("#overlay").show();
                },
                success: function(data) {
                  $("#overlay").hide();
                  if (data.success == true) {
                    notice('Email','Your email status successfully changed.','success');
                  }
                }
              });
          }
        }
      );
    });

         $('.facebook').click(function(e){
            jQuery.oauthpopup({
                path: "{!! URL::to('login/facebook')!!}",
                width:900,
                height:500,
                callback: function(){
                    window.location.href= "{!! URL::to('dashboard')!!}";
                }
            });
            e.preventDefault();
        });
        $('.google').click(function(e){
            jQuery.oauthpopup({
                path: "{!! URL::to('login/google')!!}",
                width:900,
                height:500,
                callback: function(){
                    window.location.href= "{!! URL::to('dashboard')!!}";
                }
            });
            e.preventDefault();
        });


        $(".start_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: new Date(),
        onSelect: function (date) {
            var dt1 = $('.start_date').datepicker('getDate');
            $('.end_date').datepicker('option', 'minDate', dt1);
        }
    });

    $(".end_date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: new Date(),
        onSelect: function (date) {
          var dt2 = $('.end_date').datepicker('getDate');
          $('.start_date').datepicker('option', 'maxDate', dt2);
        },
    });
  });

  window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
  ]); ?>

  $('#country').change(function(){
    var countryId	=	$('#country').val();
    if (countryId !== '') {
      city();
      $.ajax({
        method: "GET",
        url: "{{ url('state') }}",
        data: {'country_id': countryId},
        success: function (data) {
          $('.state').html(data);
        },
        complete: function () {
          $('#state').change(function () {
            var stateId = $('#state').val();
            $.ajax({
              method: "GET",
              url: "{{ url('city') }}",
              data: {'state_id': stateId},
              success: function (data) {
                $('.city').html(data);
              },
            });
          });
        },
      });
    } else {
      state();
      city();
    }
  });

  $('#state').change(function(){
    var stateId	=	$('#state').val();
    if (stateId !== '') {
      $.ajax({
        method: "GET",
        url: "{{ url('city') }}",
        data: {'state_id': stateId},
        success: function (data) {
          $('.city').html(data);
        },
      });
    } else {
      city();
    }
  });





    $('#rescountry').change(function(){
    var countryId = $('#rescountry').val();
    if (countryId !== '') {
      city();
      $.ajax({
        method: "GET",
        url: "{{ url('restaurant/restaurant-state') }}",
        data: {'country_id': countryId},
        success: function (data) {
          $('.state').html(data);
        },
        complete: function () {
          $('#resstate').change(function () {
            var stateId = $('#resstate').val();
            $.ajax({
              method: "GET",
              url: "{{ url('restaurant/restaurant-city') }}",
              data: {'state_id': stateId},
              success: function (data) {
                $('.city').html(data);
              },
            });
          });
        },
      });
    } else {
      state();
      city();
    }
  });

  $('#resstate').change(function(){
    var stateId = $('#resstate').val();
    if (stateId !== '') {
      $.ajax({
        method: "GET",
        url: "{{ url('restaurant/restaurant-city') }}",
        data: {'state_id': stateId},
        success: function (data) {
          $('.city').html(data);
        },
      });
    } else {
      city();
    }
  });


  $('.discounttype').on('change', function() {
    var id= $(this).val();
    if (id == 'PERCENTAGE') {
       $('.discountperc').removeClass('novalidate');
       $('.discountshow').show();
   } else {
       $('.discountperc').addClass('novalidate');
       $('.discountshow').hide();
   } 
 });


  $('.company_product').on('change',  function() {
   var value= $(this).val();
   $.ajax({
    url : "{{ url()->current() }}",
    method : 'get',
    data : { 'sort' : value},
    success:function(data) {
      $('.loaddata').html('');
      $('.loaddata').append(data);

    }
  });

 });

  $(".search").click(function() {
      var editor =$("input[name=editor_pick]").is(":checked") ? "editor_pick" : "";
      var shipping =$("input[name=free_shipping]").is(":checked") ? "free_shipping" : "";
       var sortby= $('select[name=sort_by]').val();
       var condition = [];
          $.each($("input[name='category']:checked"), function(){
            condition.push($(this).val()||0);
            });
       var category =condition;
        var diet = [];
          $.each($("input[name='diet']:checked"), function(){
            diet.push($(this).val()||0);
            });
       var diet =diet;
      var status =1;
      $.ajax({
          url : "{{ url('products') }}",
          method : 'get',
          data : {'editor' : editor,'shipping':shipping,'status':status,'sort_by':sortby,'category':category,'diet':diet},
          success:function(data) {
            $('.loaddata').html('');
            $('.loaddata').html(data);
          }
      });
  });


    $(".searchby").on('change',function() {
      var editor =$("input[name=editor_pick]").is(":checked") ? "editor_pick" : "";
      var shipping =$("input[name=free_shipping]").is(":checked") ? "free_shipping" : "";
       var sortby= $('select[name=sort_by]').val();
       var condition = [];
          $.each($("input[name='category']:checked"), function(){
            condition.push($(this).val()||0);
            });
       var category =condition;
        var diet = [];
          $.each($("input[name='diet']:checked"), function(){
            diet.push($(this).val()||0);
            });
       var diet =diet;
      var status =1;
      $.ajax({
          url : "{{ url('products') }}",
          method : 'get',
          data : {'editor' : editor,'shipping':shipping,'status':status,'sort_by':sortby,'category':category,'diet':diet},
          success:function(data) {
            $('.loaddata').html('');
            $('.loaddata').html(data);
          }
      });
  });

  $('.show-record').on('change', function() {
   var page= $(this).val();
   var url= '{{Request::url()}}';
   window.location.href=''+url+'?PAGINATION='+page+'';
 });

  function city()
  {
    $('.city').html('<select class="form-control" name="city_id"><option value="">Select City</option></select>');
  }

  function state()
  {
    $('.state').html('<select class="form-control" name="state_id"><option value="">Select State</option></select>');
  }

  function subscribe()
  {
    var email= $('#newsletter_email').val();
    if (email === '') {
      $('.newsletter_email').html('Please enter email address');
      return;
    } else if (!IsEmail(email)) {
      $('.newsletter_email').html('Please enter valid email address');
      return;
    } else {
      $('.newsletter_email').html('');
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url : "{{ url('newsletter') }}",
        method : 'post',
        data : { 'email' : email},
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $("#overlay").hide();
          if (data.success == true) {
            $('#newsletter_email').val('');
            notice(
              'Newsletter',
              'You are successfully registered as subscriber.',
              'success'
              );
          } else {
            notice(
              'Newsletter',
              'The email has already been taken.',
              'error'
              );
          }
        }
      });
    }
  }

    /**
     *
     * @param addressId
     */
     function removeAddress(addressId)
     {
      bootbox.confirm("Are you sure? You want to delete this element",
        function(result) {
          if (result) {
            $.ajax({
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              url: "{{ url('remove-address') }}",
              type: 'post',
              data: { 'address_id' : addressId },
              beforeSend: function() {
                $("#overlay").show();
              },
              success:function(data) {
                $('#address_'+addressId).hide();
                $("#overlay").hide();
              }
            });
          }
        }
        );
    }

    /**
     * @param addressId
     */
     function primaryAddress(addressId)
     {
      if ($('#html_'+addressId).is(":checked")) {
        $('#html_'+addressId).prop('checked',false);
        var check = false;
        var confirmMessage = "Are you sure? You want to be set this primary address";
      } else {
        $('#html_'+addressId).prop('checked',true);
        var check = true;
        var confirmMessage = "Are you sure? You want to be remove this primary address";
      }

      var status = $('#status_'+addressId).val();

      bootbox.confirm(confirmMessage,
        function(result) {
          if(result) {
            $.ajax({
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              url: "{{ url('primary-address') }}",
              type: 'post',
              data: { 'address_id' : addressId, 'status' : status },
              beforeSend: function() {
                $("#overlay").show();
              },
              success:function(data) {
                $("#overlay").hide();
                $('.all').prop('checked', false);
                $('.status').val('ACTIVE');
                if (check) {
                  $('#html_' + addressId).prop('checked', false);
                } else {
                  $('#html_' + addressId).prop('checked', true);
                  $('#status_' + addressId).val('INACTIVE');
                }
              }
            });
          }
        }
        );
    }

    /**
     * @param blogId
     */
     function comment(blogId)
     {
      var comment = $('#comment').val();
      if (comment === '') {
        $('#comment').addClass('border-red');
        return;
      } else {
        $('#comment').removeClass('border-red');
        $.ajax({
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          url: "{{ url('comment') }}",
          method: 'post',
          data: { 'blog_id' : blogId, 'comment' : comment },
          beforeSend: function() {
            $("#overlay").show();
          },
          success:function(data) {
            $("#overlay").hide();
            $('.comment_element').html(data.comment);
            $('#comment').val('');
          }
        });
      }
    }

    /**
     * @param commentId
     */
     function removeComment(commentId)
     {
      bootbox.confirm("Are you sure? You want to delete this comment",
        function(result) {
          if(result) {
            $.ajax({
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              url: "{{ url('remove-comment') }}",
              type: 'post',
              data: { 'comment_id' : commentId },
              beforeSend: function() {
                $("#overlay").show();
              },
              success:function(data) {
                $('#element_'+commentId).hide();
                $("#overlay").hide();
              }
            });
          }
        }
        );
    }

    /**
     * @param imageId
     */
     function removeImage(imageId)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('restaurant/remove-image') }}",
        type: 'post',
        data: { 'image_id' : imageId },
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $('#image_'+imageId).hide();
          $("#overlay").hide();
           location.reload();
        }
      });
    }
    

     function backgroundImage(imageId)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('restaurant/remove-backgroundimage') }}",
        type: 'post',
        data: { 'image_id' : imageId },
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $('#image_'+imageId).hide();
          $("#overlay").hide();
         location.reload();
        }
      });
    }

    /**
     * @param imageId
     */
     function productRemoveImage(imageId)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('product/remove-image') }}",
        type: 'post',
        data: { 'image_id' : imageId },
        beforeSend: function() {
          $("#overlay").show();
        },
        success:function(data) {
          $('#image_'+imageId).hide();
          $("#overlay").hide();
          location.reload();
        }
      });
    }

    /**
     * @param productId
     * @param action
     */
     function favourite(productId, action)
     {
      $.ajax({
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        url: "{{ url('favourite') }}",
        data: {'product_id':productId},
        method: 'POST',
		beforeSend: function () {
			$("#overlay").show();
		},
        success: function(data){
          $("#overlay").hide();
          if (data.success == 1) {
            if(action == 'favourite') {
              $('#fav_'+productId).removeClass('fa-heart-o');
              $('#fav_'+productId).addClass('fa-heart');
              $('._tab_'+productId).removeClass('fa-heart-o');
              $('.food_tab_'+productId).addClass('fa-heart');
              $('.fav_'+productId).attr( "onClick", "favourite('"+productId+"','unfavourite')" );
            } else {
              $('#fav_'+productId).removeClass('fa-heart');
              $('#fav_'+productId).addClass('fa-heart-o');
              $('.food_tab_'+productId).removeClass('fa-heart');
              $('.food_tab_'+productId).addClass('fa-heart-o');
              $('.fav_'+productId).attr( "onClick", "favourite('"+productId+"','favourite')" );
            }
          }
        }
      });
    }

    /**
     * @param favoriteId
     */
     function removeFavorite(favoriteId)
     {
      bootbox.confirm("Are you sure? You want to delete this favorite",
        function(result) {
          if(result) {
            $.ajax({
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              url: "{{ url('remove-favorite') }}",
              data: {'favorite_id':favoriteId},
              method: 'POST',
			  beforeSend: function () {
					$("#overlay").show();
				},
              success: function(data) {
				  $("#overlay").hide();
                if (data.success == true) {
                  $('.favorite_'+favoriteId).remove();
                }
              }
            });
          }
        }
        );
    }

    /**
     * @param productId
     */
     function removeProduct(productId)
     {
       bootbox.confirm("Are you sure? You want to delete this product",
         function(result) {
           if(result){
             $.ajax({
               headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
               url: "{{ url('delete-product') }}",
               data: {'product_id':productId},
               method: 'POST',
			   beforeSend: function () {
					$("#overlay").show();
				},
               success: function(data) {
				   $("#overlay").hide();
                 if (data.success == true) {
                   $('.product_'+productId).remove();
                   notice('Product','Product has been successfully deleted.','success');
                 }
               }
             });
           }
         }
         );
     }
         /**
     * @param CouponId
     */
     function removeCoupon(couponId)
     {
       bootbox.confirm("Are you sure? You want to delete this coupon",
         function(result) {
           if(result){
             $.ajax({
               headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
               url: "{{ url('delete-coupon') }}",
               data: {'coupon_id':couponId},
               method: 'POST',
			   beforeSend: function () {
					$("#overlay").show();
				},
               success: function(data) {
				   $("#overlay").hide();
                 if (data.success == true) {
                   $('.coupon_'+couponId).remove();
                   notice('Coupon','Coupon has been successfully deleted.','success');
                 }
               }
             });
           }
         }
         );
     }

    /**
     * @param branchtId
     */
     function removeBranch(userId)
     {
      bootbox.confirm("Are you sure? You want to delete this branch",
        function(result) {
          if(result){
            $.ajax({
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              url: "{{ url('branch/delete-branch') }}",
              data: {'user_id' : userId},
              method: 'POST',
			  beforeSend: function () {
				$("#overlay").show();
			},
              success: function(data) {
				  $("#overlay").hide();
                if (data.success == true) {
                  $('.branch_'+userId).remove();
                  notice('Branch','Branch has been successfully deleted.','success');

                  if (data.lastRecord) {
                    $('.record').html('<tr><td colspan="8"><h6 class="text-center">No Record Found</h6></td></tr>');
                  }
                }
              }
            });
          }
        }
        );
    }

    /**
    * @param Add to Cart
    * @param action
    */
    function addToCart(slug)
	{
    alert(slug);
		$.ajax({
			headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
			url: "{{ url('cart-store') }}",
			data: {'slug' : slug},
			method: 'POST',
			beforeSend: function () {
				$("#overlay").show();
			},
			success: function(data){
        console.log(data);
        alert('hello');
				$("#overlay").hide();
				if (data.success == true) {
					window.location.href='{{ url("cart") }}';
				}
			}
		});
    }

    /**
    * @param productId
    */
    function removeCart(cartId,orderId)
    {
		bootbox.confirm("Are you sure? you want to be delete this item",
			function(result) {
				if(result){
					$.ajax({
						headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
						url: "{{ url('delete-cart-product') }}",
						data: {'cart_id': cartId,'order_id':orderId},
						method: 'POST',
						beforeSend: function () {
							$("#overlay").show();
						},
						success: function(data) {
							$("#overlay").hide();
							if (data.success == true) {
								$('.web-tbody').html(data.cartList);
								$('.pay_ele').html(data.paymentList);
								$('.cart_count').html(data.count);
								if (data.lastRecord) {
									$('.record').html('<img src="{{ WEBSITE_IMG_URL.'cart.jpg' }}">');
								}
								notice('Product','Product has been successfully deleted.','success');
							}
						}
					});
				}
			}
        );
    }

    function decrementValue(orderDetailId)
    {
		var input = $('#quantity_'+orderDetailId).val();
		var val = parseInt(input, 10);
		var quantity = val - 1;
		$.ajax({
			headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
			method: "POST",
			url: "<?php echo url('increase-decrease-item');?>",
			data:{'quantity':quantity,'order_detail_id':orderDetailId},
			beforeSend:function(){
				$("#overlay").show();
			},
			success:function(data){
				$("#overlay").hide();
				if(data.success == true) {
					if(data.count == 0) {
						$('.record').html('<img src="{{ WEBSITE_IMG_URL.'cart.jpg' }}">');
						return;
					}
					$('.web-tbody').html(data.cartList);
					$('.pay_ele').html(data.paymentList);
					$('.cart_count').html(data.count);
				}
			}
		});
    }
	
    function incrementValue(orderDetailId)
    {
		var input = $('#quantity_'+orderDetailId).val();
		var val = parseInt(input, 10);
		var quantity = val + 1;
		$.ajax({
			headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
			method: "POST",
			url: "<?php echo url('increase-decrease-item');?>",
			data: {'quantity': quantity,'order_detail_id':orderDetailId},
			beforeSend: function () {
				$("#overlay").show();
			},
			success: function (data) {
				$("#overlay").hide();
				if (data.success == true) {
					$('.web-tbody').html(data.cartList);
					$('.pay_ele').html(data.paymentList);
					$('.cart_count').html(data.count);
				}
			}
		});
    }
	
	/**
     * @param orderId
     */
    function orderStatus(orderId, status)
    {
		bootbox.confirm("Are you sure? You want to be " +status.toLowerCase()+ " this order.",
			function(result) {
				if(result){
					$.ajax({
						headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
						url: "{{ url('order-status') }}",
						data: {'order_id' : orderId, 'status' : status},
						method: 'POST',
						beforeSend: function () {
							$("#overlay").show();
						},
						success: function(data) {
							$("#overlay").hide();
							if (data.success == true) {
								$('.my-order').html(data.myOrder);
                location.reload();
								notice('Order','Your order has been successfully updated.','success');
							}
						}
					});
				}
			}
        );
    }

// window.onscroll = function() {myFunction()};
//
// var header = document.getElementById("header-sticky");
// var sticky = header.offsetTop;
//
// function myFunction() {
//   if (window.pageYOffset > sticky) {
//     header.classList.add("sticky");
//   } else {
//     header.classList.remove("sticky");
//   }
// }

</script>
<script type="text/javascript">

  $(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
      $("#files").on("change", function(e) {
        var files = e.target.files,
        filesLength = files.length;
         var name= e.target.files[0].name;
         var extn = name.split('.').pop();
          if(extn=='png' ||extn=='jpeg'|| extn=='jpg'||extn=='gif'||extn=='webp')
          {
              var file, img;
             img = new Image();
             img.src = window.URL.createObjectURL(e.target.files[0])
           img.onload = () => {
              if(img.width>=1024 && img.height>=680)
              {
                for (var i = 0; i < filesLength; i++) {
                  var f = files[i]
                  var fileReader = new FileReader();
                  fileReader.onload = (function(e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                      "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                      "<br/><span class=\"remove\">Remove</span>" +
                      "<input type='hidden' name='files[]' value='"+e.target.result+"'></span>").insertAfter("#files");

                    $(".remove").click(function(){
                      $(this).parent(".pip").remove();
                    });
                  });
                  fileReader.readAsDataURL(f);
                }
              }else {
                 alert('Image must be greater than (1024X680)');
                    return false;
                 }
            }
          }else
          {
            for (var i = 0; i < filesLength; i++) {
                  var f = files[i]
                  var fileReader = new FileReader();
                  fileReader.onload = (function(e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                      "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                      "<br/><span class=\"remove\">Remove</span>" +
                      "<input type='hidden' name='files[]' value='"+e.target.result+"'></span>").insertAfter("#files");

                    $(".remove").click(function(){
                      $(this).parent(".pip").remove();
                    });
                  });
                  fileReader.readAsDataURL(f);
                }
          }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
      $("#videofile").on("change", function(e) {
        var files = e.target.files,
        filesLength = files.length;
        
        for (var i = 0; i < filesLength; i++) {
          var f = files[i]
          var fileReader = new FileReader();
          fileReader.onload = (function(e) {
            var file = e.target;
            $("<span class=\"pip\">" +"<video width='320' height='240' controls>"+
              "<source src=\"" + e.target.result + "\" type='video/mp4'></video>" +
              "<br/><span class=\"remove\">Remove</span>" +
              "<input type='hidden' name='video' value='"+e.target.result+"'></span>").insertAfter("#videofile");

            $(".remove").click(function(){
              $(this).parent(".pip").remove();
            });
          });
          fileReader.readAsDataURL(f);
        }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });
</script>
<script>
  var s3 = $("#ranged-value").freshslider({
    range: true,
    step:1,
    value:[0, 100],
    onchange:function(low, high){
    }
  });
</script>