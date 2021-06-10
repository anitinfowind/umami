<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ResetPassword\ResetPasswordRequest;
use App\Models\Access\User\User;
use Hash;

class ResetPasswordController extends Controller
{
    /**
     * @param string $forgotPasswordString
     * @return View
     */
    public function resetPasswordForm(string $forgotPasswordString)
    {
        if($forgotPasswordString != '') {
            $userDetail	=	User::where('confirmed', 1)->where('forgot_password_string',$forgotPasswordString)->first();
            if (!empty($userDetail)) {
                return view('frontend.auth.reset-password', compact('forgotPasswordString'));
            } else {
                session()->put('errors',
                    [
                        'title' => 'Error',
                        'msg' => trans('Sorry! you are using wrong link.')
                    ]
                );

                return redirect()->to('/');
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $newPassword	=	Hash::make($request->newPassword());
        $userInfo       =   User::where('forgot_password_string',$request->forgotPasswordString())->first();
        User::where('forgot_password_string',$request->forgotPasswordString())
            ->update(array(
                'password' => $newPassword,
                'forgot_password_string'	=>	null
            ));

        session()->put('reset-password',
            [
                'title' => trans('Reset Password'),
                'msg' => trans('Success! Password has been successfully reset. Please login with your new login credentials.')
            ]
        );

        $mailData = [
            'name' => $userInfo->firstName() .' '. $userInfo->lastName(),
            'email' => $userInfo->email
        ];

        $this->sendMail(
            $mailData,
            'emails.reset-password',
            'Password updated successfully'
        );

        return response()->json([
            'success' => true,
        ]);
    }
}
