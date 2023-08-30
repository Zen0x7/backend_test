<?php

namespace Tests\Unit\Api\v1\Admin;

use App\Models\User;
use App\Services\Authentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_respond_success(): void
    {
        $admin = $this->createAdmin();

        $user = User::factory()->create([
            "is_admin" => false,
        ]);

        $token = Authentication::issue($admin);

        $response = $this->json("DELETE", route("api::v1::admin::user-delete", $user), [], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                "success",
                "data",
                "error",
                "errors",
                "extra",
            ]);
    }

    public function test_should_respond_unauthorized(): void
    {
        $user = User::factory()->create([
            "is_admin" => false,
        ]);

        $response = $this->json("DELETE", route("api::v1::admin::user-delete", $user));

        $response->assertUnauthorized();
    }
}
