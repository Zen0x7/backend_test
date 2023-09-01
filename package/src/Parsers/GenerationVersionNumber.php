<?php

namespace SpiritSaint\LaravelBacs\Parsers;

use Illuminate\Http\Request;

class GenerationVersionNumber
{
    public static function fromRequest(Request $request): string
    {
        return $request->has('generation_version_number') ? $request->input('generation_version_number') : '  ';
    }
}
