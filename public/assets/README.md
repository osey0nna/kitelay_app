Folder ini disiapkan untuk asset statis publik seperti logo, foto, ikon, dan gambar pendukung UI.

Struktur yang disarankan:
- `public/assets/logos` untuk logo utama, logo partner, atau identitas brand
- `public/assets/images` untuk foto, banner, hero image, dan ilustrasi
- `public/assets/icons` untuk ikon custom jika nanti dibutuhkan

Contoh pemakaian di Blade:
- `{{ asset('assets/logos/logo.png') }}`
- `{{ asset('assets/images/hero-banner.jpg') }}`
