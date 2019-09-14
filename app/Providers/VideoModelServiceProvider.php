<?php

namespace App\Providers;
use App\Video;
use Illuminate\Support\ServiceProvider;

class VideoModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Video::observe(\App\Observers\VideoObserver::class);
    }
}
