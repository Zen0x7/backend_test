<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Authentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_users_listing_of_non_admins(): void
    {
        $admin = $this->createAdmin();

        $token = Authentication::issue($admin);

        $users = \App\Models\User::factory(3)->create([
            "is_admin" => false
        ]);

        $response = $this->json("GET", route("api::v1::admin::user-listing"), [], ["Authorization" => "Bearer {$token}"]);
        $response->assertSuccessful();

        foreach ($users as $user) {
            $response->assertSee($user->email);
        }
    }

    public function test_edit_and_delete_user_accounts(): void
    {
        $admin = $this->createAdmin();

        $token = Authentication::issue($admin);
        $password = Str::random(32);

        $original = \App\Models\User::factory()
            ->create([
                "is_admin" => false
            ]);

        $new = \App\Models\User::factory()
            ->make();

        $response = $this->json("PUT", route("api::v1::admin::user-edit", $original), [
            'first_name' => $new->first_name,
            'last_name' => $new->last_name,
            'email' => $new->email,
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $new->address,
            'phone_number' => $new->phone_number,
        ], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful()
            ->assertSee($new->email)
            ->assertSee($new->first_name)
            ->assertSee($new->last_name);

        $response = $this->json(
            "DELETE",
            route("api::v1::admin::user-delete", $original),
            [],
            ["Authorization" => "Bearer {$token}"]
        );

        $response->assertSuccessful();

        $response = $this->json("PUT", route("api::v1::admin::user-edit", $original), [
            'first_name' => $new->first_name,
            'last_name' => $new->last_name,
            'email' => $new->email,
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $new->address,
            'phone_number' => $new->phone_number,
        ], ["Authorization" => "Bearer {$token}"]);

        $response->assertNotFound();
    }
}
