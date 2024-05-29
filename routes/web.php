<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\BookingController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('home', function(){
        return view('dashboard.home');
    })->name('home');

    Route::get('edit-profile', function(){
        return view('dashboard.profile');
    })->name('profile.edit');

    Route::resource('user', UserController::class);
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/barbers', [BarberController::class, 'index'])->name('barbers.index');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    Route::get('/barbers/create', [BarberController::class, 'create'])->name('barbers.create');
    Route::post('/barbers', [BarberController::class, 'store'])->name('barbers.store');

});