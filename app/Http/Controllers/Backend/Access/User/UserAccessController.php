<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Exceptions\GeneralException;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\User\User;

class UserAccessController extends Controller
{
    /**
     * @param User $user
     * @param ManageUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function loginAs(User $user, ManageUserRequest $request)
    {
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            if (access()->id() == $user->id || session()->get('admin_user_id') == $user->id) {
                throw new GeneralException('Do not try to login as yourself.');
            }
            session(['temp_user_id' => $user->id]);
            access()->loginUsingId($user->id);

            return redirect()->route('frontend.index');
        }

        app()->make(Auth::class)->flushTempSession();

        if (access()->id() == $user->id) {
            throw new GeneralException('Do not try to login as yourself.');
        }
        session(['admin_user_id' => access()->id()]);
        session(['admin_user_name' => access()->user()->first_name]);
        session(['temp_user_id' => $user->id]);
        access()->loginUsingId($user->id);

        return redirect()->route('frontend.index');
    }

    /**
     * @param User $user
     * @param ManageUserRequest $request
     */

}
