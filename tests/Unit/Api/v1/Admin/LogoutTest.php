<?php

namespace Tests\Unit\Api\v1\Admin;

use App\Models\User;
use App\Services\Authentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_token_expiration(): void
    {
        $admin = $this->createAdmin();

        $token = Authentication::issue($admin);

        $response = $this->json('GET', route('api::v1::admin::logout'), [], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful();

        $response = $this->json('GET', route('api::v1::admin::user-listing'), ["Authorization" => "Bearer {$token}"]);

        $response->assertUnauthorized();
    }
}
