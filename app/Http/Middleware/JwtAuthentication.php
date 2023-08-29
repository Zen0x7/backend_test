<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Authentication;
use App\Traits\Authentication\Middleware\AuthorizeAccess;
use App\Traits\Authentication\Middleware\ValidatesToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

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
