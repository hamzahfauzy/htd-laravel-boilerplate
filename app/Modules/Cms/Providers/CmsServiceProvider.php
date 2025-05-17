<?php

namespace App\Modules\Cms\Providers;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Databases/Migrations');
        // $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        // $this->loadViewsFrom(__DIR__.'/../Resources/views', 'cms');
    }
}