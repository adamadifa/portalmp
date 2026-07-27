<x-app-layout>
    <x-slot name="header">
        Input Pembelian
    </x-slot>

    <style>
    /* ── Isolated Floating Label & Icon Group ──────────── */
    .c-fl-group {
        position: relative !important;
        width: 100% !important;
        margin-top: 10px !important;
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

    /* Select2 Alignment */
    .select2-container { width: 100% !important; }
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        background-color: #ffffff !important;
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        padding-top: 0 !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #294C9A !important;
        box-shadow: 0 0 0 3px rgba(41, 76, 154, 0.10) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: flex !important;
        align-items: center !important;
        height: 100% !important;
        line-height: normal !important;
        padding-left: 34px !important;
        padding-right: 32px !important;
        font-size: 12px !important;
        color: #111827 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute !important;
        top: 50% !important;
        right: 10px !important;
        transform: translateY(-50%) !important;
        height: 16px !important;
        width: 16px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        border-color: #6B7280 transparent transparent transparent !important;
        border-style: solid !important;
        border-width: 5px 4px 0 4px !important;
    }

    /* DataTable Style Customization */
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 16px !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        outline: none !important;
        font-size: 12px !important;
        margin-left: 8px !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #294C9A !important;
        box-shadow: 0 0 0 3px rgba(41, 76, 154, 0.10) !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        padding: 4px 8px !important;
        outline: none !important;
        font-size: 12px !important;
    }
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 12px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 4px 10px !important;
        margin: 0 2px !important;
        border-radius: 6px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        transition: all 0.15s !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #294C9A !important;
        color: white !important;
        border: 1px solid #294C9A !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #EEF2FF !important;
        color: #294C9A !important;
        border: 1px solid #D1D5DB !important;
    }
    </style>

    <!-- Header & Navigation -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Input Pembelian</h2>
            <p class="text-sm text-gray-500 mt-1">Registrasi transaksi pembelian barang baru.</p>
        </div>
        <a href="{{ route('pembelian.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('pembelian.store') }}" method="POST" id="formPembelian">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Panel: General Info Form -->
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="no_bukti" id="no_bukti" class="fi" placeholder="No. Bukti" autocomplete="off" />
                        <label for="no_bukti" class="c-fl-label">No. Bukti *</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="tanggal" id="tanggal" class="fi flatpickr-date" placeholder="Tanggal" autocomplete="off" />
                        <label for="tanggal" class="c-fl-label">Tanggal *</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </span>
                        <select name="kode_supplier" id="kode_supplier" class="fi select2Kodesupplier">
                            <option value="">Supplier</option>
                            @foreach ($supplier as $d)
                                <option value="{{ $d->kode_supplier }}">{{ strtoupper($d->nama_supplier) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </span>
                        <select name="kode_asal_pengajuan" id="kode_asal_pengajuan" class="fi">
                            <option value="">Asal Ajuan</option>
                            @foreach ($asal_ajuan as $d)
                                <option value="{{ $d['kode_group'] }}">
                                    {{ $d['nama_group'] }}
                                </option>
                            @endforeach
                        </select>
                        <label for="kode_asal_pengajuan" class="c-fl-label">Asal Ajuan</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </span>
                        <select name="jenis_transaksi" id="jenis_transaksi" class="fi">
                            <option value="">Tunai / Kredit</option>
                            <option value="T">Tunai</option>
                            <option value="K">Kredit</option>
                        </select>
                        <label for="jenis_transaksi" class="c-fl-label">Tunai / Kredit</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="jatuh_tempo" id="jatuh_tempo" class="fi flatpickr-date" placeholder="Jatuh Tempo" autocomplete="off" />
                        <label for="jatuh_tempo" class="c-fl-label">Jatuh Tempo</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </span>
                        <select name="no_po" id="no_po" class="fi select2PO">
                            <option value="">No PO</option>
                        </select>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-gray-700 block mb-2">PPN</span>
                        <div class="flex items-center gap-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="ppn" id="ppn1" value="1" class="rounded-full border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
                                <span class="ml-2 text-xs">Ya</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="ppn" id="ppn2" value="0" checked class="rounded-full border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
                                <span class="ml-2 text-xs">Tidak</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-gray-700 block mb-2">Kategori Transaksi</span>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="kategori_transaksi" id="inlineRadio1" value="MP" class="rounded-full border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
                                <span class="ml-2 text-xs">MP</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="kategori_transaksi" id="inlineRadio2" value="PC" class="rounded-full border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
                                <span class="ml-2 text-xs">Pacific</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="kategori_transaksi" id="inlineRadio3" value="PB" class="rounded-full border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
                                <span class="ml-2 text-xs">Pribadi</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="kategori_transaksi" id="inlineRadio4" value="IP" class="rounded-full border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
                                <span class="ml-2 text-xs">IP</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Input items & Data details -->
            <div class="lg:col-span-9 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <h3 class="font-bold text-base text-gray-900">Detail Barang Pembelian</h3>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-xs text-gray-500 font-medium">Grand Total:</span>
                            <span id="grandtotal_text" class="text-base font-bold text-[#294C9A]">0</span>
                        </div>
                    </div>

                    <!-- Input Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                        <div class="md:col-span-3">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </span>
                                <input type="text" name="nama_barang" id="nama_barang" class="fi cursor-pointer" placeholder="Klik Pilih Barang" readonly />
                                <input type="hidden" id="kode_barang" name="kode_barang">
                                <label for="nama_barang" class="c-fl-label">Pilih Barang</label>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                </span>
                                <input type="text" name="jumlah" id="jumlah" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                                <label for="jumlah" class="c-fl-label">Qty</label>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                                </span>
                                <input type="text" name="harga" id="harga" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                                <label for="harga" class="c-fl-label">Harga</label>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                                </span>
                                <input type="text" name="penyesuaian" id="penyesuaian" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                                <label for="penyesuaian" class="c-fl-label">Penyesuaian</label>
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </span>
                                <select name="kode_akun" id="kode_akun" class="fi select2Kodeakun">
                                    <option value="">Akun</option>
                                    @foreach ($coa as $d)
                                        <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                        <div class="md:col-span-8">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </span>
                                <input type="text" name="keterangan" id="keterangan" class="fi" placeholder="Keterangan" autocomplete="off" />
                                <label for="keterangan" class="c-fl-label">Keterangan</label>
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <select name="kode_cabang" id="kode_cabang" class="fi select2Kodecabang">
                                    <option value="">Cabang</option>
                                    @foreach ($cabang as $d)
                                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btnTambahbarang" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-[#294C9A] bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-xl transition shadow-sm gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Barang
                    </button>

                    <!-- Items Detail Table -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mt-3">
                        <table class="w-full text-xs text-left">
                            <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                                <tr>
                                    <th class="px-3 py-2.5">Kode</th>
                                    <th class="px-3 py-2.5">Nama Barang</th>
                                    <th class="px-3 py-2.5 text-center">Qty</th>
                                    <th class="px-3 py-2.5 text-right">Harga</th>
                                    <th class="px-3 py-2.5 text-right">Subtotal</th>
                                    <th class="px-3 py-2.5 text-right">Peny</th>
                                    <th class="px-3 py-2.5 text-right">Total</th>
                                    <th class="px-3 py-2.5">Akun</th>
                                    <th class="px-3 py-2.5">Cabang</th>
                                    <th class="px-3 py-2.5 text-center">#</th>
                                </tr>
                            </thead>
                            <tbody id="loadbarang" class="divide-y divide-gray-100 bg-white"></tbody>
                            <tfoot class="bg-gray-50 text-gray-900 border-t border-gray-200 font-bold">
                                <tr>
                                    <td colspan="6" class="px-3 py-2.5">TOTAL</td>
                                    <td id="grandtotal" class="px-3 py-2.5 text-right">0</td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Agreement & Submit Button -->
                    <div class="pt-4 border-t border-gray-100 flex flex-col gap-3">
                        <label class="inline-flex items-center text-xs text-gray-700 font-medium cursor-pointer">
                            <input type="checkbox" name="aggrement" id="defaultCheck3" class="agreement rounded border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" value="aggrement" />
                            <span class="ml-2">Yakin Akan Disimpan ?</span>
                        </label>

                        <div id="saveButton" class="hidden">
                            <button type="submit" id="btnSimpan" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                Submit Pembelian
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Data Barang -->
    <div id="modalBarang" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
                <h3 class="text-base font-bold">Data Barang</h3>
                <button type="button" onclick="$('#modalBarang').addClass('hidden')" class="text-white/80 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="w-full text-xs text-left text-gray-600" id="tabelbarang" style="width:100% !important;">
                        <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 font-bold">Kode</th>
                                <th class="px-4 py-3 font-bold">Nama Barang</th>
                                <th class="px-4 py-3 font-bold">Satuan</th>
                                <th class="px-4 py-3 font-bold">Jenis Barang</th>
                                <th class="px-4 py-3 font-bold">Kategori</th>
                                <th class="px-4 py-3 font-bold text-center">#</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@push('myscript')
<script>
    console.log("Pembelian create script tag evaluated.");
    $(document).ready(function() {
        console.log("Pembelian create document ready fired.");
        const form = $("#formPembelian");
        let baris = 0;
        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        form.find("#no_bukti").on('keydown keyup', function(e) {
            if (e.key === ' ') {
                e.preventDefault();
            }
            this.value = this.value.toUpperCase();
        });

        function buttonDisable() {
            $("#btnSimpan").prop('disabled', true);
            $("#btnSimpan").html(`
                <svg class="w-4 h-4 text-white animate-spin me-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Loading..
            `);
        }

        function resetForm() {
            form.find("#kode_barang").val("");
            form.find("#nama_barang").val("");
            form.find("#jumlah").val("");
            form.find("#harga").val("");
            form.find("#penyesuaian").val("");
            form.find('.select2Kodeakun').val('').trigger("change");
            form.find("#keterangan").val("");
            form.find('.select2Kodecabang').val('').trigger("change");
        }

        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Supplier',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2PO = $('.select2PO');
        if (select2PO.length) {
            select2PO.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'No PO',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodeakun = $('.select2Kodeakun');
        if (select2Kodeakun.length) {
            select2Kodeakun.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Akun',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodecabang = $('.select2Kodecabang');
        if (select2Kodecabang.length) {
            select2Kodecabang.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Cabang',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        function loadTablebarang(kode_group = "000") {
            $('#tabelbarang').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: `/barangpembelian/${kode_group}/getbarangjson`,
                bAutoWidth: false,
                bDestroy: true,
                columns: [
                    { data: 'kode_barang', name: 'kode_barang', orderable: true, searchable: true, width: '10%' },
                    { data: 'namabarang', name: 'nama_barang', orderable: true, searchable: true, width: '40%' },
                    { data: 'satuan', name: 'satuan', orderable: true, searchable: false, width: '10%' },
                    { data: 'jenisbarang', name: 'jenisbarang', orderable: true, searchable: false, width: '20%' },
                    { data: 'nama_kategori', name: 'nama_kategori', orderable: true, searchable: false, width: '20%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '5%' }
                ]
            });
        }

        $(document).on('click', "#nama_barang", function(e) {
            console.log("Pilih barang input clicked.");
            let kode_group = form.find("#kode_asal_pengajuan").val();
            if (kode_group == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Asal Pengajuan Harus Diisi Dahulu !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_asal_pengajuan").focus();
                    },
                });
            } else {
                console.log("Loading barang for group:", kode_group);
                loadTablebarang(kode_group);
                $("#modalBarang").removeClass("hidden");
            }
        });

        $('#tabelbarang tbody').on('click', '.pilihBarang', function(e) {
            e.preventDefault();
            const kode_barang = $(this).attr('kode_barang');
            const nama_barang = $(this).attr('nama_barang');
            const kode_jenis_barang = $(this).attr('kode_jenis_barang');

            if(kode_jenis_barang == 'BB'){
                form.find("#kode_akun").val('5-1101').trigger('change');
            }else if(kode_jenis_barang == 'BT'){
                form.find("#kode_akun").val('5-1102').trigger('change');
            } else if(kode_jenis_barang == 'KM'){
                form.find("#kode_akun").val('5-1103').trigger('change');
            } else{
                form.find("#kode_akun").val('');
            }
            form.find("#kode_barang").val(kode_barang);
            form.find("#nama_barang").val(nama_barang);
            $("#modalBarang").addClass("hidden");
            form.find("#jumlah").focus();
        });

        function convertNumber(number) {
            let formatted = number.replace(/\./g, '');
            formatted = formatted.replace(/,/g, '.');
            return formatted || 0;
        }

        function numberFormat(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
                dec = typeof dec_point === 'undefined' ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        function calculateTotal() {
            let grandTotal = 0;
            $('.totalharga').each(function() {
                grandTotal += parseFloat(convertNumber($(this).text())) || 0;
            });
            $('#grandtotal').text(numberFormat(grandTotal, '2', ',', '.'));
            $('#grandtotal_text').text(numberFormat(grandTotal, '2', ',', '.'));
        }

        function addBarang() {
            const kode_barang = form.find("#kode_barang").val();
            const nama_barang = form.find("#nama_barang").val();
            const jumlah = form.find("#jumlah").val();
            const harga = form.find("#harga").val();
            const penyesuaian = form.find("#penyesuaian").val();
            const dataAkun = form.find("#kode_akun :selected").select2(this.data);
            const kode_akun = $(dataAkun).val();
            const nama_akun = $(dataAkun).text();
            const keterangan = form.find("#keterangan").val();
            const kode_cabang = form.find("#kode_cabang").val();

            if (kode_barang == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Barang Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#nama_barang").focus();
                    },
                });
            } else if (jumlah == "" || jumlah === 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Qty Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#jumlah").focus();
                    },
                });
            } else if (harga == "" || harga === 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Harga Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#harga").focus();
                    },
                });
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Akun Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_akun").focus();
                    },
                });
            } else {
                baris = baris + 1;
                let jml = convertNumber(jumlah);
                let hrg = convertNumber(harga);
                let peny = convertNumber(penyesuaian);
                let subtotal = parseFloat(jml) * parseFloat(hrg);
                let total = parseFloat(subtotal) + parseFloat(peny);
                subtotal = numberFormat(subtotal, '2', ',', '.');
                total = numberFormat(total, '2', ',', '.');
                let bg;
                if (kode_akun.substring(0, 3) == '6-1' && kode_cabang != '' || kode_akun.substring(0, 3) == '6-2' && kode_cabang != '') {
                    bg = "bg-blue-50 text-blue-900";
                } else {
                    bg = "";
                }
                let barang = `
                <tr id="index_${baris}" class="${bg} hover:bg-gray-50/80 transition">
                    <td class="px-3 py-2 font-medium text-gray-900">
                        <input type="hidden" name="kode_barang_item[]" value="${kode_barang}" />
                        <input type="hidden" name="jumlah_item[]" value="${jumlah}" />
                        <input type="hidden" name="harga_item[]" value="${harga}" />
                        <input type="hidden" name="penyesuaian_item[]" value="${penyesuaian}" />
                        <input type="hidden" name="kode_akun_item[]" value="${kode_akun}" />
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}" />
                        <input type="hidden" name="kode_cabang_item[]" value="${kode_cabang}" />
                        ${kode_barang}
                    </td>
                    <td class="px-3 py-2 text-gray-700">${nama_barang}</td>
                    <td class="px-3 py-2 text-center text-gray-700">${jumlah}</td>
                    <td class="px-3 py-2 text-right text-gray-700">${harga}</td>
                    <td class="px-3 py-2 text-right text-gray-700">${subtotal}</td>
                    <td class="px-3 py-2 text-right text-gray-700">${penyesuaian}</td>
                    <td class="px-3 py-2 text-right font-bold text-gray-950 totalharga">${total}</td>
                    <td class="px-3 py-2 text-gray-600">${nama_akun}</td>
                    <td class="px-3 py-2 text-center text-gray-600">${kode_cabang}</td>
                    <td class="px-3 py-2 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="#" class="me-1" data-bs-toggle="popover"
                                data-bs-placement="left" data-bs-html="true"
                                data-bs-content="${keterangan}" title="Keterangan"
                                data-bs-custom-class="popover-info">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </a>
                            <a href="#" id="index_${baris}" class="delete">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>`;
                $('#loadbarang').append(barang);
                $('[data-bs-toggle="popover"]').popover();
                calculateTotal();
                resetForm();
            }
        }

        form.find("#btnTambahbarang").click(function(e) {
            e.preventDefault();
            addBarang();
        });

        $("#kode_asal_pengajuan").change(function() {
            resetForm();
            $("#loadbarang").html("");
            calculateTotal();
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            let id = $(this).attr("id");
            Swal.fire({
                title: `Apakah Anda Yakin Ingin Menghapus Data Ini ?`,
                text: "Jika dihapus maka data akan hilang permanent.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#294C9A",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Hapus Saja!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#loadbarang`).find(`#${id}`).remove();
                    calculateTotal();
                }
            });
        });

        form.find('.agreement').change(function() {
            if (this.checked) {
                form.find("#saveButton").removeClass("hidden");
            } else {
                form.find("#saveButton").addClass("hidden");
            }
        });

        form.submit(function() {
            const no_bukti = form.find("#no_bukti").val();
            const tanggal = form.find("#tanggal").val();
            const kode_supplier = form.find("#kode_supplier").val();
            const kode_asal_pengajuan = form.find("#kode_asal_pengajuan").val();
            const jenis_transaksi = form.find("#jenis_transaksi").val();
            const jatuh_tempo = form.find("#jatuh_tempo").val();

            if (no_bukti == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "No. Bukti Pembelian harus diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#no_bukti").focus();
                    },
                });
                return false;
            } else if (tanggal == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Tanggal harus diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#tanggal").focus();
                    },
                });
                return false;
            } else if (kode_supplier == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Supplier harus diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#kode_supplier").focus();
                    },
                });
                return false;
            } else if (kode_asal_pengajuan == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Asal Ajuan harus diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#kode_asal_pengajuan").focus();
                    },
                });
                return false;
            } else if (jenis_transaksi == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Jenis Transaksi harus diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#jenis_transaksi").focus();
                    },
                });
                return false;
            } else if (jatuh_tempo == "" && jenis_transaksi == 'K') {
                Swal.fire({
                    title: "Oops!",
                    text: "Jatuh Tempo harus diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#jatuh_tempo").focus();
                    },
                });
                return false;
            } else if ($('#loadbarang tr').length == 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Detail Pembelian Tidak Boleh Kosong!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: () => {
                        form.find("#nama_barang").focus();
                    },
                });
                return false;
            } else {
                buttonDisable();
            }
        });

        $('#kode_supplier').on('change', function() {
            let kode_supplier = $(this).val();
            $('#no_po').val(null).trigger('change');
            if (kode_supplier === '') {
                return;
            }
            $('#no_po').select2({
                placeholder: 'Pilih No PO',
                allowClear: true,
                ajax: {
                    url: `/po/by-supplier/${kode_supplier}`,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                }
            });
        });
    });
</script>
@endpush
</x-app-layout>
