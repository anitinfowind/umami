<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Notification\Notification;
class NotificationController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
       $lists= Notification::with('getProductNotifi')->where('is_read',0)->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
          Notification::where('is_read',0)->where('user_id', auth()->user()->id)->update(['is_read'=>1]);
        return view('frontend.notification.index', compact('lists'));
    }

    public function singleView($id=null)
    {
      if($id=='all')
      {
         $lists= Notification::with('getProductNotifi')->where('is_read',0)->where('user_id', auth()->user()->id)->get();
          Notification::where('is_read',0)->where('user_id', auth()->user()->id)->update(['is_read'=>1]);
      }else{
          $lists= Notification::with('getProductNotifi')->where('id', $id)->get();
           Notification::where('id',$id)->update(['is_read'=>1]);
      }
        //echo '<pre>'; print_r($lists);exit;
          return view('frontend.notification.view', compact('lists')); 
    }
}
