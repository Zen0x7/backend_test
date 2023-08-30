<?php

namespace App\Traits\Authentication\Middleware;

use App\Services\Authentication;
use Closure;
use Illuminate\Http\Request;
use Lcobucci\JWT\Token;

trait ValidatesToken
{
    public function validates(
        Request $request,
        Closure $next,
        Token|null $token
    ) {
        if (Authentication::validates($token)) {
            $user = Authentication::getUser($token);
            return $this->authorize($request, $next, $user);
        }
        return response()->json([
            'success' => 0,
            'data' => [],
            'error' => 'Unauthorized',
            'errors' => [],
            'trace' => [],
        ], 401);
    }
}
