<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\LogoutRequest;
use App\Models\JwtToken;
use App\Services\Authentication;
use Illuminate\Support\Str;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LogoutRequest $request)
    {
        $token = Str::replaceFirst('Bearer ', '', $request->header('Authorization'));
        $token = Authentication::decode($token);

        JwtToken::query()
            ->where('unique_id', $token->claims()->get('unique_id'))
            ->update([
                'expires_at' => now(),
            ]);

        return response()->json([
            'success' => 1,
            'data' => [],
            'error' => null,
            'errors' => [],
            'trace' => [],
        ]);
    }
}
