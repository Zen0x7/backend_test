<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Services\Paginator;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\UserListingRequest;

use OpenApi\Attributes as OA;

class UserListingController extends Controller
{
    #[OA\Put(path: '/api/v1/admin/user-listing')]
    #[OA\Response(response: '200', description: 'Success')]
    #[OA\Response(response: '401', description: 'Unauthorized')]
    public function __invoke(UserListingRequest $request)
    {
        $users = User::query()
            ->where('is_admin', false)
            ->when(
                $request->has('sortBy'),
                fn ($q) => $q->sortBy(
                    $request->query('sortBy'),
                    $request->input('desc') === true ? 'desc' : 'asc'
                )
            )
            ->when(
                $request->has('first_name'),
                fn ($q) => $q->where('first_name', 'LIKE', "%{$request->query('first_name')}%")
            )
            ->when(
                $request->has('email'),
                fn ($q) => $q->where('email', 'LIKE', "%{$request->query('email')}%")
            )
            ->when(
                $request->has('phone'),
                fn ($q) => $q->where('phone', 'LIKE', "%{$request->query('phone')}%")
            )
            ->when(
                $request->has('address'),
                fn ($q) => $q->where('address', 'LIKE', "%{$request->query('address')}%")
            )
            ->when(
                $request->has('created_at'),
                fn ($q) => $q->whereBetween('created_at', [
                    Carbon::parse($request->input('created_at'))->startOfDay(),
                    Carbon::parse($request->input('created_at'))->endOfDay(),
                ])
            )
            ->when(
                $request->has('marketing'),
                fn ($q) => $q->where('is_marketing', $request->query('marketing'))
            )
            ->paginate(Paginator::fromRequest($request));

        return response()->json($users);
    }
}
