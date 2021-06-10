@extends('emails.layouts.app')
@section('content')

<div class="content">
  <div class="invoice" style="margin: 0px auto;font-family: Arial;overflow: hidden;">
    <div class="thanks" style="width: 100%;text-align:left;font-family: Arial;margin-bottom: 10px;margin-top: 10px;">
      <p style=" font-size: 25px;font-weight: bold;color: #393939;margin-bottom: 4px;"> <br />
        Dear {{ $name }}, <br />
        Welcome to Umani Squar. Thank you for registering with us. Please click on the below link to activate your profile.</p>
        <br /><br />
        <a href="{{ $acturl }}">Click</a> to verify your email address.
        <br /><br />OR <br /><br />
        Copy below URL in your browser.
        <br />
        {{ $acturl }}
        <br />
        <br />
        <br />
        Thanks & Regards<br />
        {{ ucwords(str_replace('-', ' ', env('APP_NAME'))) }} Team.
        <br />
        <br />
    </div>
    
  </div>
</div>
</div>

@endsection