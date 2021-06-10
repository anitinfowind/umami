<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\Auth\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Models\Newsletter;
use Mail;
use Illuminate\Http\Request;
use Auth;

class RegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return View
     */
    public function registerForm()
    {
        
        /*$to = 'sudipta.aqualeaf@gmail.com';
        Mail::send('emails.test_account_confirm', [
                'name' => 'sudipta chakraborti',
                'email' => $to,
                'acturl' => url('verification', '1234registerForm22')
            ], function ($message) use ($to){
            $message->to($to);
            //$message->subject('Confirm your account');
        });*/

        return view('frontend.auth.sign');
    }

     public function vendorRegisterForm()
     {
        return view('frontend.auth.vendor_sign');
     }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    //public function register()
    {

        $user = $this->userRepository->userRegistered($request);

        /*$mailData = [
            'name' => $user->firstName() .' '. $user->lastName(),
            'email' => $user->email(),
            'url' => url('verification', $user->confirmationCode())
        ];

        $this->sendMail(
            $mailData,
            'emails.account-confirm',
            'Confirm your account'
        );*/

        /*$to = $user->email();
        Mail::send('emails.test_account_confirm', [
                'name' => $user->firstName() .' '. $user->lastName(),
                'email' => $to,
                'acturl' => url('verification', $user->confirmationCode())
            ], function ($message) use ($to){
            $message->to($to);
            $message->subject('Confirm your account');
        });*/

        $subscribe = Newsletter::where('email', $user->email())->first();
        if (empty($subscribe))
            Newsletter::create(['email' => $user->email()]);

        klaviyo_add_user(['email' => $user->email(), 'type' => 'register']);

        Auth::login($user, true);

        return response()->json([
            'success' => true
        ]);
    }
}
