<?php
$styles = [
'email_container' => 'box-shadow: 0px 1px 7px 0px rgb(0 0 0 / 20%);
    -webkit-box-shadow: 0px 1px 7px 0px rgb(0 0 0 / 20%);
    -moz-box-shadow: 0px 1px 7px 0px rgba(0, 0, 0, 0.2);
    border-radius: 10px 10px 0 0;
    -webkit-border-radius: 10px 10px 0 0;
    -moz-border-radius: 10px 10px 0 0;
    padding: 15px;',
'footer_heading' => 'color: #a9a9a9;
    font-size: 18px;
    margin: 0;
    font-family: Arial;
    padding: 8px 0;'
];


?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="x-apple-disable-message-reformatting">
        <title></title>
        <!-- <link href="{{ url('/public/latest/css/email.css') }}" rel="stylesheet"> -->
    </head>
    <body width="600px" style="width: 600px; margin: 0 auto; padding: 0 !important; mso-line-height-rule: exactly;">
        <div style="width: 600px; margin: 0 auto; {!! $styles['email_container'] !!}" class="email-container">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="margin: auto;">
                <thead>
                    <tr>
                        <td valign="top" class="bg_white" style="padding: 0;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td class="logo" style="">
                                            <a class="navbar-brand" href="{{ url('/') }}" style="display: block;">
                                                <img style="width:160px" src="{{ url('/public/images/logo.png') }}">
                                            </a>
                                        </td>
                                        <td width="60%" class="logo" style="text-align: right;">
                                            <ul class="navigation" style="list-style: none;">
                                                <!-- <li><a target="_blank" href="{{ url('/contact-us') }}" style="color: #000; text-decoration: none;">About</a></li>
                                                <li><a target="_blank" href="{{ url('/contact-us') }}" style="color: #000; text-decoration: none;">About</a></li> -->
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="bg_white">

                        @yield('content')

                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="margin: auto;">
                                <tbody>
                                    <tr>
                                        <td valign="middle" class="bg_black footer email-section" style="background: #000000; padding: 0 50px 6px 50px;">
                                            <table style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top" width="50%" style="padding-top: 10px;">
                <table role="presentation" cellspacing="0" cellpadding="0"
                    border="0" width="100%">
                    <tbody>
                        <tr>
                            <td
                                style="text-align: left; padding-left: 5px; padding-right: 5px;">
                                <!-- <h3 class="heading" style="{!! $styles['footer_heading'] !!}">Contact Info</h3> -->
                                <ul style="padding: 0; margin: 5px 0;" class="ftr-menu">
                                    <!-- <li style="list-style: none;"> 
                                        <span class="text"> 
                                            <a href="mailto:info@umamisquare.com" target="_blank" style="font-family: Arial; text-decoration: none; color: #a9a9a9;">info@umamisquare.com</a>
                                        </span> 
                                    </li> -->
                                    <li style="list-style: none; margin-bottom: 6px;"> 
                                        <span class="text"> 
                                            <a href="{{ url('/pages/mission') }}" style="font-family: Arial; text-decoration: none; color: #a9a9a9;">About Us</a>
                                        </span> 
                                    </li>
                                    <li style="list-style: none;"> 
                                        <span class="text"> 
                                            <a href="{{ url('pages/about') }}" style="font-family: Arial; text-decoration: none; color: #a9a9a9;">How It Works</a>
                                        </span> 
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
                                                        </td>
                                                        <td valign="top" width="50%" style="padding-top: 10px;">
                <table role="presentation" cellspacing="0" cellpadding="0"
                    border="0" width="100%">
                    <tbody>
                        <tr>
                            <td style="text-align: right; padding-left: 10px;">
                                <!-- <h3 class="heading" style="{!! $styles['footer_heading'] !!}">Useful Links</h3>
                                <ul class="ftr-about ftr-menu" style="padding: 0; margin: 5px 0;">
                                    <li style="list-style: none;"><a target="_blank" href="{{ url('/contact-us') }}" style="font-family: Arial; text-decoration: none; color: #a9a9a9;">About</a>
                                    </li>
                                </ul> -->
                                <div style="margin-top: 10px;">
                                    <a href="https://www.facebook.com/umamisquare/" style="margin: 0 7px;"><img src="{{ url('/public/latest/images/facebook.png') }}" style="width: 30px;" /></a>
                                    <a href="https://www.instagram.com/umamisquare" style="margin: 0 7px;"><img src="{{ url('/public/latest/images/instagram.png') }}" style="width: 30px;" /></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" class="bg_black footer email-section" style="background: #000000; padding: 0 50px 14px 50px;">
                                            <table style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top" width="100%">
                                                            <table role="presentation" cellspacing="0" cellpadding="0"
                                                                border="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="text-align: center; font-family: Arial;">
                                                                            <p style="font-size: 12px; color: #666; padding: 0; margin: 0;">Copyright@ 2020 Umami Square . All Rights Reserved.</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>