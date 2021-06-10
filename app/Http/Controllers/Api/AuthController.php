<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Access\User\User;
use App\Models\RoleUser;
use App\Models\Access\User\SocialLogin;
use Ramsey\Uuid\Uuid;
use App\Models\Restaurant\RestaurantBranch;
use Validator;
use DB;
class AuthController extends APIController
{
    /**
     * Log the user in.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }
        
        $credentials = $request->only(['email', 'password']);

        try {
            if (!Auth::attempt($credentials)) {
                  $resultArray['status']='0';
                  $resultArray['message']=trans('api.messages.login.failed');
                  return $this->respond($resultArray);
            }

            $user = $request->user();
            $geralluser= User::where('email',$request->email)->get();

        } catch (\Exception $e) {
          $resultArray['status']='0';
          $resultArray['message']=$this->respondInternalError($e->getMessage());
          return $this->respond($resultArray);
        }
        $resultArray= array();
        foreach ($geralluser as $key => $user) {
          $userRole = RoleUser::where('user_id', $user->id)->first();
          $resultArray['user_id']=$user->id;
          $resultArray['role_id']=$userRole->role_id;
          if($userRole->role_id==4)
          {
           $branddata= RestaurantBranch::where('user_id',$user->id)->select('id','restaurant_id')->first();
           $resultArray['branch_id']=$branddata->id;
           $resultArray['restaurant_id']=$branddata->restaurant_id;
          }
           if($userRole->role_id==2)
           {
            $branddata= RestaurantBranch::where('user_id',$user->id)->select('id','restaurant_id')->first();
             $resultArray['restaurant_id']=isset($branddata->restaurant_id)?$branddata->restaurant_id:'';
           }
          $resultArray['first_name']=$user->first_name;
          $resultArray['last_name']=$user->last_name;
          $resultArray['email']=$user->email;
          $resultArray['phone']=$user->phone;
          $resultArray['confirmed']=$user->confirmed;
          $resultArray['image']=url('uploads/user/'.$user->slug.'/'.$user->image);
        }
        
        return $this->respond([
                      'status'=>'1',
                      'messages'=>trans('api.messages.login.success'),
                      'data'=>$resultArray,
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
      if(auth()->check()){
            auth()->logout();
        }

        return $this->respond([
            'status'    => '1',
            'message'   => trans('api.messages.logout.success'),
        ]);
    }

    public function socialLogin(Request $request)
    {
        $checkMail= User::where('email',$request->email)->first();
        if(isset($checkMail) && !empty($checkMail))
        {

        } else {
           $token = "";
           $image = "";

            $get_user_id = User::create(
              [
                'first_name'=>$request->name,
                'email'=>$request->email,
                'slug'=>app(Controller::class)->getSlug(
                $request->name,'','users'),
                'phone'=>$request->phone,
                'image'=>$image,
                'confirmed' => '1',
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'status'=>'1',
                'device_type'=>$request->device_type,
                'device_token'=>$request->device_token
              ]);

              SocialLogin::create(
              [
                'user_id'=> $get_user_id->id,
                'provider' => $request->provider,
                'provider_id' => $request->social_id, 
                'token'=>$token,
                'avatar'=>$image
              ]);

           $userInfo = User::where('id',$get_user_id->id)->first();

           $socialInfo = SocialLogin::where('user_id',$get_user_id->id)->first();

            if(!empty($userInfo) || !empty($socialInfo)) 
            {
              $resultArray['status']='1';
              $resultArray['message']=trans('Login sucsessfully');
              $resultArray['Data']['name']=$userInfo->first_name;
              $resultArray['Data']['email']=$userInfo->email;
              $resultArray['Data']['phone']=$userInfo->phone;
              $resultArray['Data']['image']=$userInfo->image;
              $resultArray['Data']['device_type']=$userInfo->device_type;
              $resultArray['Data']['device_token']=$userInfo->device_token;
              return $this->respond($resultArray);
            }

        }
    }

    public function updateProfile()
    {
      echo 'hello';
    }
}
