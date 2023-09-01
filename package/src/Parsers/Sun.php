<?php

namespace SpiritSaint\LaravelBacs\Parsers;

use Illuminate\Http\Request;

class Sun
{
    public static function fromRequest(Request $request): string
    {
        return $request->has('sun') ? $request->input('sun') : "      ";
    }
}
