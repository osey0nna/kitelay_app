<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pendaftaran extends Model
{
    public const STATUS_REGISTERED = 'registered';

    public const STATUS_SUBMITTED = 'submitted';

    public const STATUS_REVIEWED = 'reviewed';

    public const STATUS_DISQUALIFIED = 'disqualified';

    protected $fillable = [
        'user_id',
        'perlombaan_id',
        'status',
        'submission_title',
        'submission_notes',
        'file_hasil',
        'submitted_at',
        'final_score',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'final_score' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function perlombaan(): BelongsTo
    {
        return $this->belongsTo(Perlombaan::class);
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public static function submissionDisk(): string
    {
        return (string) config('filesystems.submission_disk', 'public');
    }

    public static function previewableSubmissionExtensions(): array
    {
        return ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'svg', 'mp4', 'mov'];
    }

    public function hasStoredSubmissionFile(): bool
    {
        return filled($this->file_hasil) && str_starts_with($this->file_hasil, 'submissions/');
    }

    public function getSubmissionFileUrlAttribute(): ?string
    {
        if (! $this->hasStoredSubmissionFile()) {
            return null;
        }

        $disk = Storage::disk(static::submissionDisk());

        try {
            if (static::submissionDisk() !== 'public') {
                return $disk->temporaryUrl($this->file_hasil, now()->addMinutes(15));
            }
        } catch (\Throwable) {
            // Fall back to the standard URL when the selected disk does not support temporary URLs.
        }

        return $disk->url($this->file_hasil);
    }

    public function getSubmissionFileNameAttribute(): ?string
    {
        if (! filled($this->file_hasil)) {
            return null;
        }

        return basename($this->file_hasil);
    }

    public function getSubmissionFileExtensionAttribute(): ?string
    {
        if (! filled($this->file_hasil)) {
            return null;
        }

        return strtolower(pathinfo($this->file_hasil, PATHINFO_EXTENSION));
    }

    public function getSubmissionFileIsPreviewableAttribute(): bool
    {
        return filled($this->submission_file_extension)
            && in_array($this->submission_file_extension, static::previewableSubmissionExtensions(), true);
    }

    public function recalculateFinalScore(): ?float
    {
        $penilaians = $this->penilaians()
            ->with('kriteria:id,bobot')
            ->get()
            ->groupBy('user_id');

        if ($penilaians->isEmpty()) {
            return null;
        }

        $juryTotals = $penilaians->map(function ($juryScores) {
            return $juryScores->sum(fn ($penilaian) => ($penilaian->skor / 100) * $penilaian->kriteria->bobot);
        });

        return round((float) $juryTotals->avg(), 2);
    }

    public function refreshScoreState(): void
    {
        $finalScore = $this->recalculateFinalScore();

        $this->update([
            'final_score' => $finalScore,
            'status' => $finalScore === null
                ? ($this->submitted_at || $this->file_hasil || $this->submission_title
                    ? self::STATUS_SUBMITTED
                    : self::STATUS_REGISTERED)
                : self::STATUS_REVIEWED,
        ]);
    }
}
