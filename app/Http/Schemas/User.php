<?php

namespace App\Http\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema]
class User {
    #[OA\Property(property: "id", type: "integer")]
    public $id;

    #[OA\Property(property: "uuid", type: "string")]
    public $uuid;

    #[OA\Property(property: "first_name", type: "string")]
    public $first_name;

    #[OA\Property(property: "last_name", type: "string")]
    public $last_name;

    #[OA\Property(property: "email", type: "string")]
    public $email;

    #[OA\Property(property: "email_verified_at", type: "string")]
    public $email_verified_at;

    #[OA\Property(property: "avatar", type: "string")]
    public $avatar;

    #[OA\Property(property: "address", type: "string")]
    public $address;

    #[OA\Property(property: "phone_number", type: "string")]
    public $phone_number;

    #[OA\Property(property: "is_marketing", type: "boolean")]
    public $is_marketing;

    #[OA\Property(property: "created_at", type: "string")]
    public $created_at;

    #[OA\Property(property: "updated_at", type: "string")]
    public $updated_at;

    #[OA\Property(property: "last_login_at", type: "string")]
    public $last_login_at;
}
