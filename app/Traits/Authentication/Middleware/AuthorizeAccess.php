<?php

namespace App\Traits\Authentication\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

trait AuthorizeAccess
{
    public function authorize(Request $request, Closure $next, User $user)
    {
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
