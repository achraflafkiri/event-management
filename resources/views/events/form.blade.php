<div class="form-group mb-3">
    <label for="name" class="form-label">Event Name *</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" 
           id="name" name="name" value="{{ old('name', $event->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="description" class="form-label">Description *</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" name="description" rows="4" required>{{ old('description', $event->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="location" class="form-label">Location *</label>
    <input type="text" class="form-control @error('location') is-invalid @enderror" 
           id="location" name="location" value="{{ old('location', $event->location ?? '') }}" required>
    @error('location')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="event_date" class="form-label">Event Date & Time *</label>
    <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" 
           id="event_date" name="event_date" 
           value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d\TH:i') : '') }}" required>
    @error('event_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="rsvp_limit" class="form-label">RSVP Limit *</label>
    <input type="number" class="form-control @error('rsvp_limit') is-invalid @enderror" 
           id="rsvp_limit" name="rsvp_limit" value="{{ old('rsvp_limit', $event->rsvp_limit ?? 100) }}" 
           min="1" max="1000" required>
    @error('rsvp_limit')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Maximum number of people who can RSVP (1-1000)</div>
</div>