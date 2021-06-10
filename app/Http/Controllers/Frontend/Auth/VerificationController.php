<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * @param string $confirmationCode
     * @return mixed
     */
    public function verification(string $confirmationCode)
    {
        $userInfo	=	User::where('confirmation_code', $confirmationCode)->first();
        if (!empty($userInfo)) {
            if ($userInfo->confirmed == ONE) {
                session()->put('account-verification',
                    [
                        'title' => trans('Account Verification'),
                        'msg' => trans('Your account is already verified.')
                    ]
                );

                return redirect()->to('login');
            } else {
                User::where('id', $userInfo->id)->update(array(
                    'confirmation_code'   =>  null,
                    'confirmed' 		=>  ONE,
                ));

                $mailData = [
                    'name' => $userInfo->firstName() .' '. $userInfo->lastName(),
                    'email' => $userInfo->email()
                ];

                $this->sendMail(
                    $mailData,
                    'emails.thanks-registration',
                    'Registration successfully'
                );

                session()->put('account-verification',
                    [
                        'title' => trans('Account Verification'),
                        'msg' => trans('Your account has been successfully verified. Please login to access your account.')
                    ]
                );

                return redirect()->to('login');
            }
        } else {
            session()->put('errors',
                [
                    'title' => 'Error',
                    'msg' => trans('Sorry! you are using wrong link.')
                ]
            );

            return redirect()->to('/');
        }
    }

    /**
     * @param Request $request
     * @param string $validateString
     * @return mixed
     */
    public function sendVerificationLink(Request $request, string $confirmationCode)
    {
        $userInfo	=	User::where('confirmation_code', $confirmationCode)->first();

        $mailData = [
            'name' => $userInfo->firstName() .' '. $userInfo->lastName(),
            'email' => $userInfo->email(),
            'url' => url('verification', $userInfo->confirmationCode())
        ];

        $this->sendMail(
            $mailData,
            'emails.account-confirm',
            'Confirm your account'
        );

        session()->put('send-verification-link',
            [
                'title' => trans('Resend Link'),
                'msg' => trans('An email has been sent to your inbox with the link to verify your account. Please check your email.')
            ]
        );

        return redirect()->to('/');
    }
}
