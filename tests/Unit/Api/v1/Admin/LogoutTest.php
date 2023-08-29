<?php

namespace Tests\Unit\Api\v1\Admin;

use App\Models\User;
use App\Services\Authentication;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $admin = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $token = Authentication::issue($admin);

        $response = $this->json('GET', route('api::v1::admin::logout'), [], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful();

        $response = $this->json('GET', route('api::v1::admin::user-listing'), ["Authorization" => "Bearer {$token}"]);

        $response->assertUnauthorized();
    }
}
