<?php

namespace SpiritSaint\LaravelBacs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

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
                Rule::requiredIf(
                    fn() => $this->has('serial_number') && !$this->has('sun')
                ),
                'in:hsbc,sage'
            ],
            'sun' => [
                Rule::requiredIf(
                    fn() => $this->has('serial_number') && !$this->has('marker')
                ),
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
                Rule::requiredIf(
                    fn() => !$this->has('fast_payment')
                ),
                'date_format:Y-m-d',
                'after:yesterday',
            ],
            'expiration_date' => [
                Rule::requiredIf(
                    fn() => !$this->has('fast_payment')
                ),
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