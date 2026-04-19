<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicAnnouncementPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_view_announcements_index(): void
    {
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'nama_lomba' => 'Lomba Video Kreatif',
            'announcement_at' => now()->subHour(),
            'results_published_at' => now()->subMinutes(30),
        ]);
        $belumSelesai = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_JUDGING,
            'nama_lomba' => 'Lomba Belum Selesai',
        ]);
        $futureAnnouncement = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'nama_lomba' => 'Lomba Masa Depan',
            'announcement_at' => now()->addDay(),
            'results_published_at' => now(),
        ]);
        $unpublished = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'nama_lomba' => 'Lomba Belum Dipublish',
            'announcement_at' => now()->subHour(),
        ]);

        $response = $this->get(route('pengumuman.index'));

        $response->assertOk();
        $response->assertSee($perlombaan->nama_lomba);
        $response->assertDontSee($belumSelesai->nama_lomba);
        $response->assertDontSee($futureAnnouncement->nama_lomba);
        $response->assertDontSee($unpublished->nama_lomba);
    }

    public function test_public_can_view_competition_announcement_detail(): void
    {
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->subHour(),
            'results_published_at' => now()->subMinutes(30),
        ]);

        $peserta = User::factory()->create([
            'role' => User::ROLE_PENDAFTAR,
            'name' => 'Peserta Juara',
        ]);

        Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Pemenang',
            'final_score' => 95,
        ]);

        $response = $this->get(route('pengumuman.show', $perlombaan));

        $response->assertOk();
        $response->assertSee('Peserta Juara');
        $response->assertSee($perlombaan->nama_lomba);
        $response->assertDontSee('95.00');
        $response->assertDontSee('Peringkat Keseluruhan');
    }

    public function test_public_cannot_view_unfinished_competition_announcement_detail(): void
    {
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_JUDGING,
        ]);

        $response = $this->get(route('pengumuman.show', $perlombaan));

        $response->assertNotFound();
    }

    public function test_public_cannot_view_announcement_before_schedule(): void
    {
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->addHours(6),
            'results_published_at' => now(),
        ]);

        $response = $this->get(route('pengumuman.show', $perlombaan));

        $response->assertNotFound();
    }

    public function test_public_cannot_view_announcement_before_admin_publishes_it(): void
    {
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->subHour(),
            'results_published_at' => null,
        ]);

        $response = $this->get(route('pengumuman.show', $perlombaan));

        $response->assertNotFound();
    }

    public function test_public_cannot_view_announcement_when_publication_is_closed_even_if_internal_history_exists(): void
    {
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->subHour(),
            'results_published_at' => null,
            'results_released_at' => now()->subMinutes(30),
        ]);

        $response = $this->get(route('pengumuman.show', $perlombaan));

        $response->assertNotFound();
    }
}
