<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;
use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PesertaLombaFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_peserta_can_view_competition_catalog(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.lomba.index'));

        $response->assertOk();
        $response->assertSee($perlombaan->nama_lomba);
    }

    public function test_peserta_can_view_competition_detail_and_rundown_before_registering(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
            'nama_lomba' => 'Lomba UI UX',
        ]);

        $response = $this->actingAs($peserta)->get(route('peserta.lomba.show', $perlombaan));

        $response->assertOk();
        $response->assertSee('Detail Lomba');
        $response->assertSee('Rundown Lomba');
        $response->assertSee($perlombaan->nama_lomba);
    }

    public function test_peserta_can_register_to_competition(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
        ]);

        $this->actingAs($peserta)->get(route('peserta.lomba.show', $perlombaan));
        $response = $this->actingAs($peserta)->post(route('peserta.lomba.register', $perlombaan));

        $response->assertRedirect(route('peserta.lomba.index'));
        $this->assertDatabaseHas('pendaftarans', [
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REGISTERED,
        ]);
    }

    public function test_peserta_must_open_detail_page_before_registering(): void
    {
        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create([
            'status' => Perlombaan::STATUS_REGISTRATION_OPEN,
        ]);

        $response = $this->actingAs($peserta)->post(route('peserta.lomba.register', $perlombaan));

        $response->assertRedirect(route('peserta.lomba.show', $perlombaan));
        $this->assertDatabaseMissing('pendaftarans', [
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
        ]);
    }

    public function test_peserta_can_submit_competition_result(): void
    {
        Storage::fake('public');

        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REGISTERED,
        ]);

        $file = UploadedFile::fake()->create('video-promosi.mp4', 5000, 'video/mp4');

        $response = $this->actingAs($peserta)->put(route('peserta.lomba.update', $pendaftaran), [
            'submission_title' => 'Video Promosi Sekolah',
            'submission_notes' => 'Ini hasil final untuk dikumpulkan.',
            'file_hasil' => $file,
        ]);

        $response->assertRedirect(route('peserta.lomba.index'));

        $pendaftaran->refresh();

        $this->assertSame(Pendaftaran::STATUS_SUBMITTED, $pendaftaran->status);
        $this->assertSame('Video Promosi Sekolah', $pendaftaran->submission_title);
        $this->assertNotNull($pendaftaran->file_hasil);
        Storage::disk('public')->assertExists($pendaftaran->file_hasil);
    }

    public function test_peserta_can_submit_design_source_file(): void
    {
        Storage::fake('public');

        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REGISTERED,
        ]);

        $file = UploadedFile::fake()->create('desain-final.psd', 8000, 'application/octet-stream');

        $response = $this->actingAs($peserta)->put(route('peserta.lomba.update', $pendaftaran), [
            'submission_title' => 'Desain Final PSD',
            'submission_notes' => 'File desain sumber.',
            'file_hasil' => $file,
        ]);

        $response->assertRedirect(route('peserta.lomba.index'));

        $pendaftaran->refresh();

        $this->assertSame(Pendaftaran::STATUS_SUBMITTED, $pendaftaran->status);
        Storage::disk('public')->assertExists($pendaftaran->file_hasil);
    }

    public function test_peserta_cannot_submit_unsupported_file_type(): void
    {
        Storage::fake('public');

        $peserta = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $pendaftaran = Pendaftaran::create([
            'user_id' => $peserta->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REGISTERED,
        ]);

        $file = UploadedFile::fake()->create('script.exe', 1000, 'application/octet-stream');

        $response = $this->actingAs($peserta)->from(route('peserta.lomba.edit', $pendaftaran))->put(route('peserta.lomba.update', $pendaftaran), [
            'submission_title' => 'File Tidak Valid',
            'submission_notes' => 'Coba upload format yang tidak didukung.',
            'file_hasil' => $file,
        ]);

        $response->assertRedirect(route('peserta.lomba.edit', $pendaftaran));
        $response->assertSessionHasErrors('file_hasil');
    }

    public function test_peserta_cannot_edit_other_users_submission(): void
    {
        $pesertaA = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $pesertaB = User::factory()->create(['role' => User::ROLE_PENDAFTAR]);
        $perlombaan = Perlombaan::factory()->create();
        $pendaftaran = Pendaftaran::create([
            'user_id' => $pesertaA->id,
            'perlombaan_id' => $perlombaan->id,
            'status' => Pendaftaran::STATUS_REGISTERED,
        ]);

        $response = $this->actingAs($pesertaB)->get(route('peserta.lomba.edit', $pendaftaran));

        $response->assertForbidden();
    }
}
