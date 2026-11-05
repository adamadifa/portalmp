<x-app-layout>
    <x-slot name="header">Edit Pembelian</x-slot>
    <x-slot name="headerTitle">Edit Pembelian</x-slot>
    <x-slot name="headerDescription">Perubahan data transaksi faktur #{{ $pembelian->no_bukti }} &bull; {{ $pembelian->nama_supplier }}</x-slot>

    <style>
    .swal2-container {
        z-index: 999999 !important;
    }
    /* ── Select2 Custom Theming (Corporate Navy #162a5b) ──────────── */
    .select2-container { 
        width: 100% !important; 
    }
    .select2-container--default .select2-selection--single {
        height: 40px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        background-color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        padding-top: 0 !important;
        transition: all 0.15s ease-in-out !important;
    }
    .dark .select2-container--default .select2-selection--single {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #162a5b !important;
        box-shadow: 0 0 0 3px rgba(22, 42, 91, 0.12) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: flex !important;
        align-items: center !important;
        height: 100% !important;
        line-height: normal !important;
        padding-left: 12px !important;
        padding-right: 30px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
    }
    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f1f5f9 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute !important;
        top: 50% !important;
        right: 12px !important;
        transform: translateY(-50%) !important;
        height: 16px !important;
        width: 16px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #64748b transparent transparent transparent !important;
        border-style: solid !important;
        border-width: 5px 4px 0 4px !important;
    }
    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
        z-index: 1050 !important;
    }
    .select2-results__option {
        padding: 8px 12px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #162a5b !important;
        color: #ffffff !important;
    }

    /* ── Polished DataTable Styles (Modal Barang) ──────────── */
    .dataTables_wrapper {
        font-size: 12px !important;
    }
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 12px !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 5px 28px 5px 12px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        outline: none !important;
        background-color: #f8fafc !important;
        cursor: pointer !important;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 12px !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 6px 14px !important;
        outline: none !important;
        font-size: 12px !important;
        color: #1e293b !important;
        margin-left: 8px !important;
        min-width: 220px !important;
        transition: all 0.15s ease !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #162a5b !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(22, 42, 91, 0.12) !important;
    }
    #tabelbarang {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
    }
    #tabelbarang thead th {
        background-color: #162a5b !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 10px 14px !important;
        border: none !important;
    }
    #tabelbarang tbody td {
        padding: 10px 14px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9 !important;
        color: #334155 !important;
    }
    #tabelbarang tbody tr:hover {
        background-color: #f8fafc !important;
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 14px !important;
        font-size: 12px !important;
        color: #64748b !important;
        font-weight: 600 !important;
    }
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 12px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 12px !important;
        margin: 0 2px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        color: #475569 !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #162a5b !important;
        color: #ffffff !important;
        border: 1px solid #162a5b !important;
        box-shadow: 0 2px 4px rgba(22, 42, 91, 0.2) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #eef2ff !important;
        color: #162a5b !important;
        border-color: #c7d2fe !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #94a3b8 !important;
        border-color: #f1f5f9 !important;
        background: #f8fafc !important;
        cursor: not-allowed !important;
    }
    </style>

    <div class="space-y-6">

        <!-- Top Navigation Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('pembelian.index') }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs transition cursor-pointer"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4 text-slate-500"></i>
                    <span>Kembali ke Daftar</span>
                </a>

                <a 
                    href="{{ route('pembelian.show', Crypt::encrypt($pembelian->no_bukti)) }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 text-sky-700 dark:text-sky-300 border border-sky-200/60 font-bold text-xs shadow-2xs transition cursor-pointer"
                >
                    <i data-lucide="eye" class="w-4 h-4 text-sky-600"></i>
                    <span>Lihat Detail</span>
                </a>

                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold text-xs bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Mode Edit Faktur: {{ $pembelian->no_bukti }}</span>
                </span>
            </div>

            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                Kolom dengan tanda bintang (<span class="text-rose-500 font-bold">*</span>) wajib diisi
            </div>
        </div>

        <!-- Alert Notifications -->
        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/40 text-rose-800 dark:text-rose-300 flex items-center gap-3 shadow-2xs">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                <div class="text-xs font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/40 text-rose-800 dark:text-rose-300 shadow-2xs">
                <div class="flex items-center gap-2 font-bold text-xs mb-1.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                    <span>Terdapat beberapa kesalahan pengisian form:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 dark:text-rose-400">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form Container -->
        <form action="{{ route('pembelian.update', Crypt::encrypt($pembelian->no_bukti)) }}" method="POST" id="formPembelian" class="w-full" novalidate>
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column (4 cols): Faktur & Parameter Informasi -->
                <div class="lg:col-span-4 space-y-5">
                    
                    <!-- Card 1: Informasi Dasar Faktur -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-5 py-4 bg-[#162a5b] text-white flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                                <i data-lucide="file-edit" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xs uppercase tracking-wider text-white">Informasi Faktur</h3>
                                <p class="text-[11px] text-blue-200/80">Identitas transaksi & data supplier</p>
                            </div>
                        </div>

                        <div class="p-5 space-y-3.5">
                            <!-- No. Bukti (Read-only) -->
                            <div>
                                <label for="no_bukti" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    No. Bukti Pembelian
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i data-lucide="lock" class="w-4 h-4"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="no_bukti" 
                                        id="no_bukti" 
                                        value="{{ $pembelian->no_bukti }}" 
                                        class="w-full h-[40px] pl-10 pr-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-400 cursor-not-allowed shadow-2xs uppercase" 
                                        readonly 
                                    />
                                </div>
                            </div>

                            <!-- Tanggal Transaksi -->
                            <div>
                                <label for="tanggal" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Tanggal Faktur <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="tanggal" 
                                        id="tanggal" 
                                        value="{{ $pembelian->tanggal }}" 
                                        class="w-full h-[40px] pl-10 pr-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs flatpickr-date" 
                                        placeholder="Pilih Tanggal..." 
                                        autocomplete="off" 
                                        required 
                                    />
                                </div>
                            </div>

                            <!-- Bulan & Tahun Pajak -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="bulan_pajak" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Bulan Pajak
                                    </label>
                                    @php
                                        $selectedBulan = $pembelian->bulan_pajak ?: date('m', strtotime($pembelian->tanggal));
                                    @endphp
                                    <select 
                                        name="bulan_pajak" 
                                        id="bulan_pajak" 
                                        class="w-full h-[40px] px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs cursor-pointer"
                                    >
                                        @for ($m = 1; $m <= 12; $m++)
                                            @php $blnVal = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                            <option value="{{ $blnVal }}" {{ $selectedBulan == $blnVal ? 'selected' : '' }}>
                                                {{ $blnVal }} - {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="tahun_pajak" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Tahun Pajak
                                    </label>
                                    @php
                                        $selectedTahun = $pembelian->tahun_pajak ?: date('Y', strtotime($pembelian->tanggal));
                                    @endphp
                                    <input 
                                        type="number" 
                                        name="tahun_pajak" 
                                        id="tahun_pajak" 
                                        value="{{ $selectedTahun }}" 
                                        class="w-full h-[40px] px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" 
                                        placeholder="YYYY" 
                                        autocomplete="off" 
                                    />
                                </div>
                            </div>

                            <!-- Supplier -->
                            <div>
                                <label for="kode_supplier" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Supplier Rekanan <span class="text-rose-500">*</span>
                                </label>
                                <select name="kode_supplier" id="kode_supplier" class="select2Kodesupplier w-full">
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($supplier as $d)
                                        <option value="{{ $d->kode_supplier }}" {{ $pembelian->kode_supplier == $d->kode_supplier ? 'selected' : '' }}>
                                            {{ strtoupper($d->nama_supplier) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Asal Ajuan (Locked on Edit) -->
                            <div>
                                <label for="kode_asal_pengajuan" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Asal Ajuan
                                </label>
                                <select 
                                    id="kode_asal_pengajuan" 
                                    class="w-full h-[40px] px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-400 cursor-not-allowed shadow-2xs"
                                    disabled="true"
                                >
                                    <option value="">-- Pilih Asal Ajuan --</option>
                                    @foreach ($asal_ajuan as $d)
                                        <option value="{{ $d['kode_group'] }}" {{ $pembelian->kode_asal_pengajuan == $d['kode_group'] ? 'selected' : '' }}>
                                            {{ $d['nama_group'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="kode_asal_pengajuan" value="{{ $pembelian->kode_asal_pengajuan }}" />
                            </div>

                            <!-- Jenis Transaksi & Jatuh Tempo -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="jenis_transaksi" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Jenis Pembayaran <span class="text-rose-500">*</span>
                                    </label>
                                    <select 
                                        name="jenis_transaksi" 
                                        id="jenis_transaksi" 
                                        class="w-full h-[40px] px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs cursor-pointer"
                                        required
                                    >
                                        <option value="">-- Jenis --</option>
                                        <option value="T" {{ $pembelian->jenis_transaksi == 'T' ? 'selected' : '' }}>Tunai (Cash)</option>
                                        <option value="K" {{ $pembelian->jenis_transaksi == 'K' ? 'selected' : '' }}>Kredit (Tempo)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="jatuh_tempo" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Jatuh Tempo
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <input 
                                            type="text" 
                                            name="jatuh_tempo" 
                                            id="jatuh_tempo" 
                                            value="{{ $pembelian->jatuh_tempo }}" 
                                            class="w-full h-[40px] pl-9 pr-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs flatpickr-date" 
                                            placeholder="Tgl Tempo..." 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Pengaturan Atribut & Pajak Transaksi -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-5 py-3.5 bg-slate-800 text-white flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                                <i data-lucide="sliders" class="w-3.5 h-3.5 text-white"></i>
                            </div>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-white">Atribut & Klasifikasi Pajak</h3>
                        </div>

                        <div class="p-5 space-y-4">
                            <!-- PPN Switcher -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                    Kena Pajak Pertambahan Nilai (PPN)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label for="ppn1" class="flex items-center gap-2 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition shadow-2xs radio-card">
                                        <input type="radio" name="ppn" id="ppn1" value="1" {{ $pembelian->ppn == '1' ? 'checked' : '' }} class="w-4 h-4 text-[#162a5b] border-slate-300 focus:ring-[#162a5b] cursor-pointer shrink-0" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">PPN (11/12%)</span>
                                    </label>
                                    <label for="ppn2" class="flex items-center gap-2 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition shadow-2xs radio-card">
                                        <input type="radio" name="ppn" id="ppn2" value="0" {{ $pembelian->ppn == '0' ? 'checked' : '' }} class="w-4 h-4 text-[#162a5b] border-slate-300 focus:ring-[#162a5b] cursor-pointer shrink-0" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">Non-PPN</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Kategori Transaksi (Hidden, Konsisten MP) -->
                            <input type="hidden" name="kategori_transaksi" id="kategori_transaksi" value="{{ $pembelian->kategori_transaksi ?? 'MP' }}" />

                            <!-- Kategori Pembelian (Lokal / Import) -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                    Asal Barang (Kategori Pembelian)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label for="kategori_pembelian_l" class="flex items-center gap-2 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition shadow-2xs radio-card">
                                        <input type="radio" name="kategori_pembelian" id="kategori_pembelian_l" value="L" {{ ($pembelian->kategori_pembelian ?? 'L') == 'L' ? 'checked' : '' }} class="w-4 h-4 text-[#162a5b] border-slate-300 focus:ring-[#162a5b] cursor-pointer shrink-0" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">Lokal</span>
                                    </label>
                                    <label for="kategori_pembelian_i" class="flex items-center gap-2 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition shadow-2xs radio-card">
                                        <input type="radio" name="kategori_pembelian" id="kategori_pembelian_i" value="I" {{ ($pembelian->kategori_pembelian ?? 'L') == 'I' ? 'checked' : '' }} class="w-4 h-4 text-[#162a5b] border-slate-300 focus:ring-[#162a5b] cursor-pointer shrink-0" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">Import</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Status Uang Muka -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                    Jenis Transaksi Uang Muka
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label for="status_uang_muka_0" class="flex items-center gap-2 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition shadow-2xs radio-card">
                                        <input type="radio" name="status_uang_muka" id="status_uang_muka_0" value="0" {{ ($pembelian->status_uang_muka ?? 0) == 0 ? 'checked' : '' }} class="w-4 h-4 text-[#162a5b] border-slate-300 focus:ring-[#162a5b] cursor-pointer shrink-0" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">Biasa (Standar)</span>
                                    </label>
                                    <label for="status_uang_muka_1" class="flex items-center gap-2 px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition shadow-2xs radio-card">
                                        <input type="radio" name="status_uang_muka" id="status_uang_muka_1" value="1" {{ ($pembelian->status_uang_muka ?? 0) == 1 ? 'checked' : '' }} class="w-4 h-4 text-[#162a5b] border-slate-300 focus:ring-[#162a5b] cursor-pointer shrink-0" />
                                        <span class="text-xs font-bold text-slate-800 dark:text-white">Uang Muka (UM)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (8 cols): Input Barang & Detail Tabel -->
                <div class="lg:col-span-8 space-y-5">
                    
                    <!-- Card 3: Form Input Barang (Atau Peringatan jika sudah ada bayar) -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-6 py-4 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                                    <i data-lucide="package-plus" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-sm text-white">Input Barang Pembelian</h3>
                                    <p class="text-[11px] text-blue-200/80">Pilih barang master, masukkan kuantiti, harga, penyesuaian, dan akun</p>
                                </div>
                            </div>

                            <!-- Live Grand Total Badge -->
                            <div class="flex items-center gap-2 bg-white/10 px-3.5 py-1.5 rounded-xl border border-white/15 shrink-0">
                                <span class="text-[11px] font-semibold text-blue-100 uppercase tracking-wider">Grand Total:</span>
                                <span class="font-mono font-black text-sm sm:text-base text-white">Rp <span id="grandtotal_text">0</span></span>
                            </div>
                        </div>

                        <div class="p-5 space-y-4">
                            @if ($cekhistoribayar > 0)
                                <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/40 text-amber-900 dark:text-amber-300 text-xs leading-relaxed space-y-2">
                                    <div class="flex items-center gap-2 font-bold text-xs text-amber-800 dark:text-amber-200">
                                        <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 shrink-0"></i>
                                        <span>Faktur Pembelian Sudah Memiliki Histori Pembayaran</span>
                                    </div>
                                    <p class="text-[11px]">
                                        Data Pembelian dengan No. Bukti <strong>{{ $pembelian->no_bukti }}</strong> sudah memiliki catatan pembayaran oleh bagian Keuangan. 
                                        Untuk menambah barang, mengedit quantity, atau mengubah harga, silakan koordinasikan dengan bagian Keuangan terlebih dahulu.
                                    </p>
                                    <div class="flex justify-end pt-1">
                                        <a href="{{ request()->url() }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-lg shadow-2xs transition">
                                            <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                                            <span>Reload Halaman</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <!-- Baris 1: Item Barang, Qty, Harga, Penyesuaian -->
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                                    <!-- Pilih Barang Trigger -->
                                    <div class="sm:col-span-5">
                                        <label for="nama_barang" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                            Nama Barang <span class="text-rose-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input 
                                                type="text" 
                                                name="nama_barang" 
                                                id="nama_barang" 
                                                class="block w-full pl-3.5 pr-10 h-[40px] text-xs font-semibold text-slate-800 dark:text-white bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 shadow-2xs placeholder-slate-400" 
                                                placeholder="Klik untuk cari barang..." 
                                                readonly 
                                            />
                                            <button 
                                                type="button" 
                                                class="absolute inset-y-0 right-0 px-3.5 flex items-center text-slate-400 hover:text-blue-600 transition cursor-pointer"
                                                onclick="$('#nama_barang').click()"
                                            >
                                                <i data-lucide="search" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" id="kode_barang" name="kode_barang">
                                    </div>

                                    <!-- Qty -->
                                    <div class="sm:col-span-2">
                                        <label for="jumlah" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                            Qty <span class="text-rose-500">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="jumlah" 
                                            id="jumlah" 
                                            class="w-full h-[40px] px-3 text-xs font-bold text-right text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs number-separator" 
                                            placeholder="0" 
                                            autocomplete="off" 
                                        />
                                    </div>

                                    <!-- Harga Satuan -->
                                    <div class="sm:col-span-3">
                                        <label for="harga" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                            Harga Satuan (Rp) <span class="text-rose-500">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="harga" 
                                            id="harga" 
                                            class="w-full h-[40px] px-3 text-xs font-bold text-right text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs number-separator" 
                                            placeholder="0" 
                                            autocomplete="off" 
                                        />
                                    </div>

                                    <!-- Penyesuaian -->
                                    <div class="sm:col-span-2">
                                        <label for="penyesuaian" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                            Penyesuaian
                                        </label>
                                        <input 
                                            type="text" 
                                            name="penyesuaian" 
                                            id="penyesuaian" 
                                            class="w-full h-[40px] px-3 text-xs font-bold text-right text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs number-separator" 
                                            placeholder="0" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>

                                <!-- Baris 2: Akun Akuntansi, Cabang, Keterangan -->
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                                    <!-- Akun Pembelian -->
                                    <div class="sm:col-span-5">
                                        <label for="kode_akun" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                            Akun Akuntansi <span class="text-rose-500">*</span>
                                        </label>
                                        <select name="kode_akun" id="kode_akun" class="select2Kodeakun w-full">
                                            <option value="">Pilih Akun</option>
                                            @foreach ($coa as $d)
                                                <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Cabang -->
                                    <div class="sm:col-span-3">
                                        <label for="kode_cabang" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                            Alokasi Cabang
                                        </label>
                                        <select name="kode_cabang" id="kode_cabang" class="select2Kodecabang w-full">
                                            <option value="">Semua Cabang</option>
                                            @foreach ($cabang as $d)
                                                <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Keterangan -->
                                    <div class="sm:col-span-4">
                                        <label for="keterangan" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                            Catatan / Keterangan Item
                                        </label>
                                        <input 
                                            type="text" 
                                            name="keterangan" 
                                            id="keterangan" 
                                            class="w-full h-[40px] px-3.5 py-2 text-xs font-semibold text-slate-800 dark:text-white bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs placeholder-slate-400" 
                                            placeholder="Catatan item (opsional)..." 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>

                                <!-- Tombol Aksi Tambah & Reset -->
                                <div class="grid grid-cols-12 gap-2.5 pt-1">
                                    <div class="col-span-10 sm:col-span-11">
                                        <button 
                                            type="button" 
                                            id="btnTambahbarang" 
                                            class="w-full h-[42px] inline-flex items-center justify-center gap-2 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-[#162a5b] dark:text-blue-400 border border-blue-200 dark:border-blue-500/30 font-bold text-xs shadow-2xs transition cursor-pointer"
                                        >
                                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                            <span>Tambahkan Barang ke Daftar Faktur</span>
                                        </button>
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <a 
                                            id="btnReset" 
                                            href="{{ request()->url() }}" 
                                            class="w-full h-[42px] inline-flex items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" 
                                            title="Reset Input Form"
                                        >
                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card 4: Tabel Rincian Barang Pembelian -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-5 py-3.5 bg-slate-100/80 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i data-lucide="shopping-bag" class="w-4 h-4 text-slate-600 dark:text-slate-400"></i>
                                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-800 dark:text-slate-200">Daftar Barang Faktur</h4>
                            </div>
                            <span class="text-[11px] text-slate-500 font-semibold">Tabel Rincian Item</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left border-collapse min-w-[720px]">
                                <thead class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                                    <tr>
                                        <th class="py-2.5 px-3 w-24">Kode</th>
                                        <th class="py-2.5 px-3">Nama Barang</th>
                                        <th class="py-2.5 px-3 text-center w-16">Qty</th>
                                        <th class="py-2.5 px-3 text-right w-24">Harga</th>
                                        <th class="py-2.5 px-3 text-right w-20">Peny</th>
                                        <th class="py-2.5 px-3 text-right w-28">Total</th>
                                        <th class="py-2.5 px-3">Akun</th>
                                        <th class="py-2.5 px-3 text-center w-20">Cabang</th>
                                        <th class="py-2.5 px-3 text-center w-24">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadbarang" class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                    @php
                                        $total_pembelian = 0;
                                        $no = 1;
                                    @endphp
                                    @foreach ($detail as $d)
                                        @php
                                            $subtotal = $d->jumlah * $d->harga;
                                            $total = $subtotal + $d->penyesuaian;
                                            $total_pembelian += $total;
                                            $bg = !empty($d->kode_cr) ? 'bg-blue-50/60 dark:bg-blue-950/20' : '';
                                        @endphp
                                        <tr class="{{ $bg }} hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition" id="index_{{ $no }}">
                                            <td class="py-2.5 px-3 font-mono font-bold text-slate-800 dark:text-white">
                                                <input type="hidden" name="kode_barang_item[]" value="{{ $d->kode_barang }}" class="kode_barang" />
                                                <input type="hidden" name="jumlah_item[]" value="{{ formatAngkaDesimal($d->jumlah) }}" class="jumlah" />
                                                <input type="hidden" name="harga_item[]" value="{{ formatAngkaDesimal($d->harga) }}" class="harga" />
                                                <input type="hidden" name="penyesuaian_item[]" value="{{ formatAngkaDesimal($d->penyesuaian) }}" class="penyesuaian" />
                                                <input type="hidden" name="kode_akun_item[]" value="{{ $d->kode_akun }}" class="kode_akun" />
                                                <input type="hidden" name="keterangan_item[]" value="{{ $d->keterangan }}" class="keterangan" />
                                                <input type="hidden" name="kode_cabang_item[]" value="{{ $d->kode_cabang }}" class="kode_cabang" />
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">{{ $d->kode_barang }}</span>
                                            </td>
                                            <td class="py-2.5 px-3 font-bold text-slate-900 dark:text-white">
                                                <div>{{ textCamelCase($d->nama_barang) }}</div>
                                                @if(!empty($d->keterangan))
                                                    <div class="text-[10px] text-slate-400 font-normal mt-0.5">{{ $d->keterangan }}</div>
                                                @endif
                                            </td>
                                            <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-white">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                            <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">{{ formatAngkaDesimal($d->harga) }}</td>
                                            <td class="py-2.5 px-3 text-right font-medium text-slate-500 whitespace-nowrap">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                                            <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap totalharga">{{ formatAngkaDesimal($total) }}</td>
                                            <td class="py-2.5 px-3 text-slate-700 dark:text-slate-300">
                                                <div class="text-[11px] font-bold text-slate-900 dark:text-white">{{ $d->nama_akun }}</div>
                                                <span class="text-[10px] font-mono text-slate-400">{{ $d->kode_akun }}</span>
                                            </td>
                                            <td class="py-2.5 px-3 text-center uppercase font-semibold text-slate-600 dark:text-slate-400">{{ $d->kode_cabang ?: '-' }}</td>
                                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <button type="button" class="btnEditbarang w-7 h-7 rounded-lg inline-flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 text-emerald-600 border border-emerald-200/60 transition cursor-pointer shadow-2xs" id="index_{{ $no }}" title="Edit Barang">
                                                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                    <button type="button" class="btnSplit w-7 h-7 rounded-lg inline-flex items-center justify-center bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 text-sky-600 border border-sky-200/60 transition cursor-pointer shadow-2xs" id="index_{{ $no }}" title="Split Barang">
                                                        <i data-lucide="git-fork" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                    @if ($cekhistoribayar === 0)
                                                        <button type="button" id="index_{{ $no }}" class="delete w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" title="Hapus Barang">
                                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @php $no += 1; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t-2 border-slate-300 dark:border-slate-700 bg-slate-50/90 dark:bg-slate-800/90 font-bold text-slate-900 dark:text-white text-xs">
                                    <tr>
                                        <td colspan="5" class="py-3 px-3 text-right uppercase tracking-wider text-slate-600 dark:text-slate-400">TOTAL PEMBELIAN (RP)</td>
                                        <td id="grandtotal" class="py-3 px-3 text-right font-black text-sm text-[#162a5b] dark:text-blue-400 whitespace-nowrap">0</td>
                                        <td colspan="3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Card 5: Detail Potongan Pembelian -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-5 py-3.5 bg-slate-100/80 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i data-lucide="percent" class="w-4 h-4 text-slate-600 dark:text-slate-400"></i>
                                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-800 dark:text-slate-200">Detail Potongan Pembelian</h4>
                            </div>
                            @if ($cekhistoribayar === 0)
                                <button 
                                    type="button" 
                                    id="tambahpotongan" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/60 shadow-2xs transition cursor-pointer"
                                >
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                    <span>Tambah Potongan</span>
                                </button>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left border-collapse min-w-[600px]">
                                <thead class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                                    <tr>
                                        <th class="py-2.5 px-3">Keterangan</th>
                                        <th class="py-2.5 px-3">Kode Akun</th>
                                        <th class="py-2.5 px-3 text-center w-20">Qty</th>
                                        <th class="py-2.5 px-3 text-right w-28">Harga</th>
                                        <th class="py-2.5 px-3 text-right w-28">Total</th>
                                        <th class="py-2.5 px-3 text-center w-20">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpotongan" class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                    @php $no_potongan = 1; @endphp
                                    @foreach ($potongan as $d)
                                        @php $subtotal_potongan = $d->jumlah * $d->harga; @endphp
                                        <tr id="index_{{ $no_potongan }}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                            <td class="py-2.5 px-3 font-medium text-slate-800 dark:text-white">
                                                <input type="hidden" name="keterangan_potongan_item[]" value="{{ $d->keterangan_penjualan }}" />
                                                <input type="hidden" name="kode_akun_potongan_item[]" value="{{ $d->kode_akun }}" />
                                                <input type="hidden" name="jumlah_potongan_item[]" value="{{ $d->jumlah }}" />
                                                <input type="hidden" name="harga_potongan_item[]" value="{{ $d->harga }}" />
                                                {{ $d->keterangan_penjualan }}
                                            </td>
                                            <td class="py-2.5 px-3 text-slate-600 dark:text-slate-400">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">{{ $d->kode_akun }}</span>
                                                <span class="ml-1 text-[11px]">{{ $d->nama_akun }}</span>
                                            </td>
                                            <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-white">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                            <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">{{ formatAngkaDesimal($d->harga) }}</td>
                                            <td class="py-2.5 px-3 text-right font-mono font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">{{ formatAngkaDesimal($subtotal_potongan) }}</td>
                                            <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                                @if ($cekhistoribayar === 0)
                                                    <div class="flex items-center justify-center gap-1.5">
                                                        <button type="button" id="index_{{ $no_potongan }}" class="editpotongan w-7 h-7 rounded-lg inline-flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 text-emerald-600 border border-emerald-200/60 transition cursor-pointer shadow-2xs" title="Edit Potongan">
                                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                                        </button>
                                                        <button type="button" id="index_{{ $no_potongan }}" class="deletepotongan w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" title="Hapus Potongan">
                                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $no_potongan++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card 6: Pernyataan & Tombol Submit Final -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs space-y-4">
                        <div class="p-4 rounded-xl bg-amber-50/60 dark:bg-amber-950/20 border border-amber-200/80 dark:border-amber-900/40 flex items-start gap-3">
                            <input 
                                type="checkbox" 
                                name="aggrement" 
                                id="defaultCheck3" 
                                class="agreement w-4 h-4 mt-0.5 rounded border-slate-300 text-[#162a5b] focus:ring-[#162a5b] cursor-pointer" 
                                value="aggrement" 
                            />
                            <label for="defaultCheck3" class="text-xs font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                <span class="font-bold text-slate-900 dark:text-white block mb-0.5">Konfirmasi & Verifikasi Perubahan Faktur</span>
                                Saya menyatakan bahwa seluruh rincian perubahan barang, kuantiti, harga, penyesuaian, dan akun akuntansi di atas sudah sesuai dan siap disimpan.
                            </label>
                        </div>

                        <div id="saveButton" class="hidden">
                            <button 
                                type="submit" 
                                id="btnSimpan" 
                                class="w-full h-[46px] inline-flex items-center justify-center gap-2 px-6 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs uppercase tracking-wider shadow-sm transition cursor-pointer"
                            >
                                <i data-lucide="save" class="w-4 h-4"></i>
                                <span>Simpan Perubahan Faktur Pembelian</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>

    </div>

    <!-- Modal Form Component for Potongan, Edit Barang, Split Barang -->
    <x-modal-form id="modal" size="" show="loadmodal" title="" />

    <!-- Modal Data Master Barang -->
    <div id="modalBarang" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-5xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl overflow-hidden transform transition-all border border-slate-200 dark:border-slate-800">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#162a5b] text-white flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center border border-white/15 shadow-inner">
                        <i data-lucide="boxes" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold tracking-tight text-white">Data Master Barang Pembelian</h3>
                        <p class="text-[11px] text-blue-200/80">Pilih salah satu item barang untuk ditambahkan ke daftar faktur</p>
                    </div>
                </div>
                <button 
                    type="button" 
                    onclick="$('#modalBarang').addClass('hidden')" 
                    class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6 max-h-[80vh] overflow-y-auto bg-slate-50/50 dark:bg-slate-800/40">
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-2xs p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left" id="tabelbarang" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th style="width: 12%;">Kode</th>
                                    <th style="width: 38%;">Nama Barang</th>
                                    <th style="width: 12%;">Satuan</th>
                                    <th style="width: 16%;">Jenis Barang</th>
                                    <th style="width: 14%;">Kategori</th>
                                    <th style="width: 8%;" class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('myscript')
<script>
    $(document).ready(function() {
        const form = $("#formPembelian");

        let baris = {{ $no }};
        let barisPotongan = {{ $no_potongan }};
        let barisSplit = 1;

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        function syncRadioCardStyles() {
            $('.radio-card input[type="radio"]').each(function() {
                const label = $(this).closest('label');
                if ($(this).is(':checked')) {
                    label.addClass('border-[#162a5b] bg-blue-50/50 dark:bg-blue-950/20 text-[#162a5b] dark:text-blue-400')
                         .removeClass('border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300');
                } else {
                    label.removeClass('border-[#162a5b] bg-blue-50/50 dark:bg-blue-950/20 text-[#162a5b] dark:text-blue-400')
                         .addClass('border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300');
                }
            });
        }
        $(document).on('change', '.radio-card input[type="radio"]', syncRadioCardStyles);
        syncRadioCardStyles();

        form.find("#no_bukti").on('keydown keyup', function(e) {
            if (e.key === ' ') {
                e.preventDefault();
            }
            this.value = this.value.toUpperCase();
        });

        function buttonDisable() {
            $("#btnSimpan").prop('disabled', true);
            $("#btnSimpan").html(`
                <div class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin me-2"></div>
                <span>Menyimpan Perubahan...</span>
            `);
        }

        function resetForm() {
            form.find("#kode_barang").val("");
            form.find("#nama_barang").val("");
            form.find("#jumlah").val("");
            form.find("#harga").val("");
            form.find("#penyesuaian").val("");
            form.find('.select2Kodeakun').val('').trigger("change");
            form.find("#keterangan").val("");
            form.find('.select2Kodecabang').val('').trigger("change");
        }

        function resetFormsplit() {
            const formSplit = $(document).find("#formSplitbarang");
            formSplit.find("#kode_barang").val("");
            formSplit.find("#nama_barang_split").val("");
            formSplit.find("#jumlah").val("");
            formSplit.find("#harga").val("");
            formSplit.find("#penyesuaian").val("");
            formSplit.find('.select2Kodeakunsplit').val('').trigger("change");
            formSplit.find("#keterangan").val("");
            formSplit.find('.select2Kodecabangsplit').val('').trigger("change");
        }

        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Supplier',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodeakun = $('.select2Kodeakun');
        if (select2Kodeakun.length) {
            select2Kodeakun.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Akun',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodecabang = $('.select2Kodecabang');
        if (select2Kodecabang.length) {
            select2Kodecabang.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih Cabang (Opsional)',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        function loadTablebarang(kode_group = "000") {
            $('#tabelbarang').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: `/barangpembelian/${kode_group}/getbarangjson`,
                bAutoWidth: false,
                bDestroy: true,
                columns: [
                    { data: 'kode_barang_badge', name: 'kode_barang', orderable: true, searchable: true },
                    { data: 'namabarang', name: 'nama_barang', orderable: true, searchable: true },
                    { data: 'satuan_badge', name: 'satuan', orderable: true, searchable: false },
                    { data: 'jenisbarang', name: 'jenisbarang', orderable: true, searchable: false },
                    { data: 'kategori_badge', name: 'nama_kategori', orderable: true, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                drawCallback: function() {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }
            });
        }

        $(document).on("click", "#nama_barang", function(e) {
            let kode_group = form.find("input[name='kode_asal_pengajuan']").val() || form.find("#kode_asal_pengajuan").val();
            if (!kode_group) {
                Swal.fire({
                    title: "Perhatian",
                    text: "Asal Pengajuan tidak ditemukan!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b"
                });
            } else {
                loadTablebarang(kode_group);
                $("#modalBarang").removeClass("hidden");
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        });

        // Close modal when clicking outside box
        $(document).on('click', '#modalBarang', function(e) {
            if (e.target === this) {
                $(this).addClass('hidden');
            }
        });

        function isModalOpen(modalId) {
            var modal = document.getElementById(modalId);
            if (modal) {
                return !modal.classList.contains('hidden');
            }
            return false;
        }

        $('#tabelbarang tbody').on('click', '.pilihBarang', function(e) {
            e.preventDefault();
            const kode_barang = $(this).attr('kode_barang');
            const nama_barang = $(this).attr('nama_barang');

            if (!isModalOpen('modal')) {
                form.find("#kode_barang").val(kode_barang);
                form.find("#nama_barang").val(nama_barang);
                form.find("#jumlah").focus();
            } else {
                $(document).find("#formSplitbarang").find("#nama_barang_split").val(nama_barang);
                $(document).find("#formSplitbarang").find("#kode_barang").val(kode_barang);
            }

            $("#modalBarang").addClass("hidden");
        });

        function convertNumber(number) {
            if (!number) return 0;
            let formatted = (number + '').replace(/\./g, '');
            formatted = formatted.replace(/,/g, '.');
            return formatted || 0;
        }

        function numberFormat(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
                dec = typeof dec_point === 'undefined' ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        function calculateTotal() {
            let grandTotal = 0;
            $('.totalharga').each(function() {
                grandTotal += parseFloat(convertNumber($(this).text())) || 0;
            });
            $('#grandtotal').text(numberFormat(grandTotal, '2', ',', '.'));
            $('#grandtotal_text').text(numberFormat(grandTotal, '2', ',', '.'));
        }
        calculateTotal();

        function addBarang() {
            const kode_barang = form.find("#kode_barang").val();
            const nama_barang = form.find("#nama_barang").val();
            const jumlah = form.find("#jumlah").val();
            const harga = form.find("#harga").val();
            const penyesuaian = form.find("#penyesuaian").val() || '0';
            const dataAkun = form.find("#kode_akun :selected").select2(this.data);
            const kode_akun = $(dataAkun).val();
            const nama_akun = $(dataAkun).text();
            const keterangan = form.find("#keterangan").val();
            const kode_cabang = form.find("#kode_cabang").val();

            if (kode_barang == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Barang harus dipilih terlebih dahulu!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: (e) => {
                        form.find("#nama_barang").focus();
                    },
                });
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Oops!",
                    text: "Qty barang harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: (e) => {
                        form.find("#jumlah").focus();
                    },
                });
            } else if (harga == "" || harga === "0") {
                Swal.fire({
                    title: "Oops!",
                    text: "Harga barang harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: (e) => {
                        form.find("#harga").focus();
                    },
                });
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Akun Akuntansi harus dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: (e) => {
                        form.find("#kode_akun").focus();
                    },
                });
            } else {
                baris = baris + 1;
                let jml = convertNumber(jumlah);
                let hrg = convertNumber(harga);
                let peny = convertNumber(penyesuaian);
                let subtotal = parseFloat(jml) * parseFloat(hrg);
                let total = parseFloat(subtotal) + parseFloat(peny);
                jml = numberFormat(jml, '2', ',', '.');
                subtotal = numberFormat(subtotal, '2', ',', '.');
                total = numberFormat(total, '2', ',', '.');
                let bg;
                if ((kode_akun.substring(0, 3) == '6-1' && kode_cabang != '') || (kode_akun.substring(0, 3) == '6-2' && kode_cabang != '')) {
                    bg = "bg-blue-50/60 dark:bg-blue-950/20";
                } else {
                    bg = "";
                }
                let barang = `
                <tr id="index_${baris}" class="${bg} hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                    <td class="py-2.5 px-3 font-mono font-bold text-slate-800 dark:text-white">
                        <input type="hidden" name="kode_barang_item[]" value="${kode_barang}" class="kode_barang" />
                        <input type="hidden" name="jumlah_item[]" value="${jumlah}" class="jumlah" />
                        <input type="hidden" name="harga_item[]" value="${harga}" class="harga" />
                        <input type="hidden" name="penyesuaian_item[]" value="${penyesuaian}" class="penyesuaian" />
                        <input type="hidden" name="kode_akun_item[]" value="${kode_akun}" class="kode_akun" />
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}" class="keterangan" />
                        <input type="hidden" name="kode_cabang_item[]" value="${kode_cabang}" class="kode_cabang" />
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">${kode_barang}</span>
                    </td>
                    <td class="py-2.5 px-3 font-bold text-slate-900 dark:text-white">
                        <div>${nama_barang}</div>
                        ${keterangan ? `<div class="text-[10px] text-slate-400 font-normal mt-0.5">${keterangan}</div>` : ''}
                    </td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-white">${jml}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">${harga}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-500 whitespace-nowrap">${penyesuaian}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap totalharga">${total}</td>
                    <td class="py-2.5 px-3 text-slate-700 dark:text-slate-300">
                        <div class="text-[11px] font-bold text-slate-900 dark:text-white">${nama_akun}</div>
                        <span class="text-[10px] font-mono text-slate-400">${kode_akun}</span>
                    </td>
                    <td class="py-2.5 px-3 text-center uppercase font-semibold text-slate-600 dark:text-slate-400">${kode_cabang || '-'}</td>
                    <td class="py-2.5 px-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" class="btnEditbarang w-7 h-7 rounded-lg inline-flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 text-emerald-600 border border-emerald-200/60 transition cursor-pointer shadow-2xs" id="index_${baris}" title="Edit Barang">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" class="btnSplit w-7 h-7 rounded-lg inline-flex items-center justify-center bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 text-sky-600 border border-sky-200/60 transition cursor-pointer shadow-2xs" id="index_${baris}" title="Split Barang">
                                <i data-lucide="git-fork" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" id="index_${baris}" class="delete w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" title="Hapus Barang">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
                $('#loadbarang').append(barang);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                calculateTotal();
                resetForm();
            }
        }

        form.find("#btnTambahbarang").click(function(e) {
            e.preventDefault();
            addBarang();
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let id = $(this).attr("id");
            Swal.fire({
                title: "Hapus Item Barang?",
                text: "Barang ini akan dihapus dari faktur pembelian.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#162a5b",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loadbarang").find(`#${id}`).remove();
                    calculateTotal();
                }
            });
        });

        form.find('.agreement').change(function() {
            if (this.checked) {
                form.find("#saveButton").removeClass("hidden");
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            } else {
                form.find("#saveButton").addClass("hidden");
            }
        });

        form.submit(function() {
            const no_bukti = form.find("#no_bukti").val();
            const tanggal = form.find("#tanggal").val();
            const kode_supplier = form.find("#kode_supplier").val();
            const kode_asal_pengajuan = form.find("input[name='kode_asal_pengajuan']").val() || form.find("#kode_asal_pengajuan").val();
            const jenis_transaksi = form.find("#jenis_transaksi").val();
            const jatuh_tempo = form.find("#jatuh_tempo").val();

            if (no_bukti == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "No. Bukti Pembelian wajib diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#no_bukti").focus();
                    },
                });
                return false;
            } else if (tanggal == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Tanggal Faktur wajib diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#tanggal").focus();
                    },
                });
                return false;
            } else if (kode_supplier == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Supplier rekanan wajib dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#kode_supplier").focus();
                    },
                });
                return false;
            } else if (kode_asal_pengajuan == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Asal Ajuan pembelian wajib ada!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b"
                });
                return false;
            } else if (jenis_transaksi == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Jenis Pembayaran (Tunai/Kredit) wajib dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#jenis_transaksi").focus();
                    },
                });
                return false;
            } else if (jatuh_tempo == "" && jenis_transaksi == 'K') {
                Swal.fire({
                    title: "Perhatian",
                    text: "Jatuh Tempo wajib diisi untuk transaksi Kredit!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#jatuh_tempo").focus();
                    },
                });
                return false;
            } else if ($('#loadbarang tr').length == 0) {
                Swal.fire({
                    title: "Perhatian",
                    text: "Detail barang pembelian tidak boleh kosong! Tambahkan minimal 1 item barang.",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#nama_barang").focus();
                    },
                });
                return false;
            } else {
                buttonDisable();
            }
        });

        function loading() {
            $("#loadmodal").html(`
                <div class="flex flex-col items-center justify-center py-12 gap-3">
                    <div class="w-9 h-9 border-4 border-blue-600/20 border-t-[#162a5b] rounded-full animate-spin"></div>
                    <span class="text-xs font-semibold text-slate-500">Memuat formulir...</span>
                </div>
            `);
        }

        $(document).on("click", "#tambahpotongan", function(e) {
            e.preventDefault();
            loading();
            $("#modal").removeClass("hidden");
            $("#modal").find(".modal-title").text("Tambah Potongan Pembelian");
            $("#modal").find("#loadmodal").load(`/pembelian/createpotongan`);
            $("#modal").find(".modal-dialog").removeClass("max-w-6xl max-w-7xl max-w-full").addClass("max-w-xl");
        });

        $(document).on('submit', '#formPotongan', function(e) {
            e.preventDefault();
            const keterangan = $(this).find("#keterangan_potongan").val();
            const jumlah = $(this).find("#jumlah_potongan").val();
            const harga = $(this).find("#harga_potongan").val();
            const total_potongan = $(this).find("#total_potongan").val();
            const dataAkun = $(this).find("#kode_akun_potongan :selected").select2(this.data);
            const kode_akun = $(dataAkun).val();
            const nama_akun = $(dataAkun).text();

            if (keterangan == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Keterangan potongan harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#keterangan_potongan").focus();
                    },
                });
                return false;
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Qty potongan tidak boleh kosong!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#jumlah_potongan").focus();
                    },
                });
                return false;
            } else if (harga == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Harga potongan harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#harga_potongan").focus();
                    },
                });
                return false;
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Kode Akun potongan harus dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#kode_akun_potongan").focus();
                    },
                });
                return false;
            } else {
                barisPotongan += 1;
                let potongan = `
                <tr id="index_${barisPotongan}" class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                    <td class="py-2.5 px-3 font-medium text-slate-800 dark:text-white">
                        <input type="hidden" name="keterangan_potongan_item[]" value="${keterangan}" />
                        <input type="hidden" name="kode_akun_potongan_item[]" value="${kode_akun}" />
                        <input type="hidden" name="jumlah_potongan_item[]" value="${jumlah}" />
                        <input type="hidden" name="harga_potongan_item[]" value="${harga}" />
                        ${keterangan}
                    </td>
                    <td class="py-2.5 px-3 text-slate-600 dark:text-slate-400">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">${kode_akun}</span>
                        <span class="ml-1 text-[11px]">${nama_akun}</span>
                    </td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-white">${jumlah}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">${harga}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">${total_potongan}</td>
                    <td class="py-2.5 px-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" id="index_${barisPotongan}" class="editpotongan w-7 h-7 rounded-lg inline-flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 text-emerald-600 border border-emerald-200/60 transition cursor-pointer shadow-2xs" title="Edit Potongan">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" id="index_${barisPotongan}" class="deletepotongan w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" title="Hapus Potongan">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
                $('#loadpotongan').append(potongan);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                $("#modal").addClass("hidden");
            }
        });

        $(document).on('click', '.deletepotongan', function(e) {
            e.preventDefault();
            let id = $(this).attr("id");
            Swal.fire({
                title: "Hapus Potongan?",
                text: "Item potongan ini akan dihapus dari transaksi.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#162a5b",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loadpotongan").find(`#${id}`).remove();
                }
            });
        });

        let currentRow;
        $(document).on('click', '.btnEditbarang', function(e) {
            e.preventDefault();
            currentRow = $(this).closest('tr');

            let kode_barang = currentRow.find('td:eq(0)').text().trim();
            let nama_barang = currentRow.find('td:eq(1) > div:first').text().trim() || currentRow.find('td:eq(1)').text().trim();
            let jumlah = currentRow.find('td:eq(2)').text().trim();
            let harga = currentRow.find('td:eq(3)').text().trim();
            let penyesuaian = currentRow.find('td:eq(4)').text().trim();
            let kode_akun = currentRow.find('.kode_akun').val();
            let keterangan = currentRow.find('.keterangan').val();
            let kode_cabang = currentRow.find('.kode_cabang').val();

            let dataBarang = {
                'kode_barang': kode_barang,
                'nama_barang': nama_barang,
                'jumlah': jumlah,
                'harga': harga,
                'penyesuaian': penyesuaian,
                'kode_akun': kode_akun,
                'keterangan': keterangan,
                'kode_cabang': kode_cabang,
                'cekhistoribayar': "{{ $cekhistoribayar }}",
            };

            $.ajax({
                type: 'POST',
                url: '/pembelian/editbarang',
                data: {
                    _token: "{{ csrf_token() }}",
                    databarang: dataBarang
                },
                cache: false,
                success: function(respond) {
                    $("#modal").removeClass("hidden");
                    $("#modal").find(".modal-title").text("Edit Barang");
                    $("#loadmodal").html(respond);
                    $("#modal").find(".modal-dialog").removeClass("max-w-6xl max-w-7xl max-w-full").addClass("max-w-xl");
                }
            });
        });

        $(document).on('submit', '#formEditbarang', function(e) {
            e.preventDefault();
            const kode_barang = $(this).find("#kode_barang").val();
            const nama_barang = $(this).find("#nama_barang").val();
            const jumlah = $(this).find("#jumlah").val();
            const harga = $(this).find("#harga").val();
            const penyesuaian = $(this).find("#penyesuaian").val() || '0';
            const dataAkun = $(this).find("#kode_akun_editBarang :selected").select2(this.data);
            const kode_akun = $(dataAkun).val();
            const nama_akun = $(dataAkun).text();
            const keterangan = $(this).find("#keterangan").val();
            const kode_cabang = $(this).find("#kode_cabang_editBarang").val();

            if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Qty tidak boleh kosong!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#jumlah").focus();
                    },
                });
            } else if (harga == "" || harga === "0") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Harga tidak boleh kosong!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#harga").focus();
                    },
                });
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Akun Akuntansi harus dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#kode_akun_editBarang").focus();
                    },
                });
            } else {
                baris = baris + 1;
                let jml = convertNumber(jumlah);
                let hrg = convertNumber(harga);
                let peny = convertNumber(penyesuaian);
                let subtotal = parseFloat(jml) * parseFloat(hrg);
                let total = parseFloat(subtotal) + parseFloat(peny);
                jml = numberFormat(jml, '2', ',', '.');
                subtotal = numberFormat(subtotal, '2', ',', '.');
                total = numberFormat(total, '2', ',', '.');
                let bg;
                if ((kode_akun.substring(0, 3) == '6-1' && kode_cabang != '') || (kode_akun.substring(0, 3) == '6-2' && kode_cabang != '')) {
                    bg = "bg-blue-50/60 dark:bg-blue-950/20";
                } else {
                    bg = "";
                }
                let newRow = `
                <tr id="index_${baris}" class="${bg} hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                    <td class="py-2.5 px-3 font-mono font-bold text-slate-800 dark:text-white">
                        <input type="hidden" name="kode_barang_item[]" value="${kode_barang}" class="kode_barang"/>
                        <input type="hidden" name="jumlah_item[]" value="${jumlah}" class="jumlah"/>
                        <input type="hidden" name="harga_item[]" value="${harga}" class="harga"/>
                        <input type="hidden" name="penyesuaian_item[]" value="${penyesuaian}" class="penyesuaian"/>
                        <input type="hidden" name="kode_akun_item[]" value="${kode_akun}" class="kode_akun" />
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}" class="keterangan"/>
                        <input type="hidden" name="kode_cabang_item[]" value="${kode_cabang}" class="kode_cabang"/>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">${kode_barang}</span>
                    </td>
                    <td class="py-2.5 px-3 font-bold text-slate-900 dark:text-white">
                        <div>${nama_barang}</div>
                        ${keterangan ? `<div class="text-[10px] text-slate-400 font-normal mt-0.5">${keterangan}</div>` : ''}
                    </td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-white">${jml}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">${harga}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-500 whitespace-nowrap">${penyesuaian}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap totalharga">${total}</td>
                    <td class="py-2.5 px-3 text-slate-700 dark:text-slate-300">
                        <div class="text-[11px] font-bold text-slate-900 dark:text-white">${nama_akun}</div>
                        <span class="text-[10px] font-mono text-slate-400">${kode_akun}</span>
                    </td>
                    <td class="py-2.5 px-3 text-center uppercase font-semibold text-slate-600 dark:text-slate-400">${kode_cabang || '-'}</td>
                    <td class="py-2.5 px-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" class="btnEditbarang w-7 h-7 rounded-lg inline-flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 text-emerald-600 border border-emerald-200/60 transition cursor-pointer shadow-2xs" id="index_${baris}" title="Edit Barang">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" class="btnSplit w-7 h-7 rounded-lg inline-flex items-center justify-center bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 text-sky-600 border border-sky-200/60 transition cursor-pointer shadow-2xs" id="index_${baris}" title="Split Barang">
                                <i data-lucide="git-fork" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" id="index_${baris}" class="delete w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" title="Hapus Barang">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
                currentRow.replaceWith(newRow);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                $("#modal").addClass("hidden");
                calculateTotal();
            }
        });

        $(document).on('click', '.btnSplit', function(e) {
            e.preventDefault();
            currentRow = $(this).closest('tr');

            let kode_barang = currentRow.find('td:eq(0)').text().trim();
            let nama_barang = currentRow.find('td:eq(1) > div:first').text().trim() || currentRow.find('td:eq(1)').text().trim();
            let jumlah = currentRow.find('td:eq(2)').text().trim();
            let harga = currentRow.find('td:eq(3)').text().trim();
            let penyesuaian = currentRow.find('td:eq(4)').text().trim();
            let kode_akun = currentRow.find('.kode_akun').val();
            let keterangan = currentRow.find('.keterangan').val();
            let kode_cabang = currentRow.find('.kode_cabang').val();

            let dataBarang = {
                'kode_barang': kode_barang,
                'nama_barang': nama_barang,
                'jumlah': jumlah,
                'harga': harga,
                'penyesuaian': penyesuaian,
                'kode_akun': kode_akun,
                'keterangan': keterangan,
                'kode_cabang': kode_cabang
            };

            $.ajax({
                type: 'POST',
                url: '/pembelian/splitbarang',
                data: {
                    _token: "{{ csrf_token() }}",
                    databarang: dataBarang
                },
                cache: false,
                success: function(respond) {
                    $("#modal").removeClass("hidden");
                    $("#modal").find(".modal-title").text("Split Barang");
                    $("#loadmodal").html(respond);
                    $("#modal").find(".modal-dialog").removeClass("max-w-xl").addClass("max-w-6xl");
                }
            });
        });

        let grandTotalsplit = 0;

        function calculateTotalsplit() {
            const formSplit = $(document).find("#formSplitbarang");
            let grandTotal = 0;
            formSplit.find('.totalharga').each(function() {
                grandTotal += parseFloat(convertNumber($(this).text())) || 0;
            });
            formSplit.find('#grandtotal').text(numberFormat(grandTotal, '2', ',', '.'));
            grandTotalsplit = grandTotal;
        }

        $(document).on('click', '#btnSplitbarang', function(e) {
            e.preventDefault();
            const formSplit = $(document).find("#formSplitbarang");
            const kode_barang = formSplit.find("#kode_barang").val();
            const nama_barang = formSplit.find("#nama_barang_split").val();
            const jumlah = formSplit.find("#jumlah").val();
            const harga = formSplit.find("#harga").val();
            const penyesuaian = formSplit.find("#penyesuaian").val() || '0';
            const dataAkun = formSplit.find("#kode_akun_split :selected").select2(this.data);
            const kode_akun = $(dataAkun).val();
            const nama_akun = $(dataAkun).text();
            const keterangan = formSplit.find("#keterangan").val();
            const kode_cabang = formSplit.find("#kode_cabang_split").val();
            const totalSplit = convertNumber(formSplit.find('#totalSplit').text());
            const total = parseFloat(convertNumber(jumlah)) * parseFloat(convertNumber(harga)) + parseFloat(convertNumber(penyesuaian));
            const jmlSplit = parseFloat(grandTotalsplit) + parseFloat(total);

            if (kode_barang == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Barang harus dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        formSplit.find("#nama_barang_split").focus();
                    },
                });
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Qty tidak boleh kosong!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        formSplit.find("#jumlah").focus();
                    },
                });
            } else if (harga == "" || harga === "0") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Harga tidak boleh kosong!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        formSplit.find("#harga").focus();
                    },
                });
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Akun Akuntansi harus dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        formSplit.find("#kode_akun_split").focus();
                    },
                });
            } else if (parseFloat(jmlSplit) > parseFloat(totalSplit)) {
                Swal.fire({
                    title: "Perhatian",
                    text: "Jumlah split melebihi total seharusnya!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        formSplit.find("#jumlah").focus();
                    },
                });
            } else {
                barisSplit = barisSplit + 1;
                let jml = convertNumber(jumlah);
                let hrg = convertNumber(harga);
                let peny = convertNumber(penyesuaian);
                let subtotal = parseFloat(jml) * parseFloat(hrg);
                let totalRow = parseFloat(subtotal) + parseFloat(peny);
                jml = numberFormat(jml, '2', ',', '.');
                subtotal = numberFormat(subtotal, '2', ',', '.');
                totalRow = numberFormat(totalRow, '2', ',', '.');
                let bg;
                if ((kode_akun.substring(0, 3) == '6-1' && kode_cabang != '') || (kode_akun.substring(0, 3) == '6-2' && kode_cabang != '')) {
                    bg = "bg-blue-50/60 dark:bg-blue-950/20";
                } else {
                    bg = "";
                }
                let splitRow = `
                <tr id="index_${barisSplit}" class="${bg} hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                    <td class="py-2.5 px-3 font-mono font-bold text-slate-800 dark:text-white">
                        <input type="hidden" name="kode_barang_item[]" value="${kode_barang}" class="kode_barang"/>
                        <input type="hidden" name="jumlah_item[]" value="${jumlah}" class="jumlah"/>
                        <input type="hidden" name="harga_item[]" value="${harga}" class="harga"/>
                        <input type="hidden" name="penyesuaian_item[]" value="${penyesuaian}" class="penyesuaian"/>
                        <input type="hidden" name="kode_akun_item[]" value="${kode_akun}" class="kode_akun" />
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}" class="keterangan"/>
                        <input type="hidden" name="kode_cabang_item[]" value="${kode_cabang}" class="kode_cabang"/>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">${kode_barang}</span>
                    </td>
                    <td class="py-2.5 px-3 font-bold text-slate-900 dark:text-white">
                        <div>${nama_barang}</div>
                        ${keterangan ? `<div class="text-[10px] text-slate-400 font-normal mt-0.5">${keterangan}</div>` : ''}
                    </td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-white">${jml}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">${harga}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-500 whitespace-nowrap">${penyesuaian}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap totalharga">${totalRow}</td>
                    <td class="py-2.5 px-3 text-slate-700 dark:text-slate-300">
                        <div class="text-[11px] font-bold text-slate-900 dark:text-white">${nama_akun}</div>
                        <span class="text-[10px] font-mono text-slate-400">${kode_akun}</span>
                    </td>
                    <td class="py-2.5 px-3 text-center uppercase font-semibold text-slate-600 dark:text-slate-400">${kode_cabang || '-'}</td>
                    <td class="py-2.5 px-3 text-center whitespace-nowrap">
                        <button type="button" id="index_${barisSplit}" class="deleteSplit hapussplit w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" title="Hapus Split">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        </button>
                    </td>
                </tr>`;
                formSplit.find("#loadsplitbarang").append(splitRow);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                calculateTotalsplit();
                resetFormsplit();
            }
        });

        $(document).on('click', '.deleteSplit', function(e) {
            e.preventDefault();
            let id = $(this).attr("id");
            Swal.fire({
                title: "Hapus Baris Split?",
                text: "Baris split ini akan dihapus.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#162a5b",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(document).find("#formSplitbarang").find("#loadsplitbarang").find(`#${id}`).remove();
                    calculateTotalsplit();
                }
            });
        });

        $(document).on("click", "#nama_barang_split", function(e) {
            let kode_group = form.find("input[name='kode_asal_pengajuan']").val() || form.find("#kode_asal_pengajuan").val();
            if (!kode_group) {
                Swal.fire({
                    title: "Perhatian",
                    text: "Asal Pengajuan tidak ditemukan!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b"
                });
            } else {
                loadTablebarang(kode_group);
                $("#modalBarang").removeClass("hidden");
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        });

        $(document).on('submit', '#formSplitbarang', function(e) {
            e.preventDefault();
            $('.deleteSplit').remove();
            const totalSplit = convertNumber($(this).find('#totalSplit').text());
            if (parseFloat(grandTotalsplit) != parseFloat(totalSplit)) {
                Swal.fire({
                    title: "Perhatian",
                    text: "Total jumlah split harus sama dengan item yang di-split!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#jumlah").focus();
                    },
                });
            } else {
                var rows = $(document).find("#loadsplitbarang tr").clone();
                currentRow.replaceWith(rows);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                $("#modal").addClass("hidden");
                calculateTotal();
            }
        });

        let currentRowPotongan;
        $(document).on('click', '.editpotongan', function(e) {
            e.preventDefault();
            currentRowPotongan = $(this).closest('tr');
            let keterangan = currentRowPotongan.find('td:eq(0)').text().trim();
            let kode_akun = currentRowPotongan.find('input[name="kode_akun_potongan_item[]"]').val();
            let jumlah = currentRowPotongan.find('input[name="jumlah_potongan_item[]"]').val();
            let harga = currentRowPotongan.find('input[name="harga_potongan_item[]"]').val();
            let total = currentRowPotongan.find('td:eq(4)').text().trim();

            let datapotongan = {
                'keterangan': keterangan,
                'kode_akun': kode_akun,
                'jumlah': jumlah,
                'harga': harga,
                'total': total
            };

            $.ajax({
                type: 'POST',
                url: '/pembelian/editpotongan',
                data: {
                    _token: "{{ csrf_token() }}",
                    datapotongan: datapotongan
                },
                cache: false,
                success: function(respond) {
                    $("#modal").removeClass("hidden");
                    $("#modal").find(".modal-title").text("Edit Potongan");
                    $("#loadmodal").html(respond);
                    $("#modal").find(".modal-dialog").removeClass("max-w-6xl max-w-7xl max-w-full").addClass("max-w-xl");
                }
            });
        });

        $(document).on('submit', '#formEditPotongan', function(e) {
            e.preventDefault();
            const keterangan = $(this).find("#keterangan_potongan").val();
            const jumlah = $(this).find("#jumlah_potongan").val();
            const harga = $(this).find("#harga_potongan").val();
            const total_potongan = $(this).find("#total_potongan").val();
            const dataAkun = $(this).find("#kode_akun_potongan :selected").select2(this.data);
            const kode_akun = $(dataAkun).val();
            const nama_akun = $(dataAkun).text();

            if (keterangan == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Keterangan potongan harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#keterangan_potongan").focus();
                    },
                });
                return false;
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Qty tidak boleh kosong!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#jumlah_potongan").focus();
                    },
                });
                return false;
            } else if (harga == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Harga potongan harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#harga_potongan").focus();
                    },
                });
                return false;
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Kode Akun harus dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        $(this).find("#kode_akun_potongan").focus();
                    },
                });
                return false;
            } else {
                let potongan = `
                    <td class="py-2.5 px-3 font-medium text-slate-800 dark:text-white">
                        <input type="hidden" name="keterangan_potongan_item[]" value="${keterangan}" />
                        <input type="hidden" name="kode_akun_potongan_item[]" value="${kode_akun}" />
                        <input type="hidden" name="jumlah_potongan_item[]" value="${jumlah}" />
                        <input type="hidden" name="harga_potongan_item[]" value="${harga}" />
                        ${keterangan}
                    </td>
                    <td class="py-2.5 px-3 text-slate-600 dark:text-slate-400">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">${kode_akun}</span>
                        <span class="ml-1 text-[11px]">${nama_akun}</span>
                    </td>
                    <td class="py-2.5 px-3 text-center font-bold text-slate-800 dark:text-white">${jumlah}</td>
                    <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">${harga}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">${total_potongan}</td>
                    <td class="py-2.5 px-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1.5">
                            <button type="button" id="index_${barisPotongan}" class="editpotongan w-7 h-7 rounded-lg inline-flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 text-emerald-600 border border-emerald-200/60 transition cursor-pointer shadow-2xs" title="Edit Potongan">
                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            </button>
                            <button type="button" id="index_${barisPotongan}" class="deletepotongan w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" title="Hapus Potongan">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </td>
                `;
                currentRowPotongan.html(potongan);
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                $("#modal").addClass("hidden");
            }
        });

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush
</x-app-layout>
