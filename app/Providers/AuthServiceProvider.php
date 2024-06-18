<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public static $permision = [
        'dashboard' => ['barber', 'user'],
        'index-user' => ['admin'],
        'create-user' => ['admin'],
        'index-article' => ['admin'],
        'create-article' => ['admin'],
        'show-article' => ['admin'],
        'edit-article' => ['admin'],
        'booking' => ['barber,user'],
        'barber-booking' => ['barber'],
        'barber-schedule' => ['barber'],
        'barber-Setschedule' => ['barber'],
        'barber-price' => ['barber'],
        'barber-setprice' => ['barber'],
        'barber-saldo' => ['barber'],
        'admin-saldo' => ['admin'],
        'kelola-topup' => ['admin'],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        // Gate::define('dashboard', function(User $user){
        //     if($user->role == 'superadmin' || $user->role == 'admin'){
        //         return true;
        //     }
        // });

        // Gate::define('booking', function(User $user){
        //     return $user->role === 'user';
        // });
        
        // Gate::define('barber', function(User $user){
        //     return $user->role === 'barber';
        // });

        // Gate::before(function(User $user){
        //     if($user->role === 'admin'){
        //         return true;
        //     }
        // });

        foreach(self::$permision as $action => $roles) {
            Gate::define($action, function(User $user) use($roles){
                if(in_array($user->role, $roles)){
                    return true;
                }
            });
        }
    }
}
