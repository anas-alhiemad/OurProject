<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Kernel\ApplicationAspectKernel;
use Illuminate\Container\Container;

class AspectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot()
    // {
        // // Initialize the aspect kernel
        // $applicationAspectKernel = ApplicationAspectKernel::getInstance();
        // $applicationAspectKernel->init([
        //     'debug'       => true, // Set to true for detailed logs
        //     'appDir'      => base_path(),
        //     'cacheDir'    => storage_path('aop'),
        // ]);
    // }

    /**
     * Register any application services.
     *
     * @return void
     */
    // public function register()
    // {
    //     //
    // }
}
