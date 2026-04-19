<?php

namespace App\Http\Requests\Peserta;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
{
    public static function acceptedExtensions(): array
    {
        return [
            'pdf',
            'doc',
            'docx',
            'ppt',
            'pptx',
            'zip',
            'rar',
            'jpg',
            'jpeg',
            'png',
            'webp',
            'svg',
            'psd',
            'ai',
            'cdr',
            'mp4',
            'mov',
        ];
    }

    public static function maxUploadKilobytes(): int
    {
        return 20480;
    }

    public function authorize(): bool
    {
        return $this->user()?->isPendaftar() ?? false;
    }

    public function rules(): array
    {
        /** @var \App\Models\Pendaftaran $pendaftaran */
        $pendaftaran = $this->route('pendaftaran');

        return [
            'submission_title' => ['required', 'string', 'max:255'],
            'submission_notes' => ['nullable', 'string'],
            'file_hasil' => [
                $pendaftaran?->file_hasil ? 'nullable' : 'required',
                'file',
                'extensions:'.implode(',', self::acceptedExtensions()),
                'max:'.self::maxUploadKilobytes(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file_hasil.required' => 'File submission wajib diunggah.',
            'file_hasil.extensions' => 'Format file belum didukung. Gunakan PDF, dokumen Office, ZIP/RAR, gambar, file desain, atau video yang terdaftar.',
            'file_hasil.max' => 'Ukuran file maksimal 20 MB.',
        ];
    }
}