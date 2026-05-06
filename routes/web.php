<?php

use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\HasilPerlombaanController;
use App\Http\Controllers\Admin\JuriAssignmentController;
use App\Http\Controllers\Admin\PerlombaanController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Juri\PenilaianController as JuriPenilaianController;
use App\Http\Controllers\Peserta\LombaController as PesertaLombaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicAnnouncementController;
use App\Http\Controllers\PublicExploreController;
use App\Models\Perlombaan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $featuredCompetitions = collect();

    if (Schema::hasTable('perlombaans')) {
        $featuredCompetitions = Perlombaan::query()
            ->withCount(['kriterias', 'pendaftarans', 'juris'])
            ->whereIn('status', [
                Perlombaan::STATUS_REGISTRATION_OPEN,
                Perlombaan::STATUS_ONGOING,
                Perlombaan::STATUS_JUDGING,
                Perlombaan::STATUS_FINISHED,
            ])
            ->latest()
            ->take(3)
            ->get();
    }

    return view('welcome', compact('featuredCompetitions'));
});

Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{perlombaan}', [PublicAnnouncementController::class, 'show'])->name('pengumuman.show');
Route::get('/explore', [PublicExploreController::class, 'index'])->name('explore.index');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route untuk halaman Syarat & Ketentuan
Route::get('/syarat-ketentuan', function () {
    return view('syarat_ketentuan');
})->name('syarat-ketentuan');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserManagementController::class)->except('show');
    Route::resource('perlombaan', PerlombaanController::class)->except('show');
    Route::get('hasil', [HasilPerlombaanController::class, 'index'])->name('hasil.index');
    Route::resource('perlombaan.kriteria', KriteriaController::class)
        ->parameters(['kriteria' => 'kriteria'])
        ->except('show');
    Route::get('perlombaan/{perlombaan}/juri', [JuriAssignmentController::class, 'index'])->name('perlombaan.juri.index');
    Route::put('perlombaan/{perlombaan}/juri', [JuriAssignmentController::class, 'update'])->name('perlombaan.juri.update');
    Route::get('perlombaan/{perlombaan}/hasil', [HasilPerlombaanController::class, 'show'])->name('perlombaan.hasil.show');
    Route::put('perlombaan/{perlombaan}/hasil/publish', [HasilPerlombaanController::class, 'publish'])->name('perlombaan.hasil.publish');
    Route::delete('perlombaan/{perlombaan}/hasil/publish', [HasilPerlombaanController::class, 'unpublish'])->name('perlombaan.hasil.unpublish');
});

Route::middleware(['auth', 'verified', 'role:juri'])->prefix('juri')->name('juri.')->group(function () {
    Route::get('/penilaian', [JuriPenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{perlombaan}', [JuriPenilaianController::class, 'submissions'])->name('penilaian.submissions');
    Route::get('/penilaian/{perlombaan}/hasil', [JuriPenilaianController::class, 'results'])->name('penilaian.results');
    Route::get('/penilaian/{perlombaan}/pendaftaran/{pendaftaran}/file', [JuriPenilaianController::class, 'showSubmissionFile'])->name('penilaian.file.show');
    Route::get('/penilaian/{perlombaan}/pendaftaran/{pendaftaran}/file/download', [JuriPenilaianController::class, 'downloadSubmissionFile'])->name('penilaian.file.download');
    Route::get('/penilaian/{perlombaan}/pendaftaran/{pendaftaran}/edit', [JuriPenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::put('/penilaian/{perlombaan}/pendaftaran/{pendaftaran}', [JuriPenilaianController::class, 'update'])->name('penilaian.update');
});

Route::middleware(['auth', 'verified', 'role:pendaftar'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/lomba', [PesertaLombaController::class, 'index'])->name('lomba.index');
    Route::get('/lomba/{perlombaan}', [PesertaLombaController::class, 'show'])->name('lomba.show');
    Route::post('/lomba/{perlombaan}/daftar', [PesertaLombaController::class, 'register'])->name('lomba.register');
    Route::get('/lomba/pendaftaran/{pendaftaran}/edit', [PesertaLombaController::class, 'edit'])->name('lomba.edit');
    Route::put('/lomba/pendaftaran/{pendaftaran}', [PesertaLombaController::class, 'update'])->name('lomba.update');
    Route::get('/lomba/pendaftaran/{pendaftaran}/hasil', [PesertaLombaController::class, 'results'])->name('lomba.results');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
