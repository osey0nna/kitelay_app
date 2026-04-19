<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Perlombaan extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_REGISTRATION_OPEN = 'registration_open';

    public const STATUS_ONGOING = 'ongoing';

    public const STATUS_JUDGING = 'judging';

    public const STATUS_FINISHED = 'finished';

    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED,
            self::STATUS_REGISTRATION_OPEN,
            self::STATUS_ONGOING,
            self::STATUS_JUDGING,
            self::STATUS_FINISHED,
        ];
    }

    protected $fillable = [
        'created_by',
        'nama_lomba',
        'slug',
        'deskripsi',
        'status',
        'deadline_pendaftaran',
        'registration_start_at',
        'registration_end_at',
        'submission_deadline_at',
        'announcement_at',
        'results_published_at',
        'results_released_at',
        'max_participants',
    ];

    protected function casts(): array
    {
        return [
            'deadline_pendaftaran' => 'date',
            'registration_start_at' => 'datetime',
            'registration_end_at' => 'datetime',
            'submission_deadline_at' => 'datetime',
            'announcement_at' => 'datetime',
            'results_published_at' => 'datetime',
            'results_released_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kriterias(): HasMany
    {
        return $this->hasMany(Kriteria::class)->orderBy('urutan');
    }

    public function pendaftarans(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function juris(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'juri_perlombaan')->withTimestamps();
    }

    public function announcementTimeHasArrived(): bool
    {
        return $this->announcement_at === null || $this->announcement_at->lessThanOrEqualTo(now());
    }

    public function resultsHaveBeenReleased(): bool
    {
        return $this->results_released_at !== null || $this->results_published_at !== null;
    }

    public function resultsAreVisible(): bool
    {
        return $this->resultsHaveBeenReleased() && $this->announcementTimeHasArrived();
    }

    public function resultsArePubliclyVisible(): bool
    {
        return $this->results_published_at !== null && $this->announcementTimeHasArrived();
    }

    public function deleteWithRelations(): void
    {
        DB::transaction(function () {
            $this->juris()->detach();

            $pendaftaranIds = $this->pendaftarans()->pluck('id');
            $storedFiles = $this->pendaftarans()
                ->pluck('file_hasil')
                ->filter(fn ($path) => filled($path) && str_starts_with($path, 'submissions/'))
                ->all();

            if ($pendaftaranIds->isNotEmpty()) {
                Penilaian::query()
                    ->whereIn('pendaftaran_id', $pendaftaranIds)
                    ->delete();

                $this->pendaftarans()->delete();
            }

            $this->kriterias()->delete();
            $this->delete();

            if (! empty($storedFiles)) {
                Storage::disk(Pendaftaran::submissionDisk())->delete($storedFiles);
            }
        });
    }
}
