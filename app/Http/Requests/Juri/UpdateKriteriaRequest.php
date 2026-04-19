<?php

namespace App\Http\Requests\Juri;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKriteriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isJuri() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_kriteria' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'bobot' => ['required', 'integer', 'min:1', 'max:100'],
            'urutan' => ['required', 'integer', 'min:1'],
        ];
    }
}
