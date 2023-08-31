<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[OA\Info(version: "1.0.0", title: "Pet Shop API - Swagger Documentation")]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
