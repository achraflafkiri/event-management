@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1>{{ $event->name }}</h1>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <div>
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('events.destroy', $event) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <div class="mb-4">
                        <h6><i class="fas fa-calendar"></i> Date & Time</h6>
                        <p class="fs-5">{{ $event->formatted_date }}</p>
                    </div>

                    <div class="mb-4">
                        <h6><i class="fas fa-map-marker-alt"></i> Location</h6>
                        <p class="fs-5">{{ $event->location }}</p>
                    </div>

                    <div class="mb-4">
                        <h6><i class="fas fa-info-circle"></i> Description</h6>
                        <p>{{ $event->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h6><i class="fas fa-users"></i> Attendance</h6>
                        <p>{{ $event->rsvp_count }} out of {{ $event->rsvp_limit }} spots filled</p>
                        
                        <div class="progress mb-3" style="height: 20px;">
                            <div class="progress-bar {{ $event->rsvp_count >= $event->rsvp_limit ? 'bg-danger' : 'bg-success' }}" 
                                 style="width: {{ $event->rsvp_limit > 0 ? ($event->rsvp_count / $event->rsvp_limit) * 100 : 0 }}%">
                                {{ $event->rsvp_limit > 0 ? round(($event->rsvp_count / $event->rsvp_limit) * 100) : 0 }}%
                            </div>
                        </div>
                        
                        @if($event->rsvp_count >= $event->rsvp_limit)
                            <span class="badge bg-danger fs-6">Event Full</span>
                        @endif
                    </div>

                    @auth
                        @if(!$userHasRsvped && $event->hasAvailableSpots())
                            <form method="POST" action="{{ route('events.rsvp', $event) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg">RSVP to this Event</button>
                            </form>
                        @elseif($userHasRsvped)
                            <div class="alert alert-success">
                                <strong>✅ You are attending this event!</strong>
                            </div>
                            <form method="POST" action="{{ route('events.rsvp.cancel', $event) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">Cancel RSVP</button>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                <strong>⚠️ This event is full.</strong>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a> to RSVP to this event.
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Event Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Created by:</strong> {{ $event->creator->name }}</p>
                    <p><strong>Created:</strong> {{ $event->created_at->format('M j, Y') }}</p>
                    <p><strong>Status:</strong> 
                        @if($event->rsvp_count >= $event->rsvp_limit)
                            <span class="badge bg-danger">Full</span>
                        @else
                            <span class="badge bg-success">Open</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($event->rsvps->count() > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6>Attendees ({{ $event->rsvps->count() }})</h6>
                    </div>
                    <div class="card-body">
                        @foreach($event->rsvps->take(10) as $rsvp)
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" 
                                     style="width: 32px; height: 32px; font-size: 14px;">
                                    {{ substr($rsvp->user->name, 0, 1) }}
                                </div>
                                <span class="ms-2">{{ $rsvp->user->name }}</span>
                            </div>
                        @endforeach
                        
                        @if($event->rsvps->count() > 10)
                            <small class="text-muted">And {{ $event->rsvps->count() - 10 }} more...</small>
                        @endif
                    </div>
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('events.index') }}" class="btn btn-secondary w-100">← Back to Events</a>
            </div>
        </div>
    </div>
</div>
@endsection