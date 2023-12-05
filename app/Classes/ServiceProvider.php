<?php

namespace App\Classes;

use App\Classes\Services as Service;
use App\Classes\Services\Interfaces as IService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider as LServiceProvider;

class ServiceProvider extends LServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(IService\IProjectService::class, Service\ProjectService::class);
    }
}
