<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'payment_method_id', 
        'amount', 
        'admin_fee', 
        'total_amount', 
        'payment_proof', 
        'status',
        'invoice',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    
}
