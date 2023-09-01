<?php

namespace SpiritSaint\LaravelBacs\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '../../Routing/api.php');
    }

    public function register(): void
    {

    }
}