<x-app-layout>
    <x-slot name="header">
        Laporan Marketing
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

    /* Rendered text & placeholder vertically centered */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: flex !important;
        align-items: center !important;
        height: 100% !important;
        line-height: normal !important;
        padding-left: 34px !important;
        padding-right: 32px !important;
        font-size: 12px !important;
        color: #111827 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        margin: 0 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        display: inline-block !important;
        line-height: normal !important;
        color: #9CA3AF !important;
        font-size: 11.5px !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Chevron arrow dead-center vertically */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute !important;
        top: 50% !important;
        right: 10px !important;
        left: auto !important;
        bottom: auto !important;
        transform: translateY(-50%) !important;
        height: 16px !important;
        width: 16px !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        margin: 0 !important;
        border-color: #6B7280 transparent transparent transparent !important;
        border-style: solid !important;
        border-width: 5px 4px 0 4px !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #6B7280 transparent !important;
        border-width: 0 4px 5px 4px !important;
    }

    /* dropdown */
    .select2-dropdown {
        border: 1px solid #E5E7EB !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        z-index: 9999 !important;
        overflow: hidden !important;
    }

    .select2-results__option {
        padding: 8px 12px !important;
        font-size: 12px !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #294C9A !important;
    }

    /* Tab styles */
    .tab-btn.active {
        background-color: rgba(41, 76, 154, 0.08) !important;
        color: #294C9A !important;
    }
    .tab-btn.active .tab-icon {
        background-color: #294C9A !important;
        color: #ffffff !important;
    }
    </style>

    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Marketing</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola dan mencetak laporan penjualan serta rekapitulasi data penjualan marketing.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Sidebar Navigation Tabs -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-3 space-y-1">
            <button type="button" data-tab="penjualan" class="tab-btn active w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m3.333-9h13.334M16 11V7a4 4 0 10-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Laporan Penjualan</span>
                    <span class="text-[11px] font-normal text-gray-500">Rincian detail penjualan barang</span>
                </div>
            </button>

            <button type="button" data-tab="rekap" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap Penjualan</span>
                    <span class="text-[11px] font-normal text-gray-500">Rangkuman penjualan per produk</span>
                </div>
            </button>
        </div>

        <!-- Form Panels -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                
                <div id="panel-penjualan" class="tab-panel p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <h4 class="font-bold text-sm">Laporan Rincian Penjualan Marketing</h4>
                    </div>
                    @include('marketing.laporan.penjualan')
                </div>

                <div id="panel-rekap" class="tab-panel p-6 hidden">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <h4 class="font-bold text-sm">Laporan Rekapitulasi Penjualan Marketing</h4>
                    </div>
                    @include('marketing.laporan.rekap')
                </div>

            </div>
        </div>
    </div>

    @push('myscript')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            // Apply flatpickr to inputs
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });

            // Tab Switching Logic
            $('.tab-btn').click(function() {
                var targetTab = $(this).data('tab');
                
                // Toggle active button states
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');

                // Toggle panels
                $('.tab-panel').addClass('hidden');
                $(`#panel-${targetTab}`).removeClass('hidden');
            });

            // Validation for each form
            function validatePeriode(formId, dariFieldId = "dari", sampaiFieldId = "sampai") {
                $(`#${formId}`).submit(function() {
                    const dari = $(this).find(`#${dariFieldId}`).val();
                    const sampai = $(this).find(`#${sampaiFieldId}`).val();
                    
                    if (dari == "") {
                        Swal.fire({
                            title: "Oops!",
                            text: 'Periode Dari Harus Diisi !',
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl shadow-sm' },
                            buttonsStyling: false,
                            didClose: () => $(this).find(`#${dariFieldId}`).focus(),
                        });
                        return false;
                    } else if (sampai == "") {
                        Swal.fire({
                            title: "Oops!",
                            text: 'Periode Sampai Harus Diisi !',
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl shadow-sm' },
                            buttonsStyling: false,
                            didClose: () => $(this).find(`#${sampaiFieldId}`).focus(),
                        });
                        return false;
                    }
                    var start = new Date(dari);
                    var end = new Date(sampai);
                    if (start.getTime() > end.getTime()) {
                        Swal.fire({
                            title: "Oops!",
                            text: 'Periode Tidak Valid !, Periode Sampai Harus Lebih Akhir dari Periode Dari',
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl shadow-sm' },
                            buttonsStyling: false,
                            didClose: () => $(this).find(`#${sampaiFieldId}`).focus(),
                        });
                        return false;
                    }
                });
            }

            // Bind validations
            validatePeriode("formLapPenjualan", "dari_penjualan", "sampai_penjualan");
            validatePeriode("formLapRekapPenjualan", "dari_rekappenjualan", "sampai_rekappenjualan");

            // Select2 Initializations
            $(".select2Pelanggan, .select2Produk").each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Semua',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
