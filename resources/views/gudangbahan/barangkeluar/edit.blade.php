<style>
/* ── Isolated Floating Label & Icon Group ──────────── */
.c-fl-group {
    position: relative !important;
    width: 100% !important;
    margin-top: 4px !important;
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

/* Notched Label: Centered exactly on the top border line of input */
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

/* Background cut for Detail Barang section card (bg-gray-50) */
.c-fl-label-detail {
    background-color: #F9FAFB !important;
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
.fi.text-right {
    text-align: right !important;
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

/* Header Month & Navigation */
.flatpickr-months {
    background: linear-gradient(135deg, #294C9A 0%, #1E3A70 100%) !important;
    padding: 8px 10px !important;
    align-items: center !important;
    border-radius: 15px 15px 0 0 !important;
}
.flatpickr-months .flatpickr-month {
    color: #ffffff !important;
    height: 38px !important;
}
.flatpickr-current-month {
    font-size: 14px !important;
    font-weight: 700 !important;
    color: #ffffff !important;
    padding-top: 4px !important;
}
.flatpickr-current-month .flatpickr-monthDropdown-months {
    font-weight: 700 !important;
    color: #ffffff !important;
    background: transparent !important;
    padding: 2px 6px !important;
    border-radius: 6px !important;
    margin-right: 4px !important;
}
.flatpickr-current-month .flatpickr-monthDropdown-months:hover {
    background: rgba(255, 255, 255, 0.18) !important;
}
.flatpickr-current-month input.cur-year {
    font-weight: 700 !important;
    color: #ffffff !important;
}
.flatpickr-months .flatpickr-prev-month,
.flatpickr-months .flatpickr-next-month {
    padding: 8px !important;
    color: #ffffff !important;
    fill: #ffffff !important;
    border-radius: 8px !important;
    transition: background 0.15s ease !important;
}
.flatpickr-months .flatpickr-prev-month:hover,
.flatpickr-months .flatpickr-next-month:hover {
    background: rgba(255, 255, 255, 0.20) !important;
}
.flatpickr-months .flatpickr-prev-month svg,
.flatpickr-months .flatpickr-next-month svg {
    fill: #ffffff !important;
    width: 14px !important;
    height: 14px !important;
}

/* Weekday header */
.flatpickr-weekdays {
    background: #F3F4F6 !important;
    padding: 8px 0 !important;
    border-bottom: 1px solid #E5E7EB !important;
}
span.flatpickr-weekday {
    color: #294C9A !important;
    font-weight: 700 !important;
    font-size: 11px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
}

/* Days container & High Contrast Day Buttons */
.flatpickr-days {
    width: 307px !important;
    padding: 6px !important;
}
.dayContainer {
    width: 294px !important;
    min-width: 294px !important;
    max-width: 294px !important;
}
.flatpickr-day {
    color: #111827 !important;
    font-weight: 700 !important;
    font-size: 13px !important;
    border-radius: 10px !important;
    height: 38px !important;
    line-height: 38px !important;
    max-width: 38px !important;
    margin: 2px !important;
    border: 1px solid transparent !important;
    transition: all 0.15s ease !important;
}
.flatpickr-day:hover {
    background: #EBF1FF !important;
    color: #294C9A !important;
    font-weight: 800 !important;
    border-color: #BFDBFE !important;
}
.flatpickr-day.today {
    border: 2px solid #294C9A !important;
    color: #294C9A !important;
    font-weight: 800 !important;
    background: #F0F4FF !important;
}
.flatpickr-day.selected,
.flatpickr-day.selected:hover {
    background: linear-gradient(135deg, #294C9A 0%, #1E3A70 100%) !important;
    color: #ffffff !important;
    font-weight: 800 !important;
    box-shadow: 0 4px 12px rgba(41, 76, 154, 0.40) !important;
    border: none !important;
}
.flatpickr-day.flatpickr-disabled,
.flatpickr-day.flatpickr-disabled:hover,
.flatpickr-day.prevMonthDay,
.flatpickr-day.nextMonthDay {
    color: #9CA3AF !important;
    font-weight: 500 !important;
    opacity: 0.55 !important;
    background: transparent !important;
    border-color: transparent !important;
}

/* ── Section header ─────────────────────────── */
.sec-head {
    font-size: 10px;
    font-weight: 700;
    color: #294C9A;
    text-transform: uppercase;
    letter-spacing: .08em;
    padding-bottom: 8px;
    border-bottom: 1px solid #E5E7EB;
    margin-bottom: 18px;
}
</style>

<form action="{{ route('barangkeluargudangbahan.update', Crypt::encrypt($barangkeluar->no_bukti)) }}" method="POST" id="formeditBarangkeluargudangbahan" novalidate class="pt-2">
    @method('PUT')
    @csrf
    <input type="hidden" name="cektutuplaporan" id="cektutuplaporan" value="" />

    <!-- Header row: 3 columns -->
    <div class="grid grid-cols-3 gap-3 mb-4 pt-2">
        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </span>
            <input type="text" name="no_bukti" id="no_bukti" class="fi bg-gray-100/60" value="{{ $barangkeluar->no_bukti }}" readonly autocomplete="off" />
            <label for="no_bukti" class="c-fl-label">No. Bukti Pengeluaran</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </span>
            <input type="text" name="tanggal" id="tanggal" class="fi flatpickr-date" value="{{ $barangkeluar->tanggal }}" placeholder="Pilih Tanggal" autocomplete="off" />
            <label for="tanggal" class="c-fl-label">Tanggal *</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
            </span>
            <select name="kode_jenis_pengeluaran" id="kode_jenis_pengeluaran" class="fi">
                <option value="">Jenis Pengeluaran</option>
                @foreach ($list_jenis_pengeluaran as $d)
                    <option value="{{ $d['kode_jenis_pengeluaran'] }}" {{ $barangkeluar->kode_jenis_pengeluaran == $d['kode_jenis_pengeluaran'] ? 'selected' : '' }}>
                        {{ $d['jenis_pengeluaran'] }}
                    </option>
                @endforeach
            </select>
            <label for="kode_jenis_pengeluaran" class="c-fl-label">Jenis Pengeluaran *</label>
        </div>
    </div>

    <!-- Dynamic Section: Cabang / Unit / Keterangan -->
    <div class="grid grid-cols-1 gap-3 mb-4">
        <!-- Cabang Section -->
        <div class="c-fl-group" id="cabang-section" style="display: none;">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V9a1 1 0 011-1h2a1 1 0 011 1v12"/>
                </svg>
            </span>
            <select name="kode_cabang" id="kode_cabang" class="select2Kodecabang">
                <option value=""></option>
                @foreach ($cabang as $d)
                    <option value="{{ $d->kode_cabang }}" {{ $barangkeluar->kode_cabang == $d->kode_cabang ? 'selected' : '' }}>{{ strtoupper($d->nama_cabang) }}</option>
                @endforeach
            </select>
            <label for="kode_cabang" class="c-fl-label">Pilih Cabang *</label>
        </div>

        <!-- Unit Section -->
        <div class="c-fl-group" id="unit-section" style="display: none;">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </span>
            <select name="unit" id="unit" class="fi">
                <option value="">Unit</option>
                <option value="1" {{ $barangkeluar->keterangan == 1 ? 'selected' : '' }}>Unit 1</option>
                <option value="2" {{ $barangkeluar->keterangan == 2 ? 'selected' : '' }}>Unit 2</option>
            </select>
            <label for="unit" class="c-fl-label">Pilih Unit *</label>
        </div>

        <!-- Keterangan Header Section -->
        <div class="c-fl-group" id="keterangan-section">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </span>
            <input type="text" name="keterangan_barang_keluar" id="keterangan_barang_keluar" class="fi" value="{{ $barangkeluar->keterangan }}" placeholder="Keterangan pengeluaran..." autocomplete="off" />
            <label for="keterangan_barang_keluar" class="c-fl-label">Keterangan Pengeluaran</label>
        </div>
    </div>

    <!-- Detail Barang -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-3">
        <div class="sec-head">Detail Barang</div>

        <!-- Single row for Pilih Barang, Qty Unit, Qty Berat, Qty Lebih -->
        <div class="grid grid-cols-12 gap-3 mb-4 pt-2">
            <div class="c-fl-group col-span-6">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </span>
                <select name="kode_barang" id="kode_barang" class="select2Kodebarang">
                    <option value=""></option>
                    @foreach ($barang as $d)
                        <option value="{{ $d->kode_barang }}">{{ $d->kode_barang }} | {{ $d->nama_barang }}</option>
                    @endforeach
                </select>
                <label for="kode_barang" class="c-fl-label c-fl-label-detail">Pilih Barang *</label>
            </div>

            <div class="c-fl-group col-span-2">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                </span>
                <input type="text" id="qty_unit" class="fi text-right number-separator" placeholder="0" autocomplete="off" />
                <label for="qty_unit" class="c-fl-label c-fl-label-detail">Qty Unit</label>
            </div>

            <div class="c-fl-group col-span-2">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006 0l-3-9zm0 0h6m-6 0l10.5 3.5M12 20a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                </span>
                <input type="text" id="qty_berat" class="fi text-right number-separator" placeholder="0" autocomplete="off" />
                <label for="qty_berat" class="c-fl-label c-fl-label-detail">Qty Berat</label>
            </div>

            <div class="c-fl-group col-span-2">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <input type="text" id="qty_lebih" class="fi text-right number-separator" placeholder="0" autocomplete="off" />
                <label for="qty_lebih" class="c-fl-label c-fl-label-detail">Qty Lebih</label>
            </div>
        </div>

        <!-- Row 2: Keterangan & Button Tambah Barang -->
        <div class="flex items-center gap-3 pt-1">
            <div class="c-fl-group flex-1">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </span>
                <input type="text" id="keterangan" class="fi" placeholder="Keterangan (opsional)" autocomplete="off" />
                <label for="keterangan" class="c-fl-label c-fl-label-detail">Keterangan</label>
            </div>

            <button type="button" id="tambahproduk"
                class="inline-flex items-center gap-1.5 px-4 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-md transition shadow-sm shrink-0 h-[38px] mt-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Barang
            </button>
        </div>
    </div>

    <!-- Items Table -->
    <div class="border border-gray-200 rounded-lg overflow-hidden mb-3">
        <div class="overflow-x-auto max-h-[28vh] overflow-y-auto">
            <table class="w-full text-left border-collapse text-xs" id="tabledetail">
                <thead>
                    <tr class="bg-[#294C9A] text-white text-[10px] uppercase tracking-wider">
                        <th class="py-2 px-3 sticky top-0 bg-[#294C9A] z-10" style="width: 15%">Kode</th>
                        <th class="py-2 px-3 sticky top-0 bg-[#294C9A] z-10" style="width: 30%">Nama Barang</th>
                        <th class="py-2 px-3 text-right sticky top-0 bg-[#294C9A] z-10">Qty Unit</th>
                        <th class="py-2 px-3 text-right sticky top-0 bg-[#294C9A] z-10">Qty Berat</th>
                        <th class="py-2 px-3 text-right sticky top-0 bg-[#294C9A] z-10">Qty Lebih</th>
                        <th class="py-2 px-3 sticky top-0 bg-[#294C9A] z-10" style="width: 20%">Keterangan</th>
                        <th class="py-2 px-3 text-center sticky top-0 bg-[#294C9A] z-10">#</th>
                    </tr>
                </thead>
                <tbody id="loaddetail" class="divide-y divide-gray-100 text-xs">
                    @foreach ($detail as $d)
                        @php $index = rand(10, 10000); @endphp
                        <tr id="index_{{ $index }}" class="odd:bg-white even:bg-gray-50 hover:bg-blue-50/40 transition-colors">
                            <td class="py-1.5 px-3 font-semibold text-[#294C9A]">
                                <input type="hidden" name="kode_barang[]" value="{{ $d->kode_barang }}"/>
                                {{ $d->kode_barang }}
                            </td>
                            <td class="py-1.5 px-3 text-gray-700">{{ strtoupper($d->nama_barang) }}</td>
                            <td class="py-1.5 px-3 text-right font-semibold">
                                <input type="text" name="qty_unit[]" value="{{ formatAngkaDesimal($d->qty_unit) }}" class="fi text-right qty_unit number-separator h-7 py-0 px-2 text-xs" />
                            </td>
                            <td class="py-1.5 px-3 text-right font-semibold">
                                <input type="text" name="qty_berat[]" value="{{ formatAngkaDesimal($d->qty_berat) }}" class="fi text-right qty_berat number-separator h-7 py-0 px-2 text-xs" />
                            </td>
                            <td class="py-1.5 px-3 text-right font-semibold">
                                <input type="text" name="qty_lebih[]" value="{{ formatAngkaDesimal($d->qty_lebih) }}" class="fi text-right qty_lebih number-separator h-7 py-0 px-2 text-xs" />
                            </td>
                            <td class="py-1.5 px-3 text-gray-500">
                                <input type="hidden" name="ket[]" value="{{ $d->keterangan }}"/>{{ $d->keterangan }}
                            </td>
                            <td class="py-1.5 px-3 text-center">
                                <button type="button" data-index="{{ $index }}" class="delete-row text-red-500 hover:bg-red-50 p-1 rounded transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
        <label class="flex items-center gap-2 text-xs font-medium text-gray-600 cursor-pointer select-none">
            <input class="w-3.5 h-3.5 text-[#294C9A] border-gray-300 rounded focus:ring-[#294C9A] agreement"
                name="aggrement" value="aggrement" type="checkbox" />
            <span>Yakin Akan Disimpan?</span>
        </label>
        <div id="saveButton" style="display:none;">
            <button class="inline-flex items-center gap-1.5 px-5 py-1.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-md transition shadow-sm"
                type="submit" id="btnSimpan">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<script>
$(function() {
    const form = $("#formeditBarangkeluargudangbahan");

    // Select2 — Cabang
    $('#kode_cabang').select2({
        placeholder: 'Pilih Cabang *',
        allowClear: true,
        dropdownParent: $('#modalEdit')
    });

    // Select2 — Kode Barang
    $('#kode_barang').select2({
        placeholder: 'Cari kode / nama barang...',
        allowClear: true,
        dropdownParent: $('#modalEdit')
    });

    // Flatpickr
    flatpickr(".flatpickr-date", {
        dateFormat: "Y-m-d",
        locale: "id",
        enable: [{ from: "{{ $start_periode }}", to: "{{ $end_periode }}" }]
    });

    // Number separator
    if (typeof easyNumberSeparator === 'function') {
        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });
    }

    function loadketerangan() {
        const kode_jenis_pengeluaran = $("#kode_jenis_pengeluaran").val();
        if (kode_jenis_pengeluaran == "CBG" || kode_jenis_pengeluaran == "PRD") {
            form.find("#keterangan-section").hide();
        } else {
            form.find("#keterangan-section").show();
        }
    }

    function loadkodecabang() {
        const kode_jenis_pengeluaran = $("#kode_jenis_pengeluaran").val();
        if (kode_jenis_pengeluaran == "CBG") {
            form.find("#cabang-section").show();
        } else {
            form.find("#cabang-section").hide();
        }
    }

    function loadunit() {
        const kode_jenis_pengeluaran = $("#kode_jenis_pengeluaran").val();
        if (kode_jenis_pengeluaran == "PRD") {
            form.find("#unit-section").show();
        } else {
            form.find("#unit-section").hide();
        }
    }

    loadkodecabang();
    loadunit();
    loadketerangan();

    $("#kode_jenis_pengeluaran").change(function() {
        loadkodecabang();
        loadunit();
        loadketerangan();
    });

    function cektutuplaporan(tanggal, jenis_laporan) {
        $.ajax({
            type: "POST",
            url: "/tutuplaporan/cektutuplaporan",
            data: {
                _token: "{{ csrf_token() }}",
                tanggal: tanggal,
                jenis_laporan: jenis_laporan
            },
            cache: false,
            success: function(respond) {
                $("#cektutuplaporan").val(respond);
            }
        });
    }

    $("#tanggal").change(function(e) {
        cektutuplaporan($(this).val(), "gudangbahan");
    });

    function addProduk() {
        const dataBarang = $("#kode_barang :selected");
        const kode_barang = dataBarang.val();
        const parts = dataBarang.text().split("|");
        const nama_barang = parts[1] ? parts[1].trim() : dataBarang.text();
        const qty_unit = $("#qty_unit").val() || 0;
        const qty_berat = $("#qty_berat").val() || 0;
        const qty_lebih = $("#qty_lebih").val() || 0;
        const keterangan = $("#keterangan").val();
        const index = Math.floor(Math.random() * 10000);

        let produk = `
            <tr id="index_${index}" class="odd:bg-white even:bg-gray-50 hover:bg-blue-50/40 transition-colors">
                <td class="py-1.5 px-3 font-semibold text-[#294C9A]">
                    <input type="hidden" name="kode_barang[]" value="${kode_barang}"/>
                    ${kode_barang}
                </td>
                <td class="py-1.5 px-3 text-gray-700">${nama_barang}</td>
                <td class="py-1.5 px-3 text-right font-semibold">
                    <input type="text" name="qty_unit[]" value="${qty_unit}" class="fi text-right qty_unit number-separator h-7 py-0 px-2 text-xs" />
                </td>
                <td class="py-1.5 px-3 text-right font-semibold">
                    <input type="text" name="qty_berat[]" value="${qty_berat}" class="fi text-right qty_berat number-separator h-7 py-0 px-2 text-xs" />
                </td>
                <td class="py-1.5 px-3 text-right font-semibold">
                    <input type="text" name="qty_lebih[]" value="${qty_lebih}" class="fi text-right qty_lebih number-separator h-7 py-0 px-2 text-xs" />
                </td>
                <td class="py-1.5 px-3 text-gray-500">
                    <input type="hidden" name="ket[]" value="${keterangan}"/>${keterangan}
                </td>
                <td class="py-1.5 px-3 text-center">
                    <button type="button" data-index="${index}" class="delete-row text-red-500 hover:bg-red-50 p-1 rounded transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </td>
            </tr>
        `;

        $('#loaddetail').prepend(produk);
        $('#kode_barang').val('').trigger("change");
        $("#qty_unit,#qty_berat,#qty_lebih,#keterangan").val("");
    }

    $("#tambahproduk").click(function(e) {
        e.preventDefault();
        const kode_barang = $("#kode_barang").val();
        if (kode_barang == "") {
            Swal.fire({
                title: "Oops!",
                text: "Silahkan Pilih dulu Barang !",
                icon: "warning",
                customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                buttonsStyling: false
            });
        } else {
            addProduk();
        }
    });

    $(document).on('click', '.delete-row', function(e) {
        e.preventDefault();
        $(`#index_${$(this).data("index")}`).remove();
    });

    $('.agreement').change(function() {
        $("#saveButton").toggle(this.checked);
    });

    form.submit(function() {
        const no_bukti = $("#no_bukti").val();
        const tanggal = $("#tanggal").val();
        const kode_jenis_pengeluaran = $("#kode_jenis_pengeluaran").val();
        const cektutuplaporan = $("#cektutuplaporan").val();

        if (cektutuplaporan > 0) {
            Swal.fire({
                title: "Oops!",
                text: "Laporan Sudah Ditutup !",
                icon: "warning",
                customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                buttonsStyling: false
            });
            return false;
        } else if (tanggal == "") {
            Swal.fire({
                title: "Oops!",
                text: "Tanggal Harus Diisi !",
                icon: "warning",
                customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                buttonsStyling: false
            });
            return false;
        } else if (kode_jenis_pengeluaran == "") {
            Swal.fire({
                title: "Oops!",
                text: "Jenis Pengeluaran Harus Diisi !",
                icon: "warning",
                customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                buttonsStyling: false
            });
            return false;
        } else if ($('#loaddetail tr').length == 0) {
            Swal.fire({
                title: "Oops!",
                text: "Data Barang Masih Kosong !",
                icon: "warning",
                customClass: { confirmButton: 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                buttonsStyling: false
            });
            return false;
        }
    });
});
</script>
