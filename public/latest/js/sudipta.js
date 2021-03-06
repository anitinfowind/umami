function onlyNumbers(elem) {
  $(document).on("keypress keyup blur", elem, function (event) { 
	//$(elem).on("keypress keyup blur",function (event) {    
       $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
}

function ajax_get_cart() {
	var data = new FormData();
	data.append('action', 'ajax_get_cart');
	data.append('_token', prop.csrf_token);
	$.ajax({
		type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
			$('.cart_count').text(data.data.total_qty);
		}
	});
}


$(document).ready(function(){

	ajax_get_cart();

	$(document).on('click', '.open_search', function(){
		$('.srcInputArea').toggle();
	});

	$(document).on('click', '.qty_plus', function(){
		var qty = parseInt($.trim($(this).closest('.qty-plus-minu').find('input[name="qty"]').val()));
		$(this).closest('.qty-plus-minu').find('input[name="qty"]').val((qty + 1));
	});

	$(document).on('click', '.qty_minus', function(){
		var qty = parseInt($.trim($(this).closest('.qty-plus-minu').find('input[name="qty"]').val()));
		qty = qty - 1;
		if(qty == 0) qty = 1;
		$(this).closest('.qty-plus-minu').find('input[name="qty"]').val(qty);
	});

    var product_price = parseInt($('.base_price').attr('data-price'));
	$(document).on('click', '.add_to_cart', function(){
		var product_id = $(this).attr('product_id');
		var product_price = parseInt($('.base_price').attr('data-price'));
		var qty = $.trim($('.qty-plus-minu').find('input[name="qty"]').val());
		qty = parseInt(qty);
		$(".umami-loader").show();
	  var data = new FormData();
		data.append('action', 'add_to_cart');
		data.append('product_id', product_id);
		data.append('qty', qty);
		data.append('product_price', product_price);
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
			  	$(".umami-loader").hide();
			  	if(data.success == '0') {
			  		$("#messageModal .modal-header .modal-title").text('Add To Cart');
				  	$("#messageModal .modal-body").html('<p>' + data.message + '</p>');
				  	$("#messageModal").modal('show');
				  	setTimeout(function(){ $("#messageModal").modal('hide'); }, 2000);
			  	}
			  	if(data.success == '1') {
			  		ajax_get_cart();
			  		window.location.href = prop.url + '/cart';
			  	}
			}
		});
	});

	$(document).on('click', '.delete_cart', function(){
		var product_id = $(this).attr('product_id');
		if(confirm('Are you delete this item from cart?')) {
			//$(".umami-loader").show();
		  var data = new FormData();
			data.append('action', 'delete_cart');
			data.append('product_id', product_id);
			data.append('_token', $('meta[name="csrf-token"]').attr('content'));
			$.ajax({
				type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
				  	location.reload();
				}
			});
		}
	});

	$(document).on('click', '.update_cart', function(){
		var new_cart = {};
		$('input[name="qty"][product_id]').each(function(){
			new_cart['p_' + $(this).attr('product_id')] = $(this).val();
		});
		$(".umami-loader").show();
	  var data = new FormData();
		data.append('action', 'update_cart');
		data.append('new_cart', JSON.stringify(new_cart));
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
				$(".umami-loader").hide();
				var html = '<h5>' + data.message + '</h5>';
				$(data.data.cart_infos).each(function(i, v){
					html += '<p>' + v + '</p>';
				});
			  $("#messageModal .modal-header .modal-title").text('Cart');
		  	$("#messageModal .modal-body").html(html);
		  	$("#messageModal").modal('show');
		  	$("#messageModal").on('hide.bs.modal', function(){
			    location.reload();
			  });
			}
		});
	});

	$(document).on('click', '.cart-item .qty_plus, .cart-item .qty_minus', function(){
		var product_id = $(this).closest('.cart-item').attr('product_id');
		var qty = $(this).closest('.qty-plus-minu').find('input[name="qty"]').val();
		var that = $(this);
		//$(".umami-loader").show();
	  var data = new FormData();
		data.append('action', 'update_cart_item');
		data.append('product_id', product_id);
		data.append('qty', qty);
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
				$(".umami-loader").hide();
				if(typeof data.data.cart_total_data != 'undefined') {
					var ctd = data.data.cart_total_data;
					that.closest('tr').find('td:nth-of-type(4)').html('<b>$' + ctd.product_line_total + '</b>');
					$('[total_cart_price] span').text('$' + ctd.subtotal);
					var coupon_discount = parseFloat(ctd.coupon_discount);
					var reward_redeemed_amt = parseFloat(ctd.reward_redeemed_amt);
					var discount_amount = coupon_discount + reward_redeemed_amt;
					//$('[discount_amount] label').text('Discount' + (ctd.reward_redeemed > 0 ? ' (used ' + ctd.reward_discount + ' points)' : ''));
					$('[discount_amount] span').text('$' + discount_amount.toFixed(2));
					$('[payable_amount] span').text('$' + (parseFloat(ctd.subtotal) -  discount_amount).toFixed(2));
					$('.reward_point_info b').text(ctd.earnable_points);
				}
				var html = '<h5>' + data.message + '</h5>';
				$(data.data.cart_infos).each(function(i, v){
					html += '<p>' + v + '</p>';
				});
			  $("#messageModal .modal-header .modal-title").text('Cart');
		  	$("#messageModal .modal-body").html(html);
		  	//$("#messageModal").modal('show');
			}
		});
	});

	$(document).on('click', '.apply_coupon', function(){
		var coupon_code = $.trim($('input[name="coupon_code"]').val());
		if(coupon_code != '') {
			//$(".umami-loader").show();
		  var data = new FormData();
			data.append('action', 'apply_coupon');
			data.append('coupon_code', coupon_code);
			data.append('_token', $('meta[name="csrf-token"]').attr('content'));
			$.ajax({
				type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
					$(".umami-loader").hide();
					/*var html = '<h5>' + data.message + '</h5>';
				  $("#messageModal .modal-header .modal-title").text('Cart');
			  	$("#messageModal .modal-body").html(html);
			  	$("#messageModal").modal('show');
			  	if(data.success == '1') {
			  		$("#messageModal").on('hide.bs.modal', function(){
					    location.reload();
					  });
			  	}*/
			  	location.reload();
				}
			});
		}
	});

	$(document).on('click', '.remove_coupon', function(){
		if(confirm('Are you sure to remove applied coupon?')) {
			//$(".umami-loader").show();
		  var data = new FormData();
			data.append('action', 'remove_coupon');
			data.append('_token', $('meta[name="csrf-token"]').attr('content'));
			$.ajax({
				type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
				  	location.reload();
				}
			});
		}
	});

	$(document).on('click', '.show_reward_points', function(){
		$('.reward_point_opts').toggle();
	});

	$(document).on('click', '.reward_point_opts .rpo_item', function(){
		if(!$(this).hasClass('disabled')) {
			var type = $(this).attr('type');
			//$(".umami-loader").show();
		  var data = new FormData();
			data.append('action', 'apply_reward_point');
			data.append('type', type);
			data.append('_token', $('meta[name="csrf-token"]').attr('content'));
			$.ajax({
				type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
					//$(".umami-loader").hide();
					location.reload();
					/*var html = '<h5>' + data.message + '</h5>';
				  $("#messageModal .modal-header .modal-title").text('Cart');
			  	$("#messageModal .modal-body").html(html);
			  	$("#messageModal").modal('show');
			  	if(data.success == '1') {
			  		$("#messageModal").on('hide.bs.modal', function(){
					    location.reload();
					  });
			  	}*/
				}
			});
		}
	});

	$(document).on('click', '.reward_points_applied .close', function(){
		//$(".umami-loader").show();
	  var data = new FormData();
		data.append('action', 'remove_reward_point');
		data.append('_token', $('meta[name="csrf-token"]').attr('content'));
		$.ajax({
			type: 'POST', dataType: 'json', url: prop.ajaxurl, data: data, processData: false, contentType: false, success: function(data){
			  	location.reload();
			}
		});
	});

});