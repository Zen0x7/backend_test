<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\UserListingRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserListingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserListingRequest $request)
    {
        $users = User::query()
//            ->where('is_admin', false)
            ->when(
                $request->has('sortBy'),
                fn ($q) => $q->sortBy(
                    $request->query('sortBy'),
                    $request->has('desc') ?
                        ((bool) $request->input('desc') === true ? 'desc' : 'asc') :
                        'asc'
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
            ->paginate($request->has('limit') ? $request->input('limit') : 30);

        return response()->json($users);
    }
}
