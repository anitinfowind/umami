<?php

namespace App\Http\Controllers\Backend\Access\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\Permission\CreatePermissionRequest;
use App\Http\Requests\Backend\Access\Permission\DeletePermissionRequest;
use App\Http\Requests\Backend\Access\Permission\EditPermissionRequest;
use App\Http\Requests\Backend\Access\Permission\ManagePermissionRequest;
use App\Http\Requests\Backend\Access\Permission\StorePermissionRequest;
use App\Http\Requests\Backend\Access\Permission\UpdatePermissionRequest;
use App\Http\Responses\Backend\Access\Permission\CreateResponse;
use App\Http\Responses\Backend\Access\Permission\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Access\Permission\Permission;
use App\Repositories\Backend\Access\Permission\PermissionRepository;

class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $permissions;

    /**
     * @param PermissionRepository $permissions
     */
    public function __construct(PermissionRepository $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @param ManagePermissionRequest $request
     * @return ViewResponse
     */
    public function index(ManagePermissionRequest $request)
    {
        return new ViewResponse('backend.access.permissions.index');
    }

    /**
     * @param CreatePermissionRequest $request
     * @return CreateResponse
     */
    public function create(CreatePermissionRequest $request)
    {
        return new CreateResponse($this->permissions);
    }

    /**
     * @param StorePermissionRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(StorePermissionRequest $request)
    {
        $this->permissions->create($request->all());

        return new RedirectResponse(route('admin.access.permission.index'),
            ['flash_success' => trans('alerts.backend.permissions.created')]
        );
    }

    /**
     * @param Permission $permission
     * @param EditPermissionRequest $request
     * @return EditResponse
     */
    public function edit(Permission $permission, EditPermissionRequest $request)
    {
        return new EditResponse($permission);
    }

    /**
     * @param Permission $permission
     * @param UpdatePermissionRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $this->permissions->update($permission, $request->all());

        return new RedirectResponse(route('admin.access.permission.index'),
            ['flash_success' => trans('alerts.backend.permissions.updated')]
        );
    }

    /**
     * @param Permission $permission
     * @param DeletePermissionRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Permission $permission, DeletePermissionRequest $request)
    {
        $this->permissions->delete($permission);

        return new RedirectResponse(route('admin.access.permission.index'),
            ['flash_success' => trans('alerts.backend.permissions.deleted')]
        );
    }
}
