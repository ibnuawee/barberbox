<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public static $permision = [
        'dashboard' => ['barber', 'user'],
        'index-user' => [],
        'booking' => ['user'],
        'barber' => ['barber'],
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

        Gate::before(function(User $user){
            if($user->role === 'admin'){
                return true;
            }
        });

        foreach(self::$permision as $action => $roles) {
            Gate::define($action, function(User $user) use($roles){
                if(in_array($user->role, $roles)){
                    return true;
                }
            });
        }
    }
}
