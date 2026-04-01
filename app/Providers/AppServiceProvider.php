<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        error_reporting(E_ALL & ~E_DEPRECATED);
        $countries = collect();

        try {
            if (Schema::hasTable('countrycode')) {
                $countries = DB::table('countrycode')
                    ->select('name')
                    ->where('enable', 'yes')
                    ->groupBy('name')
                    ->pluck('name');
            }
        } catch (\Throwable $e) {
            // Keep countries empty if DB is unavailable during startup.
        }

        view()->share(['countries' => $countries]);
    }
}
