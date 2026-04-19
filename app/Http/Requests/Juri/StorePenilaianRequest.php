<?php

namespace App\Http\Requests\Juri;

use Illuminate\Foundation\Http\FormRequest;

class StorePenilaianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isJuri() ?? false;
    }

    public function rules(): array
    {
        return [
            'scores' => ['required', 'array'],
            'scores.*.kriteria_id' => ['required', 'integer', 'exists:kriterias,id'],
            'scores.*.skor' => ['required', 'integer', 'min:0', 'max:100'],
            'scores.*.catatan' => ['nullable', 'string'],
        ];
    }
}
