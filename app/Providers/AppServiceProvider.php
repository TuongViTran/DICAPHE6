<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

use App\Models\User;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $unreadCount = Notification::where('user_id', Auth::id())
                                    ->where('is_read', false)
                                    ->count();
                $view->with('unreadCount', $unreadCount);
            }
        });
        View::composer('*', function ($view) {
            $admin = User::where('role', 'admin')->first();
            $adminAvatar = $admin?->avatar_url;
            $adminName = $admin?->full_name;
    
            $view->with('adminAvatar', $adminAvatar);
            $view->with('adminName', $adminName);
        });
    }
    
}
