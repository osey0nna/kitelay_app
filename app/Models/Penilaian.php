<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['pendaftaran_id', 'user_id', 'kriteria_id', 'skor', 'catatan'];

    protected function casts(): array
    {
        return [
            'skor' => 'integer',
        ];
    }

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function juri(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
