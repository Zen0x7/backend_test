<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Authentication;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthentication
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('Authorization')) {
            $token = Str::replaceFirst('Bearer ', '', $request->header('Authorization'));
            $token = Authentication::decode($token);

            if ($token && Authentication::validates($token)) {
                $user = Authentication::getUser($token);

                if ($user && Authentication::belongsTo($token, $user)) {
                    Auth::login($user);

                    if ($request->routeIs('api::v1::admin*') && ! $user->is_admin) {
                        return response()->json([
                            'success' => 0,
                            'data' => [],
                            'error' => 'Unauthorized',
                            'errors' => [],
                            'trace' => [],
                        ], 401);
                    }

                    return $next($request);
                }
            }
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
