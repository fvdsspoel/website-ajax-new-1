<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Website back office: only an owner may give codes to new people or remove a login.
        \Illuminate\Support\Facades\Gate::define('owner', fn (\App\Models\User $user) => $user->isOwner());
    }
}
