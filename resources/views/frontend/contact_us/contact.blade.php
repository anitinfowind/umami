@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">Contact Us</h1>

    <!-- <div class="inner-breadcrumbs-menu">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i></li>
                <li><span>Contact us</span></li>
            </ul>
        </div>
    </div> -->

    <!-- <div class="map-sec">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14234.804283146777!2d75.78042128137203!3d26.881236930256758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1594705063969!5m2!1sen!2sin" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div> -->


    <section class="contact-sec">
        <div class="container">
            <div class="location-bx contact_page">
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="contact-form-bx">
                            <h4 class="text-center mb-4">SEND US MESSAGE</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="contact-form">
                                        {{ Form::open(['url' => 'contact-us' ,'id'=>'contact_form']) }}
                                            <div class="contact_form_error_div"></div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <input type="text" id="name" class="req form-control" name="name" placeholder="Name*">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <input type="email" id="email" class="req form-control" name="email" placeholder="Email*">
                                                    <span class="email error-msg" style="color:red"></span>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <input type="text" class="form-control number-field" id="phone" maxlength="10" name="phone" placeholder="Phone*">
                                                    <span class="phone error-msg" style="color:red"></span>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <input type="text" class="form-control req" name="subject" placeholder="Subject*">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 form-group pull-right">
                                                    <textarea name="message" id="message" class="form-control req" placeholder="Message*"></textarea>
                                                </div>
                                                <div class="col-sm-12 form-group text-center">
                                                    <button
                                                            class = "send-btn"
                                                            id = "submit-contact"
                                                            onclick = 'formData("contact_form","Contact Us","Thanks for contact us.",false)'
                                                            type="button"
                                                    >
                                                        Send Massage
                                                    </button>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="loc-left d-flex flex-wrap w-100 align-items-center">
                            <h4>CONTACT US</h4>
                            <!-- <ul class="contact-info">
                                <li><b>Address:</b>
                                    <p>{{ isset($setting->company_address) ? $setting->company_address : 'Street #156 Burbank, Studio City Hollywood, California USA' }}</p>
                                    
                                </li>
                                <li><b>Opening Timing:</b>
                                    <p>Monday - Friday 12pm - 11pm</p> 
                                    <p>Saturday - 10am - 12am</p>
                                    <p>Sunday - 10am - 12am</p>
                                </li>
                                <li>Live chat and phone support are available Monday to Friday, 9am to 5p EST</li>
                                <li><i class="fa fa-mobile"></i> <a href="tel:{{ $setting->company_contact ?? '' }}">{{ isset($setting->company_contact) ? $setting->company_contact : '' }}</a></li>
                                <li><i class="fa fa-envelope"></i> <a href="mailto:info@umamisquare.com">info@umamisquare.com</a></li>
                            </ul> -->
                            <div class="contact-info">
                                <i class="fa fa-envelope"></i> <a href="mailto:info@umamisquare.com">info@umamisquare.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection