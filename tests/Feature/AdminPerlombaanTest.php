<?php

namespace Tests\Feature;

use App\Models\Kriteria;
use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPerlombaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_competition_index_page(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.perlombaan.index'));

        $response->assertOk();
    }

    public function test_admin_can_create_competition(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.perlombaan.store'), [
            'nama_lomba' => 'Lomba Poster Digital',
            'slug' => 'lomba-poster-digital',
            'deskripsi' => 'Kompetisi desain poster untuk siswa SMK.',
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
            'registration_start_at' => '2026-03-20 08:00',
            'registration_end_at' => '2026-03-25 23:00',
            'deadline_pendaftaran' => '2026-03-25',
            'submission_deadline_at' => '2026-03-30 23:00',
            'announcement_at' => '2026-04-05 10:00',
            'max_participants' => 150,
        ]);

        $response->assertRedirect(route('admin.perlombaan.index'));

        $this->assertDatabaseHas('perlombaans', [
            'nama_lomba' => 'Lomba Poster Digital',
            'slug' => 'lomba-poster-digital',
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
        ]);
    }

    public function test_admin_can_delete_competition(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);
        $perlombaan = Perlombaan::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.perlombaan.destroy', $perlombaan));

        $response->assertRedirect(route('admin.perlombaan.index'));

        $this->assertDatabaseMissing('perlombaans', [
            'id' => $perlombaan->id,
        ]);
    }

    public function test_admin_can_delete_competition_with_related_data(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);
        $juri = User::factory()->create([
            'role' => User::ROLE_JURI,
        ]);
        $peserta = User::factory()->create([
            'role' => User::ROLE_PENDAFTAR,
        ]);
        $perlombaan = Perlombaan::factory()->create();
        $kriteria = Kriteria::query()->create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Kreativitas',
            'deskripsi' => 'Penilaian ide dan inovasi.',
            'bobot' => 50,
            'urutan' => 1,
        ]);
        $pendaftaran = Pendaftaran::query()->create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_SUBMITTED,
            'submission_title' => 'Karya Peserta',
            'file_hasil' => 'submissions/contoh.pdf',
            'submitted_at' => now(),
        ]);

        $perlombaan->juris()->attach($juri->id);

        $penilaian = Penilaian::query()->create([
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => $juri->id,
            'kriteria_id' => $kriteria->id,
            'skor' => 90,
            'catatan' => 'Bagus.',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.perlombaan.destroy', $perlombaan));

        $response->assertRedirect(route('admin.perlombaan.index'));

        $this->assertDatabaseMissing('perlombaans', [
            'id' => $perlombaan->id,
        ]);
        $this->assertDatabaseMissing('kriterias', [
            'id' => $kriteria->id,
        ]);
        $this->assertDatabaseMissing('pendaftarans', [
            'id' => $pendaftaran->id,
        ]);
        $this->assertDatabaseMissing('penilaians', [
            'id' => $penilaian->id,
        ]);
        $this->assertDatabaseMissing('juri_perlombaan', [
            'user_id' => $juri->id,
            'perlombaan_id' => $perlombaan->id,
        ]);
    }

    public function test_non_admin_cannot_access_admin_competition_routes(): void
    {
        $peserta = User::factory()->create([
            'role' => User::ROLE_PENDAFTAR,
        ]);

        $response = $this->actingAs($peserta)->get(route('admin.perlombaan.index'));

        $response->assertForbidden();
    }
}
