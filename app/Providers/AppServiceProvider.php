<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;

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
         // This shares the variables with ALL blade files
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();

            // Limit to 5 latest notifications for the dropdown
            $notifications = $user->notifications()->latest()->take(5)->get();

            // Count unread
            $unreadCount = $user->unreadNotifications()->count();

            $view->with('notifications', $notifications)
                 ->with('unreadCount', $unreadCount);
        } else {
            // Fallback for login page so it doesn't crash
            $view->with('notifications', collect([]))
                 ->with('unreadCount', 0);
        }
    });

    Paginator::useTailwind();
    }
}
