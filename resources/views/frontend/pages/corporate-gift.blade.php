@extends('frontend.layouts.app')
@section('content')

<div class="corporate-section">
<div class="container">
  <div class="corporate-img">
    <img src="images/gift.jpg">
  </div>
   <div class="gift-title">
    <h1>Never send a boring gift basket again!</h1>
    <p>Check off everyone on your gift list with our wide variety of iconic, award-winning & artisanal bites that are ready to ship nationwide.</p>
  </div>
 </div>
</div>

<div class="container">
	<div class="gft-bx">
		<div class="row">
			<div class="col-md-3">
				<div class="gift-box col-sm-12">
  	 	  	  		<div class="product-img-box">
  	 	  	  			<div class="product-img">
  	 	  	  	 			<img src="{{URL::to('images/gift.png')}}" class="img-fluid">
  	 	  	  			</div>
  	 	  	  		</div>
  	 	  	  		<div class="g-detail">
  	 	  	  	 		<h4>Large Orders</h4>
  	 	  	  	 		<p>Conse qut intere dum purus. Nam fringilla dapibus tellus. In tris tique  tincidunt est, petos vulputate felis suscipit in. </p>
  	 	  	  		</div>
  	 	  		</div>
			</div>
			<div class="col-md-3">
				<div class="gift-box col-sm-12">
  	 	  	  		<div class="product-img-box">
  	 	  	  			<div class="product-img">
  	 	  	  	 			<img src="{{URL::to('images/custom-notes.png')}}" class="img-fluid">
  	 	  	  			</div>
  	 	  	  		</div>
  	 	  	  		<div class="g-detail">
  	 	  	  	 		<h4>Custom Notes</h4>
  	 	  	  	 		<p>Conse qut intere dum purus. Nam fringilla dapibus tellus. In tris tique  tincidunt est, petos vulputate felis suscipit in. </p>
  	 	  	  		</div>
  	 	  		</div>
			</div>
			<div class="col-md-3">
				<div class="gift-box col-sm-12">
  	 	  	  		<div class="product-img-box">
  	 	  	  			<div class="product-img">
  	 	  	  	 			<img src="{{URL::to('images/gift-hand.png')}}" class="img-fluid">
  	 	  	  			</div>
  	 	  	  		</div>
  	 	  	  		<div class="g-detail">
  	 	  	  	 		<h4>Gorgeous Gifts</h4>
  	 	  	  	 		<p>Conse qut intere dum purus. Nam fringilla dapibus tellus. In tris tique  tincidunt est, petos vulputate felis suscipit in. </p>
  	 	  	  		</div>
  	 	  		</div>
			</div>
			<div class="col-md-3">
				<div class="gift-box col-sm-12">
  	 	  	  		<div class="product-img-box">
  	 	  	  			<div class="product-img">
  	 	  	  	 			<img src="{{URL::to('images/gift-box.png')}}" class="img-fluid">
  	 	  	  			</div>
  	 	  	  		</div>
  	 	  	  		<div class="g-detail">
  	 	  	  	 		<h4>Curated Picks</h4>
  	 	  	  	 		<p>Conse qut intere dum purus. Nam fringilla dapibus tellus. In tris tique  tincidunt est, petos vulputate felis suscipit in. </p>
  	 	  	  		</div>
  	 	  		</div>
			</div>
		</div>
	</div>
</div>

<div class="gift-sm-baner">
	<div class="container">
		<h1>Contact us to order your corporate gifts now</h1>
		<p>Our Gift Concierge is ready to place your order. All you have to do is email or call with your gifting needs.</p>
		<h4>or call 000-000-000</h4>
	</div>
</div>

<div class="info-card">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="info-card-bx">
					<h3>Choose a Yummy Gift</h3>
					<p>Choose from our list of top corporate gifts or send us an email at <a href="mailto:gifit@umami.com">xyz@gmail.com</a> if you’re looking for suggestions.</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="info-card-bx">
					<h3>Complete a Simple Form</h3>
					<p><a href="{{url('images/gift-hand.png')}}"  download>Download this form</a> and fill it in with your recipient addresses, custom gift messages & when you’d like your gifts to arrive by.</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="info-card-bx">
					<h3>Email the Form to Us</h3>
					<p><a href="mailto:webmaster@example.com">Email us</a> your completed form and your phone number so we can confirm & process your order within one business day.</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="info-card-bx">
					<p><a href="{{url('images/gift-hand.png')}}"  download><button class="btn order-btn w-100">Download Order Form</button></a></p>
					<p><a href="mailto:webmaster@example.com"><button class="btn btn-dark w-100 py-2">Email Your Concierge</button></a></p>
					<p class="font-weight-bold">Or Call - 000-000-000</p>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection