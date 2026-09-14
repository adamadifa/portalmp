<x-app-layout>
    <x-slot name="header">
        Input Biaya Operasional
    </x-slot>

    <style>
    /* ── Isolated Floating Label & Icon Group ──────────── */
    .c-fl-group {
        position: relative !important;
        width: 100% !important;
        margin-top: 22px !important;
    }
    .c-fl-group:first-child {
        margin-top: 6px !important;
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

    /* ── Polished DataTable Styles ──────────── */
    .dataTables_wrapper {
        font-size: 12px !important;
    }
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 14px !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        padding: 5px 28px 5px 10px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        color: #374151 !important;
        outline: none !important;
        background-color: #F9FAFB !important;
        cursor: pointer !important;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 14px !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        padding: 6px 14px !important;
        outline: none !important;
        font-size: 12px !important;
        color: #111827 !important;
        margin-left: 8px !important;
        min-width: 220px !important;
        transition: all 0.15s ease !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #294C9A !important;
        background-color: #FFFFFF !important;
        box-shadow: 0 0 0 3px rgba(41, 76, 154, 0.12) !important;
    }
    #tabelbarang {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
    }
    #tabelbarang thead th {
        background-color: #F8FAFC !important;
        color: #475569 !important;
        font-weight: 700 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        border-top: 1px solid #E2E8F0 !important;
        border-bottom: 2px solid #CBD5E1 !important;
        padding: 11px 14px !important;
    }
    #tabelbarang tbody td {
        padding: 10px 14px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #F1F5F9 !important;
        color: #334155 !important;
    }
    #tabelbarang tbody tr:hover {
        background-color: #F8FAFC !important;
    }
    .dataTables_wrapper .dataTables_info {
        padding-top: 14px !important;
        font-size: 12px !important;
        color: #64748B !important;
        font-weight: 500 !important;
    }
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 12px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 11px !important;
        margin: 0 2px !important;
        border-radius: 7px !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        border: 1px solid #E2E8F0 !important;
        background: #FFFFFF !important;
        color: #475569 !important;
        cursor: pointer !important;
        transition: all 0.15s ease !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #294C9A !important;
        color: #FFFFFF !important;
        border: 1px solid #294C9A !important;
        font-weight: 600 !important;
        box-shadow: 0 1px 2px rgba(41, 76, 154, 0.25) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #EEF2FF !important;
        color: #294C9A !important;
        border-color: #C7D2FE !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #94A3B8 !important;
        border-color: #F1F5F9 !important;
        background: #F8FAFC !important;
        cursor: not-allowed !important;
    }
    </style>

    <!-- Header & Navigation -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Input Transaksi Biaya</h2>
            <p class="text-sm text-gray-500 mt-1">Registrasi transaksi pengeluaran dan biaya operasional.</p>
        </div>
        <a href="{{ route('biaya.index') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('biaya.store') }}" method="POST" id="formBiaya">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Panel: General Info Form -->
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="no_bukti" id="no_bukti" class="fi" placeholder="No. Bukti" autocomplete="off" required />
                        <label for="no_bukti" class="c-fl-label">No. Bukti *</label>
                    </div>

                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="tanggal" id="tanggal" class="fi flatpickr-date" value="{{ date('Y-m-d') }}" placeholder="Tanggal" autocomplete="off" required />
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </span>
                        <select name="jenis_transaksi" id="jenis_transaksi" class="fi" required>
                            <option value="T" selected>Tunai</option>
                            <option value="K">Kredit</option>
                        </select>
                        <label for="jenis_transaksi" class="c-fl-label">Tunai / Kredit *</label>
                    </div>

                    <div class="c-fl-group hidden" id="group_jatuh_tempo">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="fi flatpickr-date" placeholder="Jatuh Tempo" autocomplete="off" />
                        <label for="tanggal_jatuh_tempo" class="c-fl-label">Jatuh Tempo</label>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Input items & Data details -->
            <div class="lg:col-span-9 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                        <h3 class="font-bold text-base text-gray-900">Detail Pos Biaya / Barang</h3>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-xs text-gray-500 font-medium">Grand Total:</span>
                            <span id="grandtotal_text" class="text-base font-bold text-[#294C9A]">0</span>
                        </div>
                    </div>

                    <!-- Input Grid (Langsung input Deskripsi / Keterangan Pos Biaya) -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                        <div class="md:col-span-5">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </span>
                                <input type="text" name="keterangan" id="keterangan" class="fi" placeholder="Keterangan / Pos Biaya *" autocomplete="off" />
                                <label for="keterangan" class="c-fl-label">Keterangan / Pos Biaya *</label>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                </span>
                                <input type="text" name="jumlah" id="jumlah" class="fi number-separator text-right" placeholder="1" value="1" autocomplete="off" />
                                <label for="jumlah" class="c-fl-label">Qty</label>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                                </span>
                                <input type="text" name="harga" id="harga" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                                <label for="harga" class="c-fl-label">Harga *</label>
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                                </span>
                                <input type="text" name="penyesuaian" id="penyesuaian" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                                <label for="penyesuaian" class="c-fl-label">Penyesuaian</label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                        <div class="md:col-span-7">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </span>
                                <select name="kode_akun" id="kode_akun" class="fi select2Kodeakun">
                                    <option value="">Akun (COA) *</option>
                                    @foreach ($coa as $d)
                                        <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="md:col-span-5">
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <select name="kode_cabang" id="kode_cabang" class="fi select2Kodecabang">
                                    <option value="">Cabang (Opsional)</option>
                                    @foreach ($cabang as $d)
                                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btnTambahbarang" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-[#294C9A] bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-xl transition shadow-sm gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Pos Biaya
                    </button>

                    <!-- Items Detail Table -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mt-3">
                        <table class="w-full text-xs text-left">
                            <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                                <tr>
                                    <th class="px-3 py-2.5">Keterangan / Pos Biaya</th>
                                    <th class="px-3 py-2.5 text-center">Qty</th>
                                    <th class="px-3 py-2.5 text-right">Harga</th>
                                    <th class="px-3 py-2.5 text-right">Subtotal</th>
                                    <th class="px-3 py-2.5 text-right">Peny</th>
                                    <th class="px-3 py-2.5 text-right">Total</th>
                                    <th class="px-3 py-2.5">Akun (COA)</th>
                                    <th class="px-3 py-2.5 text-center">Cabang</th>
                                    <th class="px-3 py-2.5 text-center">#</th>
                                </tr>
                            </thead>
                            <tbody id="loadbarang" class="divide-y divide-gray-100 bg-white"></tbody>
                            <tfoot class="bg-gray-50 text-gray-900 border-t border-gray-200 font-bold">
                                <tr>
                                    <td colspan="5" class="px-3 py-2.5 text-right uppercase">TOTAL</td>
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
                                Submit Transaksi Biaya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@push('myscript')
<script>
    $(document).ready(function() {
        const form = $("#formBiaya");
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

        $("#jenis_transaksi").change(function() {
            if ($(this).val() === 'K') {
                $("#group_jatuh_tempo").removeClass('hidden');
                $("#group_bank_bayar").addClass('hidden');
            } else {
                $("#group_jatuh_tempo").addClass('hidden');
                $("#group_bank_bayar").removeClass('hidden');
            }
        });

        function buttonDisable() {
            $("#btnSimpan").prop('disabled', true);
            $("#btnSimpan").html(`
                <svg class="w-4 h-4 text-white animate-spin me-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Loading..
            `);
        }

        function resetForm() {
            form.find("#keterangan").val("");
            form.find("#jumlah").val("1");
            form.find("#harga").val("");
            form.find("#penyesuaian").val("");
            form.find('.select2Kodeakun').val('').trigger("change");
            form.find('.select2Kodecabang').val('').trigger("change");
            form.find("#keterangan").focus();
        }

        const select2Kodesupplier = $('.select2Kodesupplier');
        if (select2Kodesupplier.length) {
            select2Kodesupplier.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Supplier / Rekanan',
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
                    placeholder: 'Akun (COA)',
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
                    placeholder: 'Cabang (Opsional)',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        function convertNumber(number) {
            if (!number) return 0;
            let formatted = number.toString().replace(/\./g, '');
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
            const keterangan = form.find("#keterangan").val().trim();
            const jumlah = form.find("#jumlah").val();
            const harga = form.find("#harga").val();
            const penyesuaian = form.find("#penyesuaian").val();
            const dataAkun = form.find("#kode_akun :selected");
            const kode_akun = dataAkun.val();
            const nama_akun = dataAkun.text();
            const kode_cabang = form.find("#kode_cabang").val();

            if (keterangan == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Keterangan / Pos Biaya Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#keterangan").focus();
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
                    text: "Akun (COA) Harus Diisi!",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_akun").focus();
                    },
                });
            } else {
                baris = baris + 1;
                let jml = convertNumber(jumlah) || 1;
                let hrg = convertNumber(harga) || 0;
                let peny = convertNumber(penyesuaian) || 0;
                let subtotal = parseFloat(jml) * parseFloat(hrg);
                let total = parseFloat(subtotal) + parseFloat(peny);
                subtotal = numberFormat(subtotal, '2', ',', '.');
                total = numberFormat(total, '2', ',', '.');
                let bg = "";
                if ((kode_akun.substring(0, 3) == '6-1' || kode_akun.substring(0, 3) == '6-2') && kode_cabang != '') {
                    bg = "bg-blue-50/50 text-blue-900";
                }

                let rowItem = `
                <tr id="index_${baris}" class="${bg} hover:bg-gray-50/80 transition">
                    <td class="px-3 py-2 font-medium text-gray-900">
                        <input type="hidden" name="keterangan_item[]" value="${keterangan}" />
                        <input type="hidden" name="jumlah_item[]" value="${jumlah || '1'}" />
                        <input type="hidden" name="harga_item[]" value="${harga}" />
                        <input type="hidden" name="penyesuaian_item[]" value="${penyesuaian || '0'}" />
                        <input type="hidden" name="kode_akun_item[]" value="${kode_akun}" />
                        <input type="hidden" name="kode_cabang_item[]" value="${kode_cabang}" />
                        ${keterangan}
                    </td>
                    <td class="px-3 py-2 text-center text-gray-700">${jumlah || '1'}</td>
                    <td class="px-3 py-2 text-right text-gray-700">${harga}</td>
                    <td class="px-3 py-2 text-right text-gray-700">${subtotal}</td>
                    <td class="px-3 py-2 text-right text-gray-700">${penyesuaian || '0'}</td>
                    <td class="px-3 py-2 text-right font-bold text-gray-950 totalharga">${total}</td>
                    <td class="px-3 py-2 text-gray-600">${nama_akun}</td>
                    <td class="px-3 py-2 text-center text-gray-600">${kode_cabang || '-'}</td>
                    <td class="px-3 py-2 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="#" id="index_${baris}" class="delete text-red-500 hover:text-red-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>`;
                $('#loadbarang').append(rowItem);
                calculateTotal();
                resetForm();
            }
        }

        form.find("#btnTambahbarang").click(function(e) {
            e.preventDefault();
            addBarang();
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
            const jenis_transaksi = form.find("#jenis_transaksi").val();
            const jatuh_tempo = form.find("#tanggal_jatuh_tempo").val();

            if (no_bukti == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "No. Bukti Biaya harus diisi!",
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
                        form.find("#tanggal_jatuh_tempo").focus();
                    },
                });
                return false;
            } else if ($('#loadbarang tr').length == 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Detail Biaya Tidak Boleh Kosong!",
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
    });
</script>
@endpush
</x-app-layout>
