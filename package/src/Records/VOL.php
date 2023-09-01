<?php

namespace SpiritSaint\LaravelBacs\Records;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VOL
{
    public static function fromRequest(Request $request)
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