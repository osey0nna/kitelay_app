<?php

namespace Tests\Feature;

use App\Models\Kriteria;
use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JuriPenilaianFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_juri_can_view_assigned_competitions(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $perlombaan = Perlombaan::factory()->create();
        $perlombaan->juris()->attach($juri->id);

        $response = $this->actingAs($juri)->get(route('juri.penilaian.index'));

        $response->assertOk();
        $response->assertSee($perlombaan->nama_lomba);
    }

    public function test_juri_can_score_submission_on_assigned_competition(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $perlombaan->juris()->attach($juri->id);

        $kriteriaA = Kriteria::create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Kreativitas',
            'deskripsi' => 'Ide dan inovasi.',
            'bobot' => 60,
            'urutan' => 1,
        ]);

        $kriteriaB = Kriteria::create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Eksekusi',
            'deskripsi' => 'Kerapian dan implementasi.',
            'bobot' => 40,
            'urutan' => 2,
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_SUBMITTED,
            'submission_title' => 'Poster Kampanye',
        ]);

        $response = $this->actingAs($juri)->put(route('juri.penilaian.update', [$perlombaan, $pendaftaran]), [
            'scores' => [
                ['kriteria_id' => (string) $kriteriaA->id, 'skor' => '80', 'catatan' => 'Bagus'],
                ['kriteria_id' => (string) $kriteriaB->id, 'skor' => '90', 'catatan' => 'Rapi'],
            ],
        ]);

        $response->assertRedirect(route('juri.penilaian.submissions', $perlombaan));

        $this->assertDatabaseHas('penilaians', [
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => $juri->id,
            'kriteria_id' => $kriteriaA->id,
            'skor' => 80,
        ]);

        $this->assertDatabaseHas('pendaftarans', [
            'id' => $pendaftaran->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'final_score' => 84,
        ]);
    }

    public function test_juri_cannot_access_unassigned_competition_scoring_page(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($juri)->get(route('juri.penilaian.submissions', $perlombaan));

        $response->assertForbidden();
    }

    public function test_juri_sees_download_action_for_non_previewable_submission_file(): void
    {
        Storage::fake('public');

        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $perlombaan->juris()->attach($juri->id);
        Storage::disk('public')->put('submissions/poster-kampanye.psd', 'dummy-design-file');

        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_SUBMITTED,
            'submission_title' => 'Poster Kampanye',
            'file_hasil' => 'submissions/poster-kampanye.psd',
        ]);

        $response = $this->actingAs($juri)->get(route('juri.penilaian.edit', [$perlombaan, $pendaftaran]));

        $response->assertOk();
        $response->assertSee('Unduh');
        $response->assertSee('Format file ini tidak mendukung preview langsung di browser');
        $response->assertDontSee('Lihat File');
        $response->assertSee(route('juri.penilaian.file.download', [$perlombaan, $pendaftaran]), false);
    }

    public function test_juri_can_preview_and_download_submission_file_through_internal_routes(): void
    {
        Storage::fake('public');

        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $perlombaan->juris()->attach($juri->id);
        Storage::disk('public')->put('submissions/poster-kampanye.pdf', 'dummy-pdf-content');

        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_SUBMITTED,
            'submission_title' => 'Poster Kampanye',
            'file_hasil' => 'submissions/poster-kampanye.pdf',
        ]);

        $previewResponse = $this->actingAs($juri)->get(route('juri.penilaian.file.show', [$perlombaan, $pendaftaran]));
        $downloadResponse = $this->actingAs($juri)->get(route('juri.penilaian.file.download', [$perlombaan, $pendaftaran]));

        $previewResponse->assertOk();
        $downloadResponse->assertOk();
        $downloadResponse->assertHeader('content-disposition');
    }

    public function test_final_score_is_averaged_across_multiple_juries(): void
    {
        $juriA = User::factory()->create(['role' => User::ROLE_JURI]);
        $juriB = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $perlombaan->juris()->attach([$juriA->id, $juriB->id]);

        $kriteriaA = Kriteria::create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Kreativitas',
            'deskripsi' => 'Ide dan inovasi.',
            'bobot' => 50,
            'urutan' => 1,
        ]);

        $kriteriaB = Kriteria::create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Eksekusi',
            'deskripsi' => 'Kerapian dan implementasi.',
            'bobot' => 50,
            'urutan' => 2,
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_SUBMITTED,
            'submission_title' => 'Poster Kampanye',
        ]);

        $this->actingAs($juriA)->put(route('juri.penilaian.update', [$perlombaan, $pendaftaran]), [
            'scores' => [
                ['kriteria_id' => $kriteriaA->id, 'skor' => 80, 'catatan' => null],
                ['kriteria_id' => $kriteriaB->id, 'skor' => 90, 'catatan' => null],
            ],
        ]);

        $this->actingAs($juriB)->put(route('juri.penilaian.update', [$perlombaan, $pendaftaran]), [
            'scores' => [
                ['kriteria_id' => $kriteriaA->id, 'skor' => 60, 'catatan' => null],
                ['kriteria_id' => $kriteriaB->id, 'skor' => 70, 'catatan' => null],
            ],
        ]);

        $this->assertDatabaseHas('pendaftarans', [
            'id' => $pendaftaran->id,
            'final_score' => 75,
        ]);
    }

    public function test_juri_can_view_published_results_for_assigned_competition(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR, 'name' => 'Peserta Juara']);
        $perlombaan = Perlombaan::factory()->create([
            'announcement_at' => now()->subHour(),
            'results_published_at' => now()->subMinutes(30),
        ]);
        $perlombaan->juris()->attach($juri->id);

        Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Juara',
            'final_score' => 95,
        ]);

        $response = $this->actingAs($juri)->get(route('juri.penilaian.results', $perlombaan));

        $response->assertOk();
        $response->assertSee('Peserta Juara');
        $response->assertSee('Podium');
    }

    public function test_juri_cannot_view_results_before_publication(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $perlombaan = Perlombaan::factory()->create([
            'announcement_at' => now()->subHour(),
            'results_published_at' => null,
        ]);
        $perlombaan->juris()->attach($juri->id);

        $response = $this->actingAs($juri)->get(route('juri.penilaian.results', $perlombaan));

        $response->assertRedirect(route('juri.penilaian.submissions', $perlombaan));
    }

    public function test_juri_can_still_view_results_after_public_page_is_closed(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR, 'name' => 'Peserta Arsip']);
        $perlombaan = Perlombaan::factory()->create([
            'announcement_at' => now()->subHour(),
            'results_published_at' => null,
            'results_released_at' => now()->subMinutes(30),
        ]);
        $perlombaan->juris()->attach($juri->id);

        Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Arsip',
            'final_score' => 93,
        ]);

        $response = $this->actingAs($juri)->get(route('juri.penilaian.results', $perlombaan));

        $response->assertOk();
        $response->assertSee('Peserta Arsip');
    }
}
