<x-app-layout>
    <x-slot name="header">Laporan Biaya Operasional</x-slot>
    <x-slot name="headerTitle">Laporan Biaya Operasional</x-slot>
    <x-slot name="headerDescription">Pusat pencetakan dan ekspor data laporan transaksi biaya operasional, histori pembayaran kas & bank, dan rekapitulasi akun beban (COA).</x-slot>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="space-y-6">

        <!-- Top Overview Header -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs">
                    <i data-lucide="printer" class="w-4 h-4 text-[#162a5b] dark:text-blue-400"></i>
                    <span>Modul Cetak Laporan Biaya Operasional</span>
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-blue-50 dark:bg-blue-900/20 text-[#162a5b] dark:text-blue-300 border border-blue-200/60 dark:border-blue-800/40">
                    <i data-lucide="file-check-2" class="w-3.5 h-3.5 text-[#162a5b] dark:text-blue-400"></i>
                    <span>3 Modul Laporan Siap Cetak</span>
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

                    <div id="reportNavList" class="space-y-3">
                        
                        <!-- Group 1: Transaksi & Pembayaran -->
                        <div class="report-group space-y-1.5">
                            <div class="px-2 pt-1 flex items-center justify-between text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                <span>Kategori Laporan Biaya</span>
                                <span class="text-[9px] px-1 rounded bg-slate-100 dark:bg-slate-800 font-mono">3</span>
                            </div>

                            <!-- Tab 1: Biaya -->
                            <button 
                                type="button" 
                                data-tab="biaya" 
                                class="tab-btn active w-full flex items-start gap-3 p-3 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                            >
                                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                                    <i data-lucide="receipt" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-1 mb-0.5">
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Laporan Biaya</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">Detail</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Rincian pos biaya, akun beban, dan PPN</p>
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
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Riwayat pembayaran kas & bank operasional</p>
                                </div>
                            </button>

                            <!-- Tab 3: Rekap Akun -->
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
                                        <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Rekap Akun (COA)</span>
                                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">Akuntansi</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">Akumulasi total pengeluaran per kode akun</p>
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
                            <h5 class="font-bold text-slate-800 dark:text-slate-200">Panduan Output Dokumen</h5>
                            <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
                                Gunakan <strong>Cetak Laporan</strong> untuk pratinjau tabel cetak resmi dengan kolom beku (*freeze header*). Gunakan <strong>Export Excel</strong> untuk mengunduh berkas spreadsheet terstruktur.
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
                                    Laporan Rincian Biaya
                                </h3>
                                <p class="text-[11px] text-white/70" id="header_panel_desc">
                                    Tentukan parameter rekanan, akun COA, dan periode transaksi biaya
                                </p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-md bg-white/15 text-[10px] font-bold text-white uppercase tracking-wider" id="header_panel_tag">
                            Detail Transaksi
                        </span>
                    </div>

                    <!-- Panel Forms Container -->
                    <div class="p-6">
                        
                        <!-- Panel 1: Laporan Biaya -->
                        <div id="panel-biaya" class="tab-panel">
                            <form action="{{ route('laporanbiaya.cetakbiaya') }}" method="POST" id="formLapBiaya" target="_blank" class="space-y-4" novalidate>
                                @csrf

                                <!-- Supplier & Akun -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label for="kode_supplier_biaya" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                            Supplier / Rekanan
                                        </label>
                                        <select name="kode_supplier" id="kode_supplier_biaya" class="select2-filter w-full text-xs font-semibold" data-placeholder="Semua Supplier / Rekanan">
                                            <option value="">Semua Supplier / Rekanan</option>
                                            @foreach ($supplier as $d)
                                                <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="kode_akun_biaya" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                            Kode Akun Beban (COA)
                                        </label>
                                        <select name="kode_akun" id="kode_akun_biaya" class="select2-filter w-full text-xs font-semibold" data-placeholder="Semua Kode Akun">
                                            <option value="">Semua Kode Akun (COA)</option>
                                            @foreach ($akun as $d)
                                                <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Cabang & PPN -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label for="kode_cabang_biaya" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                            Cabang Operasional
                                        </label>
                                        <select name="kode_cabang" id="kode_cabang_biaya" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                                            <option value="">Semua Cabang</option>
                                            @foreach ($cabang as $c)
                                                <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="ppn_biaya" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                            Status Pajak (PPN)
                                        </label>
                                        <select name="ppn" id="ppn_biaya" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                                            <option value="">Semua (PPN & Non-PPN)</option>
                                            <option value="1">PPN Aktif Saja</option>
                                            <option value="0">Non-PPN Saja</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kriteria Periode -->
                                <div class="space-y-1.5">
                                    <label for="jenis_periode_biaya" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                        Kriteria Filter Periode <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="jenis_periode" id="jenis_periode_biaya" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" onchange="togglePeriodeBiaya(this.value)">
                                        <option value="tanggal" selected>Berdasarkan Rentang Tanggal Transaksi</option>
                                        <option value="bulan_pajak">Berdasarkan Masa & Tahun Pajak</option>
                                    </select>
                                </div>

                                <!-- Filter Rentang Tanggal -->
                                <div id="wrapper_tanggal_biaya" class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                            <span>Rentang Tanggal Transaksi</span>
                                        </span>
                                        <!-- Quick Presets -->
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_biaya" data-target-sampai="sampai_biaya" data-preset="today">Hari Ini</button>
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_biaya" data-target-sampai="sampai_biaya" data-preset="this_month">Bulan Ini</button>
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_biaya" data-target-sampai="sampai_biaya" data-preset="last_month">Bulan Lalu</button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input 
                                                type="text" 
                                                name="dari" 
                                                id="dari_biaya" 
                                                class="block w-full pl-10 pr-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs placeholder-slate-400 flatpickr-date" 
                                                placeholder="Dari Tanggal" 
                                                required 
                                                autocomplete="off" 
                                                value="{{ date('Y-m-01') }}"
                                            />
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input 
                                                type="text" 
                                                name="sampai" 
                                                id="sampai_biaya" 
                                                class="block w-full pl-10 pr-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs placeholder-slate-400 flatpickr-date" 
                                                placeholder="Sampai Tanggal" 
                                                required 
                                                autocomplete="off" 
                                                value="{{ date('Y-m-d') }}"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter Masa & Tahun Pajak -->
                                <div id="wrapper_bulan_pajak_biaya" class="space-y-2 hidden">
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                                        <i data-lucide="calendar-range" class="w-4 h-4 text-slate-400"></i>
                                        <span>Masa & Tahun Pajak</span>
                                    </span>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <select name="bulan" id="bulan_biaya" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                                            <option value="">Pilih Masa Pajak</option>
                                            @foreach ($list_bulan ?? [] as $d)
                                                <option value="{{ $d['kode_bulan'] }}" {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }}>{{ $d['nama_bulan'] }}</option>
                                            @endforeach
                                        </select>
                                        <input 
                                            type="number" 
                                            name="tahun" 
                                            id="tahun_biaya" 
                                            class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" 
                                            value="{{ date('Y') }}" 
                                            placeholder="Tahun Pajak" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>

                                <!-- Actions Toolbar -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <button 
                                        type="submit" 
                                        name="submitButton" 
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-xl transition shadow-sm active:scale-95 cursor-pointer h-[42px]"
                                    >
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                        <span>Cetak Laporan</span>
                                    </button>
                                    <button 
                                        type="submit" 
                                        name="exportButton" 
                                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm active:scale-95 cursor-pointer h-[42px]"
                                    >
                                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                                        <span>Export Excel</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Panel 2: Laporan Pembayaran -->
                        <div id="panel-pembayaran" class="tab-panel hidden">
                            <form action="{{ route('laporanbiaya.cetakpembayaran') }}" method="POST" id="formLapPembayaran" target="_blank" class="space-y-4" novalidate>
                                @csrf

                                <!-- Supplier -->
                                <div class="space-y-1.5">
                                    <label for="kode_supplier_pembayaran" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                        Supplier / Rekanan
                                    </label>
                                    <select name="kode_supplier" id="kode_supplier_pembayaran" class="select2-filter w-full text-xs font-semibold" data-placeholder="Semua Supplier / Rekanan">
                                        <option value="">Semua Supplier / Rekanan</option>
                                        @foreach ($supplier as $d)
                                            <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Bank & Cabang -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label for="kode_bank_pembayaran" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                            Bank / Kas
                                        </label>
                                        <select name="kode_bank" id="kode_bank_pembayaran" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                                            <option value="">Semua Bank / Kas</option>
                                            @foreach ($bank as $b)
                                                <option value="{{ $b->kode_bank }}">{{ $b->kode_bank }} - {{ $b->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label for="kode_cabang_pembayaran" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                            Cabang Operasional
                                        </label>
                                        <select name="kode_cabang" id="kode_cabang_pembayaran" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                                            <option value="">Semua Cabang</option>
                                            @foreach ($cabang as $c)
                                                <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Periode Tanggal -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                            <span>Periode Pembayaran</span>
                                        </span>
                                        <!-- Quick Presets -->
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_pembayaran" data-target-sampai="sampai_pembayaran" data-preset="today">Hari Ini</button>
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_pembayaran" data-target-sampai="sampai_pembayaran" data-preset="this_month">Bulan Ini</button>
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_pembayaran" data-target-sampai="sampai_pembayaran" data-preset="last_month">Bulan Lalu</button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input 
                                                type="text" 
                                                name="dari" 
                                                id="dari_pembayaran" 
                                                class="block w-full pl-10 pr-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs placeholder-slate-400 flatpickr-date" 
                                                placeholder="Dari Tanggal" 
                                                required 
                                                autocomplete="off" 
                                                value="{{ date('Y-m-01') }}"
                                            />
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input 
                                                type="text" 
                                                name="sampai" 
                                                id="sampai_pembayaran" 
                                                class="block w-full pl-10 pr-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs placeholder-slate-400 flatpickr-date" 
                                                placeholder="Sampai Tanggal" 
                                                required 
                                                autocomplete="off" 
                                                value="{{ date('Y-m-d') }}"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions Toolbar -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <button 
                                        type="submit" 
                                        name="submitButton" 
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-xl transition shadow-sm active:scale-95 cursor-pointer h-[42px]"
                                    >
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                        <span>Cetak Laporan</span>
                                    </button>
                                    <button 
                                        type="submit" 
                                        name="exportButton" 
                                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm active:scale-95 cursor-pointer h-[42px]"
                                    >
                                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                                        <span>Export Excel</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Panel 3: Rekap Akun (COA) -->
                        <div id="panel-rekapakun" class="tab-panel hidden">
                            <form action="{{ route('laporanbiaya.cetakrekapakun') }}" method="POST" id="formLapRekapAkun" target="_blank" class="space-y-4" novalidate>
                                @csrf

                                <!-- Cabang -->
                                <div class="space-y-1.5">
                                    <label for="kode_cabang_rekap" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                        Cabang Operasional
                                    </label>
                                    <select name="kode_cabang" id="kode_cabang_rekap" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                                        <option value="">Semua Cabang</option>
                                        @foreach ($cabang as $c)
                                            <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kriteria Periode -->
                                <div class="space-y-1.5">
                                    <label for="jenis_periode_rekap" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                        Kriteria Filter Periode <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="jenis_periode" id="jenis_periode_rekap" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" onchange="togglePeriodeRekap(this.value)">
                                        <option value="tanggal" selected>Berdasarkan Rentang Tanggal Transaksi</option>
                                        <option value="bulan_pajak">Berdasarkan Masa & Tahun Pajak</option>
                                    </select>
                                </div>

                                <!-- Filter Rentang Tanggal -->
                                <div id="wrapper_tanggal_rekap" class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                            <span>Rentang Tanggal Transaksi</span>
                                        </span>
                                        <!-- Quick Presets -->
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_rekap" data-target-sampai="sampai_rekap" data-preset="today">Hari Ini</button>
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_rekap" data-target-sampai="sampai_rekap" data-preset="this_month">Bulan Ini</button>
                                            <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_rekap" data-target-sampai="sampai_rekap" data-preset="last_month">Bulan Lalu</button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input 
                                                type="text" 
                                                name="dari" 
                                                id="dari_rekap" 
                                                class="block w-full pl-10 pr-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs placeholder-slate-400 flatpickr-date" 
                                                placeholder="Dari Tanggal" 
                                                required 
                                                autocomplete="off" 
                                                value="{{ date('Y-m-01') }}"
                                            />
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input 
                                                type="text" 
                                                name="sampai" 
                                                id="sampai_rekap" 
                                                class="block w-full pl-10 pr-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs placeholder-slate-400 flatpickr-date" 
                                                placeholder="Sampai Tanggal" 
                                                required 
                                                autocomplete="off" 
                                                value="{{ date('Y-m-d') }}"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter Masa & Tahun Pajak -->
                                <div id="wrapper_bulan_pajak_rekap" class="space-y-2 hidden">
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                                        <i data-lucide="calendar-range" class="w-4 h-4 text-slate-400"></i>
                                        <span>Masa & Tahun Pajak</span>
                                    </span>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <select name="bulan" id="bulan_rekap" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                                            <option value="">Pilih Masa Pajak</option>
                                            @foreach ($list_bulan ?? [] as $d)
                                                <option value="{{ $d['kode_bulan'] }}" {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }}>{{ $d['nama_bulan'] }}</option>
                                            @endforeach
                                        </select>
                                        <input 
                                            type="number" 
                                            name="tahun" 
                                            id="tahun_rekap" 
                                            class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" 
                                            value="{{ date('Y') }}" 
                                            placeholder="Tahun Pajak" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>

                                <!-- Actions Toolbar -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <button 
                                        type="submit" 
                                        name="submitButton" 
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-xl transition shadow-sm active:scale-95 cursor-pointer h-[42px]"
                                    >
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                        <span>Cetak Rekap</span>
                                    </button>
                                    <button 
                                        type="submit" 
                                        name="exportButton" 
                                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm active:scale-95 cursor-pointer h-[42px]"
                                    >
                                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                                        <span>Export Excel</span>
                                    </button>
                                </div>
                            </form>
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
            $(".select2-filter").each(function() {
                var $this = $(this);
                $this.wrap('<div class="relative"></div>').select2({
                    placeholder: $this.data('placeholder') || 'Semua',
                    allowClear: true,
                    width: '100%'
                });
            });

            // Metadata for dynamic header update
            const tabMeta = {
                biaya: {
                    title: 'Laporan Rincian Biaya',
                    desc: 'Tentukan parameter rekanan, akun COA, dan periode transaksi biaya',
                    icon: 'receipt',
                    tag: 'Detail Transaksi'
                },
                pembayaran: {
                    title: 'Laporan Pembayaran Biaya',
                    desc: 'Pantau histori pelunasan transaksi biaya operasional via kas & bank',
                    icon: 'credit-card',
                    tag: 'Histori Bayar'
                },
                rekapakun: {
                    title: 'Laporan Rekap Akun Biaya (COA)',
                    desc: 'Distribusi pembebanan anggaran operasional berdasarkan kode akun COA',
                    icon: 'book-open',
                    tag: 'Rekap COA'
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

            // Validation Helper
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
            validatePeriode("formLapBiaya", "dari_biaya", "sampai_biaya");
            validatePeriode("formLapPembayaran", "dari_pembayaran", "sampai_pembayaran");
            validatePeriode("formLapRekapAkun", "dari_rekap", "sampai_rekap");
        });

        function togglePeriodeBiaya(val) {
            if (val === 'bulan_pajak') {
                $('#wrapper_tanggal_biaya').addClass('hidden');
                $('#wrapper_bulan_pajak_biaya').removeClass('hidden');
                $('#dari_biaya').removeAttr('required');
                $('#sampai_biaya').removeAttr('required');
                $('#bulan_biaya').attr('required', 'required');
                $('#tahun_biaya').attr('required', 'required');
            } else {
                $('#wrapper_tanggal_biaya').removeClass('hidden');
                $('#wrapper_bulan_pajak_biaya').addClass('hidden');
                $('#dari_biaya').attr('required', 'required');
                $('#sampai_biaya').attr('required', 'required');
                $('#bulan_biaya').removeAttr('required');
                $('#tahun_biaya').removeAttr('required');
            }
        }

        function togglePeriodeRekap(val) {
            if (val === 'bulan_pajak') {
                $('#wrapper_tanggal_rekap').addClass('hidden');
                $('#wrapper_bulan_pajak_rekap').removeClass('hidden');
                $('#dari_rekap').removeAttr('required');
                $('#sampai_rekap').removeAttr('required');
                $('#bulan_rekap').attr('required', 'required');
                $('#tahun_rekap').attr('required', 'required');
            } else {
                $('#wrapper_tanggal_rekap').removeClass('hidden');
                $('#wrapper_bulan_pajak_rekap').addClass('hidden');
                $('#dari_rekap').attr('required', 'required');
                $('#sampai_rekap').attr('required', 'required');
                $('#bulan_rekap').removeAttr('required');
                $('#tahun_rekap').removeAttr('required');
            }
        }
    </script>
    @endpush
</x-app-layout>
