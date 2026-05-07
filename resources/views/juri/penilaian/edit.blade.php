<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between relative z-10">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 rounded-sm border-l-4 border-amber-400 bg-gradient-to-r from-red-900/40 to-[#0a0a0c] px-4 py-2 w-fit shadow-[0_0_15px_rgba(251,191,36,0.1)]">
                    <span class="material-symbols-outlined text-[16px] text-amber-400">sports_score</span>
                    <span class="text-[11px] font-black uppercase tracking-widest text-amber-400">Juri Workspace</span>
                </div>
                
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-black uppercase tracking-tight text-white drop-shadow-md">
                    Penilaian <span class="text-amber-400">Peserta</span>
                </h2>
                <p class="text-xs md:text-sm font-medium text-slate-400">{{ $perlombaan->nama_lomba }} <span class="mx-2 text-neutral-600">|</span> <span class="text-white">{{ $pendaftaran->user->name }}</span></p>
            </div>

            <a href="{{ route('juri.penilaian.submissions', $perlombaan) }}" class="inline-flex items-center justify-center rounded-sm border border-neutral-700 bg-transparent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-slate-500 hover:text-white transition-all skew-x-[-10deg]">
                <span class="skew-x-[10deg]">Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 md:py-10 bg-black min-h-screen relative overflow-hidden" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 50)">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-600/5 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="mx-auto flex max-w-5xl flex-col gap-8 px-4 md:px-6 lg:px-8 relative z-10 transition-all duration-700 ease-out"
             :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            
            <section class="tilt-card rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-amber-500/40 bg-gradient-to-br from-amber-900/20 via-[#0a0a0c] to-[#050505] p-8 shadow-[0_0_30px_rgba(251,191,36,0.15)] relative overflow-hidden ring-1 ring-inset ring-white/5">
                
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-300 via-amber-500 to-orange-600 shadow-[0_0_15px_rgba(251,191,36,0.8)]"></div>
                
                <div class="grid gap-6 md:grid-cols-3 relative z-10">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-amber-500/80 mb-1">Nama Peserta</p>
                        <p class="text-xl font-black text-white uppercase tracking-wide drop-shadow-md">{{ $pendaftaran->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-amber-500/80 mb-1">Judul Karya</p>
                        <p class="text-lg font-bold text-amber-400 drop-shadow-md">{{ $pendaftaran->submission_title ?: 'Belum ada judul' }}</p>
                    </div>
                    <div class="rounded-xl bg-black/40 border border-amber-900/30 p-4 backdrop-blur-sm">
                        <p class="text-[10px] font-black uppercase tracking-widest text-amber-500 mb-2">File Submission</p>
                        @if ($pendaftaran->submission_file_url)
                            <div class="flex flex-col gap-3">
                                <p class="text-[12px] font-mono text-slate-300 truncate" title="{{ $pendaftaran->submission_file_name }}">{{ $pendaftaran->submission_file_name }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @if ($pendaftaran->submission_file_is_previewable)
                                        <a href="{{ route('juri.penilaian.file.show', [$perlombaan, $pendaftaran]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-sm bg-sky-900/40 border border-sky-400/50 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-sky-400 hover:bg-sky-600 hover:text-white transition-colors skew-x-[-10deg] shadow-[0_0_10px_rgba(56,189,248,0.2)]">
                                            <span class="skew-x-[10deg]">Lihat File</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('juri.penilaian.file.download', [$perlombaan, $pendaftaran]) }}" class="inline-flex items-center justify-center rounded-sm border border-amber-500/50 bg-amber-900/30 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-amber-400 hover:bg-amber-500 hover:text-black transition-colors skew-x-[-10deg] shadow-[0_0_10px_rgba(251,191,36,0.1)]">
                                        <span class="skew-x-[10deg]">Unduh</span>
                                    </a>
                                </div>
                                @unless ($pendaftaran->submission_file_is_previewable)
                                    <p class="text-[10px] leading-relaxed text-amber-500/80 mt-1">Format tidak mendukung preview. Harap unduh file.</p>
                                @endunless
                            </div>
                        @else
                            <p class="text-[12px] font-medium text-red-500">Belum ada file yang diunggah.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-amber-900/30 relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-500/80 mb-2">Catatan Peserta</p>
                    <p class="text-[13px] leading-relaxed text-slate-300 italic">"{{ $pendaftaran->submission_notes ?: 'Tidak ada catatan tambahan dari peserta.' }}"</p>
                </div>
            </section>

            <form method="POST" action="{{ route('juri.penilaian.update', [$perlombaan, $pendaftaran]) }}" class="rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-sm rounded-bl-sm border border-neutral-800 bg-[#0a0a0c] p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-2 h-full bg-gradient-to-b from-amber-400 to-red-600"></div>
                
                @csrf
                @method('PUT')

                <div class="space-y-6 relative z-10">
                    <h3 class="text-xl font-black uppercase tracking-wide text-white border-b border-neutral-800 pb-4 mb-6">Lembar Skor Juri</h3>

                    @foreach ($perlombaan->kriterias as $index => $kriteria)
                        @php
                            $existing = $existingScores->get($kriteria->id);
                        @endphp
                        
                        <div class="rounded-xl border border-neutral-800 bg-[#050505] p-6 transition-colors hover:border-amber-500/30 group">
                            <input type="hidden" name="scores[{{ $index }}][kriteria_id]" value="{{ $kriteria->id }}">

                            <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                                <div class="flex-1">
                                    <span class="inline-block px-3 py-1 mb-3 text-[9px] font-black uppercase tracking-widest bg-amber-900/20 text-amber-500 border border-amber-500/20 skew-x-[-10deg]">
                                        <span class="skew-x-[10deg]">Bobot {{ $kriteria->bobot }}%</span>
                                    </span>
                                    <h4 class="text-lg font-black text-white tracking-wide uppercase">{{ $kriteria->nama_kriteria }}</h4>
                                    <p class="mt-2 text-[12px] leading-relaxed text-slate-500">{{ $kriteria->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>
                                </div>
                                
                                <div class="w-full md:w-48 shrink-0">
                                    <label for="scores_{{ $index }}_skor" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 md:text-right">Skor (0-100)</label>
                                    <input type="number" id="scores_{{ $index }}_skor" name="scores[{{ $index }}][skor]" min="0" max="100" 
                                           value="{{ old('scores.'.$index.'.skor', $existing?->skor) }}" required
                                           class="block w-full rounded-sm border border-neutral-800 bg-black px-4 py-4 text-3xl font-black text-amber-400 text-center focus:border-amber-400 focus:ring-amber-400 transition-colors shadow-inner">
                                    @error('scores.'.$index.'.skor')
                                        <p class="mt-2 text-[10px] font-bold text-red-500 uppercase md:text-right">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 border-t border-neutral-800/50 pt-5">
                                <label for="scores_{{ $index }}_catatan" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Catatan Evaluasi (Opsional)</label>
                                <textarea id="scores_{{ $index }}_catatan" name="scores[{{ $index }}][catatan]" rows="2" 
                                          placeholder="Berikan alasan atau feedback untuk skor di atas..."
                                          class="block w-full rounded-sm border border-neutral-800 bg-black px-4 py-3 text-[13px] text-white focus:border-amber-400 focus:ring-amber-400 transition-colors">{{ old('scores.'.$index.'.catatan', $existing?->catatan) }}</textarea>
                                @error('scores.'.$index.'.catatan')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-neutral-800 pt-8 relative z-10">
                    <p class="text-[11px] leading-relaxed text-slate-500 max-w-md">Pastikan semua skor telah terisi dengan rentang 0-100. Nilai akan otomatis dikalkulasi berdasarkan bobot kriteria.</p>
                    <button type="submit" class="inline-flex items-center justify-center rounded-sm bg-gradient-to-r from-red-600 to-red-800 px-8 py-4 text-[12px] font-black uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:shadow-[0_0_25px_rgba(251,191,36,0.3)] hover:scale-105 hover:border-amber-400 border border-transparent transition-all skew-x-[-10deg]">
                        <span class="skew-x-[10deg]">Simpan Penilaian</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tiltElements = document.querySelectorAll('.tilt-card, .tilt-row');
            
            tiltElements.forEach(el => {
                el.style.transformStyle = 'preserve-3d';
                
                el.addEventListener('mouseenter', () => {
                    el.style.transition = 'transform 0.1s ease-out, box-shadow 0.1s ease-out';
                    el.style.zIndex = "50"; 
                });

                el.addEventListener('mousemove', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    // Rotasi Ekstrem
                    const rotateX = ((y - centerY) / centerY) * -12; 
                    const rotateY = ((x - centerX) / centerX) * 12;
                    const scale = el.classList.contains('tilt-row') ? 1.02 : 1.05;
                    
                    el.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(${scale})`;

                    // Glow Dinamis Amber Juri
                    const shadowX = ((x - centerX) / centerX) * -20;
                    const shadowY = ((y - centerY) / centerY) * -20;
                    el.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(251, 191, 36, 0.15), 0 0 15px rgba(220, 38, 38, 0.2)`;
                });

                el.addEventListener('mouseleave', () => {
                    el.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.6s ease-out';
                    el.style.transform = `perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)`;
                    el.style.boxShadow = '';
                    el.style.zIndex = "1";
                });
            });
        });
    </script>
</x-app-layout>