<?php

namespace Tests\Unit\Api\v1\Admin;

use App\Models\User;
use App\Services\Authentication;
use Tests\TestCase;

class UserListingTest extends TestCase
{
    public function test_authenticated_listing(): void
    {
        $user = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $token = Authentication::issue($user);

        $response = $this->json("GET", route("api::v1::admin::user-listing"), [], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful();
    }

    public function test_unauthorized_listing(): void
    {
        $response = $this->json("GET", route("api::v1::admin::user-listing"));

        $response->assertUnauthorized();
    }
}
