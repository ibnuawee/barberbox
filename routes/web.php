<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\FollowerController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage.index');
})->name('landingpage.index');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('home', function(){
        // return view('dashboard.home');
        $user = Auth::user();
        if ($user->role == 'user') {
            return redirect()->route('landingpage.index');
        } elseif (in_array($user->role, ['barber', 'admin'])) {
            return view('dashboard.home');
        } else {
            abort(403, 'Unauthorized action.');
        }
    })->name('home');

    Route::get('/customer/myprofile', function () {
        return view('dashboard.profileCustomer');
    })->name('profileCustomer.edit');

    Route::get('edit-profile', function(){
        $user = Auth::user();
        if ($user->role == 'user') {
            return redirect()->route('profileCustomer.edit');
        } elseif (in_array($user->role, ['barber', 'admin'])) {
            return view('dashboard.profile');
        } else {
            abort(403, 'Unauthorized action.');
        }
    })->name('profile.edit');

    Route::resource('user', UserController::class);
    // Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    // Route::post('/user', [UserController::class, 'store'])->name('user.store');
    // Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    // Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    // Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/profile/updatePicture', [App\Http\Controllers\UserController::class, 'updatePicture'])->name('profile.updatePicture');


    Route::get('/customer/mybooking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    // Route::get('/customer/mybooking/{booking}/detail', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/customer/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/barber/available-schedule', [BookingController::class, 'availableSchedule'])->name('barber.availableSchedule');
    Route::get('/barber/available-services', [BookingController::class, 'availableServices'])->name('barber.availableServices');

    Route::post('/booking/{booking}/accept', [BookingController::class, 'accept'])->name('booking.accept');
    Route::post('/booking/{booking}/complete', [BookingController::class, 'complete'])->name('booking.complete');
    Route::post('/booking/{booking}/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // Route untuk barber
        
    // Tambahkan route untuk fitur barber di sini
    Route::get('/barber', [BarberController::class, 'index'])->name('barber.index');
    Route::get('/barber/schedule', [BarberController::class, 'schedule'])->name('barber.schedule');
    // Route::post('/barber/set-schedule', [BarberController::class, 'setSchedule'])->name('barber.setSchedule');
    Route::post('/barber/schedule', [BarberController::class, 'setSchedule'])->name('barber.setSchedule');
    Route::get('/barber/price', [BarberController::class, 'Price'])->name('barber.Price');
    Route::post('/barber/price', [BarberController::class, 'setPrice'])->name('barber.setPrice');


    // Route Artikel
    Route::resource('articles', ArticleController::class);

    // Route Topup
    Route::get('/topups', [TopUpController::class, 'index'])->name('topups.index');
    Route::get('/topups/create', [TopUpController::class, 'create'])->name('topups.create');
    Route::post('/topups', [TopUpController::class, 'store'])->name('topups.store');
    Route::get('/topups/{id}/detail', [TopUpController::class, 'detail'])->name('topups.detail');
    Route::post('/topups/{id}/upload', [TopUpController::class, 'uploadProof'])->name('topups.uploadProof');
    Route::get('/topups/{id}/invoice', [TopUpController::class, 'generateInvoice'])->name('topups.invoice');


    // Route Admin
    Route::get('/admin/topups', [TopUpController::class, 'adminIndex'])->name('topups.admin_index');
    Route::patch('/topups/{topUp}/approve', [TopUpController::class, 'approve'])->name('topups.approve');
    Route::patch('/topups/{topUp}/reject', [TopUpController::class, 'reject'])->name('topups.reject');
        
    Route::resource('payments', PaymentMethodController::class)->except(['show', 'edit', 'update']);

    Route::get('/customer/saldo', [TransactionController::class, 'saldoUser'])->name('transactions.index');
    Route::get('/barber/saldo', [TransactionController::class, 'SaldoBarber'])->name('saldoBarber.index');
    Route::get('/admin/saldo', [TransactionController::class, 'SaldoAdmin'])->name('saldoAdmin.index');

    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    Route::get('/barber/{barber}', [BarberController::class, 'show'])->name('barber.show');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

    Route::post('/follow', [FollowerController::class, 'follow']);
    Route::delete('/unfollow', [FollowerController::class, 'unfollow']);
    Route::get('/followers/{barber_id}', [FollowerController::class, 'followers']);
    Route::get('/following/{user_id}', [FollowerController::class, 'following']);


});