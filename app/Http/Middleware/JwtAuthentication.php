<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Authentication;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\Authentication\Middleware\ValidatesToken;
use App\Traits\Authentication\Middleware\AuthorizeAccess;

class JwtAuthentication
{
    use ValidatesToken, AuthorizeAccess;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('Authorization')) {
            $token = Str::replaceFirst('Bearer ', '', $request->header('Authorization'));
            $token = Authentication::decode($token);

            return $this->validates($request, $next, $token);
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
