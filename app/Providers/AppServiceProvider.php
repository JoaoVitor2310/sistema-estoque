<?php

namespace App\Providers;

use App\Models\Passport\Client;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        //

        Passport::useClientModel(Client::class);
        Passport::tokensExpireIn(now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addHours(24));
    }
}
