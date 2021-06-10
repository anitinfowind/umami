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
                                            Dear {{ $name }},
                                            <br />
                                            Please click the following link to reset your password:
                                            <p><strong> Email Id : </strong> {{ $email }}</p>
                                            <br />
                                            <a href="{{ $url}}"><button type="button" class="btn
                                            btn-primary">Click Here</button></a>
                                            <br /> <br />OR <br /><br />
                                            Copy below URL in your browser.
                                            <br /><a href="{{ $url}}">{{ $url }}</a>
                                            <br />
                                            <br />
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
                        