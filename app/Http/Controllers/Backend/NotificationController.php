<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Notification\MarkNotificationRequest;
use App\Models\Notification\Notification;
use App\Repositories\Backend\Notification\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * @var NotificationRepository
     */
    protected $notification;

    /**
     * NotificationController constructor.
     * @param NotificationRepository $notification
     */
    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @throws \Throwable
     */
    public function ajaxNotifications()
    {
        $userId = Auth::user()->id;
        $where = ['user_id' => $userId, 'is_read' => 0];
        $getUnreadNotificationCount = $this->notification->getNotification($where, 'count');
        $listWhere = ['user_id' => $userId, 'is_read' => 0];
        $getNotifications = $this->notification->getNotification($listWhere, 'get', $limit = 5);
        $passArray['view'] = view('backend.includes.notification')
                ->with('notifications', $getNotifications)
                ->with('unreadNotificationCount', $getUnreadNotificationCount)
                ->render();

        $passArray['count'] = $getUnreadNotificationCount;

        echo json_encode($passArray);
        die;
    }

    /*
     * clearCurrentNotifications
     */
    public function clearCurrentNotifications()
    {
        $userId = Auth::user()->id;
        echo $this->notification->clearNotifications(5);
        die;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', access()->user()->id)->get();

        return view('backend.notification.index', compact('notifications'));
    }

    /**
     * @param $id
     * @param $status
     * @param MarkNotificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function mark($id, $status, MarkNotificationRequest $request)
    {
        $this->notification->mark($id, $status);

        return response()->json(['status' => 'OK']);
    }
}
