<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GenderApi\Client as GenderApiClient;

/**
 * Application service provider.
 *
 * @author Erik Galloway <erik@fliplearning.com>
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(GenderApiClient::class, function () {
            return new GenderApiClient(config('services.gender.key'));
        });
    }
}
