<?php

namespace Tests\Feature;

use App\Models\Kriteria;
use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminJuriAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_juri_assignment_page(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create();
        User::factory()->count(2)->create(['role' => User::ROLE_JURI]);

        $response = $this->actingAs($admin)->get(route('admin.perlombaan.juri.index', $perlombaan));

        $response->assertOk();
    }

    public function test_admin_can_assign_juri_to_perlombaan(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create();
        $juriA = User::factory()->create(['role' => User::ROLE_JURI]);
        $juriB = User::factory()->create(['role' => User::ROLE_JURI]);

        $response = $this->actingAs($admin)->put(route('admin.perlombaan.juri.update', $perlombaan), [
            'juri_ids' => [$juriA->id, $juriB->id],
        ]);

        $response->assertRedirect(route('admin.perlombaan.juri.index', $perlombaan));
        $this->assertDatabaseHas('juri_perlombaan', ['user_id' => $juriA->id, 'perlombaan_id' => $perlombaan->id]);
        $this->assertDatabaseHas('juri_perlombaan', ['user_id' => $juriB->id, 'perlombaan_id' => $perlombaan->id]);
    }

    public function test_removing_juri_assignment_cleans_their_scores_and_recalculates_results(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $juriA = User::factory()->create(['role' => User::ROLE_JURI]);
        $juriB = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $kriteria = Kriteria::query()->create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Presentasi',
            'deskripsi' => 'Kejelasan penyampaian ide.',
            'bobot' => 100,
            'urutan' => 1,
        ]);
        $pendaftaran = Pendaftaran::query()->create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Final',
            'file_hasil' => 'submissions/karya-final.pdf',
            'submitted_at' => now(),
            'final_score' => 75,
        ]);

        $perlombaan->juris()->sync([$juriA->id, $juriB->id]);

        Penilaian::query()->create([
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => $juriA->id,
            'kriteria_id' => $kriteria->id,
            'skor' => 90,
            'catatan' => 'Bagus.',
        ]);

        $removedScore = Penilaian::query()->create([
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => $juriB->id,
            'kriteria_id' => $kriteria->id,
            'skor' => 60,
            'catatan' => 'Perlu perbaikan.',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.perlombaan.juri.update', $perlombaan), [
            'juri_ids' => [$juriA->id],
        ]);

        $response->assertRedirect(route('admin.perlombaan.juri.index', $perlombaan));
        $this->assertDatabaseMissing('juri_perlombaan', ['user_id' => $juriB->id, 'perlombaan_id' => $perlombaan->id]);
        $this->assertDatabaseMissing('penilaians', ['id' => $removedScore->id]);

        $pendaftaran->refresh();

        $this->assertSame('90.00', $pendaftaran->final_score);
        $this->assertSame(Pendaftaran::STATUS_REVIEWED, $pendaftaran->status);
    }

    public function test_non_admin_cannot_access_juri_assignment_page(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($peserta)->get(route('admin.perlombaan.juri.index', $perlombaan));

        $response->assertForbidden();
    }
}
