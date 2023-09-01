<?php

namespace SpiritSaint\LaravelBacs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SpiritSaint\LaravelBacs\Rules\SunRequired;
use SpiritSaint\LaravelBacs\Rules\FasterPayment;
use SpiritSaint\LaravelBacs\Rules\MarkerRequired;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serial_number' => [
                'required', 'alpha_num', 'size:6'
            ],
            'marker' => [
                MarkerRequired::validates($this),
                'in:hsbc,sage'
            ],
            'sun' => [
                SunRequired::validates($this),
                'size:6'
            ],
            'generation_number' => [
                'nullable',
                'numeric',
                'size:4',
            ],
            'generation_version_number' => [
                'nullable',
                'numeric',
                'size:2',
            ],
            'creation_date' => [
                FasterPayment::validates($this),
                'date_format:Y-m-d',
                'after:yesterday',
            ],
            'expiration_date' => [
                FasterPayment::validates($this),
                'date_format:Y-m-d',
                'after:creation_date',
            ],
            'fast_payment' => [
                'required',
                'boolean'
            ]
        ];
    }
}
