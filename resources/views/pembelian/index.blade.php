<x-app-layout>
    <x-slot name="header">Pembelian</x-slot>
    <x-slot name="headerTitle">Pembelian</x-slot>
    <x-slot name="headerDescription">Kelola data transaksi faktur pembelian barang, pelunasan hutang dagang, uang muka, dan approval barang masuk logistik & maintenance.</x-slot>

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
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
    </style>

    <!-- Alert Notifications -->
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

    <div class="space-y-5">
        <!-- Top Action & Filter Toolbar -->
        <div class="space-y-3 w-full">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                        <i data-lucide="filter" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                        <span>Filter & Pencarian Pembelian</span>
                    </span>
                </div>

                <!-- Action Buttons Group -->
                @can('pembelian.create')
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <!-- Reset / Maintenance Data Dropdown -->
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
                        <div id="resetDropdownMenu" class="hidden absolute right-0 z-30 mt-2 w-56 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-xl py-1 text-xs">
                            <button 
                                type="button" 
                                onclick="$('#resetDropdownMenu').addClass('hidden'); resetPembayaran();" 
                                class="w-full text-left px-4 py-2.5 text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 font-semibold flex items-center gap-2 transition cursor-pointer"
                            >
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                <span>Reset Histori Pembayaran</span>
                            </button>
                            <button 
                                type="button" 
                                onclick="$('#resetDropdownMenu').addClass('hidden'); resetPembelian();" 
                                class="w-full text-left px-4 py-2.5 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 font-semibold flex items-center gap-2 transition cursor-pointer"
                            >
                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                                <span>Reset Semua Pembelian</span>
                            </button>
                        </div>
                    </div>

                    <!-- Import Pembelian Excel -->
                    <button 
                        type="button" 
                        onclick="toggleModalImport()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                        title="Import Pembelian dari Excel"
                    >
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                        <span>Import Excel</span>
                    </button>

                    <!-- Import Pembayaran Excel -->
                    <button 
                        type="button" 
                        onclick="toggleModalImportPembayaran()" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                        title="Import Pembayaran Pembelian Excel"
                    >
                        <i data-lucide="receipt" class="w-4 h-4"></i>
                        <span>Import Pembayaran</span>
                    </button>

                    <!-- Input Pembelian Baru -->
                    <a 
                        href="{{ route('pembelian.create') }}" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                    >
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Input Pembelian</span>
                    </a>
                </div>
                @endcan
            </div>

            <!-- Filter Panel Form (Tanpa Card) -->
            <form action="{{ route('pembelian.index') }}" method="GET" id="formSearch" class="space-y-2 w-full">
                    <!-- Baris 1: No. Bukti, Supplier, & Rentang Tanggal (Full Width 4 Kolom) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 w-full items-center">
                        <!-- No. Bukti -->
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </div>
                            <input 
                                type="text" 
                                name="no_bukti_search" 
                                id="no_bukti_search" 
                                value="{{ Request('no_bukti_search') }}" 
                                class="w-full h-[42px] pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs" 
                                placeholder="No. Bukti Pembelian..." 
                                autocomplete="off" 
                            />
                        </div>

                        <!-- Supplier (Select2) -->
                        <div class="relative w-full">
                            <select name="kode_supplier_search" id="kode_supplier_search" class="select2Kodesupplier w-full">
                                <option value="">Semua Supplier</option>
                                @foreach ($supplier as $d)
                                    <option value="{{ $d->kode_supplier }}" {{ Request('kode_supplier_search') == $d->kode_supplier ? 'selected' : '' }}>
                                        {{ strtoupper($d->nama_supplier) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

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
                                class="w-full h-[42px] pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
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
                                class="w-full h-[42px] pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date" 
                                placeholder="Sampai Tanggal" 
                                autocomplete="off" 
                            />
                        </div>
                    </div>

                    <!-- Baris 2: Atribut Tambahan & Tombol Aksi (Full Width) -->
                    <div class="w-full">
                        @can('pembelian.harga')
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 w-full items-center">
                                <!-- PPN / Non PPN -->
                                <div class="w-full">
                                    <select 
                                        name="ppn_search" 
                                        id="ppn_search" 
                                        class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                    >
                                        <option value="">Semua PPN</option>
                                        <option value="1" {{ Request('ppn_search') === '1' ? 'selected' : '' }}>PPN</option>
                                        <option value="0" {{ Request('ppn_search') === '0' ? 'selected' : '' }}>Non PPN</option>
                                    </select>
                                </div>

                                <!-- Tunai / Kredit -->
                                <div class="w-full">
                                    <select 
                                        name="jenis_transaksi_search" 
                                        id="jenis_transaksi_search" 
                                        class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                    >
                                        <option value="">Semua Transaksi</option>
                                        <option value="T" {{ Request('jenis_transaksi_search') == 'T' ? 'selected' : '' }}>Tunai (Cash)</option>
                                        <option value="K" {{ Request('jenis_transaksi_search') == 'K' ? 'selected' : '' }}>Kredit (Tempo)</option>
                                    </select>
                                </div>

                                <!-- Kategori Lokal / Import -->
                                <div class="w-full">
                                    <select 
                                        name="kategori_pembelian_search" 
                                        id="kategori_pembelian_search" 
                                        class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                    >
                                        <option value="">Semua Kategori</option>
                                        <option value="L" {{ Request('kategori_pembelian_search') == 'L' ? 'selected' : '' }}>Lokal</option>
                                        <option value="I" {{ Request('kategori_pembelian_search') == 'I' ? 'selected' : '' }}>Import</option>
                                    </select>
                                </div>

                                <!-- Status Uang Muka -->
                                <div class="w-full">
                                    <select 
                                        name="status_uang_muka_search" 
                                        id="status_uang_muka_search" 
                                        class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                    >
                                        <option value="">Semua Status UM</option>
                                        <option value="1" {{ Request('status_uang_muka_search') === '1' ? 'selected' : '' }}>Uang Muka (UM)</option>
                                        <option value="0" {{ Request('status_uang_muka_search') === '0' ? 'selected' : '' }}>Biasa</option>
                                    </select>
                                </div>

                                <!-- Tombol Filter & Reset (Full Width Column) -->
                                <div class="w-full flex items-center gap-2">
                                    <button 
                                        type="submit" 
                                        class="w-full flex-1 h-[42px] inline-flex items-center justify-center gap-2 px-4 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                                    >
                                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                                        <span>Filter Data</span>
                                    </button>
                                    @if(Request('no_bukti_search') || Request('dari') || Request('sampai') || Request('kode_supplier_search') || Request('ppn_search') !== null || Request('jenis_transaksi_search') || Request('kategori_pembelian_search') || Request('status_uang_muka_search') !== null)
                                        <a 
                                            href="{{ route('pembelian.index') }}" 
                                            class="h-[42px] px-3.5 inline-flex items-center justify-center gap-1.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition cursor-pointer shrink-0" 
                                            title="Reset Filter"
                                        >
                                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                            <span>Reset</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-3 w-full items-center">
                                <!-- Kategori Lokal / Import -->
                                <div class="w-full">
                                    <select 
                                        name="kategori_pembelian_search" 
                                        id="kategori_pembelian_search" 
                                        class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                    >
                                        <option value="">Semua Kategori</option>
                                        <option value="L" {{ Request('kategori_pembelian_search') == 'L' ? 'selected' : '' }}>Lokal</option>
                                        <option value="I" {{ Request('kategori_pembelian_search') == 'I' ? 'selected' : '' }}>Import</option>
                                    </select>
                                </div>

                                <!-- Status Uang Muka -->
                                <div class="w-full">
                                    <select 
                                        name="status_uang_muka_search" 
                                        id="status_uang_muka_search" 
                                        class="w-full h-[42px] px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                    >
                                        <option value="">Semua Status UM</option>
                                        <option value="1" {{ Request('status_uang_muka_search') === '1' ? 'selected' : '' }}>Uang Muka (UM)</option>
                                        <option value="0" {{ Request('status_uang_muka_search') === '0' ? 'selected' : '' }}>Biasa</option>
                                    </select>
                                </div>

                                <!-- Tombol Filter & Reset (Full Width Column) -->
                                <div class="w-full flex items-center gap-2">
                                    <button 
                                        type="submit" 
                                        class="w-full flex-1 h-[42px] inline-flex items-center justify-center gap-2 px-4 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                                    >
                                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                                        <span>Filter Data</span>
                                    </button>
                                    @if(Request('no_bukti_search') || Request('dari') || Request('sampai') || Request('kode_supplier_search') || Request('kategori_pembelian_search') || Request('status_uang_muka_search') !== null)
                                        <a 
                                            href="{{ route('pembelian.index') }}" 
                                            class="h-[42px] px-3.5 inline-flex items-center justify-center gap-1.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition cursor-pointer shrink-0" 
                                            title="Reset Filter"
                                        >
                                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                            <span>Reset</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endcan
                    </div>
                </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl shadow-2xs overflow-hidden">
            <!-- Table Card Header (Solid Biru Dongker - Seamless with Table Header) -->
            <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                            <span>Data Transaksi Pembelian</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                                {{ $pembelian->total() }} Total
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/80">Katalog faktur pembelian barang, histori pelunasan hutang dagang, dan approval gudang/maintenance</p>
                    </div>
                </div>

                @if(Request('no_bukti_search') || Request('dari') || Request('sampai') || Request('kode_supplier_search') || Request('ppn_search') !== null || Request('jenis_transaksi_search') || Request('kategori_pembelian_search') || Request('status_uang_muka_search') !== null)
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
                    <span>item pembelian terpilih</span>
                </div>
                <div class="flex flex-wrap items-center gap-2 mt-1 sm:mt-0">
                    <!-- Ubah Kategori -->
                    <div class="inline-flex items-center gap-1 bg-white dark:bg-slate-900 px-2 py-1 rounded-xl border border-slate-200 dark:border-slate-700 shadow-2xs">
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mr-1">Kategori:</span>
                        <button type="button" onclick="bulkUpdateKategori('L')" class="px-2 py-0.5 bg-sky-50 dark:bg-sky-500/10 text-sky-700 dark:text-sky-300 hover:bg-sky-100 border border-sky-200 dark:border-sky-500/30 rounded-lg text-[11px] font-bold transition cursor-pointer">
                            Lokal
                        </button>
                        <button type="button" onclick="bulkUpdateKategori('I')" class="px-2 py-0.5 bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-300 hover:bg-purple-100 border border-purple-200 dark:border-purple-500/30 rounded-lg text-[11px] font-bold transition cursor-pointer">
                            Import
                        </button>
                    </div>

                    <!-- Ubah UM -->
                    <div class="inline-flex items-center gap-1 bg-white dark:bg-slate-900 px-2 py-1 rounded-xl border border-slate-200 dark:border-slate-700 shadow-2xs">
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium mr-1">Uang Muka:</span>
                        <button type="button" onclick="bulkUpdateUangMuka(1)" class="px-2 py-0.5 bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300 hover:bg-amber-100 border border-amber-200 dark:border-amber-500/30 rounded-lg text-[11px] font-bold transition cursor-pointer">
                            Ya (UM)
                        </button>
                        <button type="button" onclick="bulkUpdateUangMuka(0)" class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 border border-slate-200 dark:border-slate-700 rounded-lg text-[11px] font-bold transition cursor-pointer">
                            Biasa
                        </button>
                    </div>

                    @can('pembelian.delete')
                        <button type="button" onclick="bulkDelete()" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow-2xs inline-flex items-center gap-1.5 cursor-pointer">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            <span>Hapus Terpilih</span>
                        </button>
                    @endcan
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
                            <th class="py-2.5 px-3 whitespace-nowrap">No. Bukti</th>
                            <th class="py-2.5 px-3 whitespace-nowrap">Tanggal</th>
                            <th class="py-2.5 px-3 min-w-[150px]">Supplier</th>
                            <th class="py-2.5 px-3 text-center whitespace-nowrap">Kategori</th>
                            <th class="py-2.5 px-3 text-center whitespace-nowrap">UM</th>
                            @can('pembelian.harga')
                                <th class="py-2.5 px-3 text-right whitespace-nowrap">Total</th>
                                <th class="py-2.5 px-3 text-right whitespace-nowrap">Bayar</th>
                                <th class="py-2.5 px-3 text-center whitespace-nowrap">PPN</th>
                                <th class="py-2.5 px-3 text-center whitespace-nowrap">KB</th>
                                <th class="py-2.5 px-3 text-center whitespace-nowrap">Status</th>
                                <th class="py-2.5 px-3 text-center whitespace-nowrap">T/K</th>
                            @endcan
                            <th class="py-2.5 px-3 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse ($pembelian as $d)
                            @php
                                $total = $d->total_pembelian;
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Checkbox -->
                                <td class="py-1.5 px-3 text-center">
                                    <input type="checkbox" class="checkItem rounded border-slate-300 dark:border-slate-700 text-[#162a5b] focus:ring-0 w-3.5 h-3.5 cursor-pointer" value="{{ $d->no_bukti }}">
                                </td>

                                <!-- No. Bukti -->
                                <td class="py-1.5 px-3 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[#162a5b] dark:text-blue-400 border border-slate-200/60 dark:border-slate-700">
                                        {{ $d->no_bukti }}
                                    </span>
                                </td>

                                <!-- Tanggal -->
                                <td class="py-1.5 px-3 whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">
                                    <div>{{ formatIndo($d->tanggal) }}</div>
                                    @if(!empty($d->bulan_pajak) || !empty($d->tahun_pajak))
                                        <div class="text-[10px] text-slate-400 font-semibold mt-0.5">
                                            Pajak: {{ str_pad($d->bulan_pajak, 2, '0', STR_PAD_LEFT) }}/{{ $d->tahun_pajak }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Supplier -->
                                <td class="py-1.5 px-3">
                                    <span class="font-bold text-slate-800 dark:text-white leading-tight">
                                        {{ $d->nama_supplier }}
                                    </span>
                                </td>

                                <!-- Kategori -->
                                <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                    @if (($d->kategori_pembelian ?? 'L') == 'I')
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-300 border border-purple-200/60 dark:border-purple-500/20 rounded-md">
                                            Import
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold bg-sky-50 dark:bg-sky-500/10 text-sky-700 dark:text-sky-300 border border-sky-200/60 dark:border-sky-500/20 rounded-md">
                                            Lokal
                                        </span>
                                    @endif
                                </td>

                                <!-- UM -->
                                <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                    @if ($d->status_uang_muka == 1)
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300 border border-amber-200/60 dark:border-amber-500/20 rounded-md">
                                            UM
                                        </span>
                                    @else
                                        <span class="text-slate-300 dark:text-slate-600 font-bold">-</span>
                                    @endif
                                </td>

                                @can('pembelian.harga')
                                    <!-- Total -->
                                    <td class="py-1.5 px-3 text-right whitespace-nowrap">
                                        <span class="font-mono text-xs font-bold text-slate-900 dark:text-white">
                                            {{ formatAngkaDesimal($total) }}
                                        </span>
                                    </td>

                                    <!-- Bayar -->
                                    <td class="py-1.5 px-3 text-right whitespace-nowrap">
                                        <span class="font-mono text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                            {{ formatAngkaDesimal($d->totalbayar) }}
                                        </span>
                                    </td>

                                    <!-- PPN -->
                                    <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                        @if ($d->ppn == '1')
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 mx-auto">
                                                <i data-lucide="check" class="w-3 h-3 stroke-[2.5]"></i>
                                            </span>
                                        @else
                                            <span class="text-slate-300 dark:text-slate-600 font-bold">-</span>
                                        @endif
                                    </td>

                                    <!-- KB -->
                                    <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                        @if ($d->cek_kontrabon > 0)
                                            <span class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 rounded">
                                                KB
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300 border border-amber-200/60 rounded">
                                                KB
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Keterangan Status Lunas -->
                                    <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                        @if (round($total, 2) <= round($d->totalbayar ?? 0, 2))
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Lunas</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-bold bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200/60 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                <span>Belum Lunas</span>
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Tunai / Kredit -->
                                    <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold rounded-md {{ $d->jenis_transaksi == 'T' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                            {{ $d->jenis_transaksi == 'T' ? 'Tunai' : 'Kredit' }}
                                        </span>
                                    </td>
                                @endcan

                                <!-- Actions -->
                                <td class="py-1.5 px-3 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1">
                                        @can('pembelian.edit')
                                            <a 
                                                href="{{ route('pembelian.edit', Crypt::encrypt($d->no_bukti)) }}" 
                                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 hover:bg-emerald-100 dark:hover:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/20 transition cursor-pointer shadow-2xs" 
                                                title="Edit Pembelian"
                                            >
                                                <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                            </a>
                                        @endcan

                                        @can('pembelian.show')
                                            <a 
                                                href="{{ route('pembelian.show', Crypt::encrypt($d->no_bukti)) }}" 
                                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-sky-50 dark:bg-sky-500/10 hover:bg-sky-100 dark:hover:bg-sky-500/20 text-sky-600 dark:text-sky-400 border border-sky-200/60 dark:border-sky-500/20 transition cursor-pointer shadow-2xs" 
                                                title="Detail Pembelian"
                                            >
                                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            </a>

                                            <a 
                                                href="{{ route('pembelian.cetak', Crypt::encrypt($d->no_bukti)) }}" 
                                                target="_blank" 
                                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-violet-50 dark:bg-violet-500/10 hover:bg-violet-100 dark:hover:bg-violet-500/20 text-violet-600 dark:text-violet-400 border border-violet-200/60 dark:border-violet-500/20 transition cursor-pointer shadow-2xs" 
                                                title="Cetak Claim"
                                            >
                                                <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                                            </a>
                                        @endcan

                                        @can('pembelian.delete')
                                            <form method="POST" action="{{ route('pembelian.delete', Crypt::encrypt($d->no_bukti)) }}" class="inline deleteform">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition cursor-pointer shadow-2xs delete-confirm" 
                                                    title="Hapus Transaksi"
                                                >
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                            <i data-lucide="inbox" class="w-6 h-6"></i>
                                        </div>
                                        <span class="font-bold text-xs">Data transaksi pembelian tidak ditemukan</span>
                                        <p class="text-[11px] text-slate-400 max-w-sm">Coba sesuaikan kata kunci filter pencarian atau rentang tanggal untuk menemukan transaksi yang diinginkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                {{ $pembelian->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Import Excel -->
    <div id="modalImport" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="px-6 py-4 bg-[#162a5b] text-white flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/15 flex items-center justify-center">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4 text-white"></i>
                    </div>
                    <h3 class="font-bold text-sm text-white">Import Pembelian Excel</h3>
                </div>
                <button type="button" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" onclick="toggleModalImport()">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <form action="{{ route('pembelian.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Pilih File Excel (.xlsx, .xls, .csv)
                    </label>
                    <input 
                        type="file" 
                        id="file_excel" 
                        name="file_excel" 
                        accept=".xlsx,.xls,.csv" 
                        required 
                        class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition border border-slate-200 dark:border-slate-800 rounded-xl p-2 cursor-pointer bg-slate-50 dark:bg-slate-800/50" 
                    />
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Pilih Sheet Excel
                    </label>
                    <select 
                        name="sheet_name" 
                        id="import_sheet_name" 
                        class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-800 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200"
                    >
                        <option value="">-- Unggah File Excel Dahulu --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Jenis Transaksi
                    </label>
                    <select 
                        name="jenis_transaksi" 
                        class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-800 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200" 
                        required
                    >
                        <option value="K">Kredit (Tempo)</option>
                        <option value="T">Tunai (Cash)</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button 
                        type="button" 
                        class="px-4 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 transition cursor-pointer" 
                        onclick="toggleModalImport()"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-xs font-bold text-white bg-[#162a5b] rounded-xl hover:bg-[#1c3574] transition shadow-sm cursor-pointer"
                    >
                        Proses Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import Pembayaran Excel -->
    <div id="modalImportPembayaran" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="px-6 py-4 bg-gradient-to-r from-teal-600 to-teal-800 text-white flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-white/15 flex items-center justify-center">
                        <i data-lucide="receipt" class="w-4 h-4 text-white"></i>
                    </div>
                    <h3 class="font-bold text-sm text-white">Import Pembayaran Excel</h3>
                </div>
                <button type="button" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" onclick="toggleModalImportPembayaran()">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <form action="{{ route('pembelian.importpembayaran') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Pilih File Excel (.xlsx, .xls, .csv)
                    </label>
                    <input 
                        type="file" 
                        id="file_excel_pembayaran" 
                        name="file_excel" 
                        accept=".xlsx,.xls,.csv" 
                        required 
                        class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition border border-slate-200 dark:border-slate-800 rounded-xl p-2 cursor-pointer bg-slate-50 dark:bg-slate-800/50" 
                    />
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Pilih Sheet Excel
                    </label>
                    <select 
                        name="sheet_name" 
                        id="import_sheet_name_pembayaran" 
                        class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-800 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200"
                    >
                        <option value="">-- Unggah File Excel Dahulu --</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button 
                        type="button" 
                        class="px-4 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 transition cursor-pointer" 
                        onclick="toggleModalImportPembayaran()"
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

@push('myscript')
<script>


    // Modal Import Excel functions
    window.toggleModalImport = function() {
        $('#modalImport').toggleClass('hidden');
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    };

    window.toggleModalImportPembayaran = function() {
        $('#modalImportPembayaran').toggleClass('hidden');
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    };

    $('#file_excel_pembayaran').change(function() {
        var file = this.files[0];
        if (!file) return;

        var formData = new FormData();
        formData.append('file_excel', file);
        formData.append('_token', '{{ csrf_token() }}');

        $('#import_sheet_name_pembayaran').html('<option value="">Sedang membaca sheet...</option>');

        $.ajax({
            url: '{{ route("pembelian.getsheets") }}',
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
            url: '{{ route("pembelian.getsheets") }}',
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

    // SweetAlert2 Reset Pembayaran Confirmation
    window.resetPembayaran = function() {
        Swal.fire({
            title: 'Reset Pembayaran Pembelian?',
            text: "Seluruh data histori pembayaran pembelian akan dihapus permanen! Data transaksi pembelian tetap aman.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d97706',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Reset Pembayaran!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route("pembelian.resetpembayaran") }}'
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

    // SweetAlert2 Reset Pembelian Confirmation
    window.resetPembelian = function() {
        Swal.fire({
            title: 'Reset Semua Pembelian?',
            text: "Seluruh data transaksi pembelian, item detail, kontrabon, histori pembayaran, cost ratio, serta barang masuk logistik & maintenance terkait akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Reset Semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route("pembelian.reset") }}'
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
        // Initialize Lucide Icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Close dropdown when clicked outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#resetDropdownWrapper').length) {
                $('#resetDropdownMenu').addClass('hidden');
            }
        });

        // Initialize Select2 Supplier
        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Semua Supplier',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }



        $(document).on('click', '.delete-confirm', function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#162a5b",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Lanjutkan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Bulk Selection & Actions
        function updateBulkBar() {
            var selected = $('.checkItem:checked').map(function() {
                return $(this).val();
            }).get();

            var count = selected.length;
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

        window.bulkUpdateKategori = function(kategori) {
            var selected = $('.checkItem:checked').map(function() {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Pilih minimal satu data pembelian!',
                    icon: 'warning',
                    confirmButtonColor: '#162a5b'
                });
                return;
            }

            var label = kategori === 'I' ? 'Import' : 'Lokal';

            Swal.fire({
                title: 'Konfirmasi Ubah Kategori',
                text: `Ubah ${selected.length} data pembelian terpilih menjadi kategori ${label}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#162a5b',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Ubah',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: "{{ route('pembelian.bulkupdatekategori') }}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            no_bukti: selected,
                            kategori_pembelian: kategori
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
                            var errMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat memproses data.';
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

        window.bulkUpdateUangMuka = function(status) {
            var selected = $('.checkItem:checked').map(function() {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Pilih minimal satu data pembelian!',
                    icon: 'warning',
                    confirmButtonColor: '#162a5b'
                });
                return;
            }

            var label = status == 1 ? 'Uang Muka (Ya)' : 'Bukan Uang Muka (Biasa)';

            Swal.fire({
                title: 'Konfirmasi Ubah Status Uang Muka',
                text: `Ubah ${selected.length} data pembelian terpilih menjadi status "${label}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#162a5b',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Ubah',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    $.ajax({
                        url: "{{ route('pembelian.bulkupdateuangmuka') }}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            no_bukti: selected,
                            status_uang_muka: status
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
                            var errMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat memproses data.';
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

        window.bulkDelete = function() {
            var selected = $('.checkItem:checked').map(function() {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Pilih minimal satu data pembelian untuk dihapus!',
                    icon: 'warning',
                    confirmButtonColor: '#162a5b'
                });
                return;
            }

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: `Menghapus ${selected.length} data pembelian terpilih. Data yang periode laporannya sudah ditutup atau memiliki kontrabon yang sudah dibayar tidak akan dihapus! Tindakan ini tidak dapat dibatalkan.`,
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
                        url: "{{ route('pembelian.bulkdelete') }}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            no_bukti: selected
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Selesai!',
                                text: response.message,
                                icon: response.deleted_count > 0 ? 'success' : 'warning',
                                confirmButtonColor: '#162a5b'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            var errMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal menghapus data.';
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
    });
</script>
@endpush
</x-app-layout>
