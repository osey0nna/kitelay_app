<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@kitelay.test'],
            [
                'name' => 'Admin Kitelay',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
                'email_verified_at' => now(),
            ]
        );

        $juri = User::firstOrCreate(
            ['email' => 'juri@kitelay.test'],
            [
                'name' => 'Juri Kitelay',
                'password' => 'password',
                'role' => User::ROLE_JURI,
                'email_verified_at' => now(),
            ]
        );

        $peserta = User::firstOrCreate(
            ['email' => 'peserta@kitelay.test'],
            [
                'name' => 'Peserta Kitelay',
                'password' => 'password',
                'role' => User::ROLE_PENDAFTAR,
                'email_verified_at' => now(),
            ]
        );

        $perlombaan = Perlombaan::firstOrCreate(
            ['slug' => 'creative-sprint-2026'],
            [
                'created_by' => $admin->id,
                'nama_lomba' => 'Creative Sprint 2026',
                'deskripsi' => 'Kompetisi untuk mengumpulkan karya digital terbaik dari peserta terpilih.',
                'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
                'deadline_pendaftaran' => now()->addDays(10)->toDateString(),
                'registration_start_at' => now()->subDays(2),
                'registration_end_at' => now()->addDays(10),
                'submission_deadline_at' => now()->addDays(17),
                'announcement_at' => now()->addDays(25),
                'max_participants' => 150,
            ]
        );

        $perlombaan->juris()->syncWithoutDetaching([$juri->id]);

        $kriteriaPresentasi = Kriteria::firstOrCreate(
            ['perlombaan_id' => $perlombaan->id, 'nama_kriteria' => 'Kreativitas'],
            ['deskripsi' => 'Keunikan ide dan eksekusi visual.', 'bobot' => 40, 'urutan' => 1]
        );

        $kriteriaImplementasi = Kriteria::firstOrCreate(
            ['perlombaan_id' => $perlombaan->id, 'nama_kriteria' => 'Eksekusi'],
            ['deskripsi' => 'Kerapian hasil akhir dan kesesuaian brief.', 'bobot' => 35, 'urutan' => 2]
        );

        $kriteriaImpact = Kriteria::firstOrCreate(
            ['perlombaan_id' => $perlombaan->id, 'nama_kriteria' => 'Impact'],
            ['deskripsi' => 'Seberapa kuat karya menyampaikan tujuan lomba.', 'bobot' => 25, 'urutan' => 3]
        );

        $pendaftaran = Pendaftaran::firstOrCreate(
            ['user_id' => $peserta->id, 'perlombaan_id' => $perlombaan->id],
            [
                'status' => Pendaftaran::STATUS_SUBMITTED,
                'submission_title' => 'Campaign Landing Page Revamp',
                'submission_notes' => 'Submission contoh untuk menyiapkan alur penilaian juri.',
                'file_hasil' => 'submissions/'.Str::slug($peserta->name).'-creative-sprint-2026.pdf',
                'submitted_at' => now()->subDay(),
                'final_score' => 87.50,
            ]
        );

        $scores = [
            $kriteriaPresentasi->id => 90,
            $kriteriaImplementasi->id => 85,
            $kriteriaImpact->id => 87,
        ];

        foreach ($scores as $kriteriaId => $score) {
            Penilaian::firstOrCreate(
                [
                    'pendaftaran_id' => $pendaftaran->id,
                    'user_id' => $juri->id,
                    'kriteria_id' => $kriteriaId,
                ],
                [
                    'skor' => $score,
                    'catatan' => 'Seed penilaian awal untuk simulasi dashboard.',
                ]
            );
        }
    }
}
