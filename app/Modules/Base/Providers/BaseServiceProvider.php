<?php

namespace App\Modules\Base\Providers;

use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Databases/Migrations');
        // $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        // $this->loadViewsFrom(__DIR__.'/../Views', 'base');
    }
}