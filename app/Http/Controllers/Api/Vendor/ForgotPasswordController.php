<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Models\Access\User\User;
use App\Http\Requests\Frontend\Auth\ForgotPassword\ForgotPasswordRequest;


class ForgotPasswordController extends APIController
{

    public function VendorSendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $userDetail = User::where('email', $request->email())->first();

        if (!empty($userDetail)) {
            if ($userDetail->confirmed == ONE) {
                $forgotPasswordString =   $request->validateString();
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

                $responsedata['status'] ='success';
                $responsedata['message'] ='Password reset successfully.';
                 return $this->respond($responsedata);

               // return response()->json($response); die;
            } else {
                $link       = \URL::to('/send-verification-link');
                $validateString   = $userDetail->confirmation_code;
                $errorVerification  = trans("Email verification is required. Please check your inbox for verification details or to resend verification code");
                $clickhere      = trans("click here");
                $error[]      = $errorVerification.' <a style="border:none; color:#000" href="'.$link.'/'.$validateString.'">'
                    .$clickhere
                    .'</a>';
            }
        } else {
                $responsedata['status'] ='failed';
                $responsedata['message'] =trans("This email address does not exist.Please recheck and try again.");
                return $this->respond($responsedata);
        }

    }
}
