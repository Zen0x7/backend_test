<?php

namespace App\Services;

class UUID
{
    public static function retrieve(): string
    {
        return match (env('APP_ENV')) {
            "production" => env('PRODUCTION_ENV_UUID'),
            "staging" => env('STAGING_ENV_UUID'),
            default => env('DEVELOPMENT_ENV_UUID'),
        };
    }
}
