<?php

namespace Tests\Unit\Api\v1;


use App\Models\User;
use App\Services\Authentication;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    public function test_authenticated_index(): void
    {
        $admin = $this->createAdmin();

        $token = Authentication::issue($admin);

        $response = $this->json("GET", route("api::v1::products"), [], ["Authorization" => "Bearer {$token}"]);

        $response->assertSuccessful();
    }

    public function test_index(): void
    {
        $response = $this->json("GET", route("api::v1::products"));

        $response->assertSuccessful();
    }
}
