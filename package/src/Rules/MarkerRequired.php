<?php

namespace SpiritSaint\LaravelBacs\Rules;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class MarkerRequired
{
    public static function validates(\Illuminate\Http\Request $request): RequiredIf
    {
        return Rule::requiredIf(
            fn () => !$request->has('sun')
        );
    }
}
