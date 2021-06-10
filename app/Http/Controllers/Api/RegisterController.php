<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Frontend\Access\User\UserRepository;
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
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name'            => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $user = $this->repository->userRegisterApp($request);
        if (!Config::get('api.register.release_token')) {
            return $this->respondCreated([
                'message'  => trans('api.messages.registeration.success'),
            ]);
        }
     return $this->respond([
                'status' =>'1',
                'first_name' => $request->first_name,
                'email' => $request->email,
                'message'   => trans('You have registered successfully.'
                 ]);
       
    }
}
