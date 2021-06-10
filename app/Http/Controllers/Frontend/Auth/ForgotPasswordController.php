<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ForgotPassword\ForgotPasswordRequest;
use App\Models\Access\User\User;

class ForgotPasswordController extends Controller
{
    /**
     * @return View
     */
    public function forgotPasswordForm()
    {
        return view('frontend.auth.forgot-password');
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $userDetail	=	User::where('email', $request->email())->first();

        if (!empty($userDetail)) {
            if ($userDetail->confirmed == ONE) {
                $forgotPasswordString	= 	$request->validateString();
                User::where('email',$request->email())
                    ->update(['forgot_password_string' => $forgotPasswordString]);

                $mailData = [
                    'name' => $userDetail->firstName() .' '. $userDetail->lastName(),
                    'email' => $userDetail->email,
                    'url' => url('reset-password',$forgotPasswordString),
                ];

                $this->sendMail(
                    $mailData,
                    'emails.forgot-password',
                    'Forgot password'
                );

                $response	=	array(
                    'success' => true,
                );

                return response()->json($response); die;
            } else {
                $link				=	\URL::to('/send-verification-link');
                $validateString		=	$userDetail->confirmation_code;
                $errorVerification	=	trans("Email verification is required. Please check your inbox for verification details or to resend verification code");
                $clickhere			=	trans("click here");
                $error[]			=	$errorVerification.' <a style="border:none; color:#000" href="'.$link.'/'.$validateString.'">'
                    .$clickhere
                    .'</a>';
            }
        } else {
            $error[] = trans("This email address does not exist in our repository.Please recheck and try again.");
        }

        return \Response::json(['errors' => ['error' => $error]], 422);
    }
}
