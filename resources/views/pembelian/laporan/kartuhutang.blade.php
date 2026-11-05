<form action="{{ route('laporanpembelian.cetakkartuhutang') }}" method="POST" id="formLapKartuHutang" target="_blank" class="space-y-4" novalidate>
    @csrf

    <!-- Supplier -->
    <div class="space-y-1.5">
        <label for="kode_supplier_kartuhutang" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
            Supplier
        </label>
        <select name="kode_supplier_kartuhutang" id="kode_supplier_kartuhutang" class="select2Kodesupplier w-full text-xs font-semibold" data-placeholder="Semua Supplier">
            <option value="">Semua Supplier</option>
            @foreach ($supplier as $d)
                <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
            @endforeach
        </select>
    </div>

    <!-- Jenis Hutang & Format Laporan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1.5">
            <label for="jenis_hutang_kartuhutang" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Klasifikasi Hutang
            </label>
            <select name="jenis_hutang" id="jenis_hutang_kartuhutang" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                <option value="">Semua Jenis Hutang</option>
                <option value="2-1200">2-1200 | Hutang Dagang</option>
                <option value="2-1300">2-1300 | Hutang Lainnya</option>
            </select>
        </div>

        <div class="space-y-1.5">
            <label for="formatlaporan_kartuhutang" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Format / Bentuk Laporan <span class="text-rose-500">*</span>
            </label>
            <select name="formatlaporan" id="formatlaporan_kartuhutang" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs" required>
                <option value="1" selected>Detail Kartu Hutang (Per Transaksi)</option>
                <option value="2">Rekapitulasi Saldo Kartu Hutang</option>
            </select>
        </div>
    </div>

    <!-- PPN & Kategori Pembelian -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="space-y-1.5">
            <label for="ppn_kartuhutang" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Status PPN
            </label>
            <select name="ppn" id="ppn_kartuhutang" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                <option value="">Semua (PPN & Non-PPN)</option>
                <option value="1">PPN Saja</option>
                <option value="0">Non-PPN Saja</option>
            </select>
        </div>

        <div class="space-y-1.5">
            <label for="kategori_pembelian_kartuhutang" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                Asal Barang (Kategori Pembelian)
            </label>
            <select name="kategori_pembelian" id="kategori_pembelian_kartuhutang" class="w-full h-[42px] px-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-[#162a5b] transition shadow-2xs">
                <option value="L" selected>Lokal (Kecualikan Import)</option>
                <option value="I">Hanya Import</option>
                <option value="ALL">Semua Kategori (Lokal & Import)</option>
            </select>
        </div>
    </div>

    <!-- Periode Tanggal -->
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                <span>Periode Kartu Hutang</span>
            </span>
            <!-- Quick Presets -->
            <div class="flex items-center gap-1.5">
                <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_kartuhutang" data-target-sampai="sampai_kartuhutang" data-preset="today">Hari Ini</button>
                <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_kartuhutang" data-target-sampai="sampai_kartuhutang" data-preset="this_month">Bulan Ini</button>
                <button type="button" class="btn-preset text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition cursor-pointer" data-target-dari="dari_kartuhutang" data-target-sampai="sampai_kartuhutang" data-preset="last_month">Bulan Lalu</button>
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
                    id="dari_kartuhutang" 
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
                    id="sampai_kartuhutang" 
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