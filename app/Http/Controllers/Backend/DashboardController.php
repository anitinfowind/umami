<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Settings\Setting;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $usercount = DB::table('users')
                        ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                        ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                        ->where('roles.id',3)
                        ->count();

        $vendorcount = DB::table('users')
                            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                            ->where('roles.id',2)->count();

        $settingData = Setting::first();
        $google_analytics = $settingData->google_analytics;

        return view('backend.dashboard',
            compact('google_analytics', $google_analytics,'usercount','vendorcount')
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function editProfile(Request $request)
    {
        return view('backend.access.users.profile-edit')->withLoggedInUser(access()->user());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateProfile(Request $request)
    {
         $request->validate([
                'first_name'=>'required',
                'last_name'=>'required'
              ]);

        $input = $request->all();
        $userId = access()->user()->id;
        $user = User::find($userId);
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->updated_by = access()->user()->id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = rand(1111,9999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/user/');
            $image->move($destinationPath, $name);
            $user->image=$name;
        }

        if ($user->save()) {
            return redirect()->route('admin.profile.edit')
                ->withFlashSuccess(trans('labels.backend.profile_updated'));
        }
    }

    /**
     * @param Request $request
     */
    public function getPermissionByRole(Request $request)
    {
        if ($request->ajax()) {
            $role_id = $request->get('role_id');
            $rsRolePermissions = Role::where('id', $role_id)->first();
            $rolePermissions = $rsRolePermissions->permissions->pluck('display_name', 'id')->all();
            $permissions = Permission::pluck('display_name', 'id')->all();
            ksort($rolePermissions);
            ksort($permissions);
            $results['permissions'] = $permissions;
            $results['rolePermissions'] = $rolePermissions;
            $results['allPermissions'] = $rsRolePermissions->all;
            echo json_encode($results);
            die;
        }
    }

    /**
     * @return View
     */
     public function commission()
     {
         $getcomm= DB::table('commissions')->first();

         return view('backend.commission.index',
             compact('getcomm')
         );
     }

    /**
     * @return View
     */
     public function commissionCreate()
     {
         return view('backend.commission.create');
     }

    /**
     * @param Request $request
     * @return mixed
     */
     public function  commissionStore(Request $request)
     {
         $request->validate([
            'site_commission' => 'required|numeric',
            'vendor_commission' => 'required|numeric',
         ]);
        $comm = array(
                'site_commission' => $request->site_commission,
                'vendor_commission' => $request->vendor_commission
        );

        DB::table('commissions')->insert($comm);

        return redirect()->to('/admin/commission')
            ->withFlashSuccess('Commission add successfully');
     }

    /**
     * @param null $id
     * @return View
     */
     public function commissionEdit($id=null)
     {
         $editcomm=DB::table('commissions')->where('id',$id)->first();

         return view('backend.commission.edit', compact('editcomm'));
     }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
     public function commissionUpdate(Request $request,$id=null)
     {
         $updatecomm = array(
                        'site_commission' => $request->site_commission,
                        'vendor_commission' => $request->vendor_commission
         );

        DB::table('commissions')->where('id',$id)->update($updatecomm);

        return redirect()->to('/admin/commission')
            ->withFlashSuccess('Commission update successfully');
    }
}
