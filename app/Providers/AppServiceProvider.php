<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Repositories\ZktecoConnect;
use App\Repositories\Contracts\ZktecoConnectInterface;
use App\Repositories\ZktecoUser;
use App\Repositories\Contracts\ZktecoUserInterface;
use App\Repositories\ZktecoAttendance;
use App\Repositories\Contracts\ZktecoAttendanceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ZktecoConnectInterface::class, ZktecoConnect::class);
        $this->app->bind(ZktecoUserInterface::class, ZktecoUser::class);
        $this->app->bind(ZktecoAttendanceInterface::class, ZktecoAttendance::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('globalCompanyName', 'ABC Corporation');
            $view->with('globalDeviceStatus', 'Active');
            $view->with('current_device_id', session('current_device_id')); // ✅ সরাসরি session
        });
    }
}
