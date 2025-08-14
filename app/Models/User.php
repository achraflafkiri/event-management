<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ❌ REMOVE THIS METHOD - it was causing double hashing
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function rsvpedEvents()
    {
        return $this->belongsToMany(Event::class, 'rsvps');
    }
}