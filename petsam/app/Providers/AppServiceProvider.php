<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Listeners\LogEmailListener;
use App\Http\View\Composers\FooterComposer;
use Illuminate\Mail\Events\MessageSending;

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
        Schema::defaultStringLength(191);

        // Listen to email sending events and log them
        \Illuminate\Support\Facades\Event::listen(
            MessageSending::class,
            LogEmailListener::class
        );

        // Register footer view composer
        View::composer('layout.footer', FooterComposer::class);
    }
}
