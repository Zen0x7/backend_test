<?php

namespace Tests\Unit\Api\v1;


use App\Models\User;
use App\Services\Authentication;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    public function test_authenticated_index(): void
    {
        $user = User::query()
            ->where('email', 'admin@buckhill.co.uk')
            ->first();

        $token = Authentication::issue($user);

        $response = $this->json("GET", route("api::v1::products"), [], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful();
    }

    public function test_index(): void
    {
        $response = $this->json("GET", route("api::v1::products"));

        $response->assertSuccessful();
    }
}
