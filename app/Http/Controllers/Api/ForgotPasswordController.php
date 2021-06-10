<?php

namespace App\Http\Controllers\Api;

use App\Models\Access\User\User;
use App\Http\Requests\Frontend\Auth\ForgotPassword\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Str,Hash;
use Validator;
class ForgotPasswordController extends APIController
{
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
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

                $responsedata['status'] ="1";
                $responsedata['message'] ='We have sent email with reset password link. Please check your inbox!.';
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
                $responsedata['status'] ="0";
                $responsedata['message'] =trans("This email address does not exist.Please recheck and try again.");
               return $this->respond($responsedata);
        }
    }

    public function changePassword(Request $request)
    {
      $validation = Validator::make($request->all(), [
            'new_password'     => 'required',
            'confirm_password' => 'required|same:new_password'
        ]);
         if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
         }

        $user = $this->findByEmail($request->email);
        if (Hash::check($request->old_password, $user->getAuthPassword())) {
            $user->password = Hash::make($request->new_password);
            if ($user->save()) {
                $updatedata['status']='1';
                $updatedata['messages']= 'Password change successfully.';
                 return $this->respond($updatedata);
              
            }
        } else {
                $updatedata['status']='0';
                $updatedata['messages']= 'Please enter correct old password.';
                 return $this->respond($updatedata);
        }
    }

    public function findByEmail($emaiId)
    {
        return User::where('email', $emaiId)->first();
    }
}
