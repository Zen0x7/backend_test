<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class ApiPrefixTest extends TestCase
{
    public function test_routes_includes_api_prefix(): void
    {
        $this->assertTrue(Str::contains(route('api::v1::admin::login'), '/api/v1'));
        $this->assertTrue(Str::contains(route('api::v1::admin::user-listing'), '/api/v1'));
    }
}
