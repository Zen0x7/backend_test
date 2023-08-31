<?php

namespace App\Http\Controllers\Api\v1\Admin;

use OpenApi\Attributes as OA;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\UserDeleteRequest;

class UserDeleteController extends Controller
{
    #[OA\Get(path: '/api/v1/admin/user-delete/{uuid}', parameters: [
        new OA\Parameter(name: "uuid", in: "path", required: true, schema: new OA\Schema(type: "string"))
    ])]
    #[OA\Response(response: '200', description: 'Success')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    public function __invoke(UserDeleteRequest $request, User $user)
    {
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'success' => 1,
            'data' => [],
            'error' => null,
            'errors' => [],
            'extra' => [],
        ]);
    }
}
