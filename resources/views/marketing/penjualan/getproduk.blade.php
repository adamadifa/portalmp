<div class="border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-lg bg-white dark:bg-slate-900 flex flex-col">
    <!-- Card Header with Corporate Navy & Search Input -->
    <div class="px-5 py-3.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-[#162a5b] text-white shrink-0">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white shrink-0">
                <i data-lucide="package" class="w-4 h-4"></i>
            </div>
            <div>
                <h3 class="font-bold text-xs uppercase tracking-wider text-white">Katalog Produk Tersedia</h3>
                <p class="text-[10px] text-white/70">Klik salah satu produk untuk menambahkan ke faktur</p>
            </div>
        </div>
        <!-- Search Bar inside Header -->
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-3.5 h-3.5"></i>
            </div>
            <input 
                type="text" 
                id="search_produk_modal" 
                class="w-full h-8 pl-8 pr-3 text-xs font-medium text-slate-800 bg-white/95 hover:bg-white focus:bg-white border-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-white/40 transition placeholder-slate-400 shadow-2xs" 
                placeholder="Cari nama atau kode produk..." 
                autocomplete="off"
            >
        </div>
    </div>

    <!-- Scrollable Table Container -->
    <div class="overflow-y-auto max-h-[380px] divide-y divide-slate-100 dark:divide-slate-800">
        <table class="w-full text-xs text-left border-collapse" id="tabelproduk_modal">
            <thead class="sticky top-0 bg-slate-50 dark:bg-slate-800/90 backdrop-blur-xs text-slate-600 dark:text-slate-300 z-10 border-b border-slate-200 dark:border-slate-700">
                <tr>
                    <th class="py-2.5 px-4 font-bold uppercase tracking-wider whitespace-nowrap text-[11px]" style="width: 15%;">Kode</th>
                    <th class="py-2.5 px-4 font-bold uppercase tracking-wider whitespace-nowrap text-[11px]" style="width: 45%;">Nama Produk</th>
                    <th class="py-2.5 px-4 font-bold uppercase tracking-wider text-center whitespace-nowrap text-[11px]" style="width: 10%;">Satuan</th>
                    <th class="py-2.5 px-4 font-bold uppercase tracking-wider text-right whitespace-nowrap text-[11px]" style="width: 20%;">Harga / Dus</th>
                    <th class="py-2.5 px-4 font-bold uppercase tracking-wider text-center whitespace-nowrap text-[11px]" style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-slate-900" id="list_produk_modal">
                @forelse ($produk as $d)
                    <tr class="hover:bg-blue-50/40 dark:hover:bg-slate-800/60 transition-colors product-row" data-search="{{ strtolower($d->kode_produk . ' ' . $d->nama_produk) }}">
                        <td class="py-2.5 px-4 font-mono font-bold">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200/50 dark:border-blue-700/30">
                                {{ $d->kode_produk }}
                            </span>
                        </td>
                        <td class="py-2.5 px-4 font-semibold text-slate-800 dark:text-slate-100">{{ $d->nama_produk }}</td>
                        <td class="py-2.5 px-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                {{ $d->satuan }}
                            </span>
                        </td>
                        <td class="py-2.5 px-4 text-right font-bold text-slate-800 dark:text-white">
                            Rp {{ number_format($d->harga, 0, ',', '.') }}
                        </td>
                        <td class="py-2.5 px-4 text-center">
                            <button 
                                type="button" 
                                class="pilihProduk inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-[#162a5b] hover:bg-[#1f3a7a] text-white rounded-lg text-xs font-bold transition shadow-2xs active:scale-95 cursor-pointer" 
                                kode_produk="{{ $d->kode_produk }}" 
                                nama_produk="{{ $d->nama_produk }}" 
                                satuan="{{ $d->satuan }}"
                                harga_dus="{{ $d->harga }}"
                            >
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                <span>Pilih</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 dark:text-slate-500">
                            <p class="text-xs">Tidak ada data produk yang aktif.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Live Instant Search inside Modal
    $('#search_produk_modal').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('.product-row').filter(function() {
            $(this).toggle($(this).data('search').indexOf(value) > -1);
        });
    });
</script>
