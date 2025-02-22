<?php

namespace App\Http\Requests;

use App\Enums\SlidePosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SlideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'header'    => 'required|max:255',
            'subheader' => 'nullable|max:255',
            'desc'      => 'nullable',
            'image'     => 'required|image|max:2048|dimensions:min_width=1920,min_height=480',
            'position'  => ['required', new Enum(SlidePosition::class)],
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['image'] = 'image|max:2048|dimensions:min_width=1920,min_height=480';
                break;
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'header'    => 'Judul',
            'subheader' => 'Sub Judul',
            'desc'      => 'Deskripsi',
            'image'     => 'Gambar',
            'positin'   => 'Posisi'
        ];
    }
}
