# Arsitektur Awal Aplikasi Lomba

## Role Utama

### 1. Pendaftar
- Registrasi akun dan login.
- Melihat katalog perlombaan yang tersedia.
- Mendaftar ke perlombaan.
- Mengunggah submission hasil lomba.
- Melihat nilai akhir, ranking, dan podium setelah pengumuman.

### 2. Juri
- Akun dibuat oleh admin.
- Hanya dapat mengakses perlombaan yang di-assign admin.
- Memberi nilai 0-100 pada setiap kriteria.
- Setiap kriteria punya bobot masing-masing.
- Dapat melihat histori penilaian yang pernah diberikan.

### 3. Admin
- Full akses CRUD data.
- Mengelola perlombaan, kriteria, assignment juri, dan peserta.
- Melihat detail penilaian tiap peserta.
- Memantau ranking dan podium.

## Struktur Data Inti

### `users`
- Menyimpan akun login.
- Kolom penting: `name`, `email`, `password`, `role`.

### `perlombaans`
- Master data lomba.
- Kolom penting: `nama_lomba`, `slug`, `deskripsi`, `status`, periode lomba, `announcement_at`.

### `juri_perlombaan`
- Pivot untuk assignment juri ke perlombaan tertentu.

### `kriterias`
- Daftar kriteria penilaian per perlombaan.
- Kolom penting: `nama_kriteria`, `deskripsi`, `bobot`, `urutan`.

### `pendaftarans`
- Data peserta yang mendaftar ke lomba.
- Kolom penting: `status`, `submission_title`, `submission_notes`, `file_hasil`, `submitted_at`, `final_score`.

### `penilaians`
- Nilai detail dari juri per kriteria.
- Kolom penting: `pendaftaran_id`, `user_id` (juri), `kriteria_id`, `skor`, `catatan`.

## Urutan Pengerjaan yang Disarankan

### Fase 1. Fondasi
- Role user dan middleware role.
- Dashboard awal per role.
- Schema dasar lomba, kriteria, pendaftaran, penilaian, assignment juri.

### Fase 2. Admin Panel Dasar
- CRUD perlombaan.
- CRUD kriteria per perlombaan.
- Assignment juri ke perlombaan.

### Fase 3. Flow Peserta
- Katalog lomba.
- Form daftar perlombaan.
- Upload/update submission.
- Riwayat lomba yang diikuti.

### Fase 4. Flow Juri
- Daftar lomba yang dipegang juri.
- Daftar submission peserta.
- Form penilaian per kriteria.
- Simpan nilai dan catatan.

### Fase 5. Hasil dan Podium
- Hitung nilai akhir berbobot.
- Ranking peserta per perlombaan.
- Tampilkan podium.
- Halaman detail rekap nilai.

## Rumus Nilai yang Disarankan

Nilai akhir peserta:

`sum((skor_kriteria / 100) * bobot_kriteria)`

Jika bobot menggunakan total 100, hasil akhir akan berada pada skala 0-100.

## Akun Seed Awal

- Admin: `admin@kitelay.test` / `password`
- Juri: `juri@kitelay.test` / `password`
- Peserta: `peserta@kitelay.test` / `password`

## Langkah Berikutnya

Setelah fase fondasi ini, pengerjaan yang paling pas adalah:

1. Bangun CRUD perlombaan untuk admin.
2. Tambahkan CRUD kriteria dan assignment juri.
3. Lanjut ke katalog lomba dan pendaftaran peserta.
