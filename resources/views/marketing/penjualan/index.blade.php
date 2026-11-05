<x-app-layout>
    <x-slot name="header">Penjualan Marketing</x-slot>
    <x-slot name="headerTitle">Penjualan Marketing</x-slot>
    <x-slot name="headerDescription">Manajemen transaksi penjualan produk, alokasi pembayaran piutang, dan integrasi import data Excel.</x-slot>

    <div class="space-y-6">

        <!-- Action & Filter Bar (Consistent with /produk) -->
        <div class="space-y-3 w-full">
            <!-- Top Action Toolbar -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                        <i data-lucide="filter" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                        <span>Filter & Pencarian Transaksi</span>
                    </span>
                </div>

                <!-- Action Buttons Group -->
                @can('penjualanmarketing.create')
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <!-- Bulk Delete (Dynamic) -->
                    @can('penjualanmarketing.delete')
                    <button 
                        type="button" 
                        id="btnHapusTerpilih" 
                        onclick="hapusTerpilih()" 
                        class="hidden items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-sm transition cursor-pointer animate-pulse"
                    >
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span>Hapus Terpilih</span>
                    </button>
                    @endcan

                    <!-- Reset Options Dropdown -->
                    <div class="relative inline-block text-left" id="resetDropdownWrapper">
                        <button 
                            type="button" 
                            onclick="$('#resetDropdownMenu').toggleClass('hidden')" 
                            class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs transition cursor-pointer"
                            title="Opsi Pembersihan Data"
                        >
                            <i data-lucide="sliders-horizontal" class="w-4 h-4 text-slate-400"></i>
                            <span>Opsi Data</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                        </button>
                        <div id="resetDropdownMenu" class="hidden absolute right-0 z-30 mt-2 w-52 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xl py-1 text-xs">
                            <button 
                                type="button" 
                                onclick="$('#resetDropdownMenu').addClass('hidden'); resetPembayaran();" 
                                class="w-full text-left px-4 py-2.5 text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 font-semibold flex items-center gap-2 transition cursor-pointer"
                            >
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                <span>Reset Pembayaran</span>
                            </button>
                            <button 
                                type="button" 
                                onclick="$('#resetDropdownMenu').addClass('hidden'); resetPenjualan();" 
                                class="w-full text-left px-4 py-2.5 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 font-semibold flex items-center gap-2 transition cursor-pointer"
                            >
                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                                <span>Reset Semua Penjualan</span>
                            </button>
                        </div>
                    </div>

                    <!-- Import Data Excel -->
                    <button 
                        type="button" 
                        onclick="toggleModalImport()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                        title="Import Data dari Excel"
                    >
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                        <span>Import Excel</span>
                    </button>

                    <!-- Import Pembayaran -->
                    <button 
                        type="button" 
                        onclick="toggleModalImportPembayaran()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                        title="Import Pembayaran Piutang Excel"
                    >
                        <i data-lucide="receipt" class="w-4 h-4"></i>
                        <span>Import Pembayaran</span>
                    </button>

                    <!-- Tambah Penjualan -->
                    <a 
                        href="{{ route('penjualanmarketing.create') }}" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Input Penjualan</span>
                    </a>
                </div>
                @endcan
            </div>

            <!-- Full Width Filter Form -->
            <form method="GET" action="{{ route('penjualanmarketing.index') }}" id="formSearch" class="flex flex-wrap lg:flex-nowrap items-center gap-3 w-full">
                <!-- No Bukti -->
                <div class="relative flex-1 min-w-[200px] w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="no_bukti_search" 
                        id="no_bukti_search" 
                        value="{{ request('no_bukti_search') }}" 
                        placeholder="Cari no. bukti penjualan..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs" 
                    />
                </div>

                <!-- Nama Pelanggan -->
                <div class="relative flex-1 min-w-[200px] w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="users" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="nama_pelanggan_search" 
                        id="nama_pelanggan_search" 
                        value="{{ request('nama_pelanggan_search') }}" 
                        placeholder="Cari nama pelanggan..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs" 
                    />
                </div>

                <!-- Dari Tanggal -->
                <div class="relative w-full sm:w-44">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="dari" 
                        id="dari" 
                        value="{{ request('dari') }}" 
                        placeholder="Dari Tanggal" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                        autocomplete="off" 
                    />
                </div>

                <!-- Sampai Tanggal -->
                <div class="relative w-full sm:w-44">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="sampai" 
                        id="sampai" 
                        value="{{ request('sampai') }}" 
                        placeholder="Sampai Tanggal" 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                        autocomplete="off" 
                    />
                </div>

                <!-- Action Button Filter & Reset -->
                <div class="flex items-center gap-2 shrink-0">
                    <button 
                        type="submit" 
                        class="px-4 py-2.5 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs transition shadow-2xs flex items-center gap-1.5 cursor-pointer"
                    >
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>
                    @if(request('no_bukti_search') || request('nama_pelanggan_search') || request('dari') || request('sampai'))
                        <a 
                            href="{{ route('penjualanmarketing.index') }}" 
                            class="px-3.5 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition flex items-center gap-1 cursor-pointer" 
                            title="Reset Filter"
                        >
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl shadow-2xs overflow-hidden">
            <!-- Table Card Header (Solid Biru Dongker - Seamless with Table Header) -->
            <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                        <i data-lucide="receipt" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                            <span>Data Transaksi Penjualan Marketing</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                                {{ $penjualan->total() }} Total
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/80">Katalog faktur penjualan produk ke Portax, histori pembayaran, dan status pelunasan</p>
                    </div>
                </div>

                @if(request('no_bukti_search') || request('nama_pelanggan_search') || request('dari') || request('sampai'))
                <div class="text-[11px] text-blue-100 flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-300"></i>
                    <span>Filter aktif diterapkan</span>
                </div>
                @endif
            </div>

            <!-- Table Responsive Area -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#162a5b]">
                        <tr class="text-[11px] font-extrabold uppercase tracking-wider text-blue-200/90 bg-[#162a5b]">
                            <th class="py-2.5 px-4 w-12 text-center">
                                <input type="checkbox" id="checkAll" class="rounded border-blue-300/40 text-blue-600 focus:ring-0 w-3.5 h-3.5 cursor-pointer bg-white/10 checked:bg-blue-600">
                            </th>
                            <th class="py-2.5 px-4 w-40 min-w-[140px] whitespace-nowrap">No. Bukti</th>
                            <th class="py-2.5 px-4 w-28 whitespace-nowrap">Tanggal</th>
                            <th class="py-2.5 px-4 w-36 min-w-[130px] whitespace-nowrap">Kode Pelanggan</th>
                            <th class="py-2.5 px-4">Nama Pelanggan</th>
                            <th class="py-2.5 px-4 w-36 whitespace-nowrap">Transaksi</th>
                            <th class="py-2.5 px-4 w-36 text-right whitespace-nowrap">Total</th>
                            <th class="py-2.5 px-4 w-32 text-center whitespace-nowrap">Status</th>
                            <th class="py-2.5 px-4 w-28 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse ($penjualan as $d)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Checkbox -->
                                <td class="py-1 px-4 text-center">
                                    <input type="checkbox" name="selected_no_bukti[]" value="{{ $d->no_bukti }}" class="row-checkbox rounded border-slate-300 dark:border-slate-700 text-[#162a5b] focus:ring-0 w-3.5 h-3.5 cursor-pointer">
                                </td>

                                <!-- No Bukti -->
                                <td class="py-1 px-4 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#162a5b] dark:text-blue-400 border border-slate-200/60 dark:border-slate-700">
                                        {{ $d->no_bukti }}
                                    </span>
                                </td>

                                <!-- Tanggal -->
                                <td class="py-1 px-4 whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">
                                    {{ date('d-m-Y', strtotime($d->tanggal)) }}
                                </td>

                                <!-- Kode Pelanggan -->
                                <td class="py-1 px-4 whitespace-nowrap">
                                    @if($d->kode_pelanggan)
                                        <span class="font-mono text-xs font-semibold px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20">
                                            {{ $d->kode_pelanggan }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Nama Pelanggan -->
                                <td class="py-1 px-4">
                                    <div class="font-bold text-slate-900 dark:text-white leading-tight">
                                        {{ $d->nama_pelanggan }}
                                    </div>
                                </td>

                                <!-- Jenis Transaksi -->
                                <td class="py-1 px-4 whitespace-nowrap">
                                    @if ($d->jenis_transaksi == 'T')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/20">
                                            <i data-lucide="banknote" class="w-3 h-3"></i>
                                            <span>TUNAI ({{ $d->jenis_bayar }})</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20">
                                            <i data-lucide="clock" class="w-3 h-3"></i>
                                            <span>KREDIT</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Total -->
                                <td class="py-1 px-4 text-right whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-slate-900 dark:text-white">
                                        Rp {{ number_format($d->total, 0, ',', '.') }}
                                    </span>
                                </td>

                                <!-- Status (Consistent Full Width Pill) -->
                                <td class="py-1 px-4 text-center whitespace-nowrap">
                                    @if ($d->status == '1')
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

                                <!-- Actions -->
                                <td class="py-1 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Show Detail -->
                                        <a 
                                            href="{{ route('penjualanmarketing.show', Crypt::encrypt($d->no_bukti)) }}" 
                                            class="w-7 h-7 rounded-lg flex items-center justify-center bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 dark:hover:bg-sky-500/20 text-sky-600 dark:text-sky-400 border border-sky-200/60 dark:border-sky-500/20 transition cursor-pointer shadow-2xs" 
                                            title="Detail Transaksi"
                                        >
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        </a>

                                        <!-- Edit -->
                                        @can('penjualanmarketing.edit')
                                        <a 
                                            href="{{ route('penjualanmarketing.edit', Crypt::encrypt($d->no_bukti)) }}" 
                                            class="w-7 h-7 rounded-lg flex items-center justify-center bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-blue-600 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20 transition cursor-pointer shadow-2xs" 
                                            title="Edit Transaksi"
                                        >
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        </a>
                                        @endcan

                                        <!-- Delete -->
                                        @can('penjualanmarketing.delete')
                                        <button 
                                            type="button" 
                                            class="btn-delete w-7 h-7 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition cursor-pointer shadow-2xs" 
                                            data-id="{{ Crypt::encrypt($d->no_bukti) }}" 
                                            data-name="{{ $d->no_bukti }}" 
                                            title="Hapus Transaksi"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-16 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3 shadow-xs">
                                            <i data-lucide="receipt" class="w-6 h-6"></i>
                                        </div>
                                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Belum ada transaksi penjualan marketing</h4>
                                        <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Input Penjualan" atau "Import Excel" untuk menambahkan transaksi baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Area -->
            @if ($penjualan->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Menampilkan <span class="font-bold text-slate-800 dark:text-slate-200">{{ $penjualan->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-800 dark:text-slate-200">{{ $penjualan->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800 dark:text-slate-200">{{ $penjualan->total() }}</span> transaksi
                    </div>
                    <div>
                        {{ $penjualan->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    @push('modals')
        <!-- Modal Import Penjualan Excel -->
        <div id="modalImport" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalImportContentWrapper">
                <!-- Modal Header -->
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="file-spreadsheet" class="w-4 h-4 text-white"></i>
                        </div>
                        <h3 class="font-bold text-sm text-white">Import Penjualan Excel</h3>
                    </div>
                    <button type="button" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition cursor-pointer" onclick="closeModal('modalImport')">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Form Import -->
                <form action="{{ route('penjualanmarketing.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">File Excel (.xlsx, .xls, .csv)</label>
                        <input 
                            type="file" 
                            id="file_excel" 
                            name="file_excel" 
                            accept=".xlsx,.xls,.csv" 
                            required 
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#162a5b] hover:file:bg-blue-100 transition border border-slate-200 dark:border-slate-800 rounded-xl p-2 bg-white dark:bg-slate-900 cursor-pointer" 
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Pilih Sheet</label>
                        <select 
                            name="sheet_name" 
                            id="import_sheet_name" 
                            class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 cursor-pointer"
                        >
                            <option value="">-- Unggah File Excel Dahulu --</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jenis Transaksi</label>
                        <select 
                            name="jenis_transaksi" 
                            id="import_jenis_transaksi" 
                            class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 cursor-pointer" 
                            required
                        >
                            <option value="K">Kredit (Tempo)</option>
                            <option value="T">Tunai (Cash)</option>
                        </select>
                    </div>

                    <div id="import_jenis_bayar_container" class="hidden">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jenis Bayar</label>
                        <select 
                            name="jenis_bayar" 
                            class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 cursor-pointer"
                        >
                            <option value="TN">Cash / Tunai</option>
                            <option value="TR">Transfer</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button 
                            type="button" 
                            class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition cursor-pointer" 
                            onclick="closeModal('modalImport')"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1c3574] rounded-xl transition shadow-sm cursor-pointer"
                        >
                            Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Import Pembayaran Excel (FIFO Pelunasan Piutang) -->
        <div id="modalImportPembayaran" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalImportPembayaranContentWrapper">
                <!-- Modal Header -->
                <div class="bg-teal-700 px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="credit-card" class="w-4 h-4 text-white"></i>
                        </div>
                        <h3 class="font-bold text-sm text-white">Import Pembayaran Piutang (FIFO)</h3>
                    </div>
                    <button type="button" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition cursor-pointer" onclick="closeModal('modalImportPembayaran')">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Form Import Pembayaran -->
                <form action="{{ route('penjualanmarketing.importpembayaran') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <div class="p-3 bg-teal-50 dark:bg-teal-500/10 border border-teal-200/70 dark:border-teal-500/20 rounded-xl text-teal-800 dark:text-teal-300 text-xs leading-relaxed">
                        <div class="font-bold flex items-center gap-1.5 mb-1 text-teal-900 dark:text-teal-200">
                            <i data-lucide="info" class="w-4 h-4 text-teal-600 dark:text-teal-400 shrink-0"></i>
                            <span>Alokasi Otomatis (FIFO)</span>
                        </div>
                        Pembayaran akan otomatis dialokasikan ke faktur penjualan pelanggan mulai dari tanggal yang paling awal hingga lunas berurutan.
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Pilih File Excel (.xlsx, .xls, .csv)</label>
                        <input 
                            type="file" 
                            id="file_excel_pembayaran" 
                            name="file_excel" 
                            accept=".xlsx,.xls,.csv" 
                            required 
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition border border-slate-200 dark:border-slate-800 rounded-xl p-2 bg-white dark:bg-slate-900 cursor-pointer" 
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Pilih Sheet</label>
                        <select 
                            name="sheet_name" 
                            id="import_sheet_name_pembayaran" 
                            class="w-full px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-600/20 focus:border-teal-600 cursor-pointer"
                        >
                            <option value="">-- Pilih Sheet / Deteksi Otomatis --</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button 
                            type="button" 
                            class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition cursor-pointer" 
                            onclick="closeModal('modalImportPembayaran')"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl transition shadow-sm cursor-pointer"
                        >
                            Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endpush

    @push('myscript')
        <script>
            // Initialize Lucide Icons
            document.addEventListener('DOMContentLoaded', function() {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });

            // Close reset dropdown on click outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#resetDropdownWrapper').length) {
                    $('#resetDropdownMenu').addClass('hidden');
                }
            });

            function toggleModalImport() {
                if ($('#modalImport').hasClass('hidden')) {
                    openModal('modalImport');
                } else {
                    closeModal('modalImport');
                }
            }

            function toggleModalImportPembayaran() {
                if ($('#modalImportPembayaran').hasClass('hidden')) {
                    openModal('modalImportPembayaran');
                } else {
                    closeModal('modalImportPembayaran');
                }
            }

            $('#file_excel_pembayaran').change(function() {
                var file = this.files[0];
                if (!file) return;

                var formData = new FormData();
                formData.append('file_excel', file);
                formData.append('_token', '{{ csrf_token() }}');

                $('#import_sheet_name_pembayaran').html('<option value="">Sedang membaca sheet...</option>');

                $.ajax({
                    url: '{{ route("penjualanmarketing.getsheets") }}',
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

            $('#file_excel').change(function() {
                var file = this.files[0];
                if (!file) return;

                var formData = new FormData();
                formData.append('file_excel', file);
                formData.append('_token', '{{ csrf_token() }}');

                $('#import_sheet_name').html('<option value="">Sedang membaca sheet...</option>');

                $.ajax({
                    url: '{{ route("penjualanmarketing.getsheets") }}',
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

            $('#import_jenis_transaksi').change(function() {
                if ($(this).val() == 'T') {
                    $('#import_jenis_bayar_container').removeClass('hidden');
                } else {
                    $('#import_jenis_bayar_container').addClass('hidden');
                }
            });

            // SweetAlert2 Delete Confirmation
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                Swal.fire({
                    title: 'Hapus Transaksi?',
                    text: "Apakah Anda yakin ingin menghapus transaksi '" + name + "'?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#162a5b',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '/penjualanmarketing/' + id
                        });
                        form.append($('<input>', {
                            'name': '_token',
                            'value': $('meta[name="csrf-token"]').attr('content'),
                            'type': 'hidden'
                        }));
                        form.append($('<input>', {
                            'name': '_method',
                            'value': 'DELETE',
                            'type': 'hidden'
                        }));
                        $('body').append(form);
                        form.submit();
                    }
                });
            });

            // SweetAlert2 Reset Penjualan Confirmation
            window.resetPenjualan = function() {
                Swal.fire({
                    title: 'Reset Semua Penjualan?',
                    text: "Seluruh data transaksi, item produk detail, dan histori pembayaran akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Reset Semua!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route("penjualanmarketing.reset") }}'
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

            // SweetAlert2 Reset Pembayaran Confirmation
            window.resetPembayaran = function() {
                Swal.fire({
                    title: 'Reset Pembayaran Piutang?',
                    text: "Seluruh data histori pembayaran piutang penjualan akan dihapus permanen! Status faktur penjualan kredit akan dikembalikan ke Belum Lunas. Data transaksi penjualan tetap aman.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d97706',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Reset Pembayaran!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route("penjualanmarketing.resetpembayaran") }}'
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

            // Checkbox logic and Bulk Delete
            $(document).on('change', '#checkAll', function() {
                $('.row-checkbox').prop('checked', this.checked);
                toggleBulkDeleteButton();
            });

            $(document).on('change', '.row-checkbox', function() {
                if ($('.row-checkbox:checked').length == $('.row-checkbox').length && $('.row-checkbox').length > 0) {
                    $('#checkAll').prop('checked', true);
                } else {
                    $('#checkAll').prop('checked', false);
                }
                toggleBulkDeleteButton();
            });

            function toggleBulkDeleteButton() {
                var checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#btnHapusTerpilih').removeClass('hidden').addClass('inline-flex');
                } else {
                    $('#btnHapusTerpilih').addClass('hidden').removeClass('inline-flex');
                }
            }

            window.hapusTerpilih = function() {
                var selected = [];
                $('.row-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) return;

                Swal.fire({
                    title: 'Hapus Transaksi Terpilih?',
                    text: "Apakah Anda yakin ingin menghapus " + selected.length + " transaksi penjualan yang terpilih beserta detail dan pembayaran terkait?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route("penjualanmarketing.delete-selected") }}'
                        });
                        form.append($('<input>', {
                            'name': '_token',
                            'value': $('meta[name="csrf-token"]').attr('content'),
                            'type': 'hidden'
                        }));
                        selected.forEach(function(id) {
                            form.append($('<input>', {
                                'name': 'ids[]',
                                'value': id,
                                'type': 'hidden'
                            }));
                        });
                        $('body').append(form);
                        form.submit();
                    }
                });
            };
        </script>
    @endpush
</x-app-layout>
