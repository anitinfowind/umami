<?php

namespace App\Http\Controllers\Backend\Access\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\Role\CreateRoleRequest;
use App\Http\Requests\Backend\Access\Role\DeleteRoleRequest;
use App\Http\Requests\Backend\Access\Role\EditRoleRequest;
use App\Http\Requests\Backend\Access\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Access\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Access\Role\UpdateRoleRequest;
use App\Http\Responses\Backend\Access\Role\CreateResponse;
use App\Http\Responses\Backend\Access\Role\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Access\Role\Role;
use App\Repositories\Backend\Access\Permission\PermissionRepository;
use App\Repositories\Backend\Access\Role\RoleRepository;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     * @var PermissionRepository
     */
    protected $permissions;

    /**
     * @param RoleRepository $roles
     * @param PermissionRepository $permissions
     */
    public function __construct(RoleRepository $roles, PermissionRepository $permissions)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * @param ManageRoleRequest $request
     * @return ViewResponse
     */
    public function index(ManageRoleRequest $request)
    {
        return new ViewResponse('backend.access.roles.index');
    }

    /**
     * @param CreateRoleRequest $request
     * @return CreateResponse
     */
    public function create(CreateRoleRequest $request)
    {
        return new CreateResponse($this->permissions, $this->roles);
    }

    /**
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(StoreRoleRequest $request)
    {
        $this->roles->create($request->all());

        return new RedirectResponse(route('admin.access.role.index'),
            ['flash_success' => trans('alerts.backend.roles.created')]
        );
    }

    /**
     * @param Role $role
     * @param EditRoleRequest $request
     * @return EditResponse
     */
    public function edit(Role $role, EditRoleRequest $request)
    {
        return new EditResponse($role, $this->permissions);
    }

    /**
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $this->roles->update($role, $request->all());

        return new RedirectResponse(route('admin.access.role.index'),
            ['flash_success' => trans('alerts.backend.roles.updated')]
        );
    }

    /**
     * @param Role $role
     * @param DeleteRoleRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Role $role, DeleteRoleRequest $request)
    {
        $this->roles->delete($role);

        return new RedirectResponse(route('admin.access.role.index'),
            ['flash_success' => trans('alerts.backend.roles.deleted')]
        );
    }
}
