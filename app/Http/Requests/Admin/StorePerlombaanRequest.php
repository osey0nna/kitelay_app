<?php

namespace App\Http\Requests\Admin;

use App\Models\Perlombaan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePerlombaanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lomba' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('perlombaans', 'slug')],
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
