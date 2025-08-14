<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'event_date', 'rsvp_limit', 'created_by'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'rsvps');
    }

    public function getRsvpCountAttribute()
    {
        return $this->rsvps()->count();
    }

    public function hasAvailableSpots()
    {
        return $this->rsvp_count < $this->rsvp_limit;
    }

    public function userHasRsvped($userId)
    {
        return $this->rsvps()->where('user_id', $userId)->exists();
    }

    public function getFormattedDateAttribute()
    {
        return $this->event_date->format('F j, Y \a\t g:i A');
    }
}