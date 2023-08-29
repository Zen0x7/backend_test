<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Authentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class MiddlewareProtectionTest extends TestCase
{
    public function test_routes_are_xss_injection_secured(): void
    {
        $injection = "<p></p>";

        $admin = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $user = User::query()->latest()->first();

        $user->update([
            'is_admin' => false,
        ]);

        $token = Authentication::issue($admin);

        $fake = User::factory()->make();
        $password = Str::random();

        $response = $this->json("PUT", route("api::v1::admin::user-edit", $user), [
            'first_name' => $fake->first_name,
            'last_name' => $fake->last_name . $injection,
            'email' => $fake->email,
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $fake->address,
            'phone_number' => $fake->phone_number,
        ], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful()
            ->assertSee($fake->last_name)
            ->assertDontSee($injection);
    }

    public function test_admin_routes_are_only_accessed_by_admins(): void
    {
        $admin = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $non_authorized = \App\Models\User::factory()->create([
            "is_admin" => false
        ]);

        $other = \App\Models\User::factory()->create([
            "is_admin" => false
        ]);

        $non_authorized_token = Authentication::issue($non_authorized);
        $authorized_token = Authentication::issue($admin);

        $fake = \App\Models\User::factory()->make([
            "is_admin" => false
        ]);

        $password = Str::random();

        $response = $this->json("PUT", route("api::v1::admin::user-edit", $other), [
            'first_name' => $fake->first_name,
            'last_name' => $fake->last_name,
            'email' => $fake->email,
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $fake->address,
            'phone_number' => $fake->phone_number,
        ], ["Authorization" => "Bearer {$non_authorized_token}"]);

        $response->assertForbidden();

        $response = $this->json("PUT", route("api::v1::admin::user-edit", $other), [
            'first_name' => $fake->first_name,
            'last_name' => $fake->last_name,
            'email' => $fake->email,
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $fake->address,
            'phone_number' => $fake->phone_number,
        ], ["Authorization" => "Bearer {$authorized_token}"]);

        $response->assertSuccessful();
    }
}
