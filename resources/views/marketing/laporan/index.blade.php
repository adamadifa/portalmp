<x-app-layout>
    <x-slot name="header">Laporan Marketing</x-slot>
    <x-slot name="headerTitle">Laporan Marketing</x-slot>
    <x-slot name="headerDescription">Pusat pencetakan dan ekspor data laporan rincian transaksi penjualan, rekapitulasi produk, dan kartu piutang pelanggan.</x-slot>

    <div class="space-y-6">

        <!-- Top Overview Header -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs">
                    <i data-lucide="printer" class="w-4 h-4 text-[#162a5b] dark:text-blue-400"></i>
                    <span>Modul Cetak Laporan Penjualan</span>
                </span>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 border border-blue-200/50 dark:border-blue-800/40">
                    <i data-lucide="file-check-2" class="w-3.5 h-3.5"></i>
                    <span>3 Modul Laporan Siap Cetak</span>
                </span>
            </div>
        </div>

        <!-- Master-Detail 2-Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column (4 cols): Report Navigation Cards -->
            <div class="lg:col-span-4 space-y-4">
                
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 p-4 shadow-2xs space-y-2.5">
                    <div class="px-2 py-1 mb-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Pilih Jenis Laporan</span>
                    </div>

                    <!-- Tab 1: Laporan Penjualan -->
                    <button 
                        type="button" 
                        data-tab="penjualan" 
                        class="tab-btn active w-full flex items-start gap-3.5 p-3.5 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                    >
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                            <i data-lucide="receipt" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Laporan Penjualan</span>
                                <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">Detail</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">Rincian detail faktur dan item barang penjualan per transaksi pelanggan.</p>
                        </div>
                    </button>

                    <!-- Tab 2: Rekapitulasi Penjualan -->
                    <button 
                        type="button" 
                        data-tab="rekap" 
                        class="tab-btn w-full flex items-start gap-3.5 p-3.5 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                    >
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                            <i data-lucide="pie-chart" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Rekap Penjualan</span>
                                <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300">Rekap</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">Rangkuman akumulasi kuantiti dus dan total omzet per produk.</p>
                        </div>
                    </button>

                    <!-- Tab 3: Kartu Piutang -->
                    <button 
                        type="button" 
                        data-tab="kartupiutang" 
                        class="tab-btn w-full flex items-start gap-3.5 p-3.5 rounded-xl border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition text-left cursor-pointer group"
                    >
                        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 tab-icon group-hover:scale-105 transition">
                            <i data-lucide="wallet-cards" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <span class="text-xs font-bold text-slate-800 dark:text-white tab-title">Kartu Piutang</span>
                                <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">Piutang</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">Buku pembantu piutang kredit, tagihan jatuh tempo, dan histori pembayaran.</p>
                        </div>
                    </button>

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
                                Gunakan <strong>Cetak Laporan</strong> untuk membuka pratinjau siap cetak / PDF. Gunakan <strong>Export Excel</strong> untuk mengunduh berkas tabel spreadsheet (.xls).
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column (8 cols): Report Configuration Form -->
            <div class="lg:col-span-8">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-2xs overflow-hidden">
                    
                    <!-- Panel Header -->
                    <div class="px-6 py-4 bg-[#162a5b] text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white shrink-0" id="header_panel_icon">
                                <i data-lucide="receipt" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-white" id="header_panel_title">
                                    Laporan Rincian Penjualan Marketing
                                </h3>
                                <p class="text-[11px] text-white/70" id="header_panel_desc">
                                    Tentukan parameter pelanggan dan rentang periode transaksi
                                </p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-md bg-white/15 text-[10px] font-bold text-white uppercase tracking-wider">
                            Parameter Form
                        </span>
                    </div>

                    <!-- Panel Forms Container -->
                    <div class="p-6">
                        
                        <!-- Panel 1: Penjualan Detail -->
                        <div id="panel-penjualan" class="tab-panel">
                            @include('marketing.laporan.penjualan')
                        </div>

                        <!-- Panel 2: Rekapitulasi Penjualan -->
                        <div id="panel-rekap" class="tab-panel hidden">
                            @include('marketing.laporan.rekap')
                        </div>

                        <!-- Panel 3: Kartu Piutang -->
                        <div id="panel-kartupiutang" class="tab-panel hidden">
                            @include('marketing.laporan.kartupiutang')
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

    @push('myscript')
    <style>
        /* Modern Tab Active State */
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
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Apply flatpickr to date inputs
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });

            // Initialize Select2 with modern dropdown
            if ($.fn.select2) {
                $('.select2-filter').select2({
                    width: '100%',
                    placeholder: 'Semua',
                    allowClear: true
                });
            }

            // Tab Panels Configuration
            const tabMeta = {
                penjualan: {
                    title: 'Laporan Rincian Penjualan Marketing',
                    desc: 'Tentukan parameter pelanggan, produk, dan rentang periode transaksi',
                    icon: 'receipt'
                },
                rekap: {
                    title: 'Laporan Rekapitulasi Penjualan Marketing',
                    desc: 'Rangkuman akumulasi penjualan seluruh produk dalam periode yang dipilih',
                    icon: 'pie-chart'
                },
                kartupiutang: {
                    title: 'Laporan Kartu Piutang Pelanggan',
                    desc: 'Pantau histori buku pembantu piutang kredit dan angsuran pembayaran pelanggan',
                    icon: 'wallet-cards'
                }
            };

            // Tab Switching Logic
            $('.tab-btn').on('click', function() {
                var targetTab = $(this).data('tab');
                
                // Toggle active button states
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                // Toggle panels
                $('.tab-panel').addClass('hidden');
                $(`#panel-${targetTab}`).removeClass('hidden');

                // Update Header
                if (tabMeta[targetTab]) {
                    $('#header_panel_title').text(tabMeta[targetTab].title);
                    $('#header_panel_desc').text(tabMeta[targetTab].desc);
                    $('#header_panel_icon').html(`<i data-lucide="${tabMeta[targetTab].icon}" class="w-4 h-4"></i>`);
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            });

            // Quick Date Range Presets
            $('.btn-preset').on('click', function(e) {
                e.preventDefault();
                let dariId = $(this).data('target-dari');
                let sampaiId = $(this).data('target-sampai');
                let preset = $(this).data('preset');

                let now = new Date();
                let pad = (n) => (n < 10 ? '0' + n : n);
                let format = (d) => d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());

                let dariVal = '';
                let sampaiVal = format(now);

                if (preset === 'today') {
                    dariVal = format(now);
                } else if (preset === 'this_month') {
                    let firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
                    dariVal = format(firstDay);
                } else if (preset === 'last_month') {
                    let firstDayLastMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                    let lastDayLastMonth = new Date(now.getFullYear(), now.getMonth(), 0);
                    dariVal = format(firstDayLastMonth);
                    sampaiVal = format(lastDayLastMonth);
                }

                if (dariVal && sampaiVal) {
                    $('#' + dariId).val(dariVal);
                    $('#' + sampaiId).val(sampaiVal);
                    if (document.getElementById(dariId)._flatpickr) {
                        document.getElementById(dariId)._flatpickr.setDate(dariVal);
                    }
                    if (document.getElementById(sampaiId)._flatpickr) {
                        document.getElementById(sampaiId)._flatpickr.setDate(sampaiVal);
                    }
                }
            });

            // Validation Helper
            function bindPeriodeValidation(formId, dariFieldId, sampaiFieldId) {
                $(`#${formId}`).on('submit', function(e) {
                    const dari = $(`#${dariFieldId}`).val().trim();
                    const sampai = $(`#${sampaiFieldId}`).val().trim();
                    
                    if (!dari) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanggal Mulai Belum Diisi',
                            text: 'Silakan tentukan Periode Dari terlebih dahulu.',
                            confirmButtonColor: '#162a5b'
                        });
                        $(`#${dariFieldId}`).focus();
                        return false;
                    }

                    if (!sampai) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanggal Akhir Belum Diisi',
                            text: 'Silakan tentukan Periode Sampai terlebih dahulu.',
                            confirmButtonColor: '#162a5b'
                        });
                        $(`#${sampaiFieldId}`).focus();
                        return false;
                    }

                    if (new Date(dari) > new Date(sampai)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Rentang Periode Tidak Valid',
                            text: 'Tanggal awal tidak boleh melebihi tanggal akhir.',
                            confirmButtonColor: '#162a5b'
                        });
                        $(`#${sampaiFieldId}`).focus();
                        return false;
                    }

                    return true;
                });
            }

            // Bind Form Validations
            bindPeriodeValidation("formLapPenjualan", "dari_penjualan", "sampai_penjualan");
            bindPeriodeValidation("formLapRekapPenjualan", "dari_rekappenjualan", "sampai_rekappenjualan");
            bindPeriodeValidation("formLapKartuPiutang", "dari_kartupiutang", "sampai_kartupiutang");
        });
    </script>
    @endpush
</x-app-layout>
