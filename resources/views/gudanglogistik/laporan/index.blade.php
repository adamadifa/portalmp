<x-app-layout>
    <x-slot name="header">
        Laporan Gudang Logistik
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
        z-index: 25 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .c-fl-group:focus-within .c-fl-icon {
        color: #294C9A !important;
    }

    /* Notched Label: Centered exactly on top border line of input */
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
        background-color: #ffffff !important;
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
        font-size: 12px !important;
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.10) !important;
        overflow: hidden !important;
    }
    .select2-search--dropdown { padding: 6px 8px !important; }
    .select2-search--dropdown .select2-search__field {
        height: 30px !important;
        padding: 0 8px !important;
        font-size: 12px !important;
        border: 1px solid #D1D5DB !important;
        border-radius: 5px !important;
        outline: none !important;
    }
    .select2-search--dropdown .select2-search__field:focus {
        border-color: #294C9A !important;
        box-shadow: 0 0 0 2px rgba(41, 76, 154, 0.10) !important;
    }
    .select2-container--default .select2-results__option {
        padding: 7px 10px !important;
        font-size: 12px !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #294C9A !important;
    }

    /* ── Premium Modern Flatpickr Theme ───────────────── */
    .flatpickr-calendar {
        background: #ffffff !important;
        border-radius: 16px !important;
        border: 1px solid #E5E7EB !important;
        box-shadow: 0 20px 35px -10px rgba(41, 76, 154, 0.22), 0 10px 20px -5px rgba(0, 0, 0, 0.08) !important;
        font-family: inherit !important;
        overflow: hidden !important;
        width: 307px !important;
        z-index: 99999 !important;
    }
    .flatpickr-months {
        background: linear-gradient(135deg, #294C9A 0%, #1E3A70 100%) !important;
        padding: 8px 10px !important;
        align-items: center !important;
        border-radius: 15px 15px 0 0 !important;
    }
    .flatpickr-months .flatpickr-month { color: #ffffff !important; height: 38px !important; }
    .flatpickr-current-month { font-size: 14px !important; font-weight: 700 !important; color: #ffffff !important; padding-top: 4px !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months { font-weight: 700 !important; color: #ffffff !important; background: transparent !important; padding: 2px 6px !important; border-radius: 6px !important; margin-right: 4px !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months:hover { background: rgba(255, 255, 255, 0.18) !important; }
    .flatpickr-current-month input.cur-year { font-weight: 700 !important; color: #ffffff !important; }
    .flatpickr-months .flatpickr-prev-month, .flatpickr-months .flatpickr-next-month { padding: 8px !important; color: #ffffff !important; fill: #ffffff !important; border-radius: 8px !important; transition: background 0.15s ease !important; }
    .flatpickr-months .flatpickr-prev-month:hover, .flatpickr-months .flatpickr-next-month:hover { background: rgba(255, 255, 255, 0.20) !important; }
    .flatpickr-months .flatpickr-prev-month svg, .flatpickr-months .flatpickr-next-month svg { fill: #ffffff !important; width: 14px !important; height: 14px !important; }
    .flatpickr-weekdays { background: #F3F4F6 !important; padding: 8px 0 !important; border-bottom: 1px solid #E5E7EB !important; }
    span.flatpickr-weekday { color: #294C9A !important; font-weight: 700 !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; }
    .flatpickr-days { width: 307px !important; padding: 6px !important; }
    .dayContainer { width: 294px !important; min-width: 294px !important; max-width: 294px !important; }
    .flatpickr-day { color: #111827 !important; font-weight: 700 !important; font-size: 13px !important; border-radius: 10px !important; height: 38px !important; line-height: 38px !important; max-width: 38px !important; margin: 2px !important; border: 1px solid transparent !important; transition: all 0.15s ease !important; }
    .flatpickr-day:hover { background: #EBF1FF !important; color: #294C9A !important; font-weight: 800 !important; border-color: #BFDBFE !important; }
    .flatpickr-day.today { border: 2px solid #294C9A !important; color: #294C9A !important; font-weight: 800 !important; background: #F0F4FF !important; }
    .flatpickr-day.selected, .flatpickr-day.selected:hover { background: linear-gradient(135deg, #294C9A 0%, #1E3A70 100%) !important; color: #ffffff !important; font-weight: 800 !important; box-shadow: 0 4px 12px rgba(41, 76, 154, 0.40) !important; border: none !important; }
    .flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover, .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay { color: #9CA3AF !important; font-weight: 500 !important; opacity: 0.55 !important; background: transparent !important; border-color: transparent !important; }
    </style>

    <!-- Header & Subtitle -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Gudang Logistik</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola dan mencetak laporan mutasi serta persediaan barang di gudang logistik.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Sidebar Navigation Tabs -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-3 space-y-1">
            @can('gl.barangmasuk')
            <button type="button" data-tab="barangmasuk" class="tab-btn active w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-[#294C9A] bg-blue-50/80 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-[#294C9A] text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Barang Masuk</span>
                    <span class="text-[11px] font-normal text-gray-500">Laporan penerimaan barang</span>
                </div>
            </button>
            @endcan

            @can('gl.barangkeluar')
            <button type="button" data-tab="barangkeluar" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Barang Keluar</span>
                    <span class="text-[11px] font-normal text-gray-500">Laporan pengeluaran barang</span>
                </div>
            </button>
            @endcan

            @can('gl.persediaan')
            <button type="button" data-tab="persediaan" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Persediaan</span>
                    <span class="text-[11px] font-normal text-gray-500">Laporan persediaan akhir</span>
                </div>
            </button>
            @endcan

            @can('gl.rekappersediaan')
            <button type="button" data-tab="rekappersediaan" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap Persediaan</span>
                    <span class="text-[11px] font-normal text-gray-500">Rekapitulasi stok & saldo</span>
                </div>
            </button>
            @endcan

            @can('gl.kartugudang')
            <button type="button" data-tab="kartugudang" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Kartu Gudang</span>
                    <span class="text-[11px] font-normal text-gray-500">Rincian riwayat per item</span>
                </div>
            </button>
            @endcan
        </div>

        <!-- Form Panels -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @can('gl.barangmasuk')
                <div id="panel-barangmasuk" class="tab-panel p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        <h3 class="font-bold text-base">Laporan Barang Masuk</h3>
                    </div>
                    @include('gudanglogistik.laporan.barangmasuk')
                </div>
                @endcan

                @can('gl.barangkeluar')
                <div id="panel-barangkeluar" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        <h3 class="font-bold text-base">Laporan Barang Keluar</h3>
                    </div>
                    @include('gudanglogistik.laporan.barangkeluar')
                </div>
                @endcan

                @can('gl.persediaan')
                <div id="panel-persediaan" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <h3 class="font-bold text-base">Laporan Persediaan</h3>
                    </div>
                    @include('gudanglogistik.laporan.persediaan')
                </div>
                @endcan

                @can('gl.rekappersediaan')
                <div id="panel-rekappersediaan" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="font-bold text-base">Rekap Persediaan</h3>
                    </div>
                    @include('gudanglogistik.laporan.rekappersediaan')
                </div>
                @endcan

                @can('gl.kartugudang')
                <div id="panel-kartugudang" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <h3 class="font-bold text-base">Kartu Gudang</h3>
                    </div>
                    @include('gudanglogistik.laporan.kartugudang')
                </div>
                @endcan
            </div>
        </div>
    </div>

    @push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        $(function() {
            flatpickr.localize(flatpickr.l10ns.id);
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
            });

            // Interactive Tab Switching
            $('.tab-btn').click(function() {
                const targetTab = $(this).data('tab');
                
                // Active styles for tab button
                $('.tab-btn').removeClass('active text-[#294C9A] bg-blue-50/80').addClass('text-gray-600 hover:bg-gray-50');
                $('.tab-btn .tab-icon').removeClass('bg-[#294C9A] text-white').addClass('bg-gray-100 text-gray-600');
                
                $(this).addClass('active text-[#294C9A] bg-blue-50/80').removeClass('text-gray-600 hover:bg-gray-50');
                $(this).find('.tab-icon').removeClass('bg-gray-100 text-gray-600').addClass('bg-[#294C9A] text-white');

                // Panel toggle
                $('.tab-panel').addClass('hidden');
                $(`#panel-${targetTab}`).removeClass('hidden');
            });

            // Validation for each form
            function validatePeriode(formId) {
                $(`#${formId}`).submit(function() {
                    const dari = $(this).find("#dari").val();
                    const sampai = $(this).find("#sampai").val();
                    if (dari == "") {
                        Swal.fire({
                            title: "Oops!",
                            text: 'Periode Dari Harus Diisi !',
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                            buttonsStyling: false,
                            didClose: () => $(this).find("#dari").focus(),
                        });
                        return false;
                    } else if (sampai == "") {
                        Swal.fire({
                            title: "Oops!",
                            text: 'Periode Sampai Harus Diisi !',
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                            buttonsStyling: false,
                            didClose: () => $(this).find("#sampai").focus(),
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
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                            buttonsStyling: false,
                            didClose: () => $(this).find("#sampai").focus(),
                        });
                        return false;
                    }
                });
            }

            function validateBulanTahun(formId, checkKategori = false, checkBarang = false, barangId = "") {
                $(`#${formId}`).submit(function() {
                    const bulan = $(this).find("#bulan").val();
                    const tahun = $(this).find("#tahun").val();
                    if (bulan == "") {
                        Swal.fire({ title: "Oops!", text: 'Bulan Harus Diisi !', icon: "warning", customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' }, buttonsStyling: false, didClose: () => $(this).find("#bulan").focus() });
                        return false;
                    } else if (tahun == "") {
                        Swal.fire({ title: "Oops!", text: 'Tahun Harus Diisi !', icon: "warning", customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' }, buttonsStyling: false, didClose: () => $(this).find("#tahun").focus() });
                        return false;
                    }
                    if (checkKategori) {
                        const kategori = $(this).find("#kode_kategori").val();
                        if (kategori == "") {
                            Swal.fire({ title: "Oops!", text: 'Kategori Harus Diisi !', icon: "warning", customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' }, buttonsStyling: false, didClose: () => $(this).find("#kode_kategori").focus() });
                            return false;
                        }
                    }
                    if (checkBarang) {
                        const barang = $(this).find(`#${barangId}`).val();
                        if (barang == "") {
                            Swal.fire({ title: "Oops!", text: 'Barang Harus Diisi !', icon: "warning", customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' }, buttonsStyling: false, didClose: () => $(this).find(`#${barangId}`).focus() });
                            return false;
                        }
                    }
                });
            }

            validatePeriode("frmLaporanbarangmasuk");
            validatePeriode("frmLaporanbarangkeluar");
            validateBulanTahun("frmPersediaan", true);
            validateBulanTahun("frmRekappersediaan", true);
            validateBulanTahun("frmKartugudang", false, true, "kode_barang_kartugudang");

            // Select2 Initializations
            $(".select2Kodebarangmasuk, .select2Kodebarangkeluar, .select2Kodebarangkartugudang").each(function() {
                $(this).select2({
                    placeholder: 'Semua Barang',
                    allowClear: true
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
