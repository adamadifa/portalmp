<style>
/* Floating Label (Consistent with /barang) */
.fl-group { position: relative; }
.fl-input, .fl-select {
    display: block; width: 100%;
    padding: 14px 14px 4px;
    font-size: 12px; color: #111827;
    background: #f9fafb;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    appearance: none;
}
.fl-input:focus, .fl-select:focus {
    border-color: #294C9A;
    box-shadow: 0 0 0 3px rgba(41,76,154,0.1);
    background: #fff;
}
.fl-input.is-invalid, .fl-select.is-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.1) !important;
    background: #fff5f5 !important;
}
.fl-label {
    position: absolute;
    left: 14px; top: 9px;
    font-size: 12px; color: #9ca3af;
    font-weight: 500;
    pointer-events: none;
    transition: all 0.15s ease;
    transform-origin: left top;
    z-index: 10;
}
.fl-input:focus ~ .fl-label,
.fl-input:not(:placeholder-shown) ~ .fl-label,
.fl-select:focus ~ .fl-label,
.fl-select:not([value=""]) ~ .fl-label,
.has-value ~ .fl-label {
    top: 3px;
    font-size: 9px;
    color: #294C9A;
    font-weight: 600;
}
.fl-select {
    padding-top: 16px;
    padding-bottom: 2px;
}
.fl-req { color: #ef4444; margin-left: 2px; }
</style>

<form action="{{ route('lainnyagudangjadi.update', Crypt::encrypt($lainnya->no_mutasi)) }}" method="POST" id="formeditLainnya" class="space-y-2.5" novalidate>
    @csrf

    <!-- Row 1: No Dokumen & Tanggal -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <div class="fl-group">
            <input type="text" name="no_mutasi" id="no_mutasi" readonly value="{{ $lainnya->no_mutasi }}" placeholder=" " class="fl-input" />
            <label class="fl-label" for="no_mutasi">No. Dokumen (Otomatis)</label>
        </div>
        <div class="fl-group">
            <input type="text" name="tanggal" id="tanggal" value="{{ $lainnya->tanggal }}" required placeholder=" " class="fl-input flatpickr-date" autocomplete="off" />
            <label class="fl-label" for="tanggal">Tanggal <span class="fl-req">*</span></label>
        </div>
    </div>

    <!-- Row 2: Keterangan -->
    <div class="fl-group">
        <input type="text" name="keterangan" id="keterangan" value="{{ $lainnya->keterangan }}" required placeholder=" " class="fl-input" />
        <label class="fl-label" for="keterangan">Keterangan <span class="fl-req">*</span></label>
    </div>

    <!-- Row 3: IN / OUT (Premium Segmented Buttons on a new row) -->
    <div class="flex flex-col gap-1.5">
        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Tipe Mutasi <span class="text-red-500">*</span></span>
        <div class="grid grid-cols-2 gap-2">
            <label class="relative flex items-center justify-center p-2.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer transition select-none hover:bg-gray-100/50 has-[:checked]:border-[#294C9A] has-[:checked]:bg-[#EEF2FF] has-[:checked]:text-[#294C9A]">
                <input type="radio" name="in_out" value="I" {{ $lainnya->in_out === 'I' ? 'checked' : '' }} required class="sr-only" />
                <span class="text-xs font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h3a3 3 0 013 3v1"></path></svg>
                    IN (Barang Masuk)
                </span>
            </label>
            <label class="relative flex items-center justify-center p-2.5 rounded-xl border border-gray-200 bg-gray-50 cursor-pointer transition select-none hover:bg-gray-100/50 has-[:checked]:border-[#294C9A] has-[:checked]:bg-[#EEF2FF] has-[:checked]:text-[#294C9A]">
                <input type="radio" name="in_out" value="O" {{ $lainnya->in_out === 'O' ? 'checked' : '' }} required class="sr-only" />
                <span class="text-xs font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h3a3 3 0 013 3v1"></path></svg>
                    OUT (Barang Keluar)
                </span>
            </label>
        </div>
    </div>

    <!-- Row 4: Detail Produk Header & Inputs -->
    <div class="border-t border-gray-100 pt-3">
        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Detail Produk</h4>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-end">
            <div class="md:col-span-7 fl-group">
                <select id="kode_produk" class="fl-select">
                    <option value=""></option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->kode_produk }}">{{ strtoupper($p->kode_produk) }} - {{ strtoupper($p->nama_produk) }}</option>
                    @endforeach
                </select>
                <label class="fl-label" for="kode_produk">Pilih Produk</label>
            </div>
            <div class="md:col-span-3 fl-group">
                <input type="number" id="jumlah" placeholder=" " class="fl-input" />
                <label class="fl-label" for="jumlah">Jumlah</label>
            </div>
            <div class="md:col-span-2">
                <button type="button" id="tambahproduk" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm h-[42px]">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="tabledetailProduk">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                        <th class="py-2.5 px-4">Kode</th>
                        <th class="py-2.5 px-4">Nama Produk</th>
                        <th class="py-2.5 px-4 text-right">Jumlah</th>
                        <th class="py-2.5 px-4 text-center">#</th>
                    </tr>
                </thead>
                <tbody id="loaddetail" class="text-sm divide-y divide-gray-100">
                    @foreach ($detail as $d)
                        <tr id="index_{{ $d->kode_produk }}" class="hover:bg-gray-50 transition-colors">
                            <td class="py-2 px-4 font-semibold text-gray-700">
                                <input type="hidden" name="kode_produk[]" value="{{ $d->kode_produk }}"/>
                                {{ $d->kode_produk }}
                            </td>
                            <td class="py-2 px-4 text-gray-600">{{ $d->nama_produk }}</td>
                            <td class="py-2 px-4 text-right">
                                <input type="number" name="jml[]" value="{{ $d->jumlah }}" class="w-24 text-right border-0 bg-transparent focus:ring-0 p-0 text-sm font-semibold text-gray-800" readonly />
                            </td>
                            <td class="py-2 px-4 text-center">
                                <button type="button" data-code="{{ $d->kode_produk }}" class="btn-delete text-red-600 hover:text-red-800 transition">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-3 pt-3 border-t border-gray-100">
        <div class="flex items-center gap-2">
            <input type="checkbox" id="agreement" class="rounded border-gray-300 text-[#294C9A] focus:ring-[#294C9A] agreement" />
            <label for="agreement" class="text-xs text-gray-600 font-medium cursor-pointer">Yakin data sudah benar dan siap diupdate?</label>
        </div>
        <div id="saveButton" class="hidden">
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Update Mutasi
            </button>
        </div>
    </div>
</form>

<script>
    $(function() {
        const formEdit = $("#formeditLainnya");
        
        flatpickr("#tanggal", {
            dateFormat: "Y-m-d",
            locale: "id",
            allowInput: true
        });

        // Initialize Select2
        const kodeProdukSelect = $('#kode_produk').select2({
            placeholder: 'Pilih Produk',
            allowClear: true,
            dropdownParent: $('#modalEdit')
        });

        // Trigger floating label transition on Select2 change
        kodeProdukSelect.on('change', function() {
            const val = $(this).val();
            if (val && val !== "") {
                $(this).addClass('has-value');
            } else {
                $(this).removeClass('has-value');
            }
        });

        function addProduk() {
            const kode_produk = formEdit.find("#kode_produk").val();
            const nama_produk = formEdit.find("#kode_produk option:selected").text().split(' - ')[1] || '';
            const jumlah = formEdit.find("#jumlah").val();

            let produk = `
                <tr id="index_${kode_produk}" class="hover:bg-gray-50 transition-colors">
                    <td class="py-2 px-4 font-semibold text-gray-700">
                        <input type="hidden" name="kode_produk[]" value="${kode_produk}"/>
                        ${kode_produk}
                    </td>
                    <td class="py-2 px-4 text-gray-600">${nama_produk}</td>
                    <td class="py-2 px-4 text-right">
                        <input type="number" name="jml[]" value="${jumlah}" class="w-24 text-right border-0 bg-transparent focus:ring-0 p-0 text-sm font-semibold text-gray-800" readonly />
                    </td>
                    <td class="py-2 px-4 text-center">
                        <button type="button" data-code="${kode_produk}" class="btn-delete text-red-600 hover:text-red-800 transition">
                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;

            $('#loaddetail').prepend(produk);
            kodeProdukSelect.val('').trigger("change");
            formEdit.find("#jumlah").val("");
            setTimeout(() => {
                kodeProdukSelect.select2('open');
            }, 100);
        }

        formEdit.find("#tambahproduk").click(function(e) {
            e.preventDefault();
            const kode_produk = formEdit.find("#kode_produk").val();
            const jumlah = formEdit.find("#jumlah").val();
            
            if (kode_produk == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Silahkan Pilih dulu Kode Produk !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
            } else if (jumlah == "" || jumlah === "0") {
                Swal.fire({
                    title: "Oops!",
                    text: "Jumlah Tidak Boleh Kosong!",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
            } else {
                if (formEdit.find('#index_' + kode_produk).length > 0) {
                    Swal.fire({
                        title: "Oops!",
                        text: "Data Sudah Ada!",
                        icon: "warning",
                        customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                        buttonsStyling: false
                    });
                } else {
                    addProduk();
                }
            }
        });

        formEdit.on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $(`#index_${code}`).remove();
        });

        formEdit.find('.agreement').change(function() {
            if (this.checked) {
                formEdit.find("#saveButton").removeClass('hidden');
            } else {
                formEdit.find("#saveButton").addClass('hidden');
            }
        });
    });
</script>
