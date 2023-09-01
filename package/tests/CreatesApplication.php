<?php

declare(strict_types=1);

namespace Tests;

trait CreatesApplication
{

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication(): \Illuminate\Foundation\Application
    {
        $app = parent::createApplication();

        return $app;
    }

    protected function getPackageProviders($app): array
    {
        return ['SpiritSaint\LaravelBacs\Providers\ServiceProvider'];
    }
}