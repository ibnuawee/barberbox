<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\BookingController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage.index');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('home', function(){
        return view('dashboard.home');
    })->name('home');

    Route::get('edit-profile', function(){
        return view('dashboard.profile');
    })->name('profile.edit');

    Route::resource('user', UserController::class);
    // Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    // Route::post('/user', [UserController::class, 'store'])->name('user.store');
    // Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    // Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    // Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/barber/available-schedule', [BookingController::class, 'availableSchedule'])->name('barber.availableSchedule');
    Route::get('/barber/available-services', [BookingController::class, 'availableServices'])->name('barber.availableServices');


    // Route untuk barber
        
    // Tambahkan route untuk fitur barber di sini
    Route::get('/barber', [BarberController::class, 'index'])->name('barber.index');
    Route::get('/barber/schedule', [BarberController::class, 'schedule'])->name('barber.schedule');
    // Route::post('/barber/set-schedule', [BarberController::class, 'setSchedule'])->name('barber.setSchedule');
    Route::post('/barber/schedule', [BarberController::class, 'setSchedule'])->name('barber.setSchedule');
    Route::get('/barber/price', [BarberController::class, 'Price'])->name('barber.Price');
    Route::post('/barber/price', [BarberController::class, 'setPrice'])->name('barber.setPrice');

});