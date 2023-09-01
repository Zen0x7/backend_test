<?php

namespace SpiritSaint\LaravelBacs\Parsers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Dates
{
    public static function fromRequest(Request $request): string
    {
        if ((string) $request->input('fast_payment') === "1") {
            $creation_date = now();
            $expiration_date = now();
        } else {
            $creation_date = Carbon::createFromFormat('Y-m-d', $request->input('creation_date'));
            $expiration_date = Carbon::createFromFormat('Y-m-d', $request->input('expiration_date'));
        }
        return [$creation_date, $expiration_date];
    }
}
