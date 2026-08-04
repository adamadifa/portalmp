<div class="border border-gray-100 rounded-2xl overflow-hidden shadow-md bg-white flex flex-col">
    <!-- Card Header with Solid Blue & Search Input (Fixed at Top of Modal Component) -->
    <div class="px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-[#294C9A] text-white shrink-0">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <h3 class="font-bold text-sm tracking-wide">Daftar Produk Tersedia</h3>
        </div>
        <!-- Embedded Search Bar inside Card Header -->
        <div class="relative w-full sm:w-64">
            <input type="text" id="search_produk_modal" class="w-full h-[32px] pl-9 pr-3 text-xs font-semibold text-gray-800 bg-white/95 hover:bg-white focus:bg-white border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-white/20 transition placeholder-gray-400" placeholder="Cari nama atau kode..." autocomplete="off">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
        </div>
    </div>

    <!-- Scrollable Table Container (Only Table Body Scrolls, Header is Sticky) -->
    <div class="overflow-y-auto max-h-[380px]">
        <table class="w-full text-xs text-left border-collapse" id="tabelproduk_modal">
            <thead class="sticky top-0 bg-[#294C9A] text-white z-10">
                <tr>
                    <th class="py-3 px-5 font-bold uppercase tracking-wider whitespace-nowrap" style="width: 15%;">Kode</th>
                    <th class="py-3 px-5 font-bold uppercase tracking-wider whitespace-nowrap" style="width: 40%;">Nama Produk</th>
                    <th class="py-3 px-5 font-bold uppercase tracking-wider text-center whitespace-nowrap" style="width: 10%;">Satuan</th>
                    <th class="py-3 px-5 font-bold uppercase tracking-wider text-right whitespace-nowrap" style="width: 25%;">Harga / Dus</th>
                    <th class="py-3 px-5 font-bold uppercase tracking-wider text-center whitespace-nowrap" style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white" id="list_produk_modal">
                @foreach ($produk as $d)
                    <tr class="hover:bg-blue-50/30 transition-colors duration-150 product-row" data-search="{{ strtolower($d->kode_produk . ' ' . $d->nama_produk) }}">
                        <td class="py-3 px-5 font-mono font-bold text-[#294C9A]">{{ $d->kode_produk }}</td>
                        <td class="py-3 px-5 font-semibold text-gray-900">{{ $d->nama_produk }}</td>
                        <td class="py-3 px-5 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-800">
                                {{ $d->satuan }}
                            </span>
                        </td>
                        <td class="py-3 px-5 text-right font-bold text-gray-900">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                        <td class="py-3 px-5 text-center">
                            <a href="#" class="pilihProduk inline-flex items-center justify-center px-3.5 py-1.5 bg-[#294C9A] hover:bg-[#1E3A70] text-white rounded-xl text-[11px] font-bold transition shadow-sm active:scale-95 duration-100" 
                               kode_produk="{{ $d->kode_produk }}" 
                               nama_produk="{{ $d->nama_produk }}" 
                               harga_dus="{{ $d->harga }}">
                                Pilih
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Live Search inside Modal
    $('#search_produk_modal').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('.product-row').filter(function() {
            $(this).toggle($(this).data('search').indexOf(value) > -1);
        });
    });
</script>
