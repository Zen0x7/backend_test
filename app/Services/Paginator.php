<?php

namespace App\Services;

use Illuminate\Http\Request;

class Paginator
{
    public static function fromRequest(Request $request)
    {
        return $request->has('limit') ? $request->input('limit') : 30;
    }
}
