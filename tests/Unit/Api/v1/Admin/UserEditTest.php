<?php

namespace Tests\Unit\Api\v1\Admin;

use App\Models\User;
use App\Services\Authentication;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserEditTest extends TestCase
{
    public function test_should_respond_success(): void
    {
        $admin = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $user = User::factory()->create([
            "is_admin" => false,
        ]);

        $token = Authentication::issue($admin);

        $fake = User::factory()->make();
        $password = Str::random();

        $response = $this->json("PUT", route("api::v1::admin::user-edit", $user), [
            'first_name' => $fake->first_name,
            'last_name' => $fake->last_name,
            'email' => $fake->email,
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $fake->address,
            'phone_number' => $fake->phone_number,
        ], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                "success",
                "data" => [
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
                ],
                "error",
                "errors",
                "extra",
            ]);
    }

    public function test_should_respond_unauthorized(): void
    {
        $user = User::query()->latest()->first();

        $response = $this->json("PUT", route("api::v1::admin::user-edit", $user));

        $response->assertUnauthorized();
    }
}
