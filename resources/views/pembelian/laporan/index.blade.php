<x-app-layout>
    <x-slot name="header">Laporan Pembelian</x-slot>
    <x-slot name="headerTitle">Laporan Pembelian</x-slot>
    <x-slot name="headerDescription">Pusat pencetakan dan ekspor data laporan faktur pembelian, histori pembayaran, kartu hutang, analisa umur hutang, dan rekapitulasi barang.</x-slot>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="space-y-6">

        <!-- Top Overview Header -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs">
                    <i data-lucide="printer" class="w-4 h-4 text-[#162a5b] dark:text-blue-400"></i>
                    <span>Modul Cetak Laporan Pembelian</span>
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-blue-50 dark:bg-blue-900/20 text-[#162a5b] dark:text-blue-300 border border-blue-200/60 dark:border-blue-800/40">
                    <i data-lucide="file-check-2" class="w-3.5 h-3.5 text-[#162a5b] dark:text-blue-400"></i>
                    <span>12 Modul Laporan Siap Cetak</span>
                </span>
            </div>
        </div>

        <!-- Master-Detail 2-Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column (4 cols): Report Navigation Cards -->
            <div class="lg:col-span-4 space-y-4">
                
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-2xs space-y-3">
                    
                    <!-- Search Filter for Modules -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        </div>
                        <input 
                            type="text" 
                            id="reportSearch" 
                            placeholder="Cari modul laporan..." 
                            class="w-full pl-8 pr-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-800 text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs font-medium"
                        />
                    </div>

                    <div id="reportNavList" class="space-y-3 max-h-[calc(100vh-280px)] overflow-y-auto pr-1">
                        
                        <!-- Group 1: Transaksi & Pembayaran -->
                        <div class="report-group space-y-1.5">
                            <div class="px-2 pt-1 flex items-center justify-between text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                <span>Transaksi & Pembayaran</span>
                                <span class="text-[9px] px-1 rounded bg-slate-100 dark:bg-slate-800 font-mono">3</span>
                            </div>

                            <!-- Tab 1: Pembelian -->
                            <button 
                                type="button" 
                                data-tab="pembelian" 
                                class="tab-btn active w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="receipt" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Laporan Pembelian</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">Detail</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Faktur, item barang, akun, dan pajak</p>
                                </div>
                            </button>

                            <!-- Tab 2: Pembayaran -->
                            <button 
                                type="button" 
                                data-tab="pembayaran" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Laporan Pembayaran</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300">Histori</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Histori pembayaran tagihan kas & bank</p>
                                </div>
                            </button>

                            <!-- Tab 3: Rekap PO -->
                            <button 
                                type="button" 
                                data-tab="rekappo" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Rekap PO (Purchase Order)</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-cyan-100 dark:bg-cyan-900/50 text-cyan-700 dark:text-cyan-300">PO</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Monitoring pemesanan & realisasi beli</p>
                                </div>
                            </button>
                        </div>

                        <!-- Group 2: Hutang & Kontrabon -->
                        <div class="report-group space-y-1.5 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <div class="px-2 pt-1 flex items-center justify-between text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                <span>Hutang & Kontrabon</span>
                                <span class="text-[9px] px-1 rounded bg-slate-100 dark:bg-slate-800 font-mono">3</span>
                            </div>

                            <!-- Tab 4: Kartu Hutang -->
                            <button 
                                type="button" 
                                data-tab="kartuhutang" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="wallet-cards" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Kartu Hutang</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">Hutang</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Buku pembantu hutang supplier</p>
                                </div>
                            </button>

                            <!-- Tab 5: AUH -->
                            <button 
                                type="button" 
                                data-tab="auh" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="clock-8" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Analisa Umur Hutang (AUH)</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-300">AUH</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Distribusi umur tagihan jatuh tempo</p>
                                </div>
                            </button>

                            <!-- Tab 6: Rekap Kontrabon -->
                            <button 
                                type="button" 
                                data-tab="rekapkontrabon" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Rekap Kontrabon</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300">Kontrabon</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Rangkuman berkas kontrabon tagihan</p>
                                </div>
                            </button>
                        </div>

                        <!-- Group 3: Rekapitulasi Pembelian & Barang -->
                        <div class="report-group space-y-1.5 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <div class="px-2 pt-1 flex items-center justify-between text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                <span>Rekapitulasi & Barang</span>
                                <span class="text-[9px] px-1 rounded bg-slate-100 dark:bg-slate-800 font-mono">4</span>
                            </div>

                            <!-- Tab 7: Rekap Pembelian -->
                            <button 
                                type="button" 
                                data-tab="rekappembelian" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="package" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Rekap Pembelian</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">Rekap</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Akumulasi kuantiti & nilai barang</p>
                                </div>
                            </button>

                            <!-- Tab 8: Rekap Supplier -->
                            <button 
                                type="button" 
                                data-tab="rekapsupplier" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Rekap Supplier</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-sky-100 dark:bg-sky-900/50 text-sky-700 dark:text-sky-300">Supplier</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Total pembelanjaan per mitra supplier</p>
                                </div>
                            </button>

                            <!-- Tab 9: Bahan Kemasan -->
                            <button 
                                type="button" 
                                data-tab="bahankemasan" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="boxes" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Bahan Baku & Kemasan</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-teal-100 dark:bg-teal-900/50 text-teal-700 dark:text-teal-300">Bahan</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Rincian pengadaan material produksi</p>
                                </div>
                            </button>

                            <!-- Tab 10: Rekap Kemasan / Supplier -->
                            <button 
                                type="button" 
                                data-tab="rekapbahankemasan" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="layers" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Kemasan per Supplier</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-lime-100 dark:bg-lime-900/50 text-lime-700 dark:text-lime-300">Kemasan</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Rangkuman kemasan per pemasok</p>
                                </div>
                            </button>
                        </div>

                        <!-- Group 4: Jurnal & Akuntansi -->
                        <div class="report-group space-y-1.5 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <div class="px-2 pt-1 flex items-center justify-between text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                <span>Jurnal & Akuntansi</span>
                                <span class="text-[9px] px-1 rounded bg-slate-100 dark:bg-slate-800 font-mono">2</span>
                            </div>

                            <!-- Tab 11: Rekap Akun -->
                            <button 
                                type="button" 
                                data-tab="rekapakun" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="book-open" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Rekap Akun COA</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">COA</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Distribusi beban & biaya pembelian</p>
                                </div>
                            </button>

                            <!-- Tab 12: Jurnal Koreksi -->
                            <button 
                                type="button" 
                                data-tab="jurnalkoreksi" 
                                class="tab-btn w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="file-edit" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Jurnal Koreksi</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-300">Koreksi</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Daftar penyesuaian selisih nilai faktur</p>
                                </div>
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Info Help Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50/50 dark:from-slate-900 dark:to-slate-900 rounded-2xl border border-blue-100 dark:border-slate-800 p-4 shadow-2xs">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-[#162a5b] text-white flex items-center justify-center shrink-0 shadow-2xs">
                            <i data-lucide="info" class="w-3.5 h-3.5"></i>
                        </div>
                        <div class="space-y-1 text-xs">
                            <h5 class="font-bold text-slate-800 dark:text-slate-200">Panduan Output Laporan</h5>
                            <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
                                Gunakan <strong>Cetak Laporan</strong> untuk pratinjau siap cetak langsung / dokumen resmi. Gunakan <strong>Export Excel</strong> untuk mengunduh format spreadsheet (.xls) terstruktur.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column (8 cols): Report Configuration Form -->
            <div class="lg:col-span-8">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-2xs overflow-hidden">
                    
                    <!-- Dynamic Panel Header (Corporate Navy #162a5b) -->
                    <div class="px-6 py-4 bg-[#162a5b] text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white shrink-0" id="header_panel_icon_wrapper">
                                <i data-lucide="receipt" class="w-4 h-4" id="header_panel_icon"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-white" id="header_panel_title">
                                    Laporan Rincian Pembelian
                                </h3>
                                <p class="text-[11px] text-white/70" id="header_panel_desc">
                                    Tentukan parameter supplier, akun, dan rentang periode transaksi faktur
                                </p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-md bg-white/15 text-[10px] font-bold text-white uppercase tracking-wider" id="header_panel_tag">
                            Detail Faktur
                        </span>
                    </div>

                    <!-- Panel Forms Container -->
                    <div class="p-6">
                        
                        <!-- Panel 1: Pembelian -->
                        <div id="panel-pembelian" class="tab-panel">
                            @include('pembelian.laporan.pembelian')
                        </div>

                        <!-- Panel 2: Pembayaran -->
                        <div id="panel-pembayaran" class="tab-panel hidden">
                            @include('pembelian.laporan.pembayaran')
                        </div>

                        <!-- Panel 3: Rekap PO -->
                        <div id="panel-rekappo" class="tab-panel hidden">
                            @include('pembelian.laporan.rekappo')
                        </div>

                        <!-- Panel 4: Kartu Hutang -->
                        <div id="panel-kartuhutang" class="tab-panel hidden">
                            @include('pembelian.laporan.kartuhutang')
                        </div>

                        <!-- Panel 5: AUH -->
                        <div id="panel-auh" class="tab-panel hidden">
                            @include('pembelian.laporan.auh')
                        </div>

                        <!-- Panel 6: Rekap Kontrabon -->
                        <div id="panel-rekapkontrabon" class="tab-panel hidden">
                            @include('pembelian.laporan.rekapkontrabon')
                        </div>

                        <!-- Panel 7: Rekap Pembelian -->
                        <div id="panel-rekappembelian" class="tab-panel hidden">
                            @include('pembelian.laporan.rekappembelian')
                        </div>

                        <!-- Panel 8: Rekap Supplier -->
                        <div id="panel-rekapsupplier" class="tab-panel hidden">
                            @include('pembelian.laporan.rekapsupplier')
                        </div>

                        <!-- Panel 9: Bahan Kemasan -->
                        <div id="panel-bahankemasan" class="tab-panel hidden">
                            @include('pembelian.laporan.bahankemasan')
                        </div>

                        <!-- Panel 10: Rekap Kemasan / Supplier -->
                        <div id="panel-rekapbahankemasan" class="tab-panel hidden">
                            @include('pembelian.laporan.rekapbahankemasan')
                        </div>

                        <!-- Panel 11: Rekap Akun -->
                        <div id="panel-rekapakun" class="tab-panel hidden">
                            @include('pembelian.laporan.rekapakun')
                        </div>

                        <!-- Panel 12: Jurnal Koreksi -->
                        <div id="panel-jurnalkoreksi" class="tab-panel hidden">
                            @include('pembelian.laporan.jurnalkoreksi')
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

    @push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <style>
        /* Active Tab State */
        .tab-btn.active {
            background-color: rgba(22, 42, 91, 0.05) !important;
            border-color: #162a5b !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .dark .tab-btn.active {
            background-color: rgba(30, 58, 122, 0.25) !important;
            border-color: #3b82f6 !important;
        }
        .tab-btn.active .tab-icon {
            background-color: #162a5b !important;
            color: #ffffff !important;
        }
        .dark .tab-btn.active .tab-icon {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }
        .tab-btn.active .tab-title {
            color: #162a5b !important;
        }
        .dark .tab-btn.active .tab-title {
            color: #93c5fd !important;
        }

        /* Select2 Modern Alignment */
        .select2-container { width: 100% !important; }
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            background-color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            padding-left: 0.5rem !important;
            padding-right: 2rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }
        .dark .select2-container--default .select2-selection--single {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            line-height: normal !important;
            padding-left: 0.25rem !important;
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #f8fafc !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 10px !important;
        }
        .select2-dropdown {
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            z-index: 9999 !important;
            overflow: hidden !important;
        }
        .dark .select2-dropdown {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        .select2-results__option {
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            padding: 8px 14px !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #162a5b !important;
            color: #ffffff !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #162a5b !important;
            box-shadow: 0 0 0 3px rgba(22, 42, 91, 0.15) !important;
        }
    </style>

    <script>
        $(function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            flatpickr.localize(flatpickr.l10ns.id);
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });

            // Select2 Initializations
            $(".select2Kodesupplier, .select2Kodebarang, .select2Kodesupplierpembayaran, .select2Kodeakun").each(function() {
                var $this = $(this);
                $this.wrap('<div class="relative"></div>').select2({
                    placeholder: $this.data('placeholder') || 'Semua',
                    allowClear: true,
                    width: '100%'
                });
            });

            // Metadata for dynamic header update
            const tabMeta = {
                pembelian: {
                    title: 'Laporan Rincian Pembelian',
                    desc: 'Tentukan parameter supplier, akun, dan rentang periode transaksi faktur',
                    icon: 'receipt',
                    tag: 'Detail Faktur'
                },
                pembayaran: {
                    title: 'Laporan Pembayaran Pembelian',
                    desc: 'Pantau histori pencairan dan pelunasan transaksi supplier via kas & bank',
                    icon: 'credit-card',
                    tag: 'Histori Bayar'
                },
                rekappo: {
                    title: 'Laporan Rekap Purchase Order (PO)',
                    desc: 'Rekapitulasi status pesanan pembelian, pemenuhan barang, dan sisa PO',
                    icon: 'clipboard-list',
                    tag: 'Monitoring PO'
                },
                kartuhutang: {
                    title: 'Laporan Kartu Hutang Supplier',
                    desc: 'Buku pembantu rincian mutasi kredit hutang, pembayaran, dan saldo akhir',
                    icon: 'wallet-cards',
                    tag: 'Buku Hutang'
                },
                auh: {
                    title: 'Analisa Umur Hutang (AUH)',
                    desc: 'Pemetaan umur hutang dagang berdasarkan tanggal jatuh tempo faktur',
                    icon: 'clock-8',
                    tag: 'Analisa Umur'
                },
                rekapkontrabon: {
                    title: 'Laporan Rekap Kontrabon',
                    desc: 'Rangkuman berkas kontrabon dan jadwal pembayaran tagihan supplier',
                    icon: 'file-text',
                    tag: 'Kontrabon'
                },
                rekappembelian: {
                    title: 'Laporan Rekapitulasi Pembelian',
                    desc: 'Rangkuman akumulasi volume dan nilai pembelian per kelompok barang / supplier',
                    icon: 'package',
                    tag: 'Rekap Produk'
                },
                rekapsupplier: {
                    title: 'Laporan Rekap Belanja per Supplier',
                    desc: 'Akumulasi total nilai transaksi pengadaan per masing-masing mitra supplier',
                    icon: 'users',
                    tag: 'Per Supplier'
                },
                bahankemasan: {
                    title: 'Laporan Bahan Baku & Kemasan',
                    desc: 'Detail pengadaan bahan mentah dan material packaging pabrik',
                    icon: 'boxes',
                    tag: 'Bahan Baku'
                },
                rekapbahankemasan: {
                    title: 'Rekap Bahan Kemasan per Supplier',
                    desc: 'Rangkuman kuantiti dan nominal material kemasan per mitra supplier',
                    icon: 'layers',
                    tag: 'Rekap Kemasan'
                },
                rekapakun: {
                    title: 'Laporan Rekap Akun Biaya (COA)',
                    desc: 'Distribusi pembebanan anggaran pembelian berdasarkan bagan akun standar',
                    icon: 'book-open',
                    tag: 'Rekap COA'
                },
                jurnalkoreksi: {
                    title: 'Laporan Jurnal Koreksi Pembelian',
                    desc: 'Daftar penyesuaian selisih harga, kuantiti, atau pembetulan jurnal pembelian',
                    icon: 'file-edit',
                    tag: 'Jurnal Koreksi'
                }
            };

            // Interactive Tab Switching
            $('.tab-btn').on('click', function() {
                const targetTab = $(this).data('tab');
                
                // Toggle active styles on buttons
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                // Panel toggle
                $('.tab-panel').addClass('hidden');
                $(`#panel-${targetTab}`).removeClass('hidden');

                // Update Header
                if (tabMeta[targetTab]) {
                    $('#header_panel_title').text(tabMeta[targetTab].title);
                    $('#header_panel_desc').text(tabMeta[targetTab].desc);
                    $('#header_panel_tag').text(tabMeta[targetTab].tag);
                    
                    // Update Icon
                    $('#header_panel_icon_wrapper').html(`<i data-lucide="${tabMeta[targetTab].icon}" class="w-4 h-4"></i>`);
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }
            });

            // Live Search Filter for Report Navigation
            $('#reportSearch').on('input', function() {
                const q = $(this).val().toLowerCase().trim();
                $('.tab-btn').each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.includes(q)) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });

                // Hide empty groups
                $('.report-group').each(function() {
                    const hasVisible = $(this).find('.tab-btn:not(.hidden)').length > 0;
                    if (hasVisible) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            });

            // Quick Date Presets Handler
            $(document).on('click', '.btn-preset', function() {
                const preset = $(this).data('preset');
                const dariId = $(this).data('target-dari');
                const sampaiId = $(this).data('target-sampai');
                
                const now = new Date();
                let dariStr = '';
                let sampaiStr = '';

                const formatDate = (d) => {
                    const y = d.getFullYear();
                    const m = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    return `${y}-${m}-${day}`;
                };

                if (preset === 'today') {
                    dariStr = formatDate(now);
                    sampaiStr = formatDate(now);
                } else if (preset === 'this_month') {
                    const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
                    dariStr = formatDate(startOfMonth);
                    sampaiStr = formatDate(now);
                } else if (preset === 'last_month') {
                    const startOfLastMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                    const endOfLastMonth = new Date(now.getFullYear(), now.getMonth(), 0);
                    dariStr = formatDate(startOfLastMonth);
                    sampaiStr = formatDate(endOfLastMonth);
                }

                if (dariId && $(`#${dariId}`).length) {
                    const fp = $(`#${dariId}`)[0]._flatpickr;
                    if (fp) fp.setDate(dariStr); else $(`#${dariId}`).val(dariStr);
                }
                if (sampaiId && $(`#${sampaiId}`).length) {
                    const fp = $(`#${sampaiId}`)[0]._flatpickr;
                    if (fp) fp.setDate(sampaiStr); else $(`#${sampaiId}`).val(sampaiStr);
                }
            });

            // Validation for each form
            function validatePeriode(formId, dariFieldId = "dari", sampaiFieldId = "sampai") {
                $(`#${formId}`).submit(function() {
                    const jenisPeriode = $(this).find('select[name="jenis_periode"]').val();
                    if (jenisPeriode === 'bulan_pajak') {
                        const bulan = $(this).find('select[name="bulan"]').val();
                        const tahun = $(this).find('input[name="tahun"]').val();
                        if (bulan == "" || !bulan) {
                            Swal.fire({
                                title: "Perhatian",
                                text: 'Masa Pajak harus dipilih!',
                                icon: "warning",
                                confirmButtonColor: "#162a5b",
                                didClose: () => $(this).find('select[name="bulan"]').focus(),
                            });
                            return false;
                        }
                        if (tahun == "" || !tahun) {
                            Swal.fire({
                                title: "Perhatian",
                                text: 'Tahun Pajak harus diisi!',
                                icon: "warning",
                                confirmButtonColor: "#162a5b",
                                didClose: () => $(this).find('input[name="tahun"]').focus(),
                            });
                            return false;
                        }
                        return true;
                    }

                    const dari = $(this).find(`#${dariFieldId}`).val();
                    const sampai = $(this).find(`#${sampaiFieldId}`).val();
                    if (dari == "") {
                        Swal.fire({
                            title: "Perhatian",
                            text: 'Periode Dari Tanggal harus diisi!',
                            icon: "warning",
                            confirmButtonColor: "#162a5b",
                            didClose: () => $(this).find(`#${dariFieldId}`).focus(),
                        });
                        return false;
                    } else if (sampai == "") {
                        Swal.fire({
                            title: "Perhatian",
                            text: 'Periode Sampai Tanggal harus diisi!',
                            icon: "warning",
                            confirmButtonColor: "#162a5b",
                            didClose: () => $(this).find(`#${sampaiFieldId}`).focus(),
                        });
                        return false;
                    }
                    var start = new Date(dari);
                    var end = new Date(sampai);
                    if (start.getTime() > end.getTime()) {
                        Swal.fire({
                            title: "Perhatian",
                            text: 'Periode Sampai Tanggal harus lebih akhir dari Periode Dari Tanggal!',
                            icon: "warning",
                            confirmButtonColor: "#162a5b",
                            didClose: () => $(this).find(`#${sampaiFieldId}`).focus(),
                        });
                        return false;
                    }
                });
            }

            // Bind validations
            validatePeriode("formLapPembelian", "dari_pembelian", "sampai_pembelian");
            validatePeriode("formLapPembayaran", "dari_pembayaran", "sampai_pembayaran");
            validatePeriode("formLapRekapSupplier", "dari_rekapsupplier", "sampai_rekapsupplier");
            validatePeriode("formLapRekapPembelian", "dari_rekappembelian", "sampai_rekappembelian");
            validatePeriode("formLapKartuHutang", "dari_kartuhutang", "sampai_kartuhutang");
            $("#formLapKartuHutang").submit(function() {
                const formatlaporan = $(this).find("#formatlaporan_kartuhutang").val();
                if (formatlaporan == "") {
                    Swal.fire({
                        title: "Perhatian",
                        text: 'Format / Bentuk Laporan harus dipilih!',
                        icon: "warning",
                        confirmButtonColor: "#162a5b",
                        didClose: () => $(this).find("#formatlaporan_kartuhutang").focus(),
                    });
                    return false;
                }
            });
            validatePeriode("formLapAuh", "dari_auh", "sampai_auh");
            validatePeriode("formLapBahanKemasan", "dari_bahankemasan", "sampai_bahankemasan");
            validatePeriode("formLapRekapBahanKemasan", "dari_rekapbahankemasan", "sampai_rekapbahankemasan");
            validatePeriode("formLapJurnalKoreksi", "dari_jurnalkoreksi", "sampai_jurnalkoreksi");
            validatePeriode("formLapRekapAkun", "dari_rekapakun", "sampai_rekapakun");
            validatePeriode("formLapRekapKontrabon", "dari_rekapkontrabon", "sampai_rekapkontrabon");
            validatePeriode("formLapRekapPo", "dari_rekappo", "sampai_rekappo");
        });

        function togglePeriodePembelian(val) {
            if (val === 'bulan_pajak') {
                $('#wrapper_tanggal_pembelian').addClass('hidden');
                $('#wrapper_bulan_pajak_pembelian').removeClass('hidden');
                $('#dari_pembelian').removeAttr('required');
                $('#sampai_pembelian').removeAttr('required');
                $('#bulan_pembelian').attr('required', 'required');
                $('#tahun_pembelian').attr('required', 'required');
            } else {
                $('#wrapper_tanggal_pembelian').removeClass('hidden');
                $('#wrapper_bulan_pajak_pembelian').addClass('hidden');
                $('#dari_pembelian').attr('required', 'required');
                $('#sampai_pembelian').attr('required', 'required');
                $('#bulan_pembelian').removeAttr('required');
                $('#tahun_pembelian').removeAttr('required');
            }
        }
    </script>
    @endpush
</x-app-layout>
