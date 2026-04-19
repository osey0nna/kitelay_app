<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHasilPerlombaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_competition_ranking_page(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create();
        $pesertaA = User::factory()->create(['role' => User::ROLE_PENDAFTAR, 'name' => 'Peserta Satu']);
        $pesertaB = User::factory()->create(['role' => User::ROLE_PENDAFTAR, 'name' => 'Peserta Dua']);

        Pendaftaran::create([
            'user_id' => $pesertaA->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya A',
            'final_score' => 92,
        ]);

        Pendaftaran::create([
            'user_id' => $pesertaB->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya B',
            'final_score' => 85,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.perlombaan.hasil.show', $perlombaan));

        $response->assertOk();
        $response->assertSeeInOrder(['Peserta Satu', 'Peserta Dua']);
    }

    public function test_admin_can_publish_competition_results(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'announcement_at' => now()->addHour(),
        ]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);

        Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'final_score' => 89,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.perlombaan.hasil.publish', $perlombaan));

        $response->assertRedirect(route('admin.perlombaan.hasil.show', $perlombaan));
        $this->assertNotNull($perlombaan->fresh()->results_published_at);
        $this->assertNotNull($perlombaan->fresh()->results_released_at);
        $this->assertSame(Perlombaan::STATUS_FINISHED, $perlombaan->fresh()->status);
    }

    public function test_admin_can_close_public_results_without_removing_internal_history(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
            'results_published_at' => now(),
            'results_released_at' => now()->subMinute(),
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.perlombaan.hasil.unpublish', $perlombaan));

        $response->assertRedirect(route('admin.perlombaan.hasil.show', $perlombaan));
        $this->assertNull($perlombaan->fresh()->results_published_at);
        $this->assertNotNull($perlombaan->fresh()->results_released_at);
    }

    public function test_admin_cannot_publish_results_without_final_scores(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.perlombaan.hasil.publish', $perlombaan));

        $response->assertRedirect(route('admin.perlombaan.hasil.show', $perlombaan));
        $response->assertSessionHas('status', 'Hasil belum bisa dipublikasikan karena belum ada nilai final peserta.');
        $this->assertNull($perlombaan->fresh()->results_published_at);
    }

    public function test_non_admin_cannot_access_competition_ranking_page(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($peserta)->get(route('admin.perlombaan.hasil.show', $perlombaan));

        $response->assertForbidden();
    }

    public function test_non_admin_cannot_publish_competition_results(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_FINISHED,
        ]);

        $response = $this->actingAs($peserta)->put(route('admin.perlombaan.hasil.publish', $perlombaan));

        $response->assertForbidden();
    }
}
