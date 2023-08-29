<?php

namespace Tests\Unit\Api\v1\Admin;


use App\Models\File;
use App\Models\User;
use App\Services\Authentication;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_should_respond_success(): void
    {
        $admin = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $token = Authentication::issue($admin);

        $fake = User::factory()->make();

        $file = File::query()
            ->create([
                'uuid' => Str::uuid(),
                'name' => "{$fake->first_name}'s avatar",
                'path' => storage_path(Str::uuid() . '.png'),
                'size' => '7Kb',
                'type' => 'application/image',
            ]);

        $response = $this->json('POST', route('api::v1::admin::create'), [
            'first_name' => $fake->first_name,
            'last_name' => $fake->last_name,
            'email' => $fake->email,
            'password' => 'admin',
            'password_confirmation' => 'admin',
            'avatar' => $file->uuid,
            'address' => $fake->address,
            'phone_number' => $fake->phone_number,
        ], ['Authorization' => "Bearer {$token}"]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'uuid',
                    'first_name',
                    'last_name',
                    'email',
                    'phone_number',
                    'updated_at',
                    'created_at',
                    'token',
                ],
                'error',
                'errors',
                'extra',
            ]);
    }

    public function test_should_respond_unauthorized(): void
    {
        $response = $this->json("POST", route("api::v1::admin::create"));

        $response->assertUnauthorized();
    }
}
