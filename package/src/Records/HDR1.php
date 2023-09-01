<?php

namespace SpiritSaint\LaravelBacs\Records;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HDR1
{
    public static function fromRequest(Request $request)
    {
        if (!$request->has('creation_date') || !$request->has('expiration_date') || !$request->has('fast_payment') || ($request->has('fast_payment') && (string) $request->input('fast_payment') == "1")) {
            $creation_date = now();
            $expiration_date = now();
        } else {
            $creation_date = Carbon::createFromFormat('Y-m-d', $request->input('creation_date'));
            $expiration_date = Carbon::createFromFormat('Y-m-d', $request->input('expiration_date'));
        }

        return implode([
            'HDR', // Label identifier
            '1', // Label number
            'A' . ($request->has('sun') ? $request->input('sun') : "      ") . 'S   ' . ($request->has('sun') ? $request->input('sun') : "      "), // File identifier
            $request->input('serial_number'), // Set identification
            '0001', // File section number
            '0001', // File sequence number
            $request->has('generation_number') ? $request->input('generation_number') : '    ', // Generation number
            $request->has('generation_version_number') ? $request->input('generation_version_number') : '  ', // Generation version number
            ' ' . $creation_date->startOfDay()->format('y') . str_pad($creation_date->dayOfYear, 3, "0", STR_PAD_LEFT), // Creating date
            ' ' . $expiration_date->startOfDay()->format('y') . str_pad($expiration_date->dayOfYear, 3, "0", STR_PAD_LEFT), // Expiration date
            '0', // Accessibility indicator
            '000000', // Block count
            $request->has('system_code') ? $request->input('system_code') : Str::random(13), // System Code
            '       '
        ]);
    }
}