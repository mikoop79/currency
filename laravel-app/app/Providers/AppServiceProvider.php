<?php

namespace App\Providers;

use App\Services\ApiRequestService;
use App\Services\ReportGenerate\ReportGenerateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register the application fee budget service
        $this->app->singleton(ApiRequestService::class, function () {
            return new ApiRequestService();
        });

        $this->app->singleton(ReportGenerateService::class, function () {
            return new ReportGenerateService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
