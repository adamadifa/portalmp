<x-app-layout>
    <x-slot name="header">
        Laporan Accounting
    </x-slot>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
    /* ── Isolated Floating Label & Icon Group ──────────── */
    .c-fl-group {
        position: relative !important;
        width: 100% !important;
        margin-top: 8px !important;
        margin-bottom: 6px !important;
    }

    .c-fl-icon {
        position: absolute !important;
        left: 10px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        color: #6B7280 !important;
        pointer-events: none !important;
        z-index: 30 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .c-fl-group:focus-within .c-fl-icon {
        color: #294C9A !important;
    }

    .c-fl-label {
        position: absolute !important;
        left: 10px !important;
        top: 0px !important;
        bottom: auto !important;
        transform: translateY(-50%) !important;
        background-color: #ffffff !important;
        padding: 0 4px !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #374151 !important;
        z-index: 30 !important;
        pointer-events: none !important;
        line-height: 1 !important;
        white-space: nowrap !important;
        border-radius: 2px !important;
    }

    .c-fl-group:focus-within .c-fl-label {
        color: #294C9A !important;
    }

    /* ── Base input ─────────────────────────────── */
    .fi {
        display: block !important;
        width: 100% !important;
        height: 38px !important;
        padding: 0 12px 0 34px !important;
        font-size: 12px !important;
        color: #111827 !important;
        background-color: #ffffff !important;
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        outline: none !important;
        transition: border-color .15s, box-shadow .15s !important;
    }
    .fi:focus {
        border-color: #294C9A !important;
        box-shadow: 0 0 0 3px rgba(41, 76, 154, 0.10) !important;
    }
    .fi::placeholder { color: #9CA3AF !important; font-size: 11.5px !important; }

    /* ── Select & Select2 reset ─────────────────── */
    .select2-container { width: 100% !important; }

    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        background-color: transparent !important;
        box-shadow: none !important;
        position: relative !important;
        display: block !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #294C9A !important;
        box-shadow: 0 0 0 3px rgba(41, 76, 154, 0.10) !important;
        outline: none !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: flex !important;
        align-items: center !important;
        height: 38px !important;
        padding-left: 34px !important;
        padding-right: 28px !important;
        font-size: 12px !important;
        color: #111827 !important;
        line-height: normal !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 8px !important;
    }

    .select2-dropdown {
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        font-size: 12px !important;
        z-index: 9999 !important;
    }
    </style>

    <!-- Header & Subtitle -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Accounting</h2>
        <p class="text-sm text-gray-500 mt-1">Mencetak laporan keuangan: Buku Besar, Neraca, Laba Rugi, dan Jurnal Umum.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Sidebar Navigation Tabs -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-3 space-y-1">
            <button type="button" data-tab="bukubesar" class="tab-btn active w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-[#294C9A] bg-blue-50/80 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-[#294C9A] text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Laporan Keuangan</span>
                    <span class="text-[11px] font-normal text-gray-500">Buku Besar, Neraca, Laba Rugi</span>
                </div>
            </button>

            @can('akt.jurnalumum')
            <button type="button" data-tab="jurnalumum" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Jurnal Umum</span>
                    <span class="text-[11px] font-normal text-gray-500">Daftar Jurnal Umum Periode</span>
                </div>
            </button>
            @endcan
        </div>

        <!-- Tab Content Cards -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <!-- Header Card -->
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h3 id="panel-title" class="text-base font-bold text-gray-800">Laporan Keuangan</h3>
                    <p id="panel-desc" class="text-xs text-gray-500 mt-0.5">Filter dan cetak format Buku Besar, Neraca, atau Laba Rugi.</p>
                </div>

                <!-- Tab Panel: Buku Besar / LK -->
                <div id="tab-bukubesar" class="tab-content">
                    @include('accounting.laporan.lk.bukubesar')
                </div>

                @can('akt.jurnalumum')
                <!-- Tab Panel: Jurnal Umum -->
                <div id="tab-jurnalumum" class="tab-content hidden">
                    @include('accounting.laporan.jurnalumum')
                </div>
                @endcan
            </div>
        </div>
    </div>

    @push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(function() {
            // Inisialisasi Flatpickr
            $(".flatpickr-date").flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true
            });

            // Inisialisasi Select2
            $('.select2Single').select2({
                width: '100%'
            });

            const formLedger = $("#formLedger");

            // Fungsi toggle COA sesuai format laporan
            function showCoa() {
                const formatlaporan = formLedger.find("#formatlaporan_ledger").val();
                if (formatlaporan == '1') {
                    $("#coa_ledger").show();
                } else {
                    $("#coa_ledger").hide();
                    formLedger.find("#kode_akun_dari_ledger").val("").trigger('change');
                    formLedger.find("#kode_akun_sampai_ledger").val("").trigger('change');
                }
            }

            showCoa();

            formLedger.find("#formatlaporan_ledger").on('change', function() {
            // Tab switching
            $('.tab-btn').on('click', function() {
                $('.tab-btn').removeClass('active text-[#294C9A] bg-blue-50/80')
                    .addClass('text-gray-600 hover:bg-gray-50');
                $('.tab-btn .w-8').removeClass('bg-[#294C9A] text-white')
                    .addClass('bg-gray-100 text-gray-600');

                $(this).addClass('active text-[#294C9A] bg-blue-50/80')
                    .removeClass('text-gray-600 hover:bg-gray-50');
                $(this).find('.w-8').addClass('bg-[#294C9A] text-white')
                    .removeClass('bg-gray-100 text-gray-600');

                const targetTab = $(this).data('tab');
                $('.tab-content').addClass('hidden');
                $(`#tab-${targetTab}`).removeClass('hidden');

                if (targetTab === 'bukubesar') {
                    $('#panel-title').text('Laporan Keuangan');
                    $('#panel-desc').text('Filter dan cetak format Buku Besar, Neraca, atau Laba Rugi.');
                } else if (targetTab === 'jurnalumum') {
                    $('#panel-title').text('Laporan Jurnal Umum');
                    $('#panel-desc').text('Filter dan cetak transaksi Jurnal Umum per periode.');
                }
            });

            formLedger.on('submit', function(e) {
                const formatlaporan = formLedger.find("#formatlaporan_ledger").val();
                const dari = formLedger.find("#dari_ledger").val();
                const sampai = formLedger.find("#sampai_ledger").val();

                if (!formatlaporan) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Peringatan",
                        text: 'Pilih format laporan terlebih dahulu!',
                        icon: "warning",
                        confirmButtonColor: '#294C9A'
                    });
                    return false;
                }

                if (!dari || !sampai) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Peringatan",
                        text: 'Periode Dari dan Sampai tanggal harus diisi!',
                        icon: "warning",
                        confirmButtonColor: '#294C9A'
                    });
                    return false;
                }

                if (new Date(dari) > new Date(sampai)) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Peringatan",
                        text: 'Periode Dari Tanggal tidak boleh lebih besar dari Sampai Tanggal!',
                        icon: "warning",
                        confirmButtonColor: '#294C9A'
                    });
                    return false;
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
