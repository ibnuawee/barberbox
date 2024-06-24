<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'barber_service')->withPivot('price');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'followers');
    }

    // TAK TAMBAH
    // follower
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'barber_id', 'user_id');
    }

    // rata2 rating
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

}