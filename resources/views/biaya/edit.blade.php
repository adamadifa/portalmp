<x-app-layout>
    <x-slot name="header">Edit Biaya Operasional</x-slot>
    <x-slot name="headerTitle">Edit Biaya Operasional</x-slot>
    <x-slot name="headerDescription">Perbarui transaksi biaya operasional, alokasi akun beban, dan perubahan rincian pos biaya</x-slot>

    <style>
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
    .dark .select2-dropdown {
        background-color: #0f172a !important;
        border-color: #334155 !important;
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
    </style>

    <div class="space-y-6">

        <!-- Top Navigation Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('biaya.index') }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs transition cursor-pointer"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4 text-slate-500"></i>
                    <span>Kembali ke Daftar Biaya</span>
                </a>

                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold text-xs bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20">
                    <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                    <span>Edit Transaksi: {{ $biaya->no_bukti }}</span>
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
        <form action="{{ route('biaya.update', Crypt::encrypt($biaya->no_bukti)) }}" method="POST" id="formBiaya" class="w-full" novalidate>
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column (4 cols): Informasi Dasar Transaksi Biaya -->
                <div class="lg:col-span-4 space-y-5">
                    
                    <!-- Card: Informasi Biaya Operasional -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-5 py-4 bg-[#162a5b] text-white flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                                <i data-lucide="receipt" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xs uppercase tracking-wider text-white">Informasi Biaya</h3>
                                <p class="text-[11px] text-blue-200/80">Identitas transaksi & data rekanan</p>
                            </div>
                        </div>

                        <div class="p-5 space-y-3.5">
                            <!-- No. Bukti (Readonly) -->
                            <div>
                                <label for="no_bukti" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    No. Bukti Biaya
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i data-lucide="hash" class="w-4 h-4"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="no_bukti" 
                                        id="no_bukti" 
                                        value="{{ $biaya->no_bukti }}" 
                                        readonly 
                                        class="w-full h-[40px] pl-10 pr-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-xs font-bold font-mono text-slate-700 dark:text-slate-300 cursor-not-allowed shadow-2xs" 
                                    />
                                </div>
                            </div>

                            <!-- Tanggal Transaksi -->
                            <div>
                                <label for="tanggal" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Tanggal Transaksi <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="tanggal" 
                                        id="tanggal" 
                                        value="{{ old('tanggal') ?? $biaya->tanggal }}" 
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
                                        $selectedBulan = old('bulan_pajak') ?? ($biaya->bulan_pajak ?: date('m', strtotime($biaya->tanggal)));
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
                                        $selectedTahun = old('tahun_pajak') ?? ($biaya->tahun_pajak ?: date('Y', strtotime($biaya->tanggal)));
                                    @endphp
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="calendar-days" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <input 
                                            type="number" 
                                            name="tahun_pajak" 
                                            id="tahun_pajak" 
                                            value="{{ $selectedTahun }}" 
                                            class="w-full h-[40px] pl-9 pr-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" 
                                            placeholder="Tahun" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Supplier / Rekanan -->
                            <div>
                                <label for="kode_supplier" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Supplier / Rekanan (Opsional)
                                </label>
                                <select name="kode_supplier" id="kode_supplier" class="select2Kodesupplier w-full">
                                    <option value="">-- Pilih Rekanan / Supplier --</option>
                                    @foreach ($supplier as $d)
                                        <option value="{{ $d->kode_supplier }}" {{ (old('kode_supplier') ?? $biaya->kode_supplier) == $d->kode_supplier ? 'selected' : '' }}>
                                            {{ strtoupper($d->nama_supplier) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jenis Transaksi (Tunai / Kredit) -->
                            <div>
                                <label for="jenis_transaksi" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Jenis Transaksi <span class="text-rose-500">*</span>
                                </label>
                                @php
                                    $jtVal = old('jenis_transaksi') ?? $biaya->jenis_transaksi;
                                @endphp
                                <select 
                                    name="jenis_transaksi" 
                                    id="jenis_transaksi" 
                                    class="w-full h-[40px] px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs cursor-pointer"
                                    required
                                >
                                    <option value="T" {{ $jtVal == 'T' ? 'selected' : '' }}>Tunai (Cash / Bank Langsung)</option>
                                    <option value="K" {{ $jtVal == 'K' ? 'selected' : '' }}>Kredit (Hutang / Tempo)</option>
                                </select>
                            </div>

                            <!-- Tanggal Jatuh Tempo (Hanya jika Kredit) -->
                            <div id="group_jatuh_tempo" class="{{ $jtVal == 'K' ? '' : 'hidden' }}">
                                <label for="tanggal_jatuh_tempo" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Tanggal Jatuh Tempo <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="tanggal_jatuh_tempo" 
                                        id="tanggal_jatuh_tempo" 
                                        value="{{ old('tanggal_jatuh_tempo') ?? $biaya->tanggal_jatuh_tempo }}" 
                                        class="w-full h-[40px] pl-10 pr-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs flatpickr-date" 
                                        placeholder="Pilih Tanggal Jatuh Tempo..." 
                                        autocomplete="off" 
                                    />
                                </div>
                            </div>

                            <!-- Catatan / Keterangan Transaksi -->
                            <div>
                                <label for="keterangan_transaksi" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Catatan Tambahan (Opsional)
                                </label>
                                <textarea 
                                    name="keterangan" 
                                    id="keterangan_transaksi" 
                                    rows="2" 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" 
                                    placeholder="Catatan umum transaksi biaya..."
                                >{{ old('keterangan') ?? $biaya->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (8 cols): Input Pos Biaya & Tabel Rincian -->
                <div class="lg:col-span-8 space-y-5">
                    
                    <!-- Card 1: Input Item Pos Biaya -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-5 py-4 bg-[#162a5b] text-white flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                                    <i data-lucide="layers" class="w-4 h-4 text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-xs uppercase tracking-wider text-white">Tambah Pos Biaya</h3>
                                    <p class="text-[11px] text-blue-200/80">Masukkan deskripsi beban pengeluaran, akun COA, dan alokasi cabang</p>
                                </div>
                            </div>

                            <!-- Live Grand Total Indicator -->
                            <div class="text-right">
                                <div class="text-[10px] uppercase font-bold text-blue-200">Total Akumulasi</div>
                                <div class="text-sm font-extrabold font-mono text-emerald-300 flex items-center justify-end gap-1">
                                    <span>Rp</span>
                                    <span id="grandtotal_text">0</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 space-y-4">
                            <!-- Row 1: Keterangan, Qty, Harga, Penyesuaian -->
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                <!-- Keterangan / Pos Biaya -->
                                <div class="md:col-span-5">
                                    <label for="keterangan" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Keterangan / Pos Biaya <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="file-text" class="w-4 h-4"></i>
                                        </div>
                                        <input 
                                            type="text" 
                                            name="keterangan" 
                                            id="keterangan" 
                                            class="w-full h-[40px] pl-10 pr-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" 
                                            placeholder="Contoh: Pembelian ATK Kantor" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>

                                <!-- Qty -->
                                <div class="md:col-span-2">
                                    <label for="jumlah" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Qty
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="hash" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <input 
                                            type="text" 
                                            name="jumlah" 
                                            id="jumlah" 
                                            value="1" 
                                            class="w-full h-[40px] pl-8 pr-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-right text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs number-separator" 
                                            placeholder="1" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>

                                <!-- Harga Satuan -->
                                <div class="md:col-span-2">
                                    <label for="harga" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Harga Satuan <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="banknote" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <input 
                                            type="text" 
                                            name="harga" 
                                            id="harga" 
                                            class="w-full h-[40px] pl-8 pr-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-right text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs number-separator" 
                                            placeholder="0" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>

                                <!-- Penyesuaian -->
                                <div class="md:col-span-3">
                                    <label for="penyesuaian" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Penyesuaian (+ / -)
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i data-lucide="sliders" class="w-3.5 h-3.5"></i>
                                        </div>
                                        <input 
                                            type="text" 
                                            name="penyesuaian" 
                                            id="penyesuaian" 
                                            class="w-full h-[40px] pl-8 pr-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-right text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs number-separator" 
                                            placeholder="0" 
                                            autocomplete="off" 
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Akun COA & Alokasi Cabang -->
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                <!-- Akun (COA) -->
                                <div class="md:col-span-7">
                                    <label for="kode_akun" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Akun Perkiraan (COA) <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="kode_akun" id="kode_akun" class="select2Kodeakun w-full">
                                        <option value="">-- Pilih Akun (COA) --</option>
                                        @foreach ($coa as $d)
                                            <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cabang (Opsional) -->
                                <div class="md:col-span-5">
                                    <label for="kode_cabang" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                        Alokasi Cabang (Opsional)
                                    </label>
                                    <select name="kode_cabang" id="kode_cabang" class="select2Kodecabang w-full">
                                        <option value="">-- Cabang (Opsional) --</option>
                                        @foreach ($cabang as $d)
                                            <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tambah Button -->
                            <div class="pt-1">
                                <button 
                                    type="button" 
                                    id="btnTambahbarang" 
                                    class="w-full h-[42px] inline-flex items-center justify-center gap-2 px-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-[#162a5b] dark:text-blue-400 font-bold text-xs border border-blue-200/60 dark:border-blue-500/20 shadow-2xs transition cursor-pointer"
                                >
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                    <span>Tambahkan ke Tabel Rincian Biaya</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Tabel Rincian Pos Biaya -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                        <div class="px-5 py-3.5 bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i data-lucide="list" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                <span class="font-bold text-xs text-slate-800 dark:text-white uppercase tracking-wider">Daftar Rincian Pos Biaya</span>
                            </div>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Pastikan seluruh pos beban dan akun telah sesuai</span>
                        </div>

                        <!-- Table Responsive -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-[#162a5b]">
                                    <tr class="text-[11px] font-extrabold uppercase tracking-wider text-blue-200/90 bg-[#162a5b]">
                                        <th class="py-2.5 px-4 min-w-[180px]">Pos Biaya / Keterangan</th>
                                        <th class="py-2.5 px-3 w-16 text-center">Qty</th>
                                        <th class="py-2.5 px-3 w-28 text-right">Harga</th>
                                        <th class="py-2.5 px-3 w-28 text-right">Subtotal</th>
                                        <th class="py-2.5 px-3 w-24 text-right">Penyesuaian</th>
                                        <th class="py-2.5 px-3 w-32 text-right">Total</th>
                                        <th class="py-2.5 px-4 min-w-[150px]">Akun (COA)</th>
                                        <th class="py-2.5 px-3 w-20 text-center">Cabang</th>
                                        <th class="py-2.5 px-3 w-14 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadbarang" class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                                    @php $initGrandTotal = 0; @endphp
                                    @foreach ($detail as $idx => $item)
                                        @php
                                            $subtotal = $item->jumlah * $item->harga;
                                            $total = $subtotal + $item->penyesuaian;
                                            $initGrandTotal += $total;
                                            $namaKet = $item->keterangan ?? $item->nama_barang;
                                            $bg = "";
                                            if ((substr($item->kode_akun, 0, 3) == '6-1' || substr($item->kode_akun, 0, 3) == '6-2') && !empty($item->kode_cabang)) {
                                                $bg = "bg-blue-50/40 dark:bg-blue-900/10";
                                            }
                                        @endphp
                                        <tr id="index_{{ $idx + 1 }}" class="item-row {{ $bg }} hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                            <td class="py-2 px-4 font-semibold text-slate-800 dark:text-white">
                                                <input type="hidden" name="keterangan_item[]" value="{{ $namaKet }}" />
                                                <input type="hidden" name="jumlah_item[]" value="{{ formatAngkaDesimal($item->jumlah) }}" />
                                                <input type="hidden" name="harga_item[]" value="{{ formatAngkaDesimal($item->harga) }}" />
                                                <input type="hidden" name="penyesuaian_item[]" value="{{ formatAngkaDesimal($item->penyesuaian) }}" />
                                                <input type="hidden" name="kode_akun_item[]" value="{{ $item->kode_akun }}" />
                                                <input type="hidden" name="kode_cabang_item[]" value="{{ $item->kode_cabang }}" />
                                                <div>{{ $namaKet }}</div>
                                            </td>
                                            <td class="py-2 px-3 text-center text-slate-700 dark:text-slate-300 font-mono">{{ formatAngkaDesimal($item->jumlah) }}</td>
                                            <td class="py-2 px-3 text-right text-slate-700 dark:text-slate-300 font-mono">{{ formatAngkaDesimal($item->harga) }}</td>
                                            <td class="py-2 px-3 text-right text-slate-700 dark:text-slate-300 font-mono">{{ formatAngkaDesimal($subtotal) }}</td>
                                            <td class="py-2 px-3 text-right text-slate-700 dark:text-slate-300 font-mono">{{ formatAngkaDesimal($item->penyesuaian) }}</td>
                                            <td class="py-2 px-3 text-right font-mono font-bold text-slate-900 dark:text-white totalharga">{{ formatAngkaDesimal($total) }}</td>
                                            <td class="py-2 px-4 text-slate-600 dark:text-slate-400 font-medium">
                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-mono border border-slate-200/60 dark:border-slate-700">
                                                    {{ $item->kode_akun }}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3 text-center text-slate-600 dark:text-slate-400 font-medium">
                                                @if(!empty($item->kode_cabang))
                                                    <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 text-[11px] font-bold border border-blue-200/60 dark:border-blue-500/20">
                                                        {{ $item->kode_cabang }}
                                                    </span>
                                                @else
                                                    <span class="text-slate-400">-</span>
                                                @endif
                                            </td>
                                            <td class="py-2 px-3 text-center">
                                                <button type="button" id="index_{{ $idx + 1 }}" class="delete w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition cursor-pointer shadow-2xs" title="Hapus Pos Biaya">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="empty_row" class="{{ count($detail) > 0 ? 'hidden' : '' }}">
                                        <td colspan="9" class="py-12 px-4 text-center">
                                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-2 shadow-2xs">
                                                    <i data-lucide="inbox" class="w-5 h-5"></i>
                                                </div>
                                                <h4 class="font-bold text-xs text-slate-700 dark:text-slate-300">Belum ada pos biaya ditambahkan</h4>
                                                <p class="text-[11px] text-slate-400 mt-0.5">Isi form di atas kemudian klik "Tambahkan ke Tabel Rincian Biaya".</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-slate-50 dark:bg-slate-800/40 border-t border-slate-200 dark:border-slate-800 font-bold text-xs">
                                    <tr>
                                        <td colspan="5" class="py-3 px-4 text-right uppercase tracking-wider text-slate-700 dark:text-slate-300 font-bold">
                                            TOTAL BIAYA OPERASIONAL
                                        </td>
                                        <td class="py-3 px-3 text-right font-mono font-extrabold text-[#162a5b] dark:text-blue-400 text-sm">
                                            <span id="grandtotal">{{ formatAngkaDesimal($initGrandTotal) }}</span>
                                        </td>
                                        <td colspan="3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Agreement Checkbox & Submit Button Area -->
                        <div class="p-5 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-800 space-y-3">
                            <label class="inline-flex items-center gap-2.5 cursor-pointer text-xs font-semibold text-slate-700 dark:text-slate-300">
                                <input 
                                    type="checkbox" 
                                    name="aggrement" 
                                    id="defaultCheck3" 
                                    class="agreement w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-[#162a5b] focus:ring-0 cursor-pointer" 
                                    value="aggrement" 
                                    checked
                                />
                                <span>Saya menyatakan bahwa rincian perubahan transaksi biaya operasional di atas telah diverifikasi dengan benar.</span>
                            </label>

                            <div id="saveButton" class="pt-1">
                                <button 
                                    type="submit" 
                                    id="btnSimpan" 
                                    class="w-full h-[44px] inline-flex items-center justify-center gap-2 px-6 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                                >
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    <span>Perbarui Transaksi Biaya</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@push('myscript')
<script>
    $(document).ready(function() {
        const form = $("#formBiaya");
        let baris = {{ count($detail) }};

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        $("#jenis_transaksi").change(function() {
            if ($(this).val() === 'K') {
                $("#group_jatuh_tempo").removeClass('hidden');
            } else {
                $("#group_jatuh_tempo").addClass('hidden');
            }
        });

        function buttonDisable() {
            $("#btnSimpan").prop('disabled', true);
            $("#btnSimpan").html(`
                <svg class="w-4 h-4 text-white animate-spin me-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Sedang Memperbarui Data...
            `);
        }

        function resetForm() {
            form.find("#keterangan").val("");
            form.find("#jumlah").val("1");
            form.find("#harga").val("");
            form.find("#penyesuaian").val("");
            form.find('.select2Kodeakun').val('').trigger("change");
            form.find('.select2Kodecabang').val('').trigger("change");
            form.find("#keterangan").focus();
        }

        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.select2({
                placeholder: '-- Pilih Rekanan / Supplier --',
                allowClear: true,
                width: '100%'
            });
        }

        const select2Kodeakun = $('.select2Kodeakun');
        if (select2Kodeakun.length) {
            select2Kodeakun.select2({
                placeholder: '-- Pilih Akun (COA) --',
                allowClear: true,
                width: '100%'
            });
        }

        const select2Kodecabang = $('.select2Kodecabang');
        if (select2Kodecabang.length) {
            select2Kodecabang.select2({
                placeholder: '-- Cabang (Opsional) --',
                allowClear: true,
                width: '100%'
            });
        }

        function convertNumber(number) {
            if (!number) return 0;
            let formatted = number.toString().replace(/\./g, '');
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

            if ($('#loadbarang tr.item-row').length === 0) {
                $('#empty_row').removeClass('hidden');
            } else {
                $('#empty_row').addClass('hidden');
            }
        }

        calculateTotal();

        function addBarang() {
            const keterangan = form.find("#keterangan").val().trim();
            const jumlah = form.find("#jumlah").val();
            const harga = form.find("#harga").val();
            const penyesuaian = form.find("#penyesuaian").val();
            const dataAkun = form.find("#kode_akun :selected");
            const kode_akun = dataAkun.val();
            const nama_akun = dataAkun.text();
            const kode_cabang = form.find("#kode_cabang").val();

            if (keterangan == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Keterangan / Pos Biaya harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#keterangan").focus();
                    },
                });
            } else if (harga == "" || harga === 0) {
                Swal.fire({
                    title: "Perhatian",
                    text: "Harga satuan biaya harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#harga").focus();
                    },
                });
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Akun perkiraan (COA) harus dipilih!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#kode_akun").focus();
                    },
                });
            } else {
                baris = baris + 1;
                let jml = convertNumber(jumlah) || 1;
                let hrg = convertNumber(harga) || 0;
                let peny = convertNumber(penyesuaian) || 0;
                let subtotal = parseFloat(jml) * parseFloat(hrg);
                let total = parseFloat(subtotal) + parseFloat(peny);
                subtotal = numberFormat(subtotal, '2', ',', '.');
                total = numberFormat(total, '2', ',', '.');
                let bg = "";
                if ((kode_akun.substring(0, 3) == '6-1' || kode_akun.substring(0, 3) == '6-2') && kode_cabang != '') {
                    bg = "bg-blue-50/40 dark:bg-blue-900/10";
                }

                let rowItem = `
                <tr id="index_${baris}" class="item-row ${bg} hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                    <td class="py-2 px-4 font-semibold text-slate-800 dark:text-white">
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}" />
                        <input type="hidden" name="jumlah_item[]" value="${jumlah || '1'}" />
                        <input type="hidden" name="harga_item[]" value="${harga}" />
                        <input type="hidden" name="penyesuaian_item[]" value="${penyesuaian || '0'}" />
                        <input type="hidden" name="kode_akun_item[]" value="${kode_akun}" />
                        <input type="hidden" name="kode_cabang_item[]" value="${kode_cabang}" />
                        <div>${keterangan}</div>
                    </td>
                    <td class="py-2 px-3 text-center text-slate-700 dark:text-slate-300 font-mono">${jumlah || '1'}</td>
                    <td class="py-2 px-3 text-right text-slate-700 dark:text-slate-300 font-mono">${harga}</td>
                    <td class="py-2 px-3 text-right text-slate-700 dark:text-slate-300 font-mono">${subtotal}</td>
                    <td class="py-2 px-3 text-right text-slate-700 dark:text-slate-300 font-mono">${penyesuaian || '0'}</td>
                    <td class="py-2 px-3 text-right font-mono font-bold text-slate-900 dark:text-white totalharga">${total}</td>
                    <td class="py-2 px-4 text-slate-600 dark:text-slate-400 font-medium">
                        <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-mono border border-slate-200/60 dark:border-slate-700">
                            ${nama_akun}
                        </span>
                    </td>
                    <td class="py-2 px-3 text-center text-slate-600 dark:text-slate-400 font-medium">
                        ${kode_cabang ? `<span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 text-[11px] font-bold border border-blue-200/60 dark:border-blue-500/20">${kode_cabang}</span>` : '<span class="text-slate-400">-</span>'}
                    </td>
                    <td class="py-2 px-3 text-center">
                        <button type="button" id="index_${baris}" class="delete w-7 h-7 rounded-lg inline-flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition cursor-pointer shadow-2xs" title="Hapus Pos Biaya">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        </button>
                    </td>
                </tr>`;
                
                $('#loadbarang').append(rowItem);
                calculateTotal();
                resetForm();

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
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
                title: "Hapus Pos Biaya Ini?",
                text: "Item pos biaya ini akan dihapus dari daftar rincian.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#162a5b",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#loadbarang`).find(`#${id}`).remove();
                    calculateTotal();
                }
            });
        });

        form.find('.agreement').change(function() {
            if (this.checked) {
                form.find("#saveButton").removeClass("hidden");
            } else {
                form.find("#saveButton").addClass("hidden");
            }
        });

        form.submit(function() {
            const tanggal = form.find("#tanggal").val().trim();
            const jenis_transaksi = form.find("#jenis_transaksi").val();
            const jatuh_tempo = form.find("#tanggal_jatuh_tempo").val().trim();

            if (tanggal == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Tanggal transaksi harus diisi!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#tanggal").focus();
                    },
                });
                return false;
            } else if (jenis_transaksi == "") {
                Swal.fire({
                    title: "Perhatian",
                    text: "Jenis transaksi harus dipilih!",
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
                    text: "Tanggal jatuh tempo harus diisi untuk transaksi kredit!",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#tanggal_jatuh_tempo").focus();
                    },
                });
                return false;
            } else if ($('#loadbarang tr.item-row').length == 0) {
                Swal.fire({
                    title: "Perhatian",
                    text: "Rincian detail pos biaya tidak boleh kosong! Tambahkan minimal satu pos biaya.",
                    icon: "warning",
                    confirmButtonColor: "#162a5b",
                    didClose: () => {
                        form.find("#keterangan").focus();
                    },
                });
                return false;
            } else {
                buttonDisable();
            }
        });
    });
</script>
@endpush
</x-app-layout>
