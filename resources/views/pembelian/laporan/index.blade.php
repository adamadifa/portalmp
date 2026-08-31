<x-app-layout>
    <x-slot name="header">
        Laporan Pembelian
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
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Pembelian</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola dan mencetak laporan pembelian, pembayaran, dan rekapitulasi data pembelian.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Sidebar Navigation Tabs -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-3 space-y-1">
            <button type="button" data-tab="pembelian" class="tab-btn active w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-[#294C9A] bg-blue-50/80 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-[#294C9A] text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Pembelian</span>
                    <span class="text-[11px] font-normal text-gray-500">Detail rincian pembelian</span>
                </div>
            </button>

            <button type="button" data-tab="pembayaran" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Pembayaran</span>
                    <span class="text-[11px] font-normal text-gray-500">Histori pembayaran supplier</span>
                </div>
            </button>

            <button type="button" data-tab="rekapsupplier" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap Supplier</span>
                    <span class="text-[11px] font-normal text-gray-500">Rekap total per supplier</span>
                </div>
            </button>

            <button type="button" data-tab="rekappembelian" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap Pembelian</span>
                    <span class="text-[11px] font-normal text-gray-500">Rangkuman barang & jenis</span>
                </div>
            </button>

            <button type="button" data-tab="kartuhutang" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Kartu Hutang</span>
                    <span class="text-[11px] font-normal text-gray-500">Buku pembantu hutang</span>
                </div>
            </button>

            <button type="button" data-tab="auh" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">AUH</span>
                    <span class="text-[11px] font-normal text-gray-500">Analisa umur hutang</span>
                </div>
            </button>

            <button type="button" data-tab="bahankemasan" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Bahan Kemasan</span>
                    <span class="text-[11px] font-normal text-gray-500">Detail bahan baku & kemasan</span>
                </div>
            </button>

            <button type="button" data-tab="rekapbahankemasan" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Kemasan / Supplier</span>
                    <span class="text-[11px] font-normal text-gray-500">Rekap kemasan per supplier</span>
                </div>
            </button>

            <button type="button" data-tab="jurnalkoreksi" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Jurnal Koreksi</span>
                    <span class="text-[11px] font-normal text-gray-500">Laporan pembetulan jurnal</span>
                </div>
            </button>

            <button type="button" data-tab="rekapakun" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap Akun</span>
                    <span class="text-[11px] font-normal text-gray-500">Rekap total per COA</span>
                </div>
            </button>

            <button type="button" data-tab="rekapkontrabon" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap Kontrabon</span>
                    <span class="text-[11px] font-normal text-gray-500">Histori & rekap kontrabon</span>
                </div>
            </button>

            <button type="button" data-tab="rekappo" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap PO</span>
                    <span class="text-[11px] font-normal text-gray-500">Rekap status Purchase Order</span>
                </div>
            </button>
        </div>

        <!-- Form Panels -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                
                <div id="panel-pembelian" class="tab-panel p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <h3 class="font-bold text-base">Laporan Pembelian</h3>
                    </div>
                    @include('pembelian.laporan.pembelian')
                </div>

                <div id="panel-pembayaran" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="font-bold text-base">Laporan Pembayaran</h3>
                    </div>
                    @include('pembelian.laporan.pembayaran')
                </div>

                <div id="panel-rekapsupplier" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="font-bold text-base">Rekap Pembelian Supplier</h3>
                    </div>
                    @include('pembelian.laporan.rekapsupplier')
                </div>

                <div id="panel-rekappembelian" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <h3 class="font-bold text-base">Rekap Pembelian</h3>
                    </div>
                    @include('pembelian.laporan.rekappembelian')
                </div>

                <div id="panel-kartuhutang" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <h3 class="font-bold text-base">Laporan Kartu Hutang</h3>
                    </div>
                    @include('pembelian.laporan.kartuhutang')
                </div>

                <div id="panel-auh" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path></svg>
                        <h3 class="font-bold text-base">Analisa Umur Hutang</h3>
                    </div>
                    @include('pembelian.laporan.auh')
                </div>

                <div id="panel-bahankemasan" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <h3 class="font-bold text-base">Laporan Bahan Kemasan</h3>
                    </div>
                    @include('pembelian.laporan.bahankemasan')
                </div>

                <div id="panel-rekapbahankemasan" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h3 class="font-bold text-base">Rekap Bahan Kemasan / Supplier</h3>
                    </div>
                    @include('pembelian.laporan.rekapbahankemasan')
                </div>

                <div id="panel-jurnalkoreksi" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <h3 class="font-bold text-base">Laporan Jurnal Koreksi</h3>
                    </div>
                    @include('pembelian.laporan.jurnalkoreksi')
                </div>

                <div id="panel-rekapakun" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <h3 class="font-bold text-base">Rekap Akun</h3>
                    </div>
                    @include('pembelian.laporan.rekapakun')
                </div>

                <div id="panel-rekapkontrabon" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="font-bold text-base">Rekap Kontrabon</h3>
                    </div>
                    @include('pembelian.laporan.rekapkontrabon')
                </div>

                <div id="panel-rekappo" class="tab-panel hidden p-6">
                    <div class="flex items-center gap-2 text-[#294C9A] pb-4 mb-4 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <h3 class="font-bold text-base">Rekap PO</h3>
                    </div>
                    @include('pembelian.laporan.rekappo')
                </div>
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
            function validatePeriode(formId, dariFieldId = "dari", sampaiFieldId = "sampai") {
                $(`#${formId}`).submit(function() {
                    const dari = $(this).find(`#${dariFieldId}`).val();
                    const sampai = $(this).find(`#${sampaiFieldId}`).val();
                    if (dari == "") {
                        Swal.fire({
                            title: "Oops!",
                            text: 'Periode Dari Harus Diisi !',
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                            buttonsStyling: false,
                            didClose: () => $(this).find(`#${dariFieldId}`).focus(),
                        });
                        return false;
                    } else if (sampai == "") {
                        Swal.fire({
                            title: "Oops!",
                            text: 'Periode Sampai Harus Diisi !',
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
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
                            customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                            buttonsStyling: false,
                            didClose: () => $(this).find(`#${sampaiFieldId}`).focus(),
                        });
                        return false;
                    }
                });
            }

            // Bind validations
            validatePeriode("formLapPembelian", "dari_pembelian", "sampai_pembelian");
            validatePeriode("formLapPembayaran", "dari_pembayaran", "sampai_pembayaran");
            validatePeriode("formLapRekapSupplier", "dari_rekapsupplier", "sampai_rekapsupplier");
            validatePeriode("formLapRekapPembelian", "dari_rekappembelian", "sampai_rekappembelian");
            validatePeriode("formLapKartuHutang", "dari_kartuhutang", "sampai_kartuhutang");
            validatePeriode("formLapAuh", "dari_auh", "sampai_auh");
            validatePeriode("formLapBahanKemasan", "dari_bahankemasan", "sampai_bahankemasan");
            validatePeriode("formLapRekapBahanKemasan", "dari_rekapbahankemasan", "sampai_rekapbahankemasan");
            validatePeriode("formLapJurnalKoreksi", "dari_jurnalkoreksi", "sampai_jurnalkoreksi");
            validatePeriode("formLapRekapAkun", "dari_rekapakun", "sampai_rekapakun");
            validatePeriode("formLapRekapKontrabon", "dari_rekapkontrabon", "sampai_rekapkontrabon");
            validatePeriode("formLapRekapPo", "dari_rekappo", "sampai_rekappo");

            // Select2 Initializations
            $(".select2Kodesupplier, .select2Kodebarang, .select2Kodesupplierpembayaran, .select2Kodeakun").each(function() {
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
