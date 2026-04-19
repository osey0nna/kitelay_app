<?php

namespace Tests\Feature;

use App\Models\Kriteria;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminKriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_competition_criteria_page(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.perlombaan.kriteria.index', $perlombaan));

        $response->assertOk();
    }

    public function test_admin_can_create_competition_criteria(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.perlombaan.kriteria.store', $perlombaan), [
            'nama_kriteria' => 'Kreativitas',
            'deskripsi' => 'Menilai orisinalitas ide dan eksekusi.',
            'bobot' => 40,
            'urutan' => 1,
        ]);

        $response->assertRedirect(route('admin.perlombaan.kriteria.index', $perlombaan));

        $this->assertDatabaseHas('kriterias', [
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Kreativitas',
            'bobot' => 40,
        ]);
    }

    public function test_admin_can_update_competition_criteria(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create();
        $kriteria = Kriteria::query()->create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Kreativitas',
            'deskripsi' => 'Deskripsi awal.',
            'bobot' => 40,
            'urutan' => 1,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.perlombaan.kriteria.update', [$perlombaan, $kriteria]), [
            'nama_kriteria' => 'Presentasi',
            'deskripsi' => 'Menilai cara penyampaian peserta.',
            'bobot' => 35,
            'urutan' => 2,
        ]);

        $response->assertRedirect(route('admin.perlombaan.kriteria.index', $perlombaan));

        $this->assertDatabaseHas('kriterias', [
            'id' => $kriteria->id,
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Presentasi',
            'bobot' => 35,
            'urutan' => 2,
        ]);
    }

    public function test_admin_can_delete_competition_criteria(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $perlombaan = Perlombaan::factory()->create();
        $kriteria = Kriteria::query()->create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Orisinalitas',
            'deskripsi' => 'Menilai keaslian ide.',
            'bobot' => 30,
            'urutan' => 1,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.perlombaan.kriteria.destroy', [$perlombaan, $kriteria]));

        $response->assertRedirect(route('admin.perlombaan.kriteria.index', $perlombaan));

        $this->assertDatabaseMissing('kriterias', [
            'id' => $kriteria->id,
        ]);
    }

    public function test_non_admin_cannot_access_competition_criteria_routes(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($peserta)->get(route('admin.perlombaan.kriteria.index', $perlombaan));

        $response->assertForbidden();
    }
}
