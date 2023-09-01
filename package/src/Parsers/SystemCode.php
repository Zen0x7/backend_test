<?php

namespace SpiritSaint\LaravelBacs\Parsers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SystemCode
{
    public static function fromRequest(Request $request): string
    {
        return $request->has('system_code') ? $request->input('system_code') : Str::random(13);
    }
}
