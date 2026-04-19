<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PesertaHasilLombaTest extends TestCase
{
    use RefreshDatabase;

    public function test_peserta_can_view_own_competition_results(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR, 'name' => 'Peserta Saya']);
        $pesertaLain = User::factory()->create(['role' => User::ROLE_PENDAFTAR, 'name' => 'Peserta Lain']);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->subHour(),
            'results_published_at' => now()->subMinutes(30),
        ]);

        $pendaftaranSaya = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Saya',
            'final_score' => 88,
        ]);

        Pendaftaran::create([
            'user_id' => $pesertaLain->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Lain',
            'final_score' => 92,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.lomba.results', $pendaftaranSaya));

        $response->assertOk();
        $response->assertSee('Peserta Saya');
        $response->assertSee('Peserta Lain');
    }

    public function test_peserta_can_view_results_when_admin_has_published_even_if_status_was_not_finished(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR, 'name' => 'Peserta Saya']);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_JUDGING,
            'announcement_at' => now()->subHour(),
            'results_published_at' => now()->subMinutes(30),
        ]);

        $pendaftaranSaya = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Saya',
            'final_score' => 88,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.lomba.results', $pendaftaranSaya));

        $response->assertOk();
        $response->assertSee('Hasil Lomba');
    }

    public function test_peserta_cannot_view_results_before_announcement_schedule(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->addDay(),
            'results_published_at' => now(),
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'final_score' => 91,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.lomba.results', $pendaftaran));

        $response->assertRedirect(route('peserta.lomba.index'));
        $response->assertSessionHas('status', 'Hasil lomba belum dipublikasikan. Silakan tunggu sampai tanggal pengumuman tiba.');
    }

    public function test_peserta_index_hides_result_access_before_announcement_schedule(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->addDay(),
            'results_published_at' => now(),
        ]);

        Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Rahasia',
            'final_score' => 91,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.lomba.index'));

        $response->assertOk();
        $response->assertSee('Menunggu Pengumuman');
        $response->assertDontSee('91.00');
        $response->assertDontSee('Lihat Hasil');
    }

    public function test_peserta_cannot_view_other_users_competition_results(): void
    {
        $pesertaA = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $pesertaB = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->subHour(),
            'results_published_at' => now()->subMinutes(30),
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $pesertaA->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'final_score' => 75,
        ]);

        $response = $this->actingAs($pesertaB)->get(route('peserta.lomba.results', $pendaftaran));

        $response->assertForbidden();
    }

    public function test_peserta_can_still_view_results_after_publication_is_closed(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->subHour(),
            'results_published_at' => null,
            'results_released_at' => now()->subMinutes(30),
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Arsip',
            'final_score' => 90,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.lomba.results', $pendaftaran));

        $response->assertOk();
        $response->assertSee('Karya Arsip');
    }
}
