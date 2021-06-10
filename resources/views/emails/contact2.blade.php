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
                Hello Admin,<br />
                A user want to contact you, you can find the details below:
            </p>
        </div>
        <div class="spacing">
            <hr
                style="width: 100%;margin-top: 10px;margin-bottom: 5px;display: inline-block;border: 1px solid #e0e0e0;">
        </div>
        <div class="productinfo" style="margin: 0px;width: 100%;padding: 0;">
            <table width="100%" border="1" style="border-collapse:collapse; border: 1px solid #e0e0e0;" class="total-wrap">
                <tbody>
                    <tr>
                        <td width="30%" style="padding: 7px;">Name</td>
                        <td style="padding: 7px;">{{ $name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 7px;">Email</td>
                        <td style="padding: 7px;">{{ $emailFrom }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 7px;">Phone No</td>
                        <td style="padding: 7px;">{{ $phone }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 7px;">Subject</td>
                        <td style="padding: 7px;">{!! $subject !!}</td>
                    </tr>
                    <tr>
                        <td style="padding: 7px;">Message</td>
                        <td style="padding: 7px;">{!! $msg !!}</td>
                    </tr>
                </tbody>
            </table>
            <br />
            Thanks &amp; Regard<br />
            {{ $name }}
            <br />
            <br />
        </div>
    </div>
</div>

@endsection
                        