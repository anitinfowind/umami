<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\CreateUserRequest;
use App\Http\Requests\Backend\Access\User\DeleteUserRequest;
use App\Http\Requests\Backend\Access\User\EditUserRequest;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Http\Requests\Backend\Access\User\ShowUserRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Http\Responses\Backend\Access\User\CreateResponse;
use App\Http\Responses\Backend\Access\User\EditResponse;
use App\Http\Responses\Backend\Access\User\ShowResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Access\Permission\Permission;
use App\Models\Access\User\User;
use App\Models\Favorite;
use App\Models\Order;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\Backend\Access\User\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @var RoleRepository
     */
    protected $roles;

  /**
     * @var Favorite
     */
    protected $favorite;

   /**
       * @var Favorite
       */
    private $order;
    /**
     * @param UserRepository $users
     * @param RoleRepository $roles
     */
    public function __construct(UserRepository $users, RoleRepository $roles, Favorite $favorite,Order $order)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->favorite = $favorite;
        $this->order = $order;
    }

    /**
     * @param ManageUserRequest $request
     * @return ViewResponse
     */
    public function index(ManageUserRequest $request)
    {
        return new ViewResponse('backend.access.users.index');
    }

    /**
     * @param CreateUserRequest $request
     * @return CreateResponse
     */
    public function create(CreateUserRequest $request)
    {
        $roles = $this->roles->getAll();

        return new CreateResponse($roles);
    }

    /**
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $this->users->create($request);

        return new RedirectResponse(route('admin.access.user.index'),
            ['flash_success' => trans('alerts.backend.users.created')]
        );
    }

    /**
     * @param User $user
     * @param ShowUserRequest $request
     * @return ShowResponse
     */
    public function show(User $user, ShowUserRequest $request)
    {
        return new ShowResponse($user);
    }

    /**
     * @param User $user
     * @param EditUserRequest $request
     * @return EditResponse
     */
    public function edit(User $user, EditUserRequest $request)
    {
        $roles = $this->roles->getAll();
        $permissions = Permission::getSelectData('display_name');

        return new EditResponse($user, $roles, $permissions);
    }

    /**
     * @param User $user
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $this->users->update($user, $request);

        return new RedirectResponse(route('admin.access.user.index'),
            ['flash_success' => trans('alerts.backend.users.updated')]
        );
    }

    /**
     * @param User $user
     * @param DeleteUserRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(User $user, DeleteUserRequest $request)
    {
        $this->users->delete($user);

        return new RedirectResponse(route('admin.access.user.index'),
            ['flash_success' => trans('alerts.backend.users.deleted')]
        );
    }

     public function orderHistory(User $user, ManageUserRequest $request)
    {
         $orderhistory = $this->order
              ->where('user_id', $user['id'])
              ->where('order_id', '!=', null)
              ->with('product','orderDetails')
              ->get();
              //echo '<pre>'; print_r($orderhistory); exit;
            return view('backend.access.users.orderhistory', compact('orderhistory'));
    }

    /**
     * @param User $user
     * @param ManageUserRequest $request
     */
    public function wishList(User $user, ManageUserRequest $request)
    {
       $favorites = $this->favorite->with('user','product')->where('user_id',$user['id'])->get();
        return view('backend.access.users.wishlist', compact('favorites'));
    }
}
