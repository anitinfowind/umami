<?php

namespace App\Http\Controllers\Backend\Event;

use App\Http\Requests\Backend\Event\EventAddRequest;
use App\Http\Requests\Backend\Event\EventDeleteRequest;
use App\Http\Requests\Backend\Event\EventEditRequest;
use App\Http\Requests\Backend\Event\EventSaveRequest;
use App\Http\Requests\Backend\Event\EventShowRequest;
use App\Http\Requests\Backend\Event\EventUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Ramsey\Uuid\Uuid;
use File;

class EventController extends Controller
{
    /**
     * @var Diet
     */
    private $event;

    /**
     * @param Diet $diet
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param DietShowRequest $request
     * @return View
     */
    public function index(EventShowRequest $request)
    {
        $events = $this->event->orderby('id','DESC')->get();
        return view('backend.event.index',
            compact('events')
        );
    }

    /**
     * @param DietAddRequest $request
     * @return View
     */
    public function addEvent(EventAddRequest $request)
    {
        return view('backend.event.create');
    }

    /**
     * @param DietSaveRequest $request
     */
    public function saveEvent(EventSaveRequest $request)
    {
       
       $name='';
       if ($request->hasFile('event_image')) {
           $image = $request->file('event_image');
           $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
           $destinationPath = public_path('/uploads/event/');
           $image->move($destinationPath, $name);
        }

        $this->event->create([
            'title' => $request->title(),
            'slug' => $this->getSlug($request->title(),'','events'),
            'description' => $request->description,
            'image' => $name,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.event.index')
            ->with(['flash_success' => trans('Event has been successfully added.')]);
    }

    /**
     * @param DietEditRequest $request
     * @param int $id
     * @return View
     */
    public function editEvent(EventEditRequest $request, int $id)
    {
        $events = $this->event->find($id);
       //  echo '<pre>'; print_r($events['eventAllImage']);exit;

        return view('backend.event.edit',
            compact('events')
        );
    }

    /**
     * @param DietUpdateRequest $request
     * @param int $id
     */
    public function updateEvent(EventUpdateRequest $request, int $id)
    {
      $events=  $this->event->where('id', $id)->first();
      $events->title =$request->title();
      $events->description =$request->description;
      $events->status =$request->status;

        if ($request->hasFile('event_image')) {
           $eventimage= $this->event->where('id',$id)->first();

            if (File::exists(public_path('/uploads/event/'.$eventimage->image))) {
                  @unlink(public_path('/uploads/event/'.$eventimage->image));
              }
              $image = $request->file('event_image');
              $name = Uuid::uuid4()->toString().'.'.$image->getClientOriginalExtension();
              $destinationPath = public_path('/uploads/event/');
              $image->move($destinationPath, $name);
            $events->image= $name;
        }
      $events->save();

        return redirect()->route('admin.event.index')
            ->with(['flash_success' => trans('Event has been successfully updated.')]);
    }

    /**
     * @param DietDeleteRequest $request
     * @param int $id
     */
    public function deleteEvent(EventDeleteRequest $request, int $id)
    {     
        $eventimage= $this->event->find($id);
        if (File::exists(public_path('/uploads/event/'.$eventimage->image))) {
              @unlink(public_path('/uploads/event/'.$eventimage->image));
          }
        $this->event->find($id)->delete();
        return redirect()->route('admin.event.index')
            ->with(['flash_success' => trans('Event has been successfully deleted.')]);
    }

    /**
     * @param DietShowRequest $request
     * @param int $modelId
     * @param string $modelStatus
     */
}
