<form action="{{ route('laporanpembelian.cetakpembelian') }}" method="POST" id="formLapPembelian" target="_blank" class="space-y-4" novalidate>
    @csrf

    <!-- Supplier & Asal Ajuan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Supplier -->
        <div class="space-y-1.5">
            <label for="kode_supplier_pembelian" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Supplier
            </label>
            <select name="kode_supplier" id="kode_supplier_pembelian" class="select2Kodesupplier w-full text-xs font-semibold" data-placeholder="Semua Supplier">
                <option value="">Semua Supplier</option>
                @foreach ($supplier as $d)
                    <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Asal Ajuan -->
        <div class="space-y-1.5">
            <label for="kode_asal_pengajuan_pembelian" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Asal Pengajuan
            </label>
            <select name="kode_asal_pengajuan" id="kode_asal_pengajuan_pembelian" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                <option value="">Semua Asal Ajuan</option>
                @foreach ($asal_ajuan as $d)
                    <option value="{{ $d['kode_group'] }}">{{ $d['nama_group'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- PPN & Kode Akun -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- PPN Status -->
        <div class="space-y-1.5">
            <label for="ppn_pembelian" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Status Pajak (PPN)
            </label>
            <select name="ppn" id="ppn_pembelian" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                <option value="">Semua (PPN & Non-PPN)</option>
                <option value="1">PPN Saja</option>
                <option value="0">Non-PPN Saja</option>
            </select>
        </div>

        <!-- Kode Akun -->
        <div class="space-y-1.5">
            <label for="kode_akun_pembelian" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Kode Akun Biaya / Beban
            </label>
            <select name="kode_akun" id="kode_akun_pembelian" class="select2Kodeakun w-full text-xs font-semibold" data-placeholder="Semua Akun">
                <option value="">Semua Akun</option>
                @foreach ($akun as $d)
                    <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Jenis Filter Periode -->
    <div class="space-y-1.5">
        <label for="jenis_periode_pembelian" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
            Kriteria Filter Periode <span class="text-rose-500">*</span>
        </label>
        <select name="jenis_periode" id="jenis_periode_pembelian" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" onchange="togglePeriodePembelian(this.value)">
            <option value="tanggal" selected>Berdasarkan Rentang Tanggal Transaksi</option>
            <option value="bulan_pajak">Berdasarkan Masa & Tahun Pajak</option>
        </select>
    </div>

    <!-- Filter Rentang Tanggal -->
    <div id="wrapper_tanggal_pembelian" class="space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                <span>Rentang Tanggal Transaksi</span>
            </span>
            <!-- Quick Presets -->
            <div class="flex items-center gap-1.5">
                <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_pembelian" data-target-sampai="sampai_pembelian" data-preset="today">Hari Ini</button>
                <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_pembelian" data-target-sampai="sampai_pembelian" data-preset="this_month">Bulan Ini</button>
                <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_pembelian" data-target-sampai="sampai_pembelian" data-preset="last_month">Bulan Lalu</button>
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
                    id="dari_pembelian" 
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
                    id="sampai_pembelian" 
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
    <div id="wrapper_bulan_pajak_pembelian" class="space-y-2 hidden">
        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
            <i data-lucide="calendar-range" class="w-4 h-4 text-slate-400"></i>
            <span>Masa & Tahun Pajak Faktur</span>
        </span>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <select name="bulan" id="bulan_pembelian" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                <option value="">Pilih Masa Pajak</option>
                @foreach ($list_bulan ?? [] as $d)
                    <option value="{{ $d['kode_bulan'] }}" {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }}>{{ $d['nama_bulan'] }}</option>
                @endforeach
            </select>
            <input 
                type="number" 
                name="tahun" 
                id="tahun_pembelian" 
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