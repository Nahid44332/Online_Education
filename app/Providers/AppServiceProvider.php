<?php

namespace App\Providers;

use App\Models\Notice;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // সব ভিউতে notice count পাঠানো
        View::composer('*', function ($view) {
            $noticeCount = Notice::where('status', 1)->count();
            $view->with('noticeCount', $noticeCount);
            $view->with('sitesettings', Settings::first());
            $view->with('admin', Auth::user());
        });
    }
}
