<x-app-layout>
    <x-slot name="header">Edit Penjualan Marketing</x-slot>
    <x-slot name="headerTitle">Edit Penjualan Marketing</x-slot>
    <x-slot name="headerDescription">Penyesuaian faktur penjualan #{{ $penjualan->no_bukti }} - {{ $penjualan->nama_pelanggan }}</x-slot>

    <div class="space-y-6">

        <!-- Top Navigation Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('penjualanmarketing.show', Crypt::encrypt($penjualan->no_bukti)) }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs transition cursor-pointer"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4 text-slate-500"></i>
                    <span>Kembali ke Detail Faktur</span>
                </a>

                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold text-xs bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                    <span>Mode Edit Faktur: <strong class="font-mono">{{ $penjualan->no_bukti }}</strong></span>
                </span>
            </div>

            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                Tanda bintang (<span class="text-rose-500 font-bold">*</span>) menunjukkan kolom wajib diisi
            </div>
        </div>

        <!-- Alert Notifications -->
        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/40 text-rose-800 dark:text-rose-300 flex items-center gap-3">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                <div class="text-xs font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/40 text-rose-800 dark:text-rose-300">
                <div class="flex items-center gap-2 font-bold text-xs mb-1.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                    <span>Terdapat beberapa kesalahan input:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 dark:text-rose-400">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form -->
        <form action="{{ route('penjualanmarketing.update', Crypt::encrypt($penjualan->no_bukti)) }}" method="POST" id="formPenjualan" class="w-full" novalidate>
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column (8 cols): Product Selector & Cart Table -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <!-- Card 1: Input Item Produk -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-5 shadow-2xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-[#162a5b] text-white flex items-center justify-center shadow-2xs">
                                    <i data-lucide="package-plus" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-800 dark:text-slate-100 uppercase tracking-wider">Tambah / Ubah Item Produk</h3>
                                    <p class="text-[11px] text-slate-400">Pilih produk tambahan dari katalog jika ingin menambah daftar item</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-md uppercase">Item Editor</span>
                        </div>

                        <!-- Form Fields Grid for Item Input -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                            
                            <!-- Product Selection Trigger -->
                            <div class="sm:col-span-5">
                                <label for="nama_produk_select" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Pilih Produk <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="nama_produk_select" 
                                        class="block w-full pl-3 pr-10 py-2.5 text-xs font-semibold text-slate-800 dark:text-white bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 shadow-2xs placeholder-slate-400" 
                                        placeholder="Klik untuk pilih produk..." 
                                        readonly 
                                    />
                                    <button 
                                        type="button" 
                                        id="btnCariProduk" 
                                        class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-blue-600 transition cursor-pointer"
                                    >
                                        <i data-lucide="search" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <input type="hidden" id="kode_produk_select">
                                <input type="hidden" id="satuan_select">
                                <input type="hidden" id="harga_dus_select">
                            </div>

                            <!-- Qty Dus -->
                            <div class="sm:col-span-2">
                                <label for="qty_select" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Qty (Dus) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        id="qty_select" 
                                        min="1" 
                                        class="block w-full px-3 py-2.5 text-xs font-bold text-right text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs placeholder-slate-400" 
                                        placeholder="1" 
                                    />
                                </div>
                            </div>

                            <!-- Harga Dus -->
                            <div class="sm:col-span-3">
                                <label for="harga_select" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Harga / Dus (Rp) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="harga_select" 
                                        class="block w-full px-3 py-2.5 text-xs font-bold text-right text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs placeholder-slate-400" 
                                        placeholder="0" 
                                    />
                                </div>
                            </div>

                            <!-- Add Button -->
                            <div class="sm:col-span-2">
                                <button 
                                    type="button" 
                                    id="btnTambahProduk" 
                                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-[#162a5b] hover:bg-[#1f3a7a] text-white rounded-xl text-xs font-bold transition shadow-sm active:scale-95 cursor-pointer h-[42px]"
                                >
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                    <span>Tambah</span>
                                </button>
                            </div>
                        </div>

                        <!-- Subtotal Preview for Selected Item -->
                        <div id="subtotal_item_preview_box" class="hidden pt-2 flex items-center justify-between text-xs bg-slate-50 dark:bg-slate-800/40 px-3.5 py-2 rounded-xl border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 font-medium">Estimasi Subtotal Item:</span>
                            <span class="font-bold text-slate-800 dark:text-slate-100 font-mono" id="subtotal_item_preview_text">Rp 0</span>
                        </div>
                    </div>

                    <!-- Card 2: Keranjang Produk (Faktur Items Table) -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-2xs overflow-hidden flex flex-col min-h-[360px] justify-between">
                        <div>
                            <!-- Header Table -->
                            <div class="px-5 py-3.5 flex items-center justify-between bg-[#162a5b] text-white shrink-0">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-white">
                                        <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xs font-bold uppercase tracking-wider text-white">Daftar Produk Dalam Faktur</h3>
                                        <p class="text-[10px] text-white/70">Pastikan kuantiti dan subtotal produk sudah sesuai</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-white/15 text-white border border-white/20 rounded-lg text-xs font-bold font-mono" id="item_count_badge">
                                    {{ count($detail) }} Item
                                </span>
                            </div>

                            <!-- Items Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs text-left border-collapse" id="tabelproduk">
                                    <thead class="bg-slate-50 dark:bg-slate-800/90 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">
                                        <tr>
                                            <th class="py-2.5 px-3 font-bold uppercase tracking-wider whitespace-nowrap text-center text-[11px] w-12">NO</th>
                                            <th class="py-2.5 px-3 font-bold uppercase tracking-wider whitespace-nowrap text-[11px] w-24">KODE</th>
                                            <th class="py-2.5 px-3 font-bold uppercase tracking-wider whitespace-nowrap text-[11px]">NAMA PRODUK</th>
                                            <th class="py-2.5 px-3 font-bold uppercase tracking-wider text-right whitespace-nowrap text-[11px] w-32">HARGA / DUS</th>
                                            <th class="py-2.5 px-3 font-bold uppercase tracking-wider text-center whitespace-nowrap text-[11px] w-24">QTY</th>
                                            <th class="py-2.5 px-3 font-bold uppercase tracking-wider text-right whitespace-nowrap text-[11px] w-36">SUBTOTAL</th>
                                            <th class="py-2.5 px-3 font-bold uppercase tracking-wider text-center whitespace-nowrap text-[11px] w-12">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loadproduk" class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                                        @php 
                                            $total_initial_dpp = 0; 
                                            $total_initial_qty = 0;
                                        @endphp
                                        @forelse ($detail as $index => $d)
                                            @php 
                                                $total_initial_dpp += $d->subtotal; 
                                                $total_initial_qty += $d->jumlah;
                                            @endphp
                                            <tr id="row_{{ $d->kode_produk }}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                                                <td class="py-1 px-3 text-center font-bold text-slate-400 row-number whitespace-nowrap">{{ $index + 1 }}</td>
                                                <td class="py-1 px-3 font-mono font-bold whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200/50 dark:border-blue-700/30">
                                                        {{ $d->kode_produk }}
                                                    </span>
                                                    <input type="hidden" name="kode_produk[]" value="{{ $d->kode_produk }}">
                                                </td>
                                                <td class="py-1 px-3 font-semibold text-slate-800 dark:text-slate-100">
                                                    {{ $d->nama_produk }}
                                                </td>
                                                <td class="py-1 px-3 text-right font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">
                                                    Rp {{ number_format($d->harga_dus, 0, ',', '.') }}
                                                    <input type="hidden" name="harga_dus_produk[]" value="{{ $d->harga_dus }}">
                                                </td>
                                                <td class="py-1 px-3 text-center whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white whitespace-nowrap">
                                                        {{ $d->jumlah }} Dus
                                                    </span>
                                                    <input type="hidden" name="jumlah_produk[]" class="row_qty" value="{{ $d->jumlah }}">
                                                </td>
                                                <td class="py-1 px-3 text-right font-bold text-slate-800 dark:text-white font-mono whitespace-nowrap">
                                                    Rp <span class="row_subtotal_text">{{ number_format($d->subtotal, 0, ',', '.') }}</span>
                                                    <input type="hidden" name="subtotal[]" class="row_subtotal" value="{{ $d->subtotal }}">
                                                </td>
                                                <td class="py-1 px-3 text-center whitespace-nowrap">
                                                    <button 
                                                        type="button" 
                                                        onclick="hapusRow('{{ $d->kode_produk }}')" 
                                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-rose-500 hover:text-white hover:bg-rose-500 transition cursor-pointer"
                                                        title="Hapus produk"
                                                    >
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="empty_cart_placeholder">
                                                <td colspan="7" class="py-16 text-center text-slate-400 dark:text-slate-500">
                                                    <div class="flex flex-col items-center justify-center space-y-2">
                                                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                                            <i data-lucide="package-open" class="w-6 h-6"></i>
                                                        </div>
                                                        <p class="text-xs font-semibold text-slate-600 dark:text-slate-400">Keranjang faktur masih kosong</p>
                                                        <p class="text-[11px] text-slate-400">Pilih produk pada formulir di atas untuk menambahkan ke faktur penjualan.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Footer Summary Bar inside Table -->
                        <div class="bg-slate-50/80 dark:bg-slate-800/50 px-5 py-3 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium flex items-center gap-1.5">
                                <i data-lucide="info" class="w-3.5 h-3.5 text-blue-500"></i>
                                <span>Subtotal per item dihitung dari: <strong class="text-slate-700 dark:text-slate-300">Qty × Harga/Dus</strong></span>
                            </span>
                            <span class="font-bold text-slate-700 dark:text-slate-300">
                                Total Item Terpilih: <span id="total_qty_counter" class="font-mono text-blue-600 dark:text-blue-400">{{ number_format($total_initial_qty, 0, ',', '.') }} Dus</span>
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Right Column (4 cols): Summary Card & Transaction Details -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Card 1: Ringkasan Total Tagihan Display -->
                    <div class="bg-gradient-to-br from-[#162a5b] to-[#1e3a7a] text-white rounded-2xl p-6 shadow-md relative overflow-hidden space-y-4">
                        <!-- Decorative glow -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-blue-400/10 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="relative z-10 flex items-center justify-between border-b border-white/10 pb-3">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-200 flex items-center gap-1.5">
                                <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
                                <span>Total Tagihan (+PPN 11%)</span>
                            </span>
                            <span class="text-[10px] font-semibold bg-white/15 px-2 py-0.5 rounded text-white">IDR</span>
                        </div>

                        @php
                            $total_initial_ppn = round($total_initial_dpp * 0.11);
                            $total_initial_grand = $total_initial_dpp + $total_initial_ppn;
                        @endphp

                        <!-- Big Grand Total -->
                        <div class="relative z-10">
                            <div class="text-3xl sm:text-4xl font-extrabold tracking-tight font-mono text-white break-all" id="grand_total_display">
                                Rp {{ number_format($total_initial_grand, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Calculation Breakdown -->
                        <div class="relative z-10 pt-3 border-t border-white/10 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between text-blue-100/80">
                                <span>Subtotal DPP:</span>
                                <span class="font-mono font-bold text-white" id="dpp_display">Rp {{ number_format($total_initial_dpp, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-blue-100/80">
                                <span>PPN (11%):</span>
                                <span class="font-mono font-bold text-emerald-300" id="ppn_display">Rp {{ number_format($total_initial_ppn, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Parameter Faktur & Pelanggan -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-5 shadow-2xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-800 dark:text-slate-100 uppercase tracking-wider">Parameter Faktur</h3>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-md uppercase">Faktur Aktif</span>
                        </div>

                        <!-- No. Bukti (Readonly on Edit) -->
                        <div>
                            <label for="no_bukti" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                No. Bukti Faktur
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="lock" class="w-4 h-4"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="no_bukti" 
                                    id="no_bukti" 
                                    value="{{ $penjualan->no_bukti }}" 
                                    readonly 
                                    class="block w-full pl-9 pr-3 py-2.5 text-xs font-mono font-bold uppercase text-slate-500 bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl cursor-not-allowed shadow-2xs" 
                                />
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Nomor bukti tidak dapat diubah setelah faktur dibuat</p>
                        </div>

                        <!-- Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                Tanggal Transaksi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="tanggal" 
                                    id="tanggal" 
                                    value="{{ old('tanggal', $penjualan->tanggal) }}" 
                                    required 
                                    class="block w-full pl-9 pr-3 py-2.5 text-xs font-bold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs placeholder-slate-400 flatpickr-date" 
                                    placeholder="Pilih tanggal..." 
                                    autocomplete="off" 
                                />
                            </div>
                        </div>

                        <!-- Pelanggan -->
                        <div>
                            <label for="kode_pelanggan" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                Pelanggan <span class="text-rose-500">*</span>
                            </label>
                            <select name="kode_pelanggan" id="kode_pelanggan" required class="select2-pelanggan block w-full text-xs font-semibold">
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->kode_pelanggan }}" {{ old('kode_pelanggan', $penjualan->kode_pelanggan) == $p->kode_pelanggan ? 'selected' : '' }}>
                                        {{ $p->nama_pelanggan }} ({{ $p->kode_pelanggan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Transaksi (Segmented Pill) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                Jenis Transaksi <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_transaksi" value="T" class="peer sr-only" {{ old('jenis_transaksi', $penjualan->jenis_transaksi) == 'T' ? 'checked' : '' }}>
                                    <div class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-500/10 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400 transition shadow-2xs">
                                        <i data-lucide="wallet" class="w-4 h-4"></i>
                                        <span>TUNAI</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_transaksi" value="K" class="peer sr-only" {{ old('jenis_transaksi', $penjualan->jenis_transaksi) == 'K' ? 'checked' : '' }}>
                                    <div class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-500/10 peer-checked:text-amber-700 dark:peer-checked:text-amber-400 transition shadow-2xs">
                                        <i data-lucide="calendar-clock" class="w-4 h-4"></i>
                                        <span>KREDIT</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Jenis Bayar (Conditional on Tunai) -->
                        <div id="wrapper_jenis_bayar" class="{{ $penjualan->jenis_transaksi == 'T' ? '' : 'hidden' }}">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                Metode Pembayaran Tunai <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_bayar" value="TN" class="peer sr-only" {{ old('jenis_bayar', $penjualan->jenis_bayar) == 'TN' ? 'checked' : '' }}>
                                    <div class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-500/10 peer-checked:text-blue-700 dark:peer-checked:text-blue-400 transition shadow-2xs">
                                        <i data-lucide="banknote" class="w-4 h-4"></i>
                                        <span>CASH</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_bayar" value="TR" class="peer sr-only" {{ old('jenis_bayar', $penjualan->jenis_bayar) == 'TR' ? 'checked' : '' }}>
                                    <div class="flex items-center justify-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-500/10 peer-checked:text-blue-700 dark:peer-checked:text-blue-400 transition shadow-2xs">
                                        <i data-lucide="credit-card" class="w-4 h-4"></i>
                                        <span>TRANSFER</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- Card 3: Action Buttons -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-2xs flex flex-col sm:flex-row gap-3">
                        <a 
                            href="{{ route('penjualanmarketing.show', Crypt::encrypt($penjualan->no_bukti)) }}" 
                            class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-xl transition cursor-pointer"
                        >
                            <i data-lucide="x" class="w-4 h-4 text-slate-400"></i>
                            <span>Batal</span>
                        </a>
                        <button 
                            type="button" 
                            id="btnSubmitPenjualan" 
                            class="flex-[2] inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-xl transition shadow-sm active:scale-95 cursor-pointer"
                        >
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                            <span>Update Penjualan</span>
                        </button>
                    </div>

                </div>

            </div>
        </form>

    </div>

    <!-- Modal Select Product (Catalog) -->
    @push('modals')
    <div id="modalProduk" class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl w-full max-w-3xl overflow-hidden transform scale-95 opacity-0 transition-all duration-200" id="modalProdukContentWrapper">
            <div class="bg-[#162a5b] px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-white">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-white">Katalog Produk Marketing</h3>
                </div>
                <button type="button" onclick="closeModal('modalProduk')" class="text-white/80 hover:text-white transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div id="loadProdukContent" class="max-h-[75vh] overflow-y-auto p-4 sm:p-6 bg-slate-50/50 dark:bg-slate-950">
                <!-- Loader placeholder -->
                <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                    <div class="w-8 h-8 border-3 border-[#162a5b] border-t-transparent rounded-full animate-spin mb-3"></div>
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Memuat katalog produk...</span>
                </div>
            </div>
        </div>
    </div>
    @endpush

    @push('myscript')
    <script>
        // Modal Animation Functions
        function openModal(id) {
            const modal = document.getElementById(id);
            const wrapper = document.getElementById(id + 'ContentWrapper');
            modal.classList.remove('hidden');
            setTimeout(() => {
                wrapper.classList.remove('scale-95', 'opacity-0');
                wrapper.classList.add('scale-100', 'opacity-100');
            }, 30);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            const wrapper = document.getElementById(id + 'ContentWrapper');
            wrapper.classList.remove('scale-100', 'opacity-100');
            wrapper.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modalProduk');
                if (modal && !modal.classList.contains('hidden')) {
                    closeModal('modalProduk');
                }
            }
        });

        // Re-number table rows
        function renumberRows() {
            let rowNumber = 1;
            $('#loadproduk tr:not(#empty_cart_placeholder)').each(function() {
                $(this).find('.row-number').text(rowNumber++);
            });
        }

        // Calculate Grand Total & Breakdown
        function hitungTotal() {
            let totalDPP = 0;
            let countItems = 0;
            let totalQty = 0;

            $('.row_subtotal').each(function() {
                totalDPP += parseInt($(this).val()) || 0;
                countItems++;
            });

            $('.row_qty').each(function() {
                totalQty += parseInt($(this).val()) || 0;
            });

            let totalPPN = Math.round(totalDPP * 0.11);
            let grandTotal = totalDPP + totalPPN;

            // Update UI elements
            $('#dpp_display').text('Rp ' + new Intl.NumberFormat('id-ID').format(totalDPP));
            $('#ppn_display').text('Rp ' + new Intl.NumberFormat('id-ID').format(totalPPN));
            $('#grand_total_display').text('Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal));
            $('#item_count_badge').text(countItems + ' Item');
            $('#total_qty_counter').text(new Intl.NumberFormat('id-ID').format(totalQty) + ' Dus');
        }

        // Remove row from cart
        function hapusRow(kode) {
            $('#row_' + kode).remove();
            renumberRows();
            hitungTotal();
            
            // Add back placeholder if cart is empty
            if ($('.row_subtotal').length === 0) {
                let placeholder = `
                    <tr id="empty_cart_placeholder">
                        <td colspan="7" class="py-16 text-center text-slate-400 dark:text-slate-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                    <i data-lucide="package-open" class="w-6 h-6"></i>
                                </div>
                                <p class="text-xs font-semibold text-slate-600 dark:text-slate-400">Keranjang faktur masih kosong</p>
                                <p class="text-[11px] text-slate-400">Pilih produk pada formulir di atas untuk menambahkan ke faktur penjualan.</p>
                            </div>
                        </td>
                    </tr>
                `;
                $('#loadproduk').append(placeholder);
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        }

        // Calculate estimation preview when user types qty or price
        function updateSubtotalPreview() {
            let qty = parseInt($('#qty_select').val()) || 0;
            let hargaRaw = $('#harga_select').val() || '';
            let harga = parseInt(hargaRaw.replace(/[^0-9]/g, '')) || 0;
            
            if (qty > 0 && harga > 0) {
                let subtotal = qty * harga;
                $('#subtotal_item_preview_text').text('Rp ' + new Intl.NumberFormat('id-ID').format(subtotal));
                $('#subtotal_item_preview_box').removeClass('hidden');
            } else {
                $('#subtotal_item_preview_box').addClass('hidden');
            }
        }

        $(document).ready(function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Init Select2 for Pelanggan
            if ($.fn.select2) {
                $('.select2-pelanggan').select2({
                    width: '100%',
                    placeholder: '-- Pilih Pelanggan --'
                });
            }

            // Handle Jenis Transaksi Toggle
            function toggleJenisTransaksi() {
                let selectedVal = $('input[name="jenis_transaksi"]:checked').val();
                if (selectedVal === 'T') {
                    $('#wrapper_jenis_bayar').removeClass('hidden');
                } else {
                    $('#wrapper_jenis_bayar').addClass('hidden');
                    $('input[name="jenis_bayar"]').prop('checked', false);
                }
            }

            $('input[name="jenis_transaksi"]').on('change', toggleJenisTransaksi);

            // Format Harga Input with Thousand Separators
            $('#harga_select').on('keyup', function() {
                let number = $(this).val().replace(/[^,\d]/g, '').toString();
                let split = number.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                $(this).val(rupiah);
                updateSubtotalPreview();
            });

            $('#qty_select').on('input keyup', function() {
                updateSubtotalPreview();
            });

            // Enter key on qty triggers add
            $('#qty_select, #harga_select').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#btnTambahProduk').trigger('click');
                }
            });

            // Open Catalog Modal
            $('#nama_produk_select, #btnCariProduk').on('click', function(e) {
                e.preventDefault();
                openModal('modalProduk');
                $('#loadProdukContent').load('/penjualanmarketing/produk/getproduk', function() {
                    if (typeof lucide !== 'undefined') lucide.createIcons();

                    // Click handler on "Pilih" button inside modal
                    $('.pilihProduk').on('click', function(e) {
                        e.preventDefault();
                        let kode = $(this).attr('kode_produk');
                        let nama = $(this).attr('nama_produk');
                        let satuan = $(this).attr('satuan') || 'DUS';
                        let harga = $(this).attr('harga_dus') || 0;

                        $('#kode_produk_select').val(kode);
                        $('#nama_produk_select').val(nama + ' (' + kode + ')');
                        $('#satuan_select').val(satuan);
                        $('#harga_dus_select').val(harga);
                        
                        // Populate and format price
                        $('#harga_select').val(new Intl.NumberFormat('id-ID').format(harga));
                        
                        // Default qty to 1 if empty
                        if (!$('#qty_select').val() || parseInt($('#qty_select').val()) <= 0) {
                            $('#qty_select').val('1');
                        }

                        updateSubtotalPreview();
                        closeModal('modalProduk');
                        $('#qty_select').focus().select();
                    });
                });
            });

            // Add Product to Cart Table
            $('#btnTambahProduk').on('click', function() {
                let kode = $('#kode_produk_select').val();
                let nama = $('#nama_produk_select').val();
                let qty = parseInt($('#qty_select').val()) || 0;
                let hargaRaw = $('#harga_select').val() || '';
                let harga = parseInt(hargaRaw.replace(/[^0-9]/g, '')) || 0;

                // Validation 1: Product selection
                if (!kode || !nama) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Produk Belum Dipilih',
                        text: 'Silakan pilih produk dari katalog terlebih dahulu.',
                        confirmButtonColor: '#162a5b'
                    });
                    $('#nama_produk_select').trigger('click');
                    return;
                }

                // Validation 2: Qty check
                if (qty <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Kuantiti Tidak Valid',
                        text: 'Jumlah kuantiti dus harus minimal 1.',
                        confirmButtonColor: '#162a5b'
                    });
                    $('#qty_select').focus();
                    return;
                }

                // Validation 3: Harga check
                if (harga <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Harga Tidak Valid',
                        text: 'Harga produk per dus harus lebih dari Rp 0.',
                        confirmButtonColor: '#162a5b'
                    });
                    $('#harga_select').focus();
                    return;
                }

                // Validation 4: Duplicate product check
                if ($('#row_' + kode).length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Produk Sudah Ada',
                        text: 'Produk ini sudah ada di dalam keranjang faktur.',
                        confirmButtonColor: '#162a5b'
                    });
                    return;
                }

                // Remove placeholder row if present
                $('#empty_cart_placeholder').remove();

                let subtotal = qty * harga;

                let row = `
                    <tr id="row_${kode}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="py-1 px-3 text-center font-bold text-slate-400 row-number whitespace-nowrap"></td>
                        <td class="py-1 px-3 font-mono font-bold whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200/50 dark:border-blue-700/30">
                                ${kode}
                            </span>
                            <input type="hidden" name="kode_produk[]" value="${kode}">
                        </td>
                        <td class="py-1 px-3 font-semibold text-slate-800 dark:text-slate-100">
                            ${nama}
                        </td>
                        <td class="py-1 px-3 text-right font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">
                            Rp ${new Intl.NumberFormat('id-ID').format(harga)}
                            <input type="hidden" name="harga_dus_produk[]" value="${harga}">
                        </td>
                        <td class="py-1 px-3 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white whitespace-nowrap">
                                ${qty} Dus
                            </span>
                            <input type="hidden" name="jumlah_produk[]" class="row_qty" value="${qty}">
                        </td>
                        <td class="py-1 px-3 text-right font-bold text-slate-800 dark:text-white font-mono whitespace-nowrap">
                            Rp <span class="row_subtotal_text">${new Intl.NumberFormat('id-ID').format(subtotal)}</span>
                            <input type="hidden" name="subtotal[]" class="row_subtotal" value="${subtotal}">
                        </td>
                        <td class="py-1 px-3 text-center whitespace-nowrap">
                            <button 
                                type="button" 
                                onclick="hapusRow('${kode}')" 
                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-rose-500 hover:text-white hover:bg-rose-500 transition cursor-pointer"
                                title="Hapus produk"
                            >
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#loadproduk').append(row);
                renumberRows();
                hitungTotal();
                if (typeof lucide !== 'undefined') lucide.createIcons();

                // Clear selection fields
                $('#kode_produk_select').val('');
                $('#nama_produk_select').val('');
                $('#satuan_select').val('');
                $('#harga_dus_select').val('');
                $('#qty_select').val('1');
                $('#harga_select').val('');
                $('#subtotal_item_preview_box').addClass('hidden');

                // Quick toast
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Item ditambahkan ke faktur',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });

            // Submit Validation & Handling
            $('#btnSubmitPenjualan').on('click', function(e) {
                e.preventDefault();

                let tanggal = $('#tanggal').val().trim();
                let kodePelanggan = $('#kode_pelanggan').val();
                let jenisTransaksi = $('input[name="jenis_transaksi"]:checked').val();
                let jenisBayar = $('input[name="jenis_bayar"]:checked').val();
                let itemCount = $('.row_subtotal').length;

                // Validate 1: Tanggal
                if (!tanggal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Transaksi Wajib Diisi',
                        text: 'Silakan pilih tanggal transaksi faktur.',
                        confirmButtonColor: '#162a5b'
                    });
                    $('#tanggal').focus();
                    return;
                }

                // Validate 2: Pelanggan
                if (!kodePelanggan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pelanggan Belum Dipilih',
                        text: 'Silakan pilih pelanggan penerima faktur.',
                        confirmButtonColor: '#162a5b'
                    });
                    if ($.fn.select2) {
                        $('.select2-pelanggan').select2('open');
                    } else {
                        $('#kode_pelanggan').focus();
                    }
                    return;
                }

                // Validate 3: Jenis Transaksi
                if (!jenisTransaksi) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Jenis Transaksi',
                        text: 'Silakan tentukan jenis transaksi (TUNAI atau KREDIT).',
                        confirmButtonColor: '#162a5b'
                    });
                    return;
                }

                // Validate 4: Jenis Bayar jika Tunai
                if (jenisTransaksi === 'T' && !jenisBayar) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Metode Bayar',
                        text: 'Untuk transaksi Tunai, wajib memilih metode pembayaran (Cash atau Transfer).',
                        confirmButtonColor: '#162a5b'
                    });
                    return;
                }

                // Validate 5: Cart Items minimum 1
                if (itemCount === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Keranjang Faktur Kosong',
                        text: 'Harap tambahkan minimal 1 produk ke dalam faktur sebelum memperbarui.',
                        confirmButtonColor: '#162a5b'
                    });
                    $('#nama_produk_select').trigger('click');
                    return;
                }

                // Confirmation Prompt
                Swal.fire({
                    title: 'Perbarui Faktur Penjualan?',
                    text: `Perubahan faktur {{ $penjualan->no_bukti }} dengan ${itemCount} produk akan disimpan.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#162a5b',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Perbarui',
                    cancelButtonText: 'Periksa Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disable button and show spinner
                        $('#btnSubmitPenjualan').prop('disabled', true).html(`
                            <div class="inline-flex items-center justify-center gap-1.5">
                                <div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                <span>Menyimpan Perubahan...</span>
                            </div>
                        `);

                        $('#formPenjualan').submit();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
