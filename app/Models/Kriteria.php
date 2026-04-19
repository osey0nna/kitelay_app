<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $fillable = ['perlombaan_id', 'nama_kriteria', 'deskripsi', 'bobot', 'urutan'];

    protected function casts(): array
    {
        return [
            'bobot' => 'integer',
            'urutan' => 'integer',
        ];
    }

    public function perlombaan(): BelongsTo
    {
        return $this->belongsTo(Perlombaan::class);
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function deleteAndRefreshScores(): void
    {
        DB::transaction(function () {
            $affectedPendaftaranIds = $this->penilaians()
                ->select('pendaftaran_id')
                ->distinct()
                ->pluck('pendaftaran_id');

            $this->penilaians()->delete();
            $this->delete();

            if ($affectedPendaftaranIds->isEmpty()) {
                return;
            }

            Pendaftaran::query()
                ->whereIn('id', $affectedPendaftaranIds)
                ->get()
                ->each(fn (Pendaftaran $pendaftaran) => $pendaftaran->refreshScoreState());
        });
    }
}
