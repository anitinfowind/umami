<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Settings\Setting;
use Illuminate\Http\Request;
use DB;
use App\Models\Admin_notification;

class NotificationsController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $notifications = Admin_notification::where('status', '0')->orderBy('created_at', 'desc')->get();

        return view('backend.notifications',
            compact('notifications')
        );
    }


    public function set_notification(Request $request)
    {
        $notification_id = $request->input('notification_id');
        $status = $request->input('status');
        Admin_notification::where('id', $notification_id)->update(['status' => $status]);
        return response()->json(['success' => 1, 'message' => '']);
    }


}
