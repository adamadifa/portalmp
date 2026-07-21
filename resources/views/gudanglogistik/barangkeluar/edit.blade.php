<form action="{{ route('barangkeluargudanglogistik.update', Crypt::encrypt($barangkeluar->no_bukti)) }}" method="post" id="formeditbarangkeluargudanglogistik" class="space-y-4">
    @csrf
    @method('PUT')

    @php
        $isCbg = $barangkeluar->kode_jenis_pengeluaran == 'CBG';
        $colSpan = $isCbg ? 'md:col-span-3' : 'md:col-span-4';
    @endphp

    <div id="top_fields_grid" class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <div id="col_no_bukti" class="{{ $colSpan }}">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                </span>
                <input type="text" name="no_bukti" id="no_bukti" value="{{ $barangkeluar->no_bukti }}" class="fi" placeholder="No. Bukti Pengeluaran" autocomplete="off" />
                <label for="no_bukti" class="c-fl-label">No. Bukti Pengeluaran *</label>
            </div>
        </div>

        <div id="col_tanggal" class="{{ $colSpan }}">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </span>
                <input type="text" name="tanggal" id="tanggal" value="{{ $barangkeluar->tanggal }}" class="fi flatpickr-date" placeholder="Pilih Tanggal" autocomplete="off" />
                <label for="tanggal" class="c-fl-label">Tanggal *</label>
            </div>
        </div>

        <div id="col_jenis" class="{{ $colSpan }}">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </span>
                <select name="kode_jenis_pengeluaran" id="kode_jenis_pengeluaran" class="fi">
                    <option value="">Jenis Pengeluaran</option>
                    @foreach ($list_jenis_pengeluaran as $d)
                        <option value="{{ $d['kode_jenis_pengeluaran'] }}" {{ $barangkeluar->kode_jenis_pengeluaran == $d['kode_jenis_pengeluaran'] ? 'selected' : '' }}>{{ $d['jenis_pengeluaran'] }}</option>
                    @endforeach
                </select>
                <label for="kode_jenis_pengeluaran" class="c-fl-label">Jenis Pengeluaran *</label>
            </div>
        </div>

        <div id="cabang_select" class="md:col-span-3 {{ $isCbg ? '' : 'hidden' }}">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V9a1 1 0 011-1h2a1 1 0 011 1v12"></path></svg>
                </span>
                <select name="kode_cabang" id="kode_cabang" class="fi">
                    <option value="">Pilih Cabang</option>
                    @foreach ($cabang as $d)
                        <option value="{{ $d->kode_cabang }}" {{ $barangkeluar->kode_cabang == $d->kode_cabang ? 'selected' : '' }}>{{ strtoupper($d->nama_cabang) }}</option>
                    @endforeach
                </select>
                <label for="kode_cabang" class="c-fl-label">Cabang Tujuan *</label>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="relative my-3">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
        <div class="relative flex justify-start"><span class="pr-3 text-xs font-semibold text-[#294C9A] bg-white">Detail Barang</span></div>
    </div>

    <!-- Input Detail Barang Grid -->
    <div class="grid grid-cols-12 gap-3 items-end">
        <div class="col-span-12 lg:col-span-5">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </span>
                <select name="kode_barang" id="kode_barang" class="select2Kodebarang">
                    <option value=""></option>
                    @foreach ($barang as $d)
                        <option value="{{ $d->kode_barang }}">{{ $d->kode_barang }} | {{ strtoupper($d->nama_barang) }}</option>
                    @endforeach
                </select>
                <label for="kode_barang" class="c-fl-label">Pilih Barang</label>
            </div>
        </div>

        <div class="col-span-6 lg:col-span-3">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                </span>
                <input type="text" name="jumlah" id="jumlah" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                <label for="jumlah" class="c-fl-label">Jumlah</label>
            </div>
        </div>

        <div class="col-span-6 lg:col-span-4">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V9a1 1 0 011-1h2a1 1 0 011 1v12"></path></svg>
                </span>
                <select name="kode_cbg" id="kode_cbg" class="fi">
                    <option value="">Pilihan Cabang (Optional)</option>
                    @foreach ($cabang as $d)
                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                    @endforeach
                </select>
                <label for="kode_cbg" class="c-fl-label">Cabang Peruntukan</label>
            </div>
        </div>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </span>
        <input type="text" name="keterangan" id="keterangan" class="fi" placeholder="Keterangan" autocomplete="off" />
        <label for="keterangan" class="c-fl-label">Keterangan</label>
    </div>

    <button type="button" id="tambahproduk" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-[#294C9A] bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-xl transition shadow-sm gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Produk
    </button>

    <!-- Detail Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mt-3">
        <table class="w-full text-xs text-left" id="tabledetail">
            <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2.5">Kode</th>
                    <th class="px-3 py-2.5">Nama Barang</th>
                    <th class="px-3 py-2.5 text-right">Jumlah</th>
                    <th class="px-3 py-2.5">Cabang</th>
                    <th class="px-3 py-2.5">Keterangan</th>
                    <th class="px-3 py-2.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="loaddetail" class="divide-y divide-gray-100 bg-white">
                @foreach ($detail as $d)
                <tr id="index_{{ $d->kode_barang }}">
                    <td class="px-3 py-2 font-medium text-gray-900">
                        <input type="hidden" name="kode_barang[]" value="{{ $d->kode_barang }}">
                        {{ $d->kode_barang }}
                    </td>
                    <td class="px-3 py-2 font-medium text-gray-800">{{ strtoupper($d->nama_barang) }}</td>
                    <td class="px-3 py-2 text-right">
                        <input type="hidden" name="jml[]" value="{{ $d->jumlah }}">
                        {{ formatAngkaDesimal($d->jumlah) }}
                    </td>
                    <td class="px-3 py-2 text-gray-700">
                        <input type="hidden" name="kode_cbg[]" value="{{ $d->kode_cabang }}">
                        {{ $d->nama_cabang ? strtoupper($d->nama_cabang) : '-' }}
                    </td>
                    <td class="px-3 py-2 text-gray-600">
                        <input type="hidden" name="ket[]" value="{{ $d->keterangan }}">
                        {{ $d->keterangan }}
                    </td>
                    <td class="px-3 py-2 text-center">
                        <button type="button" kode_barang="{{ $d->kode_barang }}" class="delete text-red-600 hover:text-red-800 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Agreement & Submit -->
    <div class="pt-2">
        <label class="inline-flex items-center text-xs text-gray-700 font-medium cursor-pointer">
            <input type="checkbox" name="aggrement" id="aggrement" class="rounded border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
            <span class="ml-2">Yakin Akan Disimpan ?</span>
        </label>
    </div>

    <div class="pt-1" id="saveButton">
        <button type="submit" id="btnSimpan" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            Update Data
        </button>
    </div>
</form>

<script>
$(function() {
    const formEdit = $("#formeditbarangkeluargudanglogistik");

    $(".flatpickr-date").flatpickr({
        dateFormat: "Y-m-d",
        enable: [{
            from: "{{ $start_periode }}",
            to: "{{ $end_periode }}"
        }]
    });

    if (typeof easyNumberSeparator === 'function') {
        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });
    }

    $(".select2Kodebarang").select2({
        placeholder: "Pilih Barang",
        allowClear: true,
        dropdownParent: formEdit
    });

    formEdit.find("#kode_jenis_pengeluaran").change(function() {
        let val = $(this).val();
        if (val === 'CBG') {
            $('#cabang_select').removeClass('hidden');
            $('#col_no_bukti, #col_tanggal, #col_jenis').removeClass('md:col-span-4').addClass('md:col-span-3');
        } else {
            $('#cabang_select').addClass('hidden');
            formEdit.find("#kode_cabang").val('');
            $('#col_no_bukti, #col_tanggal, #col_jenis').removeClass('md:col-span-3').addClass('md:col-span-4');
        }
    });

    $("#tambahproduk").click(function(e) {
        e.preventDefault();
        const kode_barang = formEdit.find("#kode_barang").val();
        const nama_barang = formEdit.find("#kode_barang option:selected").text();
        const jml = formEdit.find("#jumlah").val();
        const kode_cbg = formEdit.find("#kode_cbg").val();
        const nama_cbg = formEdit.find("#kode_cbg option:selected").text();
        const ket = formEdit.find("#keterangan").val();

        if (kode_barang == "") {
            Swal.fire({ title: "Oops!", text: 'Silahkan Pilih Barang Terlebih Dahulu !', icon: "warning" });
        } else if (jml == "" || jml == 0) {
            Swal.fire({ title: "Oops!", text: 'Jumlah Tidak Boleh Kosong !', icon: "warning" });
        } else if ($('#index_' + kode_barang).length > 0) {
            Swal.fire({ title: "Oops!", text: 'Barang Sudah Ada !', icon: "warning" });
        } else {
            let display_cbg = kode_cbg ? nama_cbg : '-';
            let row = `<tr id="index_${kode_barang}">
                <td class="px-3 py-2 font-medium text-gray-900">
                    <input type="hidden" name="kode_barang[]" value="${kode_barang}">
                    ${kode_barang}
                </td>
                <td class="px-3 py-2 font-medium text-gray-800">${nama_barang}</td>
                <td class="px-3 py-2 text-right">
                    <input type="hidden" name="jml[]" value="${jml}">
                    ${jml}
                </td>
                <td class="px-3 py-2 text-gray-700">
                    <input type="hidden" name="kode_cbg[]" value="${kode_cbg}">
                    ${display_cbg}
                </td>
                <td class="px-3 py-2 text-gray-600">
                    <input type="hidden" name="ket[]" value="${ket}">
                    ${ket}
                </td>
                <td class="px-3 py-2 text-center">
                    <button type="button" kode_barang="${kode_barang}" class="delete text-red-600 hover:text-red-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            </tr>`;
            $("#loaddetail").append(row);
            formEdit.find("#kode_barang").val('').trigger('change');
            formEdit.find("#jumlah").val('');
            formEdit.find("#kode_cbg").val('');
            formEdit.find("#keterangan").val('');
        }
    });

    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        let kode_barang = $(this).attr("kode_barang");
        $('#index_' + kode_barang).remove();
    });

    formEdit.submit(function() {
        const no_bukti = formEdit.find("#no_bukti").val();
        const tanggal = formEdit.find("#tanggal").val();
        const kode_jenis_pengeluaran = formEdit.find("#kode_jenis_pengeluaran").val();
        const kode_cabang = formEdit.find("#kode_cabang").val();

        if (no_bukti == "") {
            Swal.fire({ title: "Oops!", text: 'No. Bukti Harus Diisi !', icon: "warning" });
            return false;
        } else if (tanggal == "") {
            Swal.fire({ title: "Oops!", text: 'Tanggal Harus Diisi !', icon: "warning" });
            return false;
        } else if (kode_jenis_pengeluaran == "") {
            Swal.fire({ title: "Oops!", text: 'Jenis Pengeluaran Harus Diisi !', icon: "warning" });
            return false;
        } else if (kode_jenis_pengeluaran == "CBG" && kode_cabang == "") {
            Swal.fire({ title: "Oops!", text: 'Cabang Tujuan Harus Diisi !', icon: "warning" });
            return false;
        } else if ($("#loaddetail tr").length == 0) {
            Swal.fire({ title: "Oops!", text: 'Detail Barang Masih Kosong !', icon: "warning" });
            return false;
        } else if (!formEdit.find("#aggrement").is(":checked")) {
            Swal.fire({ title: "Oops!", text: 'Silahkan Ceklis Persetujuan Terlebih Dahulu !', icon: "warning" });
            return false;
        }
    });
});
</script>
