## Panduan Cloud Storage Submission

Project ini sudah disiapkan agar file submission peserta bisa tetap berjalan di lokal, lalu dipindahkan ke cloud tanpa perlu ubah logic upload lagi.

### Rekomendasi

Gunakan `Cloudflare R2` untuk file submission karena:

- kompatibel dengan driver `s3` Laravel
- biaya lebih ringan untuk file submission
- cocok untuk file desain, dokumen, dan arsip lomba

### Mode Aman Saat Ini

Default project masih memakai:

- `SUBMISSION_FILESYSTEM_DISK=public`

Artinya upload tetap tersimpan di storage lokal Laravel dan aman dipakai untuk development.

### Aktivasi R2

Ubah `.env` menjadi seperti ini:

```env
SUBMISSION_FILESYSTEM_DISK=r2

R2_ACCESS_KEY_ID=isi-dari-cloudflare
R2_SECRET_ACCESS_KEY=isi-dari-cloudflare
R2_DEFAULT_REGION=auto
R2_BUCKET=nama-bucket-kamu
R2_ENDPOINT=https://<account-id>.r2.cloudflarestorage.com
R2_URL=https://<domain-publik-atau-custom-domain>
R2_USE_PATH_STYLE_ENDPOINT=true
```

### Penjelasan Variable

- `SUBMISSION_FILESYSTEM_DISK=r2`
  Memerintahkan sistem agar upload submission memakai disk `r2`
- `R2_ENDPOINT`
  Endpoint bucket dari Cloudflare R2
- `R2_URL`
  URL publik atau custom domain untuk membuka file
- `R2_USE_PATH_STYLE_ENDPOINT=true`
  Opsi aman untuk kompatibilitas S3-style endpoint

### Setelah Update .env

Jalankan:

```bash
php artisan config:clear
php artisan submission-storage:check
```

Kalau berhasil, command akan:

- menulis file test kecil ke storage submission
- mengecek file tersebut bisa diakses
- menghapus file test kembali

### Catatan Preview File

Tidak semua file desain bisa dipreview langsung di browser, baik di lokal maupun cloud.

Biasanya browser hanya nyaman membuka:

- `pdf`
- `jpg`, `jpeg`, `png`, `webp`, `svg`
- `mp4`, `mov`

File seperti berikut biasanya tetap perlu diunduh dulu:

- `psd`
- `ai`
- `cdr`
- `zip`
- `rar`

Jadi kalau tombol `Lihat File` tidak muncul untuk file desain mentah, itu memang perilaku yang aman dan normal. Sistem akan menampilkan tombol `Unduh`.

### Fallback Lokal

Kalau ingin kembali ke storage lokal:

```env
SUBMISSION_FILESYSTEM_DISK=public
```

Untuk mode lokal, pastikan symlink storage sudah ada:

```bash
php artisan storage:link
```
