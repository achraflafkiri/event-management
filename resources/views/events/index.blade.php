@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Upcoming Events</h1>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('events.create') }}" class="btn btn-primary">Create New Event</a>
                    @endif
                @endauth
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Filter Events</h5>
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" id="location" name="location" class="form-control" placeholder="Filter by location" 
                                   value="{{ request('location') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="sort" class="form-label">Sort by</label>
                            <select name="sort" id="sort" class="form-select">
                                <option value="event_date" {{ request('sort') == 'event_date' ? 'selected' : '' }}>Date</option>
                                <option value="location" {{ request('sort') == 'location' ? 'selected' : '' }}>Location</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="direction" class="form-label">Order</label>
                            <select name="direction" id="direction" class="form-select">
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Events List -->
            @if(isset($events) && $events->count() > 0)
                <div class="row">
                    @foreach($events as $event)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit($event->description, 100) }}</p>
                                    
                                    <div class="mt-auto">
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <strong>📅 {{ $event->formatted_date }}</strong><br>
                                                <strong>📍 {{ $event->location }}</strong><br>
                                                <strong>👥 {{ $event->rsvp_count }}/{{ $event->rsvp_limit }}</strong> attending
                                            </small>
                                        </p>
                                        
                                        @if($event->rsvp_count >= $event->rsvp_limit)
                                            <span class="badge bg-danger mb-2">Full</span>
                                        @elseif($event->rsvp_count > ($event->rsvp_limit * 0.8))
                                            <span class="badge bg-warning mb-2">Almost Full</span>
                                        @else
                                            <span class="badge bg-success mb-2">Available</span>
                                        @endif
                                        
                                        <div>
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-primary btn-sm">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="card">
                        <div class="card-body">
                            <h3>No Events Found</h3>
                            <p class="text-muted">There are currently no events available.</p>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('events.create') }}" class="btn btn-primary">Create the First Event</a>
                                @endif
                            @else
                                <p>Please <a href="{{ route('login') }}">login</a> to see more events or create an account.</p>
                            @endauth
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection