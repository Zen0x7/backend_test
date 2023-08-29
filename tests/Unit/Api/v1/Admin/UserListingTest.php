<?php

namespace Tests\Unit\Api\v1\Admin;

use App\Models\User;
use App\Services\Authentication;
use Tests\TestCase;

class UserListingTest extends TestCase
{
    public function test_should_respond_success(): void
    {
        $user = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $token = Authentication::issue($user);

        $response = $this->json("GET", route("api::v1::admin::user-listing"), [], ["Authorization" => "Bearer {$token}"]);
        $response->assertSuccessful()
            ->assertJsonStructure([
                "current_page",
                "data" => [
                    [
                        "uuid",
                        "first_name",
                        "last_name",
                        "email",
                        "email_verified_at",
                        "avatar",
                        "address",
                        "phone_number",
                        "is_marketing",
                        "created_at",
                        "updated_at",
                        "last_login_at",
                    ]
                ],
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "links" => [
                    ["url", "label", "active"]
                ],
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to",
                "total",
            ]);
    }

    public function test_should_respond_unauthorized(): void
    {
        $response = $this->json("GET", route("api::v1::admin::user-listing"));

        $response->assertUnauthorized();
    }
}
