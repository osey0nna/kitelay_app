<?php

namespace Tests\Feature;

use App\Models\Kriteria;
use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JuriCriteriaVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_assigned_juri_can_see_competition_criteria_on_scoring_form(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $perlombaan->juris()->attach($juri->id);

        $kriteria = Kriteria::query()->create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Kreativitas',
            'deskripsi' => 'Menilai ide dan orisinalitas.',
            'bobot' => 40,
            'urutan' => 1,
        ]);

        $pendaftaran = Pendaftaran::query()->create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_SUBMITTED,
            'submission_title' => 'Karya Inovatif',
            'file_hasil' => 'submissions/karya-inovatif.pdf',
            'submitted_at' => now(),
        ]);

        $response = $this->actingAs($juri)->get(route('juri.penilaian.edit', [$perlombaan, $pendaftaran]));

        $response->assertOk();
        $response->assertSee($kriteria->nama_kriteria);
        $response->assertSee((string) $kriteria->bobot);
    }

    public function test_juri_cannot_access_admin_criteria_management_page(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($juri)->get(route('admin.perlombaan.kriteria.index', $perlombaan));

        $response->assertForbidden();
    }
}
