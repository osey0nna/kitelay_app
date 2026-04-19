<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_JURI = 'juri';

    public const ROLE_PENDAFTAR = 'pendaftar';

    public static function roles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_JURI,
            self::ROLE_PENDAFTAR,
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pendaftarans(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'user_id');
    }

    public function lombaDibuat(): HasMany
    {
        return $this->hasMany(Perlombaan::class, 'created_by');
    }

    public function lombaDinilai(): BelongsToMany
    {
        return $this->belongsToMany(Perlombaan::class, 'juri_perlombaan')->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isJuri(): bool
    {
        return $this->role === self::ROLE_JURI;
    }

    public function isPendaftar(): bool
    {
        return $this->role === self::ROLE_PENDAFTAR;
    }

    public function deleteWithRelations(): void
    {
        DB::transaction(function () {
            $this->lombaDinilai()->detach();

            $affectedPendaftaranIds = $this->penilaians()
                ->select('pendaftaran_id')
                ->distinct()
                ->pluck('pendaftaran_id');

            $this->penilaians()->delete();

            $myRegistrationIds = $this->pendaftarans()->pluck('id');
            $storedFiles = $this->pendaftarans()
                ->pluck('file_hasil')
                ->filter(fn ($path) => filled($path) && str_starts_with($path, 'submissions/'))
                ->all();

            if ($myRegistrationIds->isNotEmpty()) {
                Penilaian::query()
                    ->whereIn('pendaftaran_id', $myRegistrationIds)
                    ->delete();

                $this->pendaftarans()->delete();
            }

            $this->delete();

            if (! empty($storedFiles)) {
                Storage::disk(Pendaftaran::submissionDisk())->delete($storedFiles);
            }

            if ($affectedPendaftaranIds->isNotEmpty()) {
                Pendaftaran::query()
                    ->whereIn('id', $affectedPendaftaranIds)
                    ->get()
                    ->each(fn (Pendaftaran $pendaftaran) => $pendaftaran->refreshScoreState());
            }
        });
    }
}
