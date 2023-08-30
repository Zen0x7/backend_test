<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\JwtToken;
use Illuminate\Support\Str;
use App\Services\Authentication;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\LogoutRequest;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LogoutRequest $request)
    {
        $token = Str::replaceFirst('Bearer ', '', $request->header('Authorization'));
        $token = Authentication::decode($token);

        $request->user()
            ->tokens()
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
