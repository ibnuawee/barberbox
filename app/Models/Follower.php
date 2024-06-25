<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    // Definisikan atribut yang boleh diisi
    protected $fillable = ['user_id', 'barber_id'];
}