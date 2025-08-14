<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Event $event)
    {
        // Check if event has available spots
        if (!$event->hasAvailableSpots()) {
            return back()->with('error', 'This event is full!');
        }

        // Check if user already RSVP'd
        if ($event->userHasRsvped(auth()->id())) {
            return back()->with('error', 'You are already registered for this event!');
        }

        Rsvp::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'You have successfully registered for this event!');
    }

    public function destroy(Event $event)
    {
        $rsvp = Rsvp::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->first();

        if ($rsvp) {
            $rsvp->delete();
            return back()->with('success', 'RSVP cancelled successfully!');
        }

        return back()->with('error', 'RSVP not found!');
    }
}