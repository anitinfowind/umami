<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\Login\LoginRequest;

class LoginController extends Controller
{
    /**
     * @return string
     */
    public function redirectPath($preview=null)
    {
        if (auth()->user()->isVender() || auth()->user()->isUser() || auth()->user()->isManager()) {
           if(!empty($preview))
           {
            return redirect()->to($preview);
           }
            return route('frontend.user.dashboard');
        }

        return route('admin.dashboard');
    }

    /**
     * @return View
     */
    public function loginForm()
    {
        return view('frontend.auth.sign');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (filter_var($request->email(), FILTER_VALIDATE_EMAIL)) {
            $userdata = [
                'email' => $request->email(),
                'password' => $request->password(),
            ];
        } else {
            $userdata = [
                'phone'     => $request->email(),
                'password'  => $request->password(),
            ];
        }
        $preview='';
        if(!empty($request->preview))
        {
          $preview=$request->preview;
        }
       $remember_me = $request->has('remember') ? true : false;
        
        if (auth()->attempt($userdata,$remember_me)) {
            if(auth()->user()->status == ONE){
                if(auth()->user()->confirmed == ONE){
                    $response	=	array(
                        'success' => true,
                        'redirect' => $this->redirectPath(),
                        'preview' => $preview,
                    );

                    return response()->json($response);
                } else {
                    $link				=	\URL::to('/send-verification-link');
                    $validateString		=	auth()->user()->confirmation_code;
                    $errorVerification	=	trans("Email verification is required. Please check your inbox for verification details or to resend verification code");
                    $clickhere			=	trans("click here");
                    $error[]			=	$errorVerification.' <a style="border:none; color:#000" href="'.$link.'/'.$validateString.'">'
                        .$clickhere
                        .'</a>';
                    auth()->logout();
                }
            } else {
                $error[] = trans("Your account has been disabled by the administrator.");
                auth()->logout();
            }
        } else {
            $error[] = trans("Invalid email / phone no or password combination.");
        }

        return response()->json(['errors' => ['error' => $error]], 422);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        if(auth()->check()){
            auth()->logout();
        }
        return redirect()->to('/');
    }
}
