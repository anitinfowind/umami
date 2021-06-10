@extends('frontend.layouts.app')
@section('content')

<?php
$ways_points = [];
$order_status = ''; // 1 = confirmed, 2 = on its way, 3 = out for delivery, 4 = delivered
$tracking_number = $myOrder->tracking_id;
//$tracking_number = '1ZR673Y50399868349';
//$tracking_number = '1ZR673Y50395145029';
//$tracking_number = '1ZR673Y50398045837';
//$tracking_number = '1ZR673Y51395497256';
//$tracking_number = '1ZR673Y51395442662';
$accesskey = env('UPS_API_KEY');
$userid = env('UPS_USER_ID');
$password = env('UPS_PASSWORD');
$tracking = new \Ups\Tracking($accesskey, $userid, $password);
try {
  $tracking = $tracking->track($tracking_number);
  //print_r($tracking);
  //dd($tracking);
  foreach ($tracking->Package->Activity as $key => $value) {
  	//dd($value->ActivityLocation->Address->City);
  	//if(isset($value->ActivityLocation->Address->City) && isset($value->ActivityLocation->Address->StateProvinceCode) && isset($value->ActivityLocation->Address->PostalCode))
  		//print_r($value->ActivityLocation->Address);
  	if(isset($value->ActivityLocation->Address->City) && isset($value->ActivityLocation->Address->StateProvinceCode) && (isset($value->ActivityLocation->Address->PostalCode) || isset($value->ActivityLocation->Address->CountryCode))) {
  		$way = $value->ActivityLocation->Address->City . ', ' . $value->ActivityLocation->Address->StateProvinceCode . ' ' . ($value->ActivityLocation->Address->PostalCode ?? '') . ' ' . ($value->ActivityLocation->Address->CountryCode ?? '');
  		//echo $way . '<br>';
  		if($order_status == '' && $value->Status->StatusType->Code == 'D') {
  			$way = $myOrder->streetAddress() . ($myOrder->address_line_2 != '' ? ', ' . $myOrder->address_line_2 : '') . $way;
  			$order_status = 4;
  		}
  		if($order_status == '' && $value->Status->StatusType->Code == 'I' && $value->Status->StatusCode->Code == 'OT')
  			$order_status = 3;
  		if($order_status == '' && $value->Status->StatusType->Code == 'P' && $value->Status->StatusCode->Code == 'PU')
  			$order_status = 2;
  		if($order_status == '' && $value->Status->StatusType->Code == 'M' && $value->Status->StatusCode->Code == 'MP')
  			$order_status = 1;
  		if(!in_array($way, $ways_points)) $ways_points[] = $way;
  	}
  }
  $resloc = $myOrder->vendor->restaurant->restaurantLocation;
  $ways_points[] = $resloc->location . ', ' . $resloc->withCity->name . ', ' . $resloc->withCity->state_code . ' ' . $resloc->zip_code;
  $ways_points = array_reverse($ways_points);
} catch (\Ups\Exception\InvalidResponseException $e) {
  echo $e->getMessage();
}

//dd($ways_points);
//$order_status = 4;


/*$from = '82 beaver street #606, new york, New york country, NY, US, 10005';
//$from = '82 Beaver Street, New York, New York, NY 10005, U.S';
$from = '7152 North Ohio St. Fountain Valley, CA 92708';
//$url = "https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($from)."&destination=".urlencode($to)."&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
$url = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".urlencode($from)."&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
$result_string = file_get_contents($url);
$result_string = json_decode($result_string, true);
//dd($result_string);


$place_id = $result_string['predictions'][0]['place_id'] ?? '';
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id=" . $place_id . "&key=AIzaSyDg7Axyq3hQ9nUwBepdIdpZZ5MSHwg6TOI";
$result_string = file_get_contents($url);
$result_string = json_decode($result_string, true);
//dd($result_string);*/
?>

<div class="dashboard-wrap">
  <div class="container">
    <div class="row">
			<div class="inner-breadcrumbs-menu">
				<div class="container">
					<a class="pull-right" href="{{ url('my-order') }}">
						<button type="button" class="btn add-product">
							<i class="fa fa-arrow-left" aria-hidden="true"></i> Back
						</button>
					</a>
					<ul>
						<li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
						<li><span>Order Track</span></li>
					</ul>
				</div>
			</div>
      <div class="order-detail-section">
				<div class="container">
					<div class="oredr-loaction">
						<div class="row">
							<div class="col-md-6">
								<div class="order-detail">
									<?php //dd($myOrder);
									//dd($myOrder->vendor->restaurant->restaurantLocation);
									 ?>
									<!-- <a href="">
										<h4>{{-- $myOrder->product->title() --}}</h4>
									</a> -->
									<span>Order Date</span>
									<h5>{{-- $myOrder->createdAt() --}}{{ date('F j, Y', strtotime($myOrder->order_date)) }}</h5>
									<div class="order-flow">
										<!-- <ul>
											<li class="active @if(in_array($myOrder->status(), [PACKED,SHIPPED,DELIVERED])) done @endif">
												<span class="number"></span>
												<span>Order</span>
											</li>
											<li class="active @if(in_array($myOrder->status(), [SHIPPED,DELIVERED])) done @endif">
												<span class="number"></span>
												<span>Packed</span>
											</li>
											<li class="active @if(in_array($myOrder->status(), [DELIVERED])) done @endif">
												<span class="number"></span>
												<span>Shipped</span>
											</li>
											<li class="active">
												<span class="number"></span>
												<span>Delivered</span>
											</li>
										</ul> -->
										<ul>
											<?php
											if($order_status == '') {
												echo '<li class="active done">
													<span class="number"></span>
													<span>Confirmed</span>
												</li>
												<li class="active">
													<span class="number"></span>
													<span>On Its Way</span>
												</li>
												<li class="active">
													<span class="number"></span>
													<span>Out For Delivery</span>
												</li>
												<li class="active">
													<span class="number"></span>
													<span>Delivered</span>
												</li>';
											} else { ?>
												<li class="active {{ $order_status > 1 ? 'done' : '' }}">
													<span class="number"></span>
													<span>Confirmed</span>
												</li>
												<li class="active {{ $order_status > 2 ? 'done' : '' }}">
													<span class="number"></span>
													<span>On Its Way</span>
												</li>
												<li class="active {{ $order_status > 3 ? 'done' : '' }}">
													<span class="number"></span>
													<span>Out For Delivery</span>
												</li>
												<li class="active">
													<span class="number"></span>
													<span>Delivered</span>
												</li>
											<?php } ?>
										</ul>
									</div>
								</div>
								<div class="mb-2 text-center"><a href="http://wwwapps.ups.com/WebTracking/processInputRequest?sort_by=status&tracknums_displayed=1&TypeOfInquiryNumber=T&loc=en_US&InquiryNumber1={{ $myOrder->tracking_id }}&track.x=0&track.y=0" class="btn btn-dark" target="_blank">Track in UPS</a></div>
							</div>
							<div class="col-md-6">
								<div class="location-map">
									<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2482.0489026867444!2d-0.09584538453988803!3d51.53066287963904!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sLUXNYOU%20LTD%3B%2022%20Wenlock%20Road%20London%2C%20United%20Kingdom.!5e0!3m2!1sen!2sin!4v1595344700929!5m2!1sen!2sin" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
									<div id="map" style="height: 250px;"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="oredr-loaction">
						<div class="row">
							<div class="col-sm-8">
								<div class="order-detail">
									
									<span>Estimated Delivery Date: {{ date('m-d-Y', strtotime($myOrder->delivery_date)) }}</span>
									<?php if($myOrder->tracking_id != '') { ?>
										<br><span>UPS Tracking ID: {{ $myOrder->tracking_id }}</span>
									<?php } ?>
									<div class="row">
										<div class="col-sm-6">
											<div class="order-address">
												<h4>Delivery to:</h4>
												<p>{{ $myOrder->fullName() }}<br>
													{{ $myOrder->streetAddress() }} {{ $myOrder->address_line_2 != '' ? ', ' . $myOrder->address_line_2 : '' }}<br>
													{{ $myOrder->country->name() }}<br>
													{{ $myOrder->state->name() }}<br>
													{{ $myOrder->city }},
													{{ $myOrder->zipCode() }}<br>
													{{ $myOrder->phone()}}</p>
													<?php
													$address_str = $myOrder->streetAddress() . ($myOrder->address_line_2 != '' ? ', ' . $myOrder->address_line_2 : '');
													$address_str .= $myOrder->city . ', ' . $myOrder->zipCode() . ', ' . $myOrder->country->name();
													$resloc = $myOrder->vendor->restaurant->restaurantLocation;
  												$rest_address_str = $resloc->location . ', ' . $resloc->withCity->name . ', ' . $resloc->withCity->state_code . ' ' . $resloc->zip_code;

													?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="order-serve">
									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="order-item cart-section">
									<h4>Your Order </h4>
									<h5>Order From: <b>{!! $myOrder->orderDetails[0]->vendor_name !!}</b></h5>
									<h5>{{ date('F j, Y', strtotime($myOrder->order_date)) }}<span>Order Id {{ $myOrder->orderId() }}</span></h5>
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
                        $subtotal=0;
                        @endphp
                       @foreach($myOrder->orderDetails as $myOrderDetail)
                       @php
                       $subtotal=$myOrderDetail->total+$subtotal;
                       @endphp

                       <?php
                       //dd($myOrderDetail->product->productImage);
                       $pdimg = WEBSITE_IMG_URL.'no-product-image.png';
                       foreach ($myOrderDetail->product->productImage as $ik => $iv) {
                       	$pathinfo = pathinfo($iv->image);
                       	if(in_array($pathinfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp'])) 
                       		$pdimg = PRODUCT_URL . $iv->image;
                       }
                       ?>
                       
                        @if(!empty($myOrderDetail->product->singleProductImage->image) &&
                        File::exists(PRODUCT_ROOT_PATH.$myOrderDetail->product->singleProductImage->image))
                          <?php $image = PRODUCT_URL.$myOrderDetail->product->singleProductImage->image; ?>
                        @else
                          <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                        @endif
												<tr>
													<td>
														<a href="{{ url('product-detail',$myOrderDetail->product->slug()) }}">
															<img src="{{ $pdimg }}" alt="{{ $myOrderDetail->product->title() }}">
															<h5>{{ $myOrderDetail->product->title() }}</h5>
														</a>	
													</td>
													<td style="text-align: center;">{{ $myOrderDetail->price() }}</td>
													<td style="text-align: center;">{{ $myOrderDetail->quantity() }}</td>
													<td style="text-align: right;"><b>{{ $myOrderDetail->total() }}</b></td>
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
													<li>Subtotal: <span>${{ number_format($myOrder->payment->product_amount, 2) }}</span></li>
													<!-- <li>Delivery fee: <span>$0.00</span></li>
													<li>Tax and fees: <span>$0.00</span></li> -->
													<li>Discount: <span>${{ $myOrder->payment->discount_price }}</span></li>
													<?php
													if($myOrder->payment->shipping_charge > 0)
														echo '<li>Shipping Fee: <span>$' . number_format($myOrder->payment->shipping_charge, 2) . '</span></li>';
													?>
													<li>Processing Fee: <span>${{ number_format(($myOrder->payment->amount - ($myOrder->payment->product_amount - $myOrder->payment->discount_price + $myOrder->payment->shipping_charge)), 2) }}</span></li>
													<li>Total: <span>${{ $myOrder->payment->amount }}</span></li>
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



@section('after-script')


<script type="text/javascript">
function initMap2() {
	const directionsService = new google.maps.DirectionsService();
  const directionsRenderer = new google.maps.DirectionsRenderer({polylineOptions:{
    strokeColor:'#666'
  }});
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 6,
    center: { lat: 41.85, lng: -87.65 },
  });
  directionsRenderer.setMap(map);
  /*document.getElementById("submit").addEventListener("click", () => {
    calculateAndDisplayRoute(directionsService, directionsRenderer);
  });*/

  const waypts = [];

  <?php
  if(count($ways_points) > 1) {
  	foreach ($ways_points as $key => $value) {
  		if($key == 0) continue;
  		if($key == (count($ways_points) - 1)) continue;
  		echo 'waypts.push({location: "' . $value . '", stopover: true});';
  	}
  }
  ?>

  /*waypts.push({location: 'toronto, ont', stopover: true});
  waypts.push({location: 'chicago, il', stopover: true});
  waypts.push({location: 'fargo, nd', stopover: true});*/

  directionsService.route(
    {
      //origin: 'Halifax, NS',
      //destination: 'Vancouver, BC',
      origin: '{{ $ways_points[0] ?? '' }}',
      destination: '{{ $ways_points[(count($ways_points) - 1)] ?? '' }}',
      waypoints: waypts,
      optimizeWaypoints: false,
      travelMode: google.maps.TravelMode.DRIVING,
    },
    (response, status) => {
      if (status === "OK" && response) {
        directionsRenderer.setDirections(response);
        directionsRenderer.setOptions( { suppressMarkers: true } );
        //console.log(response.routes);
        for (let i = 0; i < response.routes[0].legs.length; i++) {
        	var leg = response.routes[0].legs[i];
        	new google.maps.Marker({
            position: leg.start_location,
            map: map,
            icon: '{{ url('public/latest/images/marker.png') }}',
            title: leg.start_address
        	});
        	if(i == (response.routes[0].legs.length - 1)) {
        		new google.maps.Marker({
	            position: leg.end_location,
	            map: map,
	            icon: '{{ url('public/latest/images/final_marker.png') }}',
	            title: leg.end_address
	        	});
        	}
        }
        /*const route = response.routes[0];
        const summaryPanel = document.getElementById("directions-panel");
        summaryPanel.innerHTML = "";
        for (let i = 0; i < route.legs.length; i++) {
          const routeSegment = i + 1;
          summaryPanel.innerHTML +=
            "<b>Route Segment: " + routeSegment + "</b><br>";
          summaryPanel.innerHTML += route.legs[i].start_address + " to ";
          summaryPanel.innerHTML += route.legs[i].end_address + "<br>";
          summaryPanel.innerHTML +=
            route.legs[i].distance.text + "<br><br>";
        }*/
      } else {
        window.alert("Directions request failed due to " + status);
      }
    }
  );

}


      function initMap() {
        const uluru = { lat: -25.344, lng: 131.036 };
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 10,
          center: uluru,
        });
        const marker = new google.maps.Marker({
          position: uluru,
          map: map,
        });
        var address = '{{ $rest_address_str }}';
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location,
              icon: '{{ url('public/latest/images/final_marker.png') }}',
	            title: '{{ $rest_address_str }}'
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

      $(document).ready(function(){

      	<?php
      	if(count($ways_points) > 1) {
      		echo 'initMap2();';
      	} else {
      		echo 'initMap();';
      	}
      	?>
      	
      });
    </script>

@endsection