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
                                            Hello Admin,<br />
                                            A user want to contact you, you can find the details below:<br />
                                            &nbsp;
                                            <table class="border" border="1" cellpadding="1" cellspacing="1" width="100%">
                                                <tbody>
                                                    <tr height="35px">
                                                        <td class="padding" width="80px">Name</td>
                                                        <td class="padding">{{ $name }}</td>
                                                    </tr>
                                                    <tr height="35px">
                                                        <td class="padding" width="80px">Email</td>
                                                        <td class="padding">{{ $emailFrom }}</td>
                                                    </tr>
                                                    <tr height="35px">
                                                        <td class="padding" width="80px">Phone No</td>
                                                        <td class="padding">{{ $phone }}</td>
                                                    </tr>
                                                    <tr height="35px">
                                                        <td class="padding" width="80px">Subject</td>
                                                        <td class="padding">{!! $subject  !!}</td>
                                                    </tr>
                                                    <tr height="35px">
                                                        <td class="padding" width="80px">Message</td>
                                                        <td class="padding">{!! $msg  !!}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br />
                                            Thanks &amp; Regard<br />
                                            {{ $name }}
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
                        