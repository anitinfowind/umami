@extends('emails.layouts.app')
@section('content')

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tbody>
        <tr>
            <td class="bg_light email-section" style="width: 100%;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td valign="middle" width="50%">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <br />
                                            <h3>Dear {{ $name }},</h3>
                                            Greetings of the Day..<br />
                                            We wanted to let you know that you are now registered with Website
                                            <br />
                                            <br />
                                            Your Email address is &quot;{{ $email }}&quot;<br />
                                            And&nbsp; password is &quot;{{ $password }}&quot;.<br />
                                            <br/>

                                            Please follow the link and login with your email address and password.
                                            <p><a href="{{ $url }}">Click here</a><br />
                                                <br />
                                                OR<br />
                                                <br />
                                                Copy below URL in your browser.<br />
                                                {{$url}}</p>

                                            Thanks & Regards<br />
                                            {{ ucwords(str_replace('-', ' ', env('APP_NAME'))) }} Team.
                                            <br />
                                            <br />
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

@endsection
                        