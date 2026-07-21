<style>
/* ── Base input ─────────────────────────────── */
.fi {
    display: block;
    width: 100%;
    height: 34px;
    padding: 0 10px;
    font-size: 12px;
    color: #111827;
    background: #fff;
    border: 1px solid #D1D5DB;
    border-radius: 6px;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.fi:focus {
    border-color: #294C9A;
    box-shadow: 0 0 0 3px rgba(41,76,154,0.10);
}
.fi::placeholder { color: #9CA3AF; font-size: 11.5px; }

/* ── Select2 reset ─ match .fi exactly ─────── */
.select2-container { width: 100% !important; }

.select2-container--default .select2-selection--single {
    height: 34px !important;
    border: 1px solid #D1D5DB !important;
    border-radius: 6px !important;
    display: flex !important;
    align-items: center !important;
    background: #fff !important;
    box-shadow: none !important;
}
.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: #294C9A !important;
    box-shadow: 0 0 0 3px rgba(41,76,154,0.10) !important;
    outline: none !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 34px !important;
    padding: 0 30px 0 10px !important;
    font-size: 12px !important;
    color: #111827 !important;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #9CA3AF !important;
    font-size: 11.5px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 32px !important;
    width: 24px !important;
    right: 4px !important;
    top: 1px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #6B7280 transparent transparent transparent !important;
}
.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #6B7280 transparent !important;
}

/* dropdown */
.select2-dropdown {
    font-size: 12px !important;
    border: 1px solid #D1D5DB !important;
    border-radius: 6px !important;
    box-shadow: 0 6px 20px rgba(0,0,0,0.10) !important;
    overflow: hidden;
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
    box-shadow: 0 0 0 2px rgba(41,76,154,0.10) !important;
}
.select2-container--default .select2-results__option {
    padding: 7px 10px !important;
    font-size: 12px !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #294C9A !important;
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
    margin-bottom: 10px;
}
</style>

<form action="{{ route('barangmasukgudangbahan.store') }}" method="POST" id="formcreateBarangmasukgudangbahan" novalidate>
    @csrf

    <!-- Header row: 3 columns, no labels -->
    <div class="grid grid-cols-3 gap-3 mb-4">
        <input type="text" name="no_bukti" id="no_bukti"
            class="fi" placeholder="No. Bukti Pemasukan *" autocomplete="off" />

        <input type="text" name="tanggal" id="tanggal"
            class="fi flatpickr-date" placeholder="Tanggal *" autocomplete="off" />

        <select name="kode_asal_barang" id="kode_asal_barang" class="select2AsalBarang">
            <option value=""></option>
            @foreach ($list_asal_barang as $d)
                <option value="{{ $d['kode_asal_barang'] }}">{{ $d['asal_barang'] }}</option>
            @endforeach
        </select>
    </div>

    <!-- Detail Barang -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-3">
        <div class="sec-head">Detail Barang</div>

        <div class="grid grid-cols-4 gap-3 mb-3">
            <div class="col-span-2">
                <select name="kode_barang_select" id="kode_barang_select" class="select2Kodebarang">
                    <option value=""></option>
                    @foreach ($barang as $d)
                        <option value="{{ $d->kode_barang }}">{{ $d->kode_barang }} | {{ $d->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" id="qty_unit"
                class="fi text-right number-separator" placeholder="Qty Unit" autocomplete="off" />
            <input type="text" id="qty_berat"
                class="fi text-right number-separator" placeholder="Qty Berat" autocomplete="off" />
        </div>

        <div class="grid grid-cols-3 gap-3 mb-3">
            <input type="text" id="qty_lebih"
                class="fi text-right number-separator" placeholder="Qty Lebih" autocomplete="off" />
            <input type="text" id="keterangan"
                class="fi col-span-2" placeholder="Keterangan (opsional)" autocomplete="off" />
        </div>

        <div class="flex justify-end">
            <button type="button" id="tambahproduk"
                class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-md transition shadow-sm">
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
                        <th class="py-2 px-3 sticky top-0 bg-[#294C9A] z-10">Kode</th>
                        <th class="py-2 px-3 sticky top-0 bg-[#294C9A] z-10" style="width:35%">Nama Barang</th>
                        <th class="py-2 px-3 text-right sticky top-0 bg-[#294C9A] z-10">Qty Unit</th>
                        <th class="py-2 px-3 text-right sticky top-0 bg-[#294C9A] z-10">Qty Berat</th>
                        <th class="py-2 px-3 text-right sticky top-0 bg-[#294C9A] z-10">Qty Lebih</th>
                        <th class="py-2 px-3 sticky top-0 bg-[#294C9A] z-10">Keterangan</th>
                        <th class="py-2 px-3 text-center sticky top-0 bg-[#294C9A] z-10">#</th>
                    </tr>
                </thead>
                <tbody id="loaddetail" class="divide-y divide-gray-100 text-xs"></tbody>
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
                Simpan Transaksi
            </button>
        </div>
    </div>
</form>

<script>
$(function() {
    const formCreate = $("#formcreateBarangmasukgudangbahan");

    // Flatpickr
    flatpickr(".flatpickr-date", {
        dateFormat: "Y-m-d",
        locale: "id",
        enable: [{ from: "{{ $start_periode }}", to: "{{ $end_periode }}" }]
    });

    // Select2 — Asal Barang
    $('#kode_asal_barang').select2({
        placeholder: 'Asal Barang *',
        allowClear: true,
        dropdownParent: $('#modalCreate')
    });

    // Select2 — Kode Barang
    $('#kode_barang_select').select2({
        placeholder: 'Cari kode / nama barang...',
        allowClear: true,
        dropdownParent: $('#modalCreate')
    });

    // Number separator
    easyNumberSeparator({
        selector: '.number-separator',
        separator: '.',
        decimalSeparator: ',',
    });

    function addProduk() {
        const dataBarang = $("#kode_barang_select :selected");
        const kode_barang  = dataBarang.val();
        const parts = dataBarang.text().split("|");
        const nama_barang  = parts[1] ? parts[1].trim() : dataBarang.text();
        const qty_unit     = $("#qty_unit").val()  || 0;
        const qty_berat    = $("#qty_berat").val() || 0;
        const qty_lebih    = $("#qty_lebih").val() || 0;
        const keterangan   = $("#keterangan").val();
        const index        = Math.floor(Math.random() * 100000);

        $('#loaddetail').prepend(`
            <tr id="index_${index}" class="odd:bg-white even:bg-gray-50 hover:bg-blue-50/40 transition-colors">
                <td class="py-1.5 px-3 font-semibold text-[#294C9A]">
                    <input type="hidden" name="kode_barang[]" value="${kode_barang}"/>
                    ${kode_barang}
                </td>
                <td class="py-1.5 px-3 text-gray-700">${nama_barang}</td>
                <td class="py-1.5 px-3 text-right font-semibold">
                    <input type="hidden" name="qty_unit[]" value="${qty_unit}"/>${qty_unit}
                </td>
                <td class="py-1.5 px-3 text-right font-semibold">
                    <input type="hidden" name="qty_berat[]" value="${qty_berat}"/>${qty_berat}
                </td>
                <td class="py-1.5 px-3 text-right font-semibold">
                    <input type="hidden" name="qty_lebih[]" value="${qty_lebih}"/>${qty_lebih}
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
        `);

        $('#kode_barang_select').val('').trigger("change");
        $("#qty_unit,#qty_berat,#qty_lebih,#keterangan").val("");
    }

    $("#tambahproduk").click(function(e) {
        e.preventDefault();
        if (!$("#kode_barang_select").val()) {
            Swal.fire({ title:"Oops!", text:"Silahkan Pilih dulu Barang !", icon:"warning",
                customClass:{ confirmButton:'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                buttonsStyling:false });
        } else { addProduk(); }
    });

    $(document).on('click','.delete-row',function(e){
        e.preventDefault();
        $(`#index_${$(this).data("index")}`).remove();
    });

    $('.agreement').change(function(){
        $("#saveButton").toggle(this.checked);
    });

    formCreate.submit(function(){
        const checks = [
            [!$("#no_bukti").val(),        "No. Bukti Harus Diisi !"],
            [!$("#tanggal").val(),          "Tanggal Harus Diisi !"],
            [!$("#kode_asal_barang").val(), "Asal Barang Harus Diisi !"],
            [$('#loaddetail tr').length===0,"Data Barang Masih Kosong !"],
        ];
        for (const [fail, msg] of checks) {
            if (fail) {
                Swal.fire({ title:"Oops!", text:msg, icon:"warning",
                    customClass:{ confirmButton:'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-md' },
                    buttonsStyling:false });
                return false;
            }
        }
    });
});
</script>
