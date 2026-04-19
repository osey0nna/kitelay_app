<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('submission-storage:check', function () {
    $diskName = (string) config('filesystems.submission_disk', 'public');
    $disk = Storage::disk($diskName);
    $path = 'submissions/healthchecks/'.Str::uuid().'.txt';
    $contents = 'submission-storage-check '.now()->toIso8601String();

    $this->comment("Checking submission disk [{$diskName}] ...");

    try {
        $written = $disk->put($path, $contents);

        if (! $written) {
            $this->error('File test gagal ditulis ke storage submission.');

            return self::FAILURE;
        }

        $exists = $disk->exists($path);
        $url = $disk->url($path);

        $this->info('Storage submission berhasil diakses.');
        $this->line("Path test: {$path}");
        $this->line("URL test: {$url}");
        $this->line('File tersedia: '.($exists ? 'ya' : 'tidak'));

        $disk->delete($path);
        $this->comment('File test berhasil dibersihkan kembali.');

        return self::SUCCESS;
    } catch (\Throwable $exception) {
        $this->error('Storage submission gagal diakses.');
        $this->line($exception->getMessage());

        return self::FAILURE;
    }
})->purpose('Check the configured submission storage disk');
