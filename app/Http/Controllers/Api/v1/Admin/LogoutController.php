<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Admin;

use OpenApi\Attributes as OA;
use Illuminate\Support\Str;
use App\Services\Authentication;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\LogoutRequest;

class LogoutController extends Controller
{
    #[OA\Get(path: '/api/v1/admin/logout')]
    #[OA\Response(response: '200', description: 'Success')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
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
