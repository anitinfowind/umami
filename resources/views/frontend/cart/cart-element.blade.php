<table class="table">
	<thead>
		<tr>
			<th width="40%" style="padding-left: 25px;">Product</th>
			<th style="text-align: center;">Price</th>
			<th style="text-align: center;">Quantity</th>
			<th style="text-align: right;">Total</th>
		</tr>
	</thead>
	<tbody>
		@foreach($carts as $cart)
			<tr class="cart-item">
				<td>
					<div class="d-flex align-items-center">
					<a class="meal-dlt" href="javascript:void()"> 
						<span onclick="removeCart('{{ $cart->id }}','{{ $cart->order_id }}');">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
						</span>
					</a>
					@if(!empty($cart->product->singleProductImage->image) && File::exists(PRODUCT_ROOT_PATH.$cart->product->singleProductImage->image))
							<?php $image = PRODUCT_URL.$cart->product->singleProductImage->image; ?>						
					@else
						<?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
					@endif
						<div class="cart-image">
							<img src="{{ $image }}">
						</div>
					<div class="cart-item-product-wrap">
						<a href="{{url('product-detail/'.$cart->product->slug)}}">	
							<h5>{{isset($cart->product->title)?$cart->product->title:''}}</h5></a>
					</div>
					</div>
				
			</td>
				<td style="text-align: center;">{{ CURRENCY }}{{ number_format($cart->price, 2) }}</td>
				<td style="text-align: center;">
					<div class="inc-dec-btn">
						<span class="qty_stock"></span>
						<div class="input-group justify-content-center">
							<span class="input-group-btn">
								<button 
										type = "button" 
										class =" quantity-left-minus btn btn-number"
										onclick = 'decrementValue("{{ $cart->id }}")'
								>-</button>
							</span>
							<input 
									type = "text" 
									id = "quantity_{{ $cart->id }}" 
									class = "form-control input-number" 
									value = "{{$cart->quantity}}" 
									min = "1" 
									max = "100"
									readonly
							>
							<span class="input-group-btn">
								<button 
										type = "button" 
										class = "quantity-right-plus btn btn-number" 
										onclick = 'incrementValue("{{ $cart->id }}")'
								>+</button>
							</span>
						</div>
					</div>
				</td>
				<td style="text-align: right;">
					<b>{{ CURRENCY }}{{number_format($cart->total,2)}}</b>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>