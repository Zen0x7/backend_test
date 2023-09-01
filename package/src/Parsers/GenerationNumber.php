<?php

namespace SpiritSaint\LaravelBacs\Parsers;

use Illuminate\Http\Request;

class GenerationNumber
{
    public static function fromRequest(Request $request): string
    {
        return $request->has('generation_number') ? $request->input('generation_number') : '    ';
    }
}
