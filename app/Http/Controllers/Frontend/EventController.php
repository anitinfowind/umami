<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * @var Event
     */
    private $event;

    /**
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @return View
     */
    public function show()
    {
        $events = $this->event->where('status', '1')->orderBy('created_at','DESC')->get();

        return view('frontend.event.event',
            compact('events')
        );
    }

    public function eventDetail(string $slug)
    {
		$events = $this->event->where('status', '1')->orderBy('created_at','DESC')->limit(5)->get();
        $detail = $this->event->where('slug', $slug)->first();
	  
		return view('frontend.event.event-detail',
            compact('detail', 'events')
        );
    }
}
