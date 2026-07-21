<form action="{{ route('barangmasukgudangbahan.update', Crypt::encrypt($barangmasuk->no_bukti)) }}" method="POST" id="formeditBarangmasukgudangbahan" class="space-y-4 text-xs" novalidate>
    @csrf
    @method('PUT')

    <!-- Top Fields -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="no_bukti">No. Bukti Pemasukan <span class="text-red-500">*</span></label>
            <input type="text" name="no_bukti" id="no_bukti" value="{{ $barangmasuk->no_bukti }}" required class="block w-full py-2.5 px-4 text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm" autocomplete="off" />
        </div>
        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="tanggal">Tanggal <span class="text-red-500">*</span></label>
            <input type="text" name="tanggal" id="tanggal" value="{{ $barangmasuk->tanggal }}" required class="block w-full py-2.5 px-4 text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm flatpickr-date" autocomplete="off" />
        </div>
        <div>
            <label class="block font-semibold text-gray-700 mb-1" for="kode_asal_barang">Asal Barang <span class="text-red-500">*</span></label>
            <select name="kode_asal_barang" id="kode_asal_barang" required class="block w-full py-2.5 px-4 text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm">
                <option value=""></option>
                @foreach ($list_asal_barang as $d)
                    <option value="{{ $d['kode_asal_barang'] }}" {{ $barangmasuk->kode_asal_barang == $d['kode_asal_barang'] ? 'selected' : '' }}>{{ $d['asal_barang'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Product Adder Card -->
    <div class="bg-gray-50/70 p-5 rounded-2xl border border-gray-100/80 space-y-4">
        <div class="text-xs font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-2">Detail Barang</div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block font-semibold text-gray-700 mb-1">Pilih Barang</label>
                <select name="kode_barang_select" id="kode_barang_select" class="select2Kodebarang w-full">
                    <option value=""></option>
                    @foreach ($barang as $d)
                        <option value="{{ $d->kode_barang }}">{{ $d->kode_barang }} | {{ $d->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700 mb-1" for="qty_unit">Qty Unit</label>
                <input type="text" id="qty_unit" class="block w-full py-2.5 px-4 text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm text-right number-separator" autocomplete="off" />
            </div>
            <div>
                <label class="block font-semibold text-gray-700 mb-1" for="qty_berat">Qty Berat</label>
                <input type="text" id="qty_berat" class="block w-full py-2.5 px-4 text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm text-right number-separator" autocomplete="off" />
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-semibold text-gray-700 mb-1" for="qty_lebih">Qty Lebih</label>
                <input type="text" id="qty_lebih" class="block w-full py-2.5 px-4 text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm text-right number-separator" autocomplete="off" />
            </div>
            <div class="md:col-span-2">
                <label class="block font-semibold text-gray-700 mb-1" for="keterangan">Keterangan</label>
                <input type="text" id="keterangan" class="block w-full py-2.5 px-4 text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm" autocomplete="off" />
            </div>
        </div>

        <div class="flex justify-end">
            <button type="button" id="tambahproduk" class="inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm h-[38px]">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Barang
            </button>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-4">
        <div class="overflow-x-auto max-h-[30vh] overflow-y-auto">
            <table class="w-full text-left border-collapse" id="tabledetail">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10">Kode</th>
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10" style="width: 35%;">Nama Barang</th>
                        <th class="py-2.5 px-4 text-right sticky top-0 bg-[#294C9A] z-10">Qty Unit</th>
                        <th class="py-2.5 px-4 text-right sticky top-0 bg-[#294C9A] z-10">Qty Berat</th>
                        <th class="py-2.5 px-4 text-right sticky top-0 bg-[#294C9A] z-10">Qty Lebih</th>
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10">Keterangan</th>
                        <th class="py-2.5 px-4 text-center sticky top-0 bg-[#294C9A] z-10">#</th>
                    </tr>
                </thead>
                <tbody id="loaddetail" class="text-sm divide-y divide-gray-100">
                    @foreach ($detail as $d)
                        @php
                            $index = rand(10, 10000);
                        @endphp
                        <tr id="index_{{ $index }}" class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-2.5 px-4 font-semibold text-[#294C9A]">
                                <input type="hidden" name="kode_barang[]" value="{{ $d->kode_barang }}">
                                {{ $d->kode_barang }}
                            </td>
                            <td class="py-2.5 px-4 text-gray-700 font-medium">{{ strtoupper($d->nama_barang) }}</td>
                            <td class="py-2.5 px-4 text-right">
                                <input type="text" name="qty_unit[]" value="{{ formatAngkaDesimal($d->qty_unit) }}"
                                    class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none number-separator" />
                            </td>
                            <td class="py-2.5 px-4 text-right">
                                <input type="text" name="qty_berat[]" value="{{ formatAngkaDesimal($d->qty_berat) }}"
                                    class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none number-separator" />
                            </td>
                            <td class="py-2.5 px-4 text-right">
                                <input type="text" name="qty_lebih[]" value="{{ formatAngkaDesimal($d->qty_lebih) }}"
                                    class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none number-separator" />
                            </td>
                            <td class="py-2.5 px-4 text-gray-500 font-medium">
                                <input type="hidden" name="ket[]" value="{{ $d->keterangan }}">
                                {{ $d->keterangan }}
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <button type="button" data-index="{{ $index }}" class="delete-row text-red-600 hover:bg-red-50 p-1.5 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Consent and Submit -->
    <div class="pt-4 border-t border-gray-100 space-y-3">
        <label class="flex items-center gap-2 text-xs font-medium text-gray-700 cursor-pointer select-none">
            <input class="w-4 h-4 text-[#294C9A] border-gray-300 rounded focus:ring-[#294C9A] agreement" name="aggrement" value="aggrement" type="checkbox" />
            <span>Yakin Akan Disimpan?</span>
        </label>
        <div class="form-group" id="saveButton" style="display: none;">
            <button class="w-full inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm" type="submit" id="btnSimpan">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<script>
    $(function() {
        const formEdit = $("#formeditBarangmasukgudangbahan");
        
        flatpickr(".flatpickr-date", {
            dateFormat: "Y-m-d",
            locale: "id",
            enable: [{
                from: "{{ $start_periode }}",
                to: "{{ $end_periode }}"
            }]
        });

        // Initialize select2
        $('.select2Kodebarang').wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Pilih Barang',
            allowClear: true,
            dropdownParent: $('.select2Kodebarang').parent()
        });

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        function addProduk() {
            const dataBarang = $("#kode_barang_select :selected");
            const kode_barang = dataBarang.val();
            const rawText = dataBarang.text();
            const textParts = rawText.split("|");
            const nama_barang = textParts[1] ? textParts[1].trim() : rawText;
            
            const qty_unit = $("#qty_unit").val() || 0;
            const qty_berat = $("#qty_berat").val() || 0;
            const qty_lebih = $("#qty_lebih").val() || 0;
            const keterangan = $("#keterangan").val();
            const index = Math.floor(Math.random() * 10000);
            
            let produk = `
                <tr id="index_${index}" class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-2.5 px-4 font-semibold text-[#294C9A]">
                        <input type="hidden" name="kode_barang[]" value="${kode_barang}"/>
                        ${kode_barang}
                    </td>
                    <td class="py-2.5 px-4 text-gray-700 font-medium">${nama_barang}</td>
                    <td class="py-2.5 px-4 text-right">
                        <input type="text" name="qty_unit[]" value="${qty_unit}" class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none number-separator" />
                    </td>
                    <td class="py-2.5 px-4 text-right">
                        <input type="text" name="qty_berat[]" value="${qty_berat}" class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none number-separator" />
                    </td>
                    <td class="py-2.5 px-4 text-right">
                        <input type="text" name="qty_lebih[]" value="${qty_lebih}" class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none number-separator" />
                    </td>
                    <td class="py-2.5 px-4 text-gray-500 font-medium">
                        <input type="hidden" name="ket[]" value="${keterangan}" />
                        ${keterangan}
                    </td>
                    <td class="py-2.5 px-4 text-center">
                        <button type="button" data-index="${index}" class="delete-row text-red-600 hover:bg-red-50 p-1.5 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;

            $('#loaddetail').prepend(produk);
            
            easyNumberSeparator({
                selector: '.number-separator',
                separator: '.',
                decimalSeparator: ',',
            });

            $('.select2Kodebarang').val('').trigger("change");
            $("#qty_unit").val("");
            $("#qty_berat").val("");
            $("#qty_lebih").val("");
            $("#keterangan").val("");
            $("#kode_barang_select").focus();
        }

        $("#tambahproduk").click(function(e) {
            e.preventDefault();
            const kode_barang = $("#kode_barang_select").val();
            if (kode_barang == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Silahkan Pilih dulu Barang !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
            } else {
                addProduk();
            }
        });

        $(document).on('click', '.delete-row', function(e) {
            e.preventDefault();
            var index = $(this).data("index");
            $(`#index_${index}`).remove();
        });

        $('.agreement').change(function() {
            if (this.checked) {
                $("#saveButton").show();
            } else {
                $("#saveButton").hide();
            }
        });

        formEdit.submit(function() {
            const no_bukti = $("#no_bukti").val();
            const tanggal = $("#tanggal").val();
            const kode_asal_barang = $("#kode_asal_barang").val();
            
            if (no_bukti == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "No. Bukti Harus Diisi !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else if (tanggal == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Tanggal Harus Diisi !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else if (kode_asal_barang == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Asal Barang Harus Diisi !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else if ($('#loaddetail tr').length == 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Data Barang Masih Kosong !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            }
        });
    });
</script>
