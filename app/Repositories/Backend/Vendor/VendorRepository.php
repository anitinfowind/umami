<?php

namespace App\Repositories\Backend\Vendor;

use DB;
use Carbon\Carbon;
use App\Models\Vendor\Vendor;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Events\Backend\Access\User\UserUpdated;

/**
 * Class VendorRepository.
 */
class VendorRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Vendor::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        return $this->query()
           ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
            ->select([
               config('access.users_table').'.id',
                config('access.users_table').'.first_name',
                config('access.users_table').'.last_name',
                config('access.users_table').'.email',
                config('access.users_table').'.status',
                config('access.users_table').'.confirmed',
                config('access.users_table').'.slug',
                config('access.users_table').'.created_at',
                config('access.users_table').'.updated_at',
                config('access.users_table').'.deleted_at',
            ])
             ->where('role_user.role_id',2);
              if ($trashed == 'true') {
            return $dataTableQuery->onlyTrashed();
        }

        // active() is a scope on the UserScope trait
        return $dataTableQuery->active($status);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        if (Vendor::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.vendors.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Vendor $vendor
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Vendor $vendor, $request)
    {
      $data = $request->except('assignees_roles', 'permissions');
        $roles = $request->get('assignees_roles');
        $permissions = $request->get('permissions');

         DB::transaction(function () use ($vendor, $data, $roles, $permissions) {
            if ($vendor->update($data)) {
                $vendor->status = isset($data['status']) && $data['status'] == '1' ? 1 : 0;
                $vendor->confirmed = isset($data['confirmed']) && $data['confirmed'] == '1' ? 1 : 0;

                $vendor->save();
                event(new UserUpdated($vendor));

                return true;
            }

           throw new GeneralException(trans('exceptions.backend.vendors.update_error'));
        });
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Vendor $vendor
     * @throws GeneralException
     * @return bool
     */
    public function delete(Vendor $vendor)
    {
        if ($vendor->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.vendors.delete_error'));
    }
}
