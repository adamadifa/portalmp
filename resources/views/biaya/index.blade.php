<x-app-layout>
    <x-slot name="header">Biaya Operasional</x-slot>
    <x-slot name="headerTitle">Biaya Operasional</x-slot>
    <x-slot name="headerDescription">Kelola data transaksi biaya operasional, pos beban pengeluaran, tagihan rekanan/supplier, dan histori pembayaran.</x-slot>

    <!-- Custom Select2 & Layout Styling -->
    <style>
        .select2-container { width: 100% !important; }
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            background-color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            padding-left: 0.875rem !important;
            padding-right: 2rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease !important;
        }
        .select2-container--default .select2-selection--single:hover {
            border-color: #cbd5e1 !important;
        }
        .dark .select2-container--default .select2-selection--single {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #f8fafc !important;
        }
        .dark .select2-container--default .select2-selection--single:hover {
            border-color: #334155 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            line-height: normal !important;
            padding-left: 0 !important;
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
            border-color: #2563eb !important;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
        }
    </style>

    <!-- Alert Notifications -->
    @if(session('import_skipped') && count(session('import_skipped')) > 0)
        @php
            $skipped = session('import_skipped');
            $hasSuccess = session('success') ? true : false;
        @endphp
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var skippedData = @json($skipped);
                var rowsHtml = '';
                skippedData.forEach(function(item) {
                    rowsHtml += `<tr class="border-b border-slate-100 hover:bg-slate-50 text-left">
                        <td class="px-3 py-2 text-center font-semibold text-slate-700">${item.baris}</td>
                        <td class="px-3 py-2 font-mono text-xs font-semibold text-[#162a5b]">${item.no_bukti || '-'}</td>
                        <td class="px-3 py-2 text-rose-600 text-xs">${item.alasan}</td>
                    </tr>`;
                });

                var htmlContent = `
                    <div class="text-left space-y-3">
                        <p class="text-xs text-slate-600">
                            {{ $hasSuccess ? session('success') : session('error') }}
                        </p>
                        <div class="bg-amber-50 border border-amber-200 text-amber-900 px-3 py-2 rounded-xl text-xs font-semibold flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 shrink-0"></i>
                            <span>Ditemukan <strong>${skippedData.length} baris</strong> Excel yang dilewati / gagal diproses:</span>
                        </div>
                        <div class="border border-slate-200 rounded-xl overflow-hidden max-h-60 overflow-y-auto">
                            <table class="w-full text-xs text-slate-600">
                                <thead class="bg-slate-100 text-slate-700 font-bold sticky top-0 uppercase tracking-wider text-[10px]">
                                    <tr>
                                        <th class="px-3 py-2 text-center w-16">Baris</th>
                                        <th class="px-3 py-2 w-36">No. Bukti</th>
                                        <th class="px-3 py-2">Alasan Dilewati</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    ${rowsHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;

                Swal.fire({
                    title: '{{ $hasSuccess ? "Hasil Import Biaya" : "Import Biaya Sebagian / Gagal" }}',
                    html: htmlContent,
                    icon: '{{ $hasSuccess ? "warning" : "error" }}',
                    width: '640px',
                    confirmButtonColor: '#162a5b',
                    confirmButtonText: 'Tutup & Mengerti'
                });
            });
        </script>
    @else
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonColor: '#162a5b'
                    });
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Gagal!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                });
            </script>
        @endif
    @endif

    <div class="space-y-6">
        <!-- Top Action & Filter Toolbar -->
        <div class="space-y-3 w-full">
            <!-- Action Toolbar Header -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                        <i data-lucide="filter" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                        <span>Filter & Pencarian Biaya Operasional</span>
                    </span>
                </div>

                <!-- Action Buttons Group -->
                @can('pembelian.create')
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <!-- Reset Biaya Button -->
                    <button 
                        type="button" 
                        onclick="resetBiaya()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-rose-50 dark:hover:bg-rose-500/10 hover:border-rose-200 text-rose-600 dark:text-rose-400 font-bold text-xs shadow-2xs transition cursor-pointer"
                        title="Reset Seluruh Data Biaya"
                    >
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-500"></i>
                        <span>Reset Biaya</span>
                    </button>

                    <!-- Import Excel Biaya -->
                    <button 
                        type="button" 
                        onclick="toggleModalImport()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                        title="Import Transaksi Biaya dari Excel"
                    >
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                        <span>Import Excel</span>
                    </button>

                    <!-- Import Pembayaran Excel -->
                    <button 
                        type="button" 
                        onclick="toggleModalImportPembayaran()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                        title="Import Pembayaran Biaya dari Excel"
                    >
                        <i data-lucide="receipt" class="w-4 h-4"></i>
                        <span>Import Pembayaran</span>
                    </button>

                    <!-- Input Biaya Baru -->
                    <a 
                        href="{{ route('biaya.create') }}" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Input Biaya</span>
                    </a>
                </div>
                @endcan
            </div>

            <!-- Filter Panel Form (Baris 1: Periode Tanggal Full Width, Baris 2: Sisanya Full Width Tanpa Space Kosong) -->
            <form action="{{ route('biaya.index') }}" method="GET" id="formSearch" class="space-y-3 w-full">
                <!-- Baris 1: Periode Tanggal (Maksimalkan Full Width Layar) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full items-center">
                    <!-- Dari Tanggal -->
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <input 
                            type="text" 
                            name="dari" 
                            id="dari" 
                            value="{{ Request('dari') }}" 
                            class="w-full h-[42px] pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                            placeholder="Dari Tanggal" 
                            autocomplete="off" 
                        />
                    </div>

                    <!-- Sampai Tanggal -->
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <input 
                            type="text" 
                            name="sampai" 
                            id="sampai" 
                            value="{{ Request('sampai') }}" 
                            class="w-full h-[42px] pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                            placeholder="Sampai Tanggal" 
                            autocomplete="off" 
                        />
                    </div>
                </div>

                <!-- Baris 2: Sisanya (No Bukti, Rekanan, PPN, Status Bayar, Filter & Reset) Maksimalkan Full Width Layar Tanpa Space Kosong -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 w-full items-center">
                    <!-- No. Bukti Search -->
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </div>
                        <input 
                            type="text" 
                            name="no_bukti_search" 
                            id="no_bukti_search" 
                            value="{{ Request('no_bukti_search') }}" 
                            class="w-full h-[42px] pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs" 
                            placeholder="Cari no. bukti biaya..." 
                            autocomplete="off" 
                        />
                    </div>

                    <!-- Supplier / Rekanan (Select2) -->
                    <div class="relative w-full">
                        <select name="kode_supplier_search" id="kode_supplier_search" class="select2Kodesupplier w-full">
                            <option value="">Semua Rekanan / Supplier</option>
                            @foreach ($supplier as $d)
                                <option value="{{ $d->kode_supplier }}" {{ Request('kode_supplier_search') == $d->kode_supplier ? 'selected' : '' }}>
                                    {{ strtoupper($d->nama_supplier) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status PPN -->
                    <div class="w-full">
                        <select 
                            name="ppn" 
                            id="ppn" 
                            class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                        >
                            <option value="">Semua Status PPN</option>
                            <option value="1" {{ Request('ppn') === '1' ? 'selected' : '' }}>PPN (Kena Pajak)</option>
                            <option value="0" {{ Request('ppn') === '0' ? 'selected' : '' }}>Non-PPN</option>
                        </select>
                    </div>

                    <!-- Status Bayar -->
                    <div class="w-full">
                        <select 
                            name="status_bayar" 
                            id="status_bayar" 
                            class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                        >
                            <option value="">Semua Status Bayar</option>
                            <option value="1" {{ Request('status_bayar') === '1' ? 'selected' : '' }}>Lunas</option>
                            <option value="0" {{ Request('status_bayar') === '0' ? 'selected' : '' }}>Belum Lunas</option>
                        </select>
                    </div>

                    <!-- Tombol Filter & Reset (Kolom ke-5 Full) -->
                    <div class="w-full flex items-center gap-2">
                        <button 
                            type="submit" 
                            class="w-full flex-1 h-[42px] inline-flex items-center justify-center gap-1.5 px-4 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs shadow-2xs transition cursor-pointer"
                        >
                            <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                            <span>Filter</span>
                        </button>
                        @if(Request('no_bukti_search') || Request('dari') || Request('sampai') || Request('kode_supplier_search') || Request('ppn') !== null || Request('status_bayar') !== null)
                            <a 
                                href="{{ route('biaya.index') }}" 
                                class="h-[42px] px-3.5 inline-flex items-center justify-center gap-1 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition cursor-pointer shrink-0" 
                                title="Reset Filter"
                            >
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="per_page" id="form_per_page" value="{{ Request('per_page', '15') }}">
            </form>
        </div>

        <!-- Table Card (Consistent with /penjualan) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl shadow-2xs overflow-hidden">
            <!-- Table Card Header (Solid Biru Dongker - Seamless with Table Header) -->
            <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                        <i data-lucide="receipt" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                            <span>Data Transaksi Biaya Operasional</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                                {{ $biaya->total() }} Total
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/80">Katalog pencatatan biaya operasional, pos beban pengeluaran, dan histori pembayaran rekanan</p>
                    </div>
                </div>

                @if(Request('no_bukti_search') || Request('dari') || Request('sampai') || Request('kode_supplier_search') || Request('ppn') !== null || Request('status_bayar') !== null)
                <div class="text-[11px] text-blue-100 flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-300"></i>
                    <span>Filter aktif diterapkan</span>
                </div>
                @endif
            </div>

            <!-- Bulk Action Bar (Animated when rows checked) -->
            <div id="bulkActionBar" class="hidden bg-gradient-to-r from-blue-50 to-indigo-50/80 dark:from-slate-800 dark:to-slate-800/90 border-b border-blue-200 dark:border-blue-900/40 px-5 py-2.5 flex flex-wrap items-center justify-between text-xs transition duration-200">
                <div class="flex items-center gap-2.5 text-[#162a5b] dark:text-blue-300 font-bold">
                    <span id="selectedCount" class="bg-[#162a5b] dark:bg-blue-600 text-white px-2.5 py-0.5 rounded-full text-[11px] font-extrabold shadow-2xs">0</span>
                    <span>item biaya terpilih</span>
                </div>
                <div class="flex flex-wrap items-center gap-2 mt-1 sm:mt-0">
                    <button type="button" onclick="bulkDeleteBiaya()" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow-2xs inline-flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                </div>
            </div>

            <!-- Table Responsive Area -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#162a5b]">
                        <tr class="text-[11px] font-extrabold uppercase tracking-wider text-blue-200/90 bg-[#162a5b]">
                            <th class="py-2.5 px-3 w-10 text-center">
                                <input type="checkbox" id="checkAll" class="rounded border-blue-300/40 text-blue-600 focus:ring-0 w-3.5 h-3.5 cursor-pointer bg-white/10 checked:bg-blue-600">
                            </th>
                            <th class="py-2.5 px-4 w-40 min-w-[140px] whitespace-nowrap">No. Bukti</th>
                            <th class="py-2.5 px-4 w-28 whitespace-nowrap">Tanggal</th>
                            <th class="py-2.5 px-4 min-w-[180px]">Rekanan / Supplier</th>
                            <th class="py-2.5 px-4 w-24 text-center whitespace-nowrap">PPN</th>
                            <th class="py-2.5 px-4 w-28 text-right whitespace-nowrap">PPh 23</th>
                            <th class="py-2.5 px-4 w-32 text-right whitespace-nowrap">Total</th>
                            <th class="py-2.5 px-4 w-32 text-right whitespace-nowrap">Bayar</th>
                            <th class="py-2.5 px-4 w-32 text-right whitespace-nowrap">Sisa</th>
                            <th class="py-2.5 px-4 w-28 text-center whitespace-nowrap">Status</th>
                            <th class="py-2.5 px-4 w-36 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse ($biaya as $d)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Checkbox -->
                                <td class="py-1 px-3 text-center">
                                    <input type="checkbox" class="checkItem rounded border-slate-300 dark:border-slate-700 text-[#162a5b] focus:ring-0 w-3.5 h-3.5 cursor-pointer" value="{{ $d->no_bukti }}">
                                </td>

                                <!-- No Bukti -->
                                <td class="py-1 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#162a5b] dark:text-blue-400 border border-slate-200/60 dark:border-slate-700">
                                            {{ $d->no_bukti }}
                                        </span>
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $d->jenis_transaksi == 'T' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60' : 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-200/60' }}">
                                            {{ $d->jenis_transaksi == 'T' ? 'T' : 'K' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Tanggal -->
                                <td class="py-1 px-4 whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">
                                    <div>{{ formatIndo($d->tanggal) }}</div>
                                    @if(!empty($d->bulan_pajak) || !empty($d->tahun_pajak))
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold mt-0.5">
                                            Pajak: {{ str_pad($d->bulan_pajak, 2, '0', STR_PAD_LEFT) }}/{{ $d->tahun_pajak }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Rekanan / Supplier -->
                                <td class="py-1 px-4">
                                    <div class="font-bold text-slate-900 dark:text-white leading-tight">
                                        {{ $d->nama_supplier ?? ($d->kode_supplier ?: '-') }}
                                    </div>
                                </td>

                                <!-- PPN -->
                                <td class="py-1 px-4 text-center whitespace-nowrap">
                                    @if ($d->ppn == '1')
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold bg-blue-50 dark:bg-blue-900/30 text-[#162a5b] dark:text-blue-400 border border-blue-200/60 dark:border-blue-800/40 rounded-md">
                                            PPN
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 rounded-md">
                                            Non-PPN
                                        </span>
                                    @endif
                                </td>

                                <!-- PPh 23 -->
                                <td class="py-1 px-4 text-right whitespace-nowrap">
                                    @if ($d->potongan_pph23 > 0)
                                        <span class="font-mono text-xs font-bold text-amber-600 dark:text-amber-400">
                                            -{{ formatAngkaDesimal($d->potongan_pph23) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 font-mono text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Total -->
                                <td class="py-1 px-4 text-right whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-slate-900 dark:text-white">
                                        {{ formatAngkaDesimal($d->total_biaya) }}
                                    </span>
                                </td>

                                <!-- Bayar -->
                                <td class="py-1 px-4 text-right whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ formatAngkaDesimal($d->total_bayar) }}
                                    </span>
                                </td>

                                <!-- Sisa -->
                                <td class="py-1 px-4 text-right whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold {{ $d->sisa_bayar > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400' }}">
                                        {{ formatAngkaDesimal($d->sisa_bayar) }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="py-1 px-4 text-center whitespace-nowrap">
                                    @if ($d->total_biaya > 0 && $d->sisa_bayar <= 0)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Lunas</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            <span>Belum Lunas</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-1 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Show Detail -->
                                        <a 
                                            href="{{ route('biaya.show', Crypt::encrypt($d->no_bukti)) }}" 
                                            class="w-7 h-7 rounded-lg flex items-center justify-center bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 dark:hover:bg-sky-500/20 text-sky-600 dark:text-sky-400 border border-sky-200/60 dark:border-sky-500/20 transition cursor-pointer shadow-2xs" 
                                            title="Lihat Detail Biaya"
                                        >
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a 
                                            href="{{ route('biaya.edit', Crypt::encrypt($d->no_bukti)) }}" 
                                            class="w-7 h-7 rounded-lg flex items-center justify-center bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20 transition cursor-pointer shadow-2xs" 
                                            title="Edit Biaya"
                                        >
                                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                        </a>


                                        <!-- Histori Pembayaran -->
                                        @if($d->total_bayar > 0)
                                            <button 
                                                type="button" 
                                                class="btnHistoriBayar w-7 h-7 rounded-lg flex items-center justify-center bg-purple-50 dark:bg-purple-500/10 hover:bg-purple-100 dark:hover:bg-purple-500/20 text-purple-600 dark:text-purple-400 border border-purple-200/60 dark:border-purple-500/20 transition cursor-pointer shadow-2xs" 
                                                no_bukti="{{ Crypt::encrypt($d->no_bukti) }}" 
                                                title="Histori Pembayaran"
                                            >
                                                <i data-lucide="history" class="w-3.5 h-3.5"></i>
                                            </button>
                                        @endif

                                        <!-- Hapus -->
                                        <form method="POST" action="{{ route('biaya.destroy', Crypt::encrypt($d->no_bukti)) }}" class="inline deleteform">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition delete-confirm cursor-pointer shadow-2xs" 
                                                title="Hapus Biaya"
                                            >
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="py-16 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3 shadow-xs">
                                            <i data-lucide="receipt" class="w-6 h-6"></i>
                                        </div>
                                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Belum ada transaksi biaya operasional</h4>
                                        <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Input Biaya" atau "Import Excel" untuk menambahkan transaksi baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Per-Page Controls Area -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col md:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div class="flex flex-wrap items-center gap-3">
                    <div>
                        Menampilkan <span class="font-bold text-slate-800 dark:text-slate-200">{{ $biaya->total() > 0 ? ($biaya->firstItem() ?? 1) : 0 }}</span> - <span class="font-bold text-slate-800 dark:text-slate-200">{{ $biaya->total() > 0 ? ($biaya->lastItem() ?? $biaya->total()) : 0 }}</span> dari <span class="font-bold text-slate-800 dark:text-slate-200">{{ $biaya->total() }}</span> transaksi
                    </div>
                    <!-- Pilihan Banyak Data Per Halaman -->
                    <div class="flex items-center gap-1.5 pl-2 sm:border-l sm:border-slate-300 dark:sm:border-slate-700">
                        <span class="text-[11px] text-slate-500 font-medium">Tampilkan:</span>
                        <select 
                            id="per_page_select" 
                            class="h-[30px] px-2 py-0 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-1 focus:ring-blue-600 cursor-pointer shadow-2xs"
                            onchange="changePerPage(this.value)"
                        >
                            <option value="10" {{ Request('per_page') == '10' ? 'selected' : '' }}>10 / hal</option>
                            <option value="15" {{ Request('per_page', '15') == '15' ? 'selected' : '' }}>15 / hal</option>
                            <option value="25" {{ Request('per_page') == '25' ? 'selected' : '' }}>25 / hal</option>
                            <option value="50" {{ Request('per_page') == '50' ? 'selected' : '' }}>50 / hal</option>
                            <option value="100" {{ Request('per_page') == '100' ? 'selected' : '' }}>100 / hal</option>
                            <option value="all" {{ Request('per_page') == 'all' ? 'selected' : '' }}>Semua Data</option>
                        </select>
                    </div>
                </div>
                <div>
                    {{ $biaya->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Dialog Universal (Detail, Bayar, Histori Bayar) -->
    <div id="modalDialog" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="relative w-full max-w-5xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800 transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#162a5b] text-white flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="layers" class="w-5 h-5 text-blue-200"></i>
                    <h3 id="modalTitle" class="text-sm font-bold text-white uppercase tracking-wider">Modal Title</h3>
                </div>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-white/80 hover:text-white hover:bg-white/10 transition cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div id="modalBody" class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-center py-12">
                    <div class="w-8 h-8 border-3 border-[#162a5b] border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Excel Biaya -->
    <div id="modalImport" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-xs overflow-y-auto p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="px-5 py-4 flex justify-between items-center bg-[#162a5b] text-white">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5 text-blue-200"></i>
                    <h3 class="font-bold text-xs uppercase tracking-wider text-white">Import Biaya Excel</h3>
                </div>
                <button type="button" class="w-7 h-7 rounded-lg flex items-center justify-center text-white/80 hover:text-white hover:bg-white/10 transition cursor-pointer" onclick="toggleModalImport()">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <form action="{{ route('biaya.import') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">File Dokumen Excel (.xlsx, .xls, .csv) <span class="text-rose-500">*</span></label>
                    <input type="file" id="file_excel_biaya" name="file_excel" accept=".xlsx,.xls,.csv" required class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#162a5b] hover:file:bg-blue-100 transition border border-slate-200 dark:border-slate-700 rounded-xl p-2 bg-white dark:bg-slate-900 cursor-pointer" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Pilih Lembar Kerja (Sheet)</label>
                    <select name="sheet_name" id="import_sheet_name" class="w-full h-[40px] px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:border-[#162a5b] focus:ring-2 focus:ring-blue-600/20">
                        <option value="">-- Unggah File Excel Dahulu --</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Default Jenis Transaksi <span class="text-rose-500">*</span></label>
                    <select name="jenis_transaksi" class="w-full h-[40px] px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:border-[#162a5b] focus:ring-2 focus:ring-blue-600/20" required>
                        <option value="K">Kredit (Tempo)</option>
                        <option value="T">Tunai (Cash)</option>
                    </select>
                <div class="p-3 bg-blue-50/70 dark:bg-blue-900/20 rounded-xl border border-blue-200/60 dark:border-blue-800/40 text-[11px] text-slate-600 dark:text-slate-300 space-y-1">
                    <div class="font-bold text-[#162a5b] dark:text-blue-300 flex items-center gap-1.5">
                        <i data-lucide="info" class="w-3.5 h-3.5"></i>
                        <span>Format Kolom Excel:</span>
                    </div>
                    <p class="text-[10px] leading-relaxed text-slate-500 dark:text-slate-400">
                        Mendukung kolom: <b>BPB / No Bukti, Tanggal, Kode Akun, Supplier, Keterangan, Qty, Harga, DPP, PPN, Potongan PPh 23</b>.
                    </p>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 transition cursor-pointer" onclick="toggleModalImport()">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1f3a7a] rounded-xl transition shadow-sm cursor-pointer">Proses Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import Pembayaran Excel -->
    <div id="modalImportPembayaran" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-xs overflow-y-auto p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="px-5 py-4 flex justify-between items-center bg-teal-700 text-white">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="receipt" class="w-5 h-5 text-teal-200"></i>
                    <h3 class="font-bold text-xs uppercase tracking-wider text-white">Import Pembayaran Excel</h3>
                </div>
                <button type="button" class="w-7 h-7 rounded-lg flex items-center justify-center text-white/80 hover:text-white hover:bg-white/10 transition cursor-pointer" onclick="toggleModalImportPembayaran()">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <form action="{{ route('biaya.importpembayaran') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">File Dokumen Excel (.xlsx, .xls, .csv) <span class="text-rose-500">*</span></label>
                    <input type="file" id="file_excel_pembayaran" name="file_excel" accept=".xlsx,.xls,.csv" required class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition border border-slate-200 dark:border-slate-700 rounded-xl p-2 bg-white dark:bg-slate-900 cursor-pointer" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">Pilih Lembar Kerja (Sheet)</label>
                    <select name="sheet_name" id="import_sheet_name_pembayaran" class="w-full h-[40px] px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:border-teal-600 focus:ring-2 focus:ring-teal-600/20">
                        <option value="">-- Unggah File Excel Dahulu --</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 transition cursor-pointer" onclick="toggleModalImportPembayaran()">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl transition shadow-sm cursor-pointer">Proses Import</button>
                </div>
            </form>
        </div>
    </div>

@push('myscript')
<script>
    function openModal(title, url) {
        $("#modalTitle").text(title);
        $("#modalBody").html(`
            <div class="flex items-center justify-center py-12">
                <div class="w-8 h-8 border-3 border-[#162a5b] border-t-transparent rounded-full animate-spin"></div>
            </div>
        `);
        $("#modalDialog").removeClass("hidden");
        $("#modalBody").load(url, function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }

    function closeModal() {
        $("#modalDialog").addClass("hidden");
    }

    window.inputPembayaranDirect = function(no_bukti) {
        openModal("Input Pembayaran Biaya", `/biaya/${no_bukti}/createprosespembayaran`);
    };

    // Modal Import Excel functions
    window.toggleModalImport = function() {
        $('#modalImport').toggleClass('hidden');
    };

    window.toggleModalImportPembayaran = function() {
        $('#modalImportPembayaran').toggleClass('hidden');
    };

    $('#file_excel_biaya').change(function() {
        var file = this.files[0];
        if (!file) return;

        var formData = new FormData();
        formData.append('file_excel', file);
        formData.append('_token', '{{ csrf_token() }}');

        $('#import_sheet_name').html('<option value="">Sedang membaca sheet...</option>');

        $.ajax({
            url: '{{ route("biaya.getsheets") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var options = '<option value="">-- Pilih Sheet / Deteksi Otomatis --</option>';
                    response.sheets.forEach(function(sheetName) {
                        options += '<option value="' + sheetName + '">' + sheetName + '</option>';
                    });
                    $('#import_sheet_name').html(options);
                } else {
                    $('#import_sheet_name').html('<option value="">Gagal membaca sheet: ' + response.message + '</option>');
                }
            },
            error: function() {
                $('#import_sheet_name').html('<option value="">Gagal menghubungi server</option>');
            }
        });
    });

    $('#file_excel_pembayaran').change(function() {
        var file = this.files[0];
        if (!file) return;

        var formData = new FormData();
        formData.append('file_excel', file);
        formData.append('_token', '{{ csrf_token() }}');

        $('#import_sheet_name_pembayaran').html('<option value="">Sedang membaca sheet...</option>');

        $.ajax({
            url: '{{ route("biaya.getsheets") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var options = '<option value="">-- Pilih Sheet / Deteksi Otomatis --</option>';
                    response.sheets.forEach(function(sheetName) {
                        options += '<option value="' + sheetName + '">' + sheetName + '</option>';
                    });
                    $('#import_sheet_name_pembayaran').html(options);
                } else {
                    $('#import_sheet_name_pembayaran').html('<option value="">Gagal membaca sheet: ' + response.message + '</option>');
                }
            },
            error: function() {
                $('#import_sheet_name_pembayaran').html('<option value="">Gagal menghubungi server</option>');
            }
        });
    });

    // SweetAlert2 Reset Biaya Confirmation
    window.resetBiaya = function() {
        Swal.fire({
            title: 'Reset Semua Data Biaya?',
            text: "Seluruh data transaksi biaya operasional, item detail pos biaya, dan histori pembayaran biaya akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#162a5b',
            confirmButtonText: 'Ya, Reset Semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route("biaya.reset") }}'
                });
                form.append($('<input>', {
                    'name': '_token',
                    'value': $('meta[name="csrf-token"]').attr('content'),
                    'type': 'hidden'
                }));
                $('body').append(form);
                form.submit();
            }
        });
    };

    $(function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.select2({
                placeholder: 'Semua Rekanan / Supplier',
                allowClear: true,
                width: '100%'
            });
        }



        // Checkbox Logic & Bulk Actions
        function updateBulkBar() {
            var count = $('.checkItem:checked').length;
            $('#selectedCount').text(count);

            if (count > 0) {
                $('#bulkActionBar').removeClass('hidden');
            } else {
                $('#bulkActionBar').addClass('hidden');
            }

            var totalItems = $('.checkItem').length;
            $('#checkAll').prop('checked', totalItems > 0 && count === totalItems);

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        $('#checkAll').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.checkItem').prop('checked', isChecked);
            updateBulkBar();
        });

        $(document).on('change', '.checkItem', function() {
            updateBulkBar();
        });

        window.bulkDeleteBiaya = function() {
            var selected = $('.checkItem:checked').map(function() {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Pilih minimal satu data biaya untuk dihapus!',
                    icon: 'warning',
                    confirmButtonColor: '#162a5b'
                });
                return;
            }

            Swal.fire({
                title: 'Hapus Data Terpilih?',
                text: `Apakah Anda yakin ingin menghapus ${selected.length} data biaya operasional terpilih beserta detail item dan histori pembayarannya? Tindakan ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus Terpilih!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: "{{ route('biaya.bulkdelete') }}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            no_bukti: selected
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#162a5b'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            var errMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal menghapus data biaya.';
                            Swal.fire({
                                title: 'Gagal!',
                                text: errMsg,
                                icon: 'error',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                }
            });
        };

        window.changePerPage = function(val) {
            var url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.delete('page'); // Reset ke halaman 1 saat ganti jumlah limit per halaman
            window.location.href = url.toString();
        };

        $(".btnHistoriBayar").click(function(e) {
            e.preventDefault();
            var no_bukti = $(this).attr("no_bukti");
            openModal("Histori Pembayaran Biaya", `/biaya/${no_bukti}/showpembayaran`);
        });

        $(document).on('click', '.delete-confirm', function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data biaya operasional ini akan dihapus permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#162a5b",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
</x-app-layout>
