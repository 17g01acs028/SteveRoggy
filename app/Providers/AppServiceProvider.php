<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Horizon\Horizon;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      // Schema::defaultStringLength(191);
      Horizon::auth(function ($request) {
        $user = Auth::user();
          // Always show admin if local development
        //   if (env('APP_ENV') == 'production') {
        //       return true;
        //   }
          if ($user->hasRole('super-admin|admin|manager')) {
              return true;
          }
      });
    }
}
