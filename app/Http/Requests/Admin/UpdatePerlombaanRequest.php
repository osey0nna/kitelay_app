<?php

namespace App\Http\Requests\Admin;

use App\Models\Perlombaan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePerlombaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        /** @var \App\Models\Perlombaan $perlombaan */
        $perlombaan = $this->route('perlombaan');

        return [
            'nama_lomba' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('perlombaans', 'slug')->ignore($perlombaan->id)],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', Rule::in(Perlombaan::statuses())],
            'registration_start_at' => ['nullable', 'date'],
            'registration_end_at' => ['nullable', 'date', 'after_or_equal:registration_start_at'],
            'deadline_pendaftaran' => ['nullable', 'date'],
            'submission_deadline_at' => ['nullable', 'date', 'after_or_equal:registration_end_at'],
            'announcement_at' => ['nullable', 'date', 'after_or_equal:submission_deadline_at'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
