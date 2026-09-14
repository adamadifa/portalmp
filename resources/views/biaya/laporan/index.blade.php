<x-app-layout>
    <x-slot name="header">
        Laporan Biaya
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
        height: 36px !important;
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

    /* ── Flatpickr Theme ───────────────── */
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
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Laporan Biaya</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola dan mencetak laporan transaksi biaya operasional, histori pembayaran, dan rekapitulasi akun.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Sidebar Navigation Tabs -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-3 space-y-1">
            <button type="button" data-tab="biaya" class="tab-btn active w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-[#294C9A] bg-blue-50/80 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-[#294C9A] text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Laporan Biaya</span>
                    <span class="text-[11px] font-normal text-gray-500">Detail rincian transaksi biaya</span>
                </div>
            </button>

            <button type="button" data-tab="pembayaran" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Laporan Pembayaran</span>
                    <span class="text-[11px] font-normal text-gray-500">Histori pembayaran per bank</span>
                </div>
            </button>

            <button type="button" data-tab="rekapakun" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 transition-all text-left">
                <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center shrink-0 tab-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-bold">Rekap Akun (COA)</span>
                    <span class="text-[11px] font-normal text-gray-500">Rekap total per kode akun</span>
                </div>
            </button>
        </div>

        <!-- Form Content Container -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <!-- 1. Tab Laporan Biaya -->
            <div id="tab-biaya" class="tab-pane block">
                <div class="border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-base font-bold text-gray-800">Filter Laporan Transaksi Biaya</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Tentukan parameter tanggal dan filter untuk mencetak data biaya.</p>
                </div>
                <form action="{{ route('laporanbiaya.cetakbiaya') }}" method="POST" target="_blank" class="space-y-4">
                    @csrf
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <select name="kode_supplier" id="kode_supplier_biaya" class="select2-filter">
                            <option value="">Semua Supplier / Rekanan</option>
                            @foreach ($supplier as $d)
                                <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
                            @endforeach
                        </select>
                        <label class="c-fl-label">Supplier / Rekanan</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </span>
                        <select name="kode_akun" id="kode_akun_biaya" class="select2-filter">
                            <option value="">Semua Kode Akun (COA)</option>
                            @foreach ($akun as $d)
                                <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                            @endforeach
                        </select>
                        <label class="c-fl-label">Akun (COA)</label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            <select name="kode_cabang" class="fi">
                                <option value="">Semua Cabang</option>
                                @foreach ($cabang as $c)
                                    <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }}</option>
                                @endforeach
                            </select>
                            <label class="c-fl-label">Cabang</label>
                        </div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <select name="ppn" class="fi">
                                <option value="">PPN / NON PPN</option>
                                <option value="1">PPN</option>
                                <option value="0">NON PPN</option>
                            </select>
                            <label class="c-fl-label">Status PPN</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="dari" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
                            <label class="c-fl-label">Dari Tanggal *</label>
                        </div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="sampai" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
                            <label class="c-fl-label">Sampai Tanggal *</label>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3">
                        <button type="submit" name="submitButton" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan
                        </button>
                        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export Excel
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. Tab Laporan Pembayaran -->
            <div id="tab-pembayaran" class="tab-pane hidden">
                <div class="border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-base font-bold text-gray-800">Filter Laporan Pembayaran Biaya</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Tentukan parameter untuk mencetak riwayat pembayaran kas & bank.</p>
                </div>
                <form action="{{ route('laporanbiaya.cetakpembayaran') }}" method="POST" target="_blank" class="space-y-4">
                    @csrf
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <select name="kode_supplier" class="select2-filter">
                            <option value="">Semua Supplier / Rekanan</option>
                            @foreach ($supplier as $d)
                                <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
                            @endforeach
                        </select>
                        <label class="c-fl-label">Supplier / Rekanan</label>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </span>
                            <select name="kode_bank" class="fi">
                                <option value="">Semua Bank / Kas</option>
                                @foreach ($bank as $b)
                                    <option value="{{ $b->kode_bank }}">{{ $b->kode_bank }} - {{ $b->nama_bank }}</option>
                                @endforeach
                            </select>
                            <label class="c-fl-label">Bank / Kas</label>
                        </div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            <select name="kode_cabang" class="fi">
                                <option value="">Semua Cabang</option>
                                @foreach ($cabang as $c)
                                    <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }}</option>
                                @endforeach
                            </select>
                            <label class="c-fl-label">Cabang</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="dari" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
                            <label class="c-fl-label">Dari Tanggal *</label>
                        </div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="sampai" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
                            <label class="c-fl-label">Sampai Tanggal *</label>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3">
                        <button type="submit" name="submitButton" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan
                        </button>
                        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export Excel
                        </button>
                    </div>
                </form>
            </div>

            <!-- 3. Tab Rekap Akun -->
            <div id="tab-rekapakun" class="tab-pane hidden">
                <div class="border-b border-gray-100 pb-4 mb-5">
                    <h3 class="text-base font-bold text-gray-800">Rekapitulasi Akun (COA) Biaya</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Merekap total akumulasi biaya per pos akun (COA) untuk periode yang dipilih.</p>
                </div>
                <form action="{{ route('laporanbiaya.cetakrekapakun') }}" method="POST" target="_blank" class="space-y-4">
                    @csrf
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </span>
                        <select name="kode_cabang" class="fi">
                            <option value="">Semua Cabang</option>
                            @foreach ($cabang as $c)
                                <option value="{{ $c->kode_cabang }}">{{ $c->nama_cabang }}</option>
                            @endforeach
                        </select>
                        <label class="c-fl-label">Cabang</label>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="dari" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
                            <label class="c-fl-label">Dari Tanggal *</label>
                        </div>
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="text" name="sampai" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off" />
                            <label class="c-fl-label">Sampai Tanggal *</label>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3">
                        <button type="submit" name="submitButton" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Rekap
                        </button>
                        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-filter').select2({
                width: '100%'
            });

            flatpickr(".flatpickr-date", {
                locale: "id",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                allowInput: true
            });

            $('.tab-btn').on('click', function() {
                var targetTab = $(this).data('tab');

                // Update tab buttons style
                $('.tab-btn').removeClass('active text-[#294C9A] bg-blue-50/80')
                    .addClass('text-gray-600 hover:bg-gray-50');
                $('.tab-btn .tab-icon').removeClass('bg-[#294C9A] text-white').addClass('bg-gray-100 text-gray-600');

                $(this).addClass('active text-[#294C9A] bg-blue-50/80').removeClass('text-gray-600 hover:bg-gray-50');
                $(this).find('div:first').removeClass('bg-gray-100 text-gray-600').addClass('bg-[#294C9A] text-white');

                // Switch visible pane
                $('.tab-pane').addClass('hidden').removeClass('block');
                $('#tab-' + targetTab).removeClass('hidden').addClass('block');
            });
        });
    </script>
    @endpush
</x-app-layout>
