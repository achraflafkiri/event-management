<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Rsvp;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        $events = Event::with('creator')->paginate(10);
        return response()->json($events);
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return response()->json($event->load('creator'), 201);
    }

    public function show(Event $event)
    {
        return response()->json($event->load('creator', 'rsvps.user'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return response()->json($event->load('creator'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }

    public function rsvp(Event $event)
    {
        if (!$event->hasAvailableSpots()) {
            return response()->json(['message' => 'Event is full'], 400);
        }

        if ($event->userHasRsvped(auth()->id())) {
            return response()->json(['message' => 'Already RSVP\'d'], 400);
        }

        Rsvp::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return response()->json(['message' => 'RSVP successful'], 201);
    }
}