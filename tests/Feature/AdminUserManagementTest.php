<?php

namespace Tests\Feature;

use App\Models\Kriteria;
use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_management_page(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertSee('Kelola User');
    }

    public function test_admin_can_create_juri_account(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Juri Baru',
            'email' => 'juri-baru@example.com',
            'role' => User::ROLE_JURI,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'juri-baru@example.com',
            'role' => User::ROLE_JURI,
        ]);
    }

    public function test_admin_can_update_user_account(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $user = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
            'name' => 'Peserta Internal',
            'email' => $user->email,
            'role' => User::ROLE_JURI,
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Peserta Internal',
            'role' => User::ROLE_JURI,
        ]);
    }

    public function test_admin_can_delete_pendaftar_account_and_related_submission_file(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $juri = User::factory()->create(['role' => User::ROLE_JURI]);
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $kriteria = Kriteria::query()->create([
            'perlombaan_id' => $perlombaan->id,
            'nama_kriteria' => 'Eksekusi',
            'deskripsi' => 'Kualitas hasil akhir.',
            'bobot' => 100,
            'urutan' => 1,
        ]);

        Storage::disk('public')->put('submissions/peserta-file.pdf', 'isi file');

        $pendaftaran = Pendaftaran::query()->create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REVIEWED,
            'submission_title' => 'Karya Peserta',
            'file_hasil' => 'submissions/peserta-file.pdf',
            'submitted_at' => now(),
            'final_score' => 88,
        ]);

        $score = Penilaian::query()->create([
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => $juri->id,
            'kriteria_id' => $kriteria->id,
            'skor' => 88,
            'catatan' => 'Sudah baik.',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $peserta));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $peserta->id]);
        $this->assertDatabaseMissing('pendaftarans', ['id' => $pendaftaran->id]);
        $this->assertDatabaseMissing('penilaians', ['id' => $score->id]);
        Storage::disk('public')->assertMissing('submissions/peserta-file.pdf');
    }

    public function test_admin_cannot_delete_own_account_from_management_page(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_non_admin_cannot_access_user_management_page(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);

        $response = $this->actingAs($peserta)->get(route('admin.users.index'));

        $response->assertForbidden();
    }
}
