<?php

namespace Tests\Unit;

use Illuminate\Support\Str;

use function Pest\Laravel\{json};

it('should return valid VOL and HDR1 records when fast_payment is marked as false', function() {
    $serial_number = Str::upper(Str::random(6));
    $sun = Str::upper(Str::random(6));
    $creation_date = "2030-01-01";
    $expiration_at = "2030-01-05";

    json("GET", "/api/bacs?serial_number={$serial_number}&sun={$sun}&creation_date={$creation_date}&expiration_date={$expiration_at}&fast_payment=0")
        ->assertSee("VOL1")
        ->assertSee("HDR1A")
        ->assertSee($serial_number)
        ->assertSee($sun)
        ->assertSee("30001")
        ->assertSee("30005")
        ->assertSee("                                1")
        ->assertStatus(200);

});

it('should return valid VOL and HDR1 records when fast_payment is marked as true', function () {
    $serial_number = Str::upper(Str::random(6));
    $sun = Str::upper(Str::random(6));
    $year = now()->format('y');
    $day_of_year = str_pad(now()->dayOfYear, 3, "0", STR_PAD_LEFT);

    json("GET", "/api/bacs?serial_number={$serial_number}&sun={$sun}&fast_payment=1")
        ->assertSee("VOL1")
        ->assertSee("HDR1A")
        ->assertSee($serial_number)
        ->assertSee($sun)
        ->assertSee("{$year}{$day_of_year}")
        ->assertSee("                                1")
        ->assertStatus(200);
});

it('should return valid VOL and HDR1 records when sun is not defined and is marked as hsbc', function () {
    $serial_number = Str::upper(Str::random(6));
    $year = now()->format('y');
    $day_of_year = str_pad(now()->dayOfYear, 3, "0", STR_PAD_LEFT);

    json("GET", "/api/bacs?serial_number={$serial_number}&marker=hsbc&fast_payment=1")
        ->assertSee("VOL1")
        ->assertSee("HDR1A")
        ->assertSee($serial_number)
        ->assertSee('HSBC')
        ->assertSee("{$year}{$day_of_year}")
        ->assertSee("                                1")
        ->assertStatus(200);
});

it('should return valid VOL and HDR1 records when sun is not defined and is marked as sage', function () {
    $serial_number = Str::upper(Str::random(6));
    $creation_date = "2030-01-01";
    $expiration_at = "2030-01-05";

    json("GET", "/api/bacs?serial_number={$serial_number}&marker=sage&creation_date={$creation_date}&expiration_date={$expiration_at}&fast_payment=0")
        ->assertSee("VOL1")
        ->assertSee("HDR1A")
        ->assertSee($serial_number)
        ->assertSee('SAGE')
        ->assertSee("30001")
        ->assertSee("30005")
        ->assertSee("                                1")
        ->assertStatus(200);
});