<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\User\UserRepository;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class UserTableController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param ManageUserRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ManageUserRequest $request)
    {
        return Datatables::make($this->users->getForDataTable($request->get('status'), $request->get('trashed')))
            ->escapeColumns(['first_name', 'email'])
            ->editColumn('confirmed', function ($user) {
                return $user->confirmed_label;
            })
            ->addColumn('status', function ($user) {
                return $user->status_label;
            })
            ->addColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format('d-M-Y');
            })
            ->addColumn('updated_at', function ($user) {
                return Carbon::parse($user->updated_at)->format('d-M-Y');
            })
            ->addColumn('actions', function ($user) {
                return $user->action_buttons;
            })
            ->make(true);
    }
}
