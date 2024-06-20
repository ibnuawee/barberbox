<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'barber_id', 'service_id', 'haircut_name', 'booking_date', 'gender', 'status', 'invoice_number', 'total_price', 'confirmed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

}