<?php

namespace SpiritSaint\LaravelBacs\Records;

use Illuminate\Http\Request;
use SpiritSaint\LaravelBacs\Parsers\Sun;
use SpiritSaint\LaravelBacs\Parsers\Dates;
use SpiritSaint\LaravelBacs\Parsers\SystemCode;
use SpiritSaint\LaravelBacs\Parsers\GenerationNumber;
use SpiritSaint\LaravelBacs\Parsers\GenerationVersionNumber;

class HDR1
{
    public static function fromRequest(Request $request): string
    {
        $dates = Dates::fromRequest($request);

        $creation_date = $dates[0];
        $expiration_date = $dates[1];

        return implode([
            'HDR', // Label identifier
            '1', // Label number
            'A' . Sun::fromRequest($request) . 'S   ' .  Sun::fromRequest($request), // File identifier
            $request->input('serial_number'), // Set identification
            '0001', // File section number
            '0001', // File sequence number
            GenerationNumber::fromRequest($request), // Generation number
            GenerationVersionNumber::fromRequest($request), // Generation version number
            ' ' . $creation_date->startOfDay()->format('y') . str_pad($creation_date->dayOfYear, 3, "0", STR_PAD_LEFT), // Creating date
            ' ' . $expiration_date->startOfDay()->format('y') . str_pad($expiration_date->dayOfYear, 3, "0", STR_PAD_LEFT), // Expiration date
            '0', // Accessibility indicator
            '000000', // Block count
            SystemCode::fromRequest($request), // System Code
            '       '
        ]);
    }
}
