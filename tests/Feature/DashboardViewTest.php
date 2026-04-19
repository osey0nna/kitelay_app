<?php

namespace Tests\Feature;

use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_management_shortcuts(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        Perlombaan::factory()->count(2)->create();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Kelola User');
        $response->assertSee('Perlombaan Terbaru');
    }

    public function test_juri_dashboard_shows_scoring_workspace(): void
    {
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $perlombaan = Perlombaan::factory()->create([
            'announcement_at' => now()->subHour(),
            'results_published_at' => now()->subMinutes(30),
        ]);
        $perlombaan->juris()->attach($juri->id);

        $response = $this->actingAs($juri)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Hasil Terbaru');
        $response->assertSee('Lomba Tugas');
    }

    public function test_peserta_dashboard_shows_competition_progress(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        Perlombaan::factory()->create(['status' => Perlombaan::STATUS_REGISTRATION_OPEN]);

        $response = $this->actingAs($peserta)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Lihat Katalog Lomba');
        $response->assertSee('Peluang Baru');
    }
}
