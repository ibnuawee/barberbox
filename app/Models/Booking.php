<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barber_id',
        'booking_time',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
