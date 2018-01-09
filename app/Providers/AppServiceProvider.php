<?php

namespace App\Providers;

use App;
use App\Channel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function ($view) {
            $channels = \Cache::rememberForever('channels', function () {
                return Channel::all();
            });

            $view->with('channels', $channels);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (App::environment(['local', 'testing'])) {
            // \Debugbar::enable();

            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
