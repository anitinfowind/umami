<!-- layout head starts -->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="x-apple-disable-message-reformatting">
        <title></title>
        <link href="./email_files/css" rel="stylesheet">
        <style>
            html,
            body {
                margin: 0 auto !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
                background: #f1f1f1;
            }
            * {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            div[style*="margin: 16px 0"] {
                margin: 0 !important;
            }
            table,
            td {
                mso-table-lspace: 0pt !important;
                mso-table-rspace: 0pt !important;
            }
            table {
                border-spacing: 0 !important;
                border-collapse: collapse !important;
                table-layout: fixed !important;
                margin: 0 auto !important;
            }
            img {
                -ms-interpolation-mode:bicubic;
            }
            a {
                text-decoration: none;
            }
            *[x-apple-data-detectors],
            .unstyle-auto-detected-links *,
            .aBn {
                border-bottom: 0 !important;
                cursor: default !important;
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }
            .a6S {
                display: none !important;
                opacity: 0.01 !important;
            }
            .im {
                color: inherit !important;
            }
            img.g-img + div {
                display: none !important;
            }
            a.navbar-brand img {
              width: 160px;
              height: auto;
          }
          .navbar-brand {
                padding-top: 0;
                padding-bottom: 0;
            }
            .navbar-dark .navbar-brand {
                  color: #fff;
              }
          img {
                max-width: 100%;
            }
            .logo .navbar-brand img {
                  width: 100%;
              }
            ul.navigation {
                padding: 0;
                margin: 0;
            }
            ul.navigation li {
                display: inline-block;
            }
            ul.navigation li a {
              text-decoration: none;
              color: #494949;
              width: 100%;
              display: inline-block;
              padding: 0 15px;
          }

            @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                u ~ div .email-container {
                    min-width: 320px !important;
                }
            }
            @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                u ~ div .email-container {
                    min-width: 375px !important;
                }
            }
            @media only screen and (min-device-width: 414px) {
                u ~ div .email-container {
                    min-width: 414px !important;
                }
            }
        </style>
        <style>
            .primary{
                background: #0d0cb5;
            }
            .bg_white{
                background: #ffffff;
            }
            .bg_light{
                background: #fafafa;
            }
            .bg_black{
                background: #000000;
            }
            .bg_dark{
                background: rgba(0,0,0,.8);
            }
            .email-section{
                padding:0 2.5em;
            }
            .btn{
                padding: 5px 15px;
                display: inline-block;
            }
            .btn.btn-primary{
                border-radius: 5px;
                background: #0d0cb5;
                color: #ffffff;
            }
            .btn.btn-white{
                border-radius: 5px;
                background: #ffffff;
                color: #000000;
            }
            .btn.btn-white-outline{
                border-radius: 5px;
                background: transparent;
                border: 1px solid #fff;
                color: #fff;
            }
            h1,h2,h3,h4,h5,h6{
                font-family: 'Poppins', sans-serif;
                color: #000000;
                margin-top: 0;
            }
            body{
                font-family: 'Poppins', sans-serif;
                font-weight: 400;
                font-size: 15px;
                line-height: 1.8;
                color: rgba(0,0,0,.4);
            }
            a{
                color: #0d0cb5;
            }
            table{
            }
            .logo h1{
                margin: 0;
            }
            .logo h1 a{
                color: #000000;
                font-size: 20px;
                font-weight: 700;
                text-transform: uppercase;
                font-family: 'Poppins', sans-serif;
            }
            .navigation{
                padding: 0;
            }
            .navigation li{
                list-style: none;
                display: inline-block;;
                margin-left: 5px;
                font-size: 13px;
                font-weight: 500;
            }
            .navigation li a{
                color: rgba(0,0,0,.4);
            }
            .hero{
                position: relative;
                z-index: 0;
            }
            .hero .overlay{
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                content: '';
                width: 100%;
                background: #000000;
                z-index: -1;
                opacity: .3;
            }
            .hero .icon{
            }
            .hero .icon a{
                display: block;
                width: 60px;
                margin: 0 auto;
            }
            .hero .text{
                color: rgba(255,255,255,.8);
            }
            .hero .text h2{
                color: #ffffff;
                font-size: 30px;
                margin-bottom: 0;
            }
            .heading-section{
            }
            .heading-section h2{
                color: #000000;
                font-size: 20px;
                margin-top: 0;
                line-height: 1.4;
                font-weight: 700;
                text-transform: uppercase;
            }
            .heading-section .subheading{
                margin-bottom: 20px !important;
                display: inline-block;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: rgba(0,0,0,.4);
                position: relative;
            }
            .heading-section .subheading::after{
                position: absolute;
                left: 0;
                right: 0;
                bottom: -10px;
                content: '';
                width: 100%;
                height: 2px;
                background: #0d0cb5;
                margin: 0 auto;
            }
            .heading-section-white{
                color: rgba(255,255,255,.8);
            }
            .heading-section-white h2{
                font-family:
                line-height: 1;
                padding-bottom: 0;
            }
            .heading-section-white h2{
                color: #ffffff;
            }
            .heading-section-white .subheading{
                margin-bottom: 0;
                display: inline-block;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: rgba(255,255,255,.4);
            }
            .icon{
                text-align: center;
            }
            .icon img{
            }
            .padding{
                padding:6px;
            }
            table.border {
                border: gainsboro;
            }
            .services{
                background: rgba(0,0,0,.03);
            }
            .text-services{
                padding: 10px 10px 0;
                text-align: center;
            }
            .text-services h3{
                font-size: 16px;
                font-weight: 600;
            }
            .services-list{
                padding: 0;
                margin: 0 0 20px 0;
                width: 100%;
                float: left;
            }
            .services-list img{
                float: left;
            }
            .services-list .text{
                width: calc(100% - 60px);
                float: right;
            }
            .services-list h3{
                margin-top: 0;
                margin-bottom: 0;
            }
            .services-list p{
                margin: 0;
            }
            .text-services .meta{
                text-transform: uppercase;
                font-size: 14px;
            }
            .text-testimony .name{
                margin: 0;
            }
            .text-testimony .position{
                color: rgba(0,0,0,.3);
            }
            .img{
                width: 100%;
                height: auto;
                position: relative;
            }
            .img .icon{
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                bottom: 0;
                margin-top: -25px;
            }
            .img .icon a{
                display: block;
                width: 60px;
                position: absolute;
                top: 0;
                left: 50%;
                margin-left: -25px;
            }
            .counter{
                width: 100%;
                position: relative;
                z-index: 0;
            }
            .counter .overlay{
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                content: '';
                width: 100%;
                background: #000000;
                z-index: -1;
                opacity: .3;
            }
            .counter-text{
                text-align: center;
            }
            .counter-text .num{
                display: block;
                color: #ffffff;
                font-size: 34px;
                font-weight: 700;
            }
            .counter-text .name{
                display: block;
                color: rgba(255,255,255,.9);
                font-size: 13px;
            }
            .footer{
                color: rgba(255,255,255,.5);
            }
            .footer .heading{
                color: #ffffff;
                font-size: 20px;
            }
            .footer ul{
                margin: 0;
                padding: 0;
            }
            .footer ul li{
                list-style: none;
                margin-bottom: 10px;
            }
            .footer ul li a{
                color: rgba(255,255,255,1);
            }
            @media screen and (max-width: 500px) {
                .icon{
                    text-align: left;
                }
                .text-services{
                    padding-left: 0;
                    padding-right: 20px;
                    text-align: left;
                }
            }
        </style>
    </head>
    <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
    <center style="width: 100%; background-color: #f1f1f1;">
        <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            ‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;‌&nbsp;
        </div>
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tbody>
                  <!-- layout head ends -->

                  <!-- header starts -->
                  <tr>
  <td valign="top" class="bg_white" style="padding: 1em 2.5em;"><table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
        <tr>
          <td class="logo" style="text-align: center;"><a class="navbar-brand" href="{{ url('/') }}"><img style="width:160px" src='{{ WEBSITE_IMG_URL."logo.png" }}'></a></td>
          <td width="60%" class="logo" style="text-align: right;"><ul class="navigation" style="    list-style: none;">
              <!--<li><a target="_blank" href="{{ url('/') }}">Home</a></li>-->
              <li><a target="_blank" href="{{ url('contact-us') }}">About</a></li>
              <!--<li><a target="_blank" href="{{ url('blog') }}">Blog</a></li>
              <li><a target="_blank" href="{{ url('contact-us') }}">Contact</a></li>-->
            </ul></td>
        </tr>
      </tbody>
    </table></td>
</tr>
<!-- header ends -->



<tr>
                        <td class="bg_white">

<div class="content">
  <div class="invoice" style="margin: 0px auto;font-family: Arial;overflow: hidden;">
    <div class="thanks" style="width: 100%;text-align:left;font-family: Arial;margin-bottom: 10px;margin-top: 10px;text-transform: uppercase;">
      <p style=" font-size: 25px;font-weight: bold;color: #393939;margin-bottom: 4px;letter-spacing: 3px;text-transform: uppercase;"> <br />
        Hi {{ $name }}, <br />
        Thank you for your order.</p>
    </div>
    <div class="spacing">
      <hr  style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px dashed #393939;">
    </div>
    <div class="orderinfo" style="float: left;margin-left: 30px;width: 430px;line-height: 150%;padding-left: 15px;border-left: 1px dashed;height: 190px;">
      <p style="font-size: 18px;font-weight: bold;margin-bottom: 0px;color: #393939;"> Order Information: </p>
      <strong> Order Id: </strong> {{ $order_result[0]['order_info']->order_id }}<br />
      <strong> Order Date: </strong> {{ $order_result[0]['order_info']->order_date }}<br />
      <?php $delivery_date = explode(' ', $order_result[0]['order_info']->delivery_date); ?>
      <strong> Delivery Date: </strong> {{ $delivery_date[0] }}<br />
    </div>
    <div class="spacing">
      <hr  style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px dashed #393939;">
    </div>
    <div class="productinfo" style="display: inline-block;margin-top: 20px;float: left;width: 98.3%;padding: 10px;margin-right: 30px;border-radius: 10px;">
      <p style="margin-top: 0px;font-weight: bold;font-size: 18px;margin-bottom: 5px;"> Your order information:</p>
      <table width="100%" border="1" style=" border:1px solid; border-collapse:collapse">
        <tbody>
          <tr>
            <th class="name" align="left"> Product Name </th>
            <th class="detail" align="left"> Price</th>
            <th class="qty" align="left">Qty</th>
            <th class="cost" align="left">Cost</th>
          </tr>
          <?php
          foreach ($order_result as $key => $value) {
            ?>
            <tr>
            <td class="name" align="left">{{ $value['title'] }}</td>
            <td class="detail" align="left">{{ $value['price'] }}</td>
            <td class="qty" align="left">{{ $value['qty'] }}</td>
            <td class="cost" align="left">{{ $value['total'] }}</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <table width="100%" border="0" style="border-collapse:collapse">
        <tbody>
          <tr><th style="width: 70%; text-align: right;"></th><td style="width: 30%; text-align: right;"></td></tr>
          <tr><th style="text-align: right;">Subtotal:</th><td style="text-align: right;">${{ number_format($payment_history->product_amount, 2) }}</td></tr>
          <tr><th style="text-align: right;">Discount:</th><td style="text-align: right;">${{ number_format($payment_history->discount_price, 2) }}</td></tr>
          <?php
          if($payment_history->shipping_charge > 0) {
          ?>
            <tr><th style="text-align: right;">Shipping Fee:</th><td style="text-align: right;">${{ number_format($payment_history->shipping_charge, 2) }}</td></tr>
          <?php } ?>
          <tr><th style="text-align: right;">Processing Fee:</th><td style="text-align: right;">${{ number_format(($payment_history->amount - ($payment_history->product_amount - $payment_history->discount_price + $payment_history->shipping_charge)), 2) }}</td></tr>
          <tr style="border-top: 1px solid #999;"><th style="text-align: right;">Total:</th><th style="text-align: right;">${{ number_format($payment_history->amount, 2) }}</th></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>




<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
  <tbody>
    <tr>
      <td valign="middle" class="bg_black footer email-section"><table>
          <tbody>
            <tr>
              <td valign="top" width="50%" style="padding-top: 20px;"><table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tbody>
                    <tr>
                      <td style="text-align: left; padding-left: 5px; padding-right: 5px;"><h3 class="heading">Contact Info</h3>
                        <ul>
                          <li> <span class="text" > <a href="mailto:info@umamisquare.com" target="_blank" style="color:#000">info@umamisquare.com</a> </span> </li>
                        </ul></td>
                    </tr>
                  </tbody>
                </table></td>
              <td valign="top" width="50%" style="padding-top: 20px;"><table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tbody>
                    <tr>
                      <td style="text-align: left; padding-left: 10px;"><h3 class="heading">Useful Links</h3>
                        <ul>
                          <li><a target="_blank" href="{{ url('contact-us') }}">About</a></li>
                        </ul></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td valign="middle" class="bg_black footer email-section"><table>
          <tbody>
            <tr>
              <td valign="top" width="33.333%"><table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tbody>
                    <tr>
                      <td style="text-align: center; padding-right: 10px;"><p>{{ isset($setting->copyright_text) ? $setting->copyright_text : 'Copyright@ 2020 Umami Square . All Rights Reserved.' }}</p></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>




</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </center>
</body>
</html>