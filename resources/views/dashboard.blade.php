<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="headerTitle">Dashboard Operasional</x-slot>
    <x-slot name="headerDescription">Ringkasan aktivitas penjualan, pembelian, produksi, dan pergudangan Portal MP</x-slot>

    <div class="space-y-6">

        <!-- WELCOME BANNER (SOLID BIRU DONGKER / NAVY BLUE) -->
        <div class="relative overflow-hidden rounded-2xl bg-[#162a5b] text-white p-6 sm:p-8 border border-[#234285]/50 shadow-md">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="max-w-xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-semibold text-blue-100">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-sky-300"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white leading-tight">
                        Selamat Datang, 
                        @php
                            $nameParts = explode(' ', trim(Auth::user()->name ?? 'User'));
                            echo count($nameParts) > 1 ? $nameParts[0] . ' ' . $nameParts[1] : $nameParts[0];
                        @endphp! 👋
                    </h2>

                    <p class="text-xs sm:text-sm text-blue-100/90 leading-relaxed">
                        Kelola data operasional terpadu, monitoring inventaris gudang & logistik, serta rekap transaksi finansial dengan cepat dan presisi.
                    </p>

                    <div class="flex items-center gap-2 pt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white/15 text-white border border-white/20 text-xs font-bold">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-sky-300"></i>
                            <span>{{ Auth::user()->roles->first()->name ?? 'Administrator' }}</span>
                        </span>
                        <span class="text-[11px] text-blue-200">Pacific Portal MP v2.0</span>
                    </div>
                </div>

                @if (file_exists(public_path('karakter.png')))
                <div class="hidden md:flex items-center justify-center shrink-0 pr-4">
                    <img src="{{ asset('karakter.png') }}" alt="Portal Character" class="h-44 object-contain filter drop-shadow-2xl">
                </div>
                @endif
            </div>
        </div>

        <!-- ROW 1: TOP 4 STAT METRIC CARDS (Exact poslaravel style) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            
            <!-- Card 1: Penjualan Bulan Ini -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs flex flex-col justify-between min-h-[140px] transition-all hover:border-slate-300 dark:hover:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Penjualan Bulan Ini</h4>
                        <p class="text-[11px] text-slate-400">Total omset marketing</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 flex items-center justify-center border border-emerald-100 dark:border-emerald-500/20 shadow-2xs">
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                    </div>
                </div>

                <div class="my-2">
                    <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        Rp {{ number_format($thisMonthSales ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="flex items-center justify-between text-[11px] border-t border-slate-100 dark:border-slate-800 pt-2 text-slate-500 dark:text-slate-400">
                    <span>{{ $thisMonthTransactions ?? 0 }} transaksi faktur</span>
                    @can('penjualanmarketing.view')
                    <a href="{{ route('penjualanmarketing.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-bold flex items-center gap-0.5">
                        <span>Lihat</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                    @endcan
                </div>
            </div>

            <!-- Card 2: Pembelian Bulan Ini -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs flex flex-col justify-between min-h-[140px] transition-all hover:border-slate-300 dark:hover:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Pembelian Bulan Ini</h4>
                        <p class="text-[11px] text-slate-400">Total pengadaan bahan & barang</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 flex items-center justify-center border border-amber-100 dark:border-amber-500/20 shadow-2xs">
                        <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    </div>
                </div>

                <div class="my-2">
                    <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        Rp {{ number_format($thisMonthPurchases ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="flex items-center justify-between text-[11px] border-t border-slate-100 dark:border-slate-800 pt-2 text-slate-500 dark:text-slate-400">
                    <span>{{ $thisMonthPurchaseCount ?? 0 }} transaksi PO</span>
                    @can('pembelian.index')
                    <a href="{{ route('pembelian.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-bold flex items-center gap-0.5">
                        <span>Lihat</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                    @endcan
                </div>
            </div>

            <!-- Card 3: Biaya Operasional -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs flex flex-col justify-between min-h-[140px] transition-all hover:border-slate-300 dark:hover:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Biaya Operasional</h4>
                        <p class="text-[11px] text-slate-400">Pengeluaran kas bulan ini</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 flex items-center justify-center border border-rose-100 dark:border-rose-500/20 shadow-2xs">
                        <i data-lucide="receipt" class="w-4 h-4"></i>
                    </div>
                </div>

                <div class="my-2">
                    <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        Rp {{ number_format($thisMonthBiaya ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="flex items-center justify-between text-[11px] border-t border-slate-100 dark:border-slate-800 pt-2 text-slate-500 dark:text-slate-400">
                    <span>Pengeluaran umum</span>
                    <a href="{{ route('biaya.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-bold flex items-center gap-0.5">
                        <span>Lihat</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>

            <!-- Card 4: Katalog Master Produk & Mitra -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs flex flex-col justify-between min-h-[140px] transition-all hover:border-slate-300 dark:hover:border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200">Katalog & Rekanan</h4>
                        <p class="text-[11px] text-slate-400">Database master aktif</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 flex items-center justify-center border border-blue-100 dark:border-blue-500/20 shadow-2xs">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                    </div>
                </div>

                <div class="my-2">
                    <div class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ number_format($totalProduk ?? 0, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">SKU</span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-[11px] border-t border-slate-100 dark:border-slate-800 pt-2 text-slate-500 dark:text-slate-400">
                    <span>{{ $totalPelanggan ?? 0 }} Pelanggan • {{ $totalSupplier ?? 0 }} Pemasok</span>
                    @can('produk.view')
                    <a href="{{ route('produk.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-bold flex items-center gap-0.5">
                        <span>Master</span>
                        <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                    @endcan
                </div>
            </div>

        </div>

        <!-- ROW 2: ANALYTICS CHART & QUICK SHORTCUTS -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Left: Tren Penjualan & Pembelian (8 cols) -->
            <div class="lg:col-span-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-6 shadow-2xs relative">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Tren Performa Operasional (6 Bulan Terakhir)</h3>
                            <p class="text-[11px] text-slate-400">Perbandingan pergerakan nilai Penjualan vs Pembelian</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live Analytics
                        </span>
                    </div>
                </div>

                <div id="operationalTrendChart" class="w-full -ml-2"></div>
            </div>

            <!-- Right: Aksi Pintar & Modul Utama (4 cols) -->
            <div class="lg:col-span-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-6 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Aksi Cepat</h3>
                                <p class="text-[11px] text-slate-400">Shortcut transaksi harian</p>
                            </div>
                        </div>
                        <kbd class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">⌘K</kbd>
                    </div>

                    <div class="space-y-2">
                        @can('penjualanmarketing.view')
                        <a href="{{ route('penjualanmarketing.index') }}" class="group flex items-center justify-between p-3 rounded-xl border border-slate-100 dark:border-slate-800 hover:border-emerald-200 dark:hover:border-emerald-500/30 hover:bg-emerald-50/40 dark:hover:bg-emerald-500/5 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Penjualan Marketing</h4>
                                    <p class="text-[10px] text-slate-400">Kelola pesanan & invoice</p>
                                </div>
                            </div>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-emerald-500 group-hover:translate-x-0.5 transition"></i>
                        </a>
                        @endcan

                        @can('pembelian.index')
                        <a href="{{ route('pembelian.index') }}" class="group flex items-center justify-between p-3 rounded-xl border border-slate-100 dark:border-slate-800 hover:border-amber-200 dark:hover:border-amber-500/30 hover:bg-amber-50/40 dark:hover:bg-amber-500/5 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">Pengadaan & Pembelian</h4>
                                    <p class="text-[10px] text-slate-400">Order barang & PO supplier</p>
                                </div>
                            </div>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-amber-500 group-hover:translate-x-0.5 transition"></i>
                        </a>
                        @endcan

                        @can('samutasiproduksi.view')
                        <a href="{{ route('samutasiproduksi.index') }}" class="group flex items-center justify-between p-3 rounded-xl border border-slate-100 dark:border-slate-800 hover:border-indigo-200 dark:hover:border-indigo-500/30 hover:bg-indigo-50/40 dark:hover:bg-indigo-500/5 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                    <i data-lucide="factory" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Mutasi Produksi</h4>
                                    <p class="text-[10px] text-slate-400">Pencatatan BPBJ & FSTHP</p>
                                </div>
                            </div>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-indigo-500 group-hover:translate-x-0.5 transition"></i>
                        </a>
                        @endcan

                        <a href="{{ route('biaya.index') }}" class="group flex items-center justify-between p-3 rounded-xl border border-slate-100 dark:border-slate-800 hover:border-rose-200 dark:hover:border-rose-500/30 hover:bg-rose-50/40 dark:hover:bg-rose-500/5 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                                    <i data-lucide="receipt" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">Input Biaya Operasional</h4>
                                    <p class="text-[10px] text-slate-400">Pencatatan kas keluar</p>
                                </div>
                            </div>
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-rose-500 group-hover:translate-x-0.5 transition"></i>
                        </a>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400">
                    <span>Gunakan Spotlight</span>
                    <button type="button" onclick="document.getElementById('navSearchTrigger')?.click();" class="text-blue-600 dark:text-blue-400 font-bold hover:underline cursor-pointer">Cari Menu</button>
                </div>
            </div>

        </div>

        <!-- ROW 3: RECENT TRANSACTIONS (2 COLUMNS: PENJUALAN & PEMBELIAN) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            
            <!-- Penjualan Terkini -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-6 shadow-2xs">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Transaksi Penjualan Terakhir</h3>
                            <p class="text-[11px] text-slate-400">Data pesanan pelanggan terkini</p>
                        </div>
                    </div>
                    @can('penjualanmarketing.view')
                    <a href="{{ route('penjualanmarketing.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">Semua</a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-800">
                                <th class="pb-2.5 font-bold">No Bukti</th>
                                <th class="pb-2.5 font-bold">Pelanggan</th>
                                <th class="pb-2.5 font-bold">Tanggal</th>
                                <th class="pb-2.5 font-bold text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @forelse($recentSales as $sale)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition">
                                <td class="py-2.5 font-bold text-blue-600 dark:text-blue-400 font-mono">{{ $sale->no_bukti }}</td>
                                <td class="py-2.5 font-semibold text-slate-800 dark:text-slate-200 truncate max-w-[150px]">{{ $sale->nama_pelanggan ?? '-' }}</td>
                                <td class="py-2.5 text-slate-400">{{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}</td>
                                <td class="py-2.5 font-bold text-slate-900 dark:text-white text-right">Rp {{ number_format($sale->total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400">Belum ada transaksi penjualan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pembelian Terkini -->
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-6 shadow-2xs">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-100 dark:border-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Transaksi Pembelian Terakhir</h3>
                            <p class="text-[11px] text-slate-400">Data PO dan pengadaan ke supplier</p>
                        </div>
                    </div>
                    @can('pembelian.index')
                    <a href="{{ route('pembelian.index') }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">Semua</a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-800">
                                <th class="pb-2.5 font-bold">No Bukti</th>
                                <th class="pb-2.5 font-bold">Supplier</th>
                                <th class="pb-2.5 font-bold">Tanggal</th>
                                <th class="pb-2.5 font-bold text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @forelse($recentPurchases as $pmb)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition">
                                <td class="py-2.5 font-bold text-amber-600 dark:text-amber-400 font-mono">{{ $pmb->no_bukti }}</td>
                                <td class="py-2.5 font-semibold text-slate-800 dark:text-slate-200 truncate max-w-[150px]">{{ $pmb->nama_supplier ?? '-' }}</td>
                                <td class="py-2.5 text-slate-400">{{ \Carbon\Carbon::parse($pmb->tanggal)->format('d/m/Y') }}</td>
                                <td class="py-2.5 font-bold text-slate-900 dark:text-white text-right">Rp {{ number_format($pmb->total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400">Belum ada transaksi pembelian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    @push('myscript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ApexCharts Operational Trend Chart
            const chartEl = document.querySelector("#operationalTrendChart");
            if (chartEl && typeof ApexCharts !== 'undefined') {
                const isDark = document.documentElement.classList.contains('dark');
                
                const options = {
                    series: [
                        {
                            name: 'Penjualan Marketing',
                            data: {!! json_encode($chartSalesData ?? [0,0,0,0,0,0]) !!}
                        },
                        {
                            name: 'Pembelian & Pengadaan',
                            data: {!! json_encode($chartPurchaseData ?? [0,0,0,0,0,0]) !!}
                        }
                    ],
                    chart: {
                        type: 'area',
                        height: 310,
                        toolbar: { show: false },
                        fontFamily: 'Plus Jakarta Sans, sans-serif',
                        background: 'transparent'
                    },
                    colors: ['#2563eb', '#f59e0b'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 95, 100]
                        }
                    },
                    dataLabels: { enabled: false },
                    stroke: {
                        curve: 'smooth',
                        width: 2.5
                    },
                    xaxis: {
                        categories: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) !!},
                        labels: {
                            style: {
                                colors: isDark ? '#94a3b8' : '#64748b',
                                fontSize: '11px',
                                fontWeight: 500
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        labels: {
                            formatter: function (value) {
                                if (value >= 1000000000) return (value / 1000000000).toFixed(1) + ' M';
                                if (value >= 1000000) return (value / 1000000).toFixed(1) + ' Jt';
                                if (value >= 1000) return (value / 1000).toFixed(0) + ' Rb';
                                return value;
                            },
                            style: {
                                colors: isDark ? '#94a3b8' : '#64748b',
                                fontSize: '11px'
                            }
                        }
                    },
                    grid: {
                        borderColor: isDark ? '#1e293b' : '#f1f5f9',
                        strokeDashArray: 4
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        labels: {
                            colors: isDark ? '#f8fafc' : '#334155'
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: {
                            formatter: function (val) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                            }
                        }
                    }
                };

                const chart = new ApexCharts(chartEl, options);
                chart.render();

                window.addEventListener('themeChanged', function (e) {
                    const darkNow = e.detail.theme === 'dark';
                    chart.updateOptions({
                        xaxis: {
                            labels: { style: { colors: darkNow ? '#94a3b8' : '#64748b' } }
                        },
                        yaxis: {
                            labels: { style: { colors: darkNow ? '#94a3b8' : '#64748b' } }
                        },
                        grid: {
                            borderColor: darkNow ? '#1e293b' : '#f1f5f9'
                        },
                        legend: {
                            labels: { colors: darkNow ? '#f8fafc' : '#334155' }
                        },
                        tooltip: {
                            theme: darkNow ? 'dark' : 'light'
                        }
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
