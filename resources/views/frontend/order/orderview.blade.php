@extends('frontend.layouts.app')
@section('content')
<style type="text/css">
  img.image_lable {
    transform: rotate(90deg);
    position: relative;
    top: 216px;
    height: 53%;
}
</style>
<div class="dashboard-wrap">
  <div class="container">
    <div class="row">
      <div class="inner-breadcrumbs-menu">
        <div class="container"> <a class="pull-right" href="{{ url('order') }}">
          <button type="button" class="btn add-product"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back </button>
          </a>
          <ul>
            <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
            <li><span>Order Detail</span></li>
          </ul>
        </div>
      </div>
      <div class="order-detail-section">
        <div class="container">
          <div class="oredr-loaction">
            <?php
               //$imageLable= App::make('App\Http\Controllers\Frontend\OrderController')->trackImage($ordersDetail->orderId());
          ?>
            @if($ordersDetail->label_image != '')
            <div class="row">
              <div class="col-sm-12"> <img class="image_lable" src="data:image/png;base64,{{$ordersDetail->label_image}}"> </div>
            </div>
            @endif 
            
            @if(isset($ordersDetail->gift_message) && !empty($ordersDetail->gift_message))
            <div class="container">
              <div class="row">
                <div class="col-sm-12">
                  <h2 class="gift_image_name">
                  GIFT MESSAGE:
                  </h3>
                  <h2>{{$ordersDetail->gift_message}}</h2>
                  
                  <!--   <a href="#" download>
                <canvas id="myCanvas" width="200" height="100" style="background: #eb97e4;
                  box-shadow: 1px 3px 3px 9px #8a4584;
                  border: 2px solid #eb97e4;
                  font-size: 30px;text-align:center"></canvas></a>
                 <script>
                  var c = document.getElementById("myCanvas");
                  var ctx = c.getContext("2d");
                  ctx.font = "30px cursive";
                  ctx.color = "#fff";
                  ctx.strokeText("Ganesh",10,50);
                  </script> --> 
                </div>
              </div>
            </div>
            @endif
            <div class="row">
              <div class="col-sm-8">
                <div class="order-detail"> <span>Estimated Delivery Date: {{ date('m-d-Y', strtotime($ordersDetail->delivery_date)) }}</span>
                  <?php if($ordersDetail->tracking_id != '') { ?>
                  <br>
                  <span>UPS Tracking ID: {{ $ordersDetail->tracking_id }}</span>
                  <?php } ?>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="order-address">
                        <h4>Delivery To:</h4>
                        <p>{{ $ordersDetail->fullName() }}<br>
                          {{ $ordersDetail->streetAddress() }} {{ $ordersDetail->address_line_2 != '' ? ', ' . $ordersDetail->address_line_2 : '' }}<br>
                          {{ $ordersDetail->country->name() }}<br>
                          {{ $ordersDetail->state->name() }}<br>
                          {{ $ordersDetail->city }},
                          {{ $ordersDetail->zipCode() }}<br>
                          {{-- $ordersDetail->phone() --}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="order-item cart-section">
                  <h4>Order </h4>
                  <h5>{{ date('m-d-Y', strtotime($ordersDetail->order_date)) }}<span>Order Id {{ $ordersDetail->orderId() }}</span></h5>
                  <div class="item-table web-tbody">
                    <table class="table">
                      <thead>
                        <tr>
                          <th width="40%" style="padding-left: 25px;">Ordered</th>
                          <th style="text-align: center;">Price</th>
                          <th style="text-align: center;">quantity</th>
                          <th style="text-align: right;">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @php
                      $items_price=0;
                      $subtotal=0;
                      $grosstotal=0;
                      $included_shipping_price=0;
                      $items_total_price=0;
                      @endphp
                      @foreach($ordersDetail->orderDetails as $myOrderDetail)
                      @php
                      $subtotal=$myOrderDetail->total+$subtotal;
                      @endphp
                      
                      @if(!empty($myOrderDetail->product->singleProductImage->image) &&
                      File::exists(PRODUCT_ROOT_PATH.$myOrderDetail->product->singleProductImage->image))
                      <?php $image = PRODUCT_URL.$myOrderDetail->product->singleProductImage->image; ?>
                      @else
                      <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                      @endif
                      <?php 
					  $included_shipping_price 	= !empty($myOrderDetail->included_shipping_price)?$myOrderDetail->included_shipping_price:'0';
            $items_price        = $myOrderDetail->price - $included_shipping_price;
					  $included_shipping_price	= $included_shipping_price * $myOrderDetail->quantity();
					  
					  $items_total_price		= $myOrderDetail->total -  $included_shipping_price;
					  
					  
					  $grosstotal += $items_total_price;
					  
					  ?>
                      <tr>
                        <td><a href="{{ url('product-detail',$myOrderDetail ->product->slug()) }}"> <img src="{{ $image }}" alt="{{ $myOrderDetail->product->title() }}">
                          <h5>{{ $myOrderDetail->product->title() }}</h5>
                          </a></td>
                        <td style="text-align: center;">${{ number_format($items_price, 2)}}</td>
                        <td style="text-align: center;">{{ $myOrderDetail->quantity() }}</td>
                        <td style="text-align: right;"><b>${{ number_format($items_total_price, 2)}}</b></td>
                      </tr>
                      @endforeach
                        </tbody>
                      
                    </table>
                  </div>
                  <div class="row">
                    <div class="col-sm-7"></div>
                    <div class="col-sm-5">
                      <div class="order-total">
                        <ul>
                          <!-- <li>Subtotal: <span>{{ $subtotal}}</span></li>
														<li>Delivery fee: <span>$0.00</span></li>
														<li>Tax and fees: <span>$0.00</span></li>
														<li>Total: <span>{{ $subtotal }}</span></li> -->
                          <li>Subtotal: <span>${{ number_format($grosstotal, 2) }}</span></li>
                          <!-- <li>Delivery fee: <span>$0.00</span></li>
														<li>Tax and fees: <span>$0.00</span></li> --> 
                          <!--<li>Discount: <span>${{ $ordersDetail->payment->discount_price }}</span></li>
                          <li>Processing Fee: <span>${{ number_format(($ordersDetail->payment->amount - ($ordersDetail->payment->product_amount - $ordersDetail->payment->discount_price)), 2) }}</span></li>-->
                          <li>Total: <span>${{ number_format($grosstotal, 2) }}</span></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection