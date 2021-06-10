@extends('emails.layouts.layout')
@section('content')


<div class="content">
    <div class="invoice" style="margin: 0px auto;font-family: Arial;overflow: hidden;">
        <div class="spacing">
            <hr
                style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px solid #e0e0e0;">
        </div>
        <div class="thanks" style="width: 100%;text-align:left;font-family: Arial; padding: 15px 0;">
            <p style="font-size: 20px;color: #393939;margin: 0; padding: 0; line-height: 28px;">
                <br />
                Dear {{ $email }},<br />
                Greeetings of the Day..<br />
                <br />
                You have subscribed Website newsletter successfully. We will update you with our latest news.
                <br />
                <br />
                <br />
                Thanks &amp; Regard<br />
                {{ $name }}
                <br />
                <br />
            </p>
        </div>
        
    </div>
</div>


@endsection
                        