<?php

namespace App\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends APIController
{
    /**
     * Log the user in.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function VendorLogin(Request $request)
    {

      if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
          $userdata = [
              'email' => $request->email,
              'password' => $request->password,
          ];

            $validation = Validator::make($request->all(), [
              'email'    => 'required|email',
              'password' => 'required',
          ]);

      } else {
          $userdata = [
              'phone'     => $request->email,
              'password'  => $request->password,
          ];

          $validation = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required',
        ]);
      }
        
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        //$credentials = $request->only(['email', 'password']);

        try {
            if (!Auth::attempt($userdata)) {

                  $resultArray['status']='0';
                  $resultArray['message']=trans('api.messages.login.failed');
                  return $this->respond($resultArray);
            }

            $user = $request->user();

        } catch (\Exception $e) {

          $resultArray['status']='0';
          $resultArray['message']=$this->respondInternalError($e->getMessage());
          return $this->respond($resultArray);
        }

        $resultArray['user_id']=$user->id;
        $resultArray['first_name']=$user->first_name;
        $resultArray['last_name']=$user->last_name;
        $resultArray['email']=$user->email;
        $resultArray['phone']=$user->phone;
        $resultArray['user_role']=$user->phone;
        $resultArray['image']=url('uploads/user/'.$user->slug.'/'.$user->image);
        
        return $this->respond([
                'success' => 1,
                'message' => trans('api.messages.login.success'),
                'data'=>$resultArray
      ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'status'=> "1",
            'message'   => trans('api.messages.logout.success'),
        ]);
    }
}
