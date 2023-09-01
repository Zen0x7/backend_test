<?php

namespace SpiritSaint\LaravelBacs\Records;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VOL
{
    public static function fromRequest(Request $request): string
    {
        return implode([
            'VOL', // Label identifier
            '1', // Label number
            $request->input('serial_number'), // Serial number
            '0', // Accessibility indicator
            '                    ', // Reserved field
            $request->has('sun') ? '      ' : Str::upper($request->input('marker')) . "  ", // Reserved field
            '    ', // Owner ID
            $request->has('sun') ? $request->input('sun') : "      ", // SUN or blank
            '    ', // Blank filled
            '                            ', // Reserved field
            '1', // Label standard level
        ]);
    }
}
