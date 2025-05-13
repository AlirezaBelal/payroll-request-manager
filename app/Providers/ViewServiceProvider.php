<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // دایرکتیو‌های Blade برای نمایش متناسب با نقش کاربر
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role == $role;
        });

        Blade::if('anyrole', function ($roles) {
            if (!auth()->check()) {
                return false;
            }

            $roles = is_array($roles) ? $roles : explode('|', $roles);

            return in_array(auth()->user()->role, $roles) || auth()->user()->role == 'super_admin';
        });
    }
}
