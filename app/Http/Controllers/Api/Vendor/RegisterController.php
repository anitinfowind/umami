<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Repositories\Frontend\Access\User\UserRepository;
use App\Http\Controllers\Controller;
use Config;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends APIController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Register User.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function vendorRegister(Request $request)
    {
      $validation = Validator::make($request->all(), [
          'first_name'            => 'required',
          'email'                 => 'required|email|unique:users',
          'password'              => 'required|min:6',
          'phone'                 =>  'required|numeric',
      ]);
      
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $user = $this->repository->vendorRegisterApp($request);
        if (!Config::get('api.register.release_token')) {
            return $this->respondCreated([
                'message'  => trans('api.messages.registeration.success'),
            ]);
        }

        // $passportToken = $user->createToken('API Access Token');

        // // Save generated token
        // $passportToken->token->save();

        // $token = $passportToken->accessToken;
       $mailData = [
                'name' => $user->first_name,
                'email' => $user->email,
                'url' => url('verification', $user->confirmation_code)
            ];

            $this->sendMail(
                $mailData,
                'emails.account-confirm',
                'Confirm your account'
            );

        return $this->respondCreated([
            'status' =>'1',
            'first_name' => $request->first_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message'   => trans('api.messages.registeration.success'),
        ]);
    }
}
