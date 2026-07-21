<form action="{{ route('opgudanglogistik.store') }}" method="post" id="formeditopnamegudanglogistik" class="space-y-4">
    @csrf

    <!-- Form Top Fields aligned in 1 row -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
        <div class="md:col-span-3">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </span>
                <select name="bulan" id="bulan" class="fi">
                    <option value="">Pilih Bulan</option>
                    @foreach ($list_bulan as $d)
                        @php
                            $k_bln = is_array($d) ? $d['kode_bulan'] : $d->kode_bulan;
                            $n_bln = is_array($d) ? $d['nama_bulan'] : $d->nama_bulan;
                        @endphp
                        <option value="{{ $k_bln }}" {{ $opname->bulan == $k_bln ? 'selected' : '' }}>{{ $n_bln }}</option>
                    @endforeach
                </select>
                <label for="bulan" class="c-fl-label">Bulan *</label>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </span>
                <select name="tahun" id="tahun" class="fi">
                    <option value="">Pilih Tahun</option>
                    @for ($t = $start_year; $t <= date('Y'); $t++)
                        <option value="{{ $t }}" {{ $opname->tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endfor
                </select>
                <label for="tahun" class="c-fl-label">Tahun *</label>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10M7 17h10"></path></svg>
                </span>
                <select name="kode_kategori" id="kode_kategori" class="fi">
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $d)
                        <option value="{{ $d->kode_kategori }}" {{ $opname->kode_kategori == $d->kode_kategori ? 'selected' : '' }}>{{ strtoupper($d->nama_kategori) }}</option>
                    @endforeach
                </select>
                <label for="kode_kategori" class="c-fl-label">Kategori *</label>
            </div>
        </div>

        <div class="md:col-span-3">
            <button type="button" id="getsaldo" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh Saldo
            </button>
        </div>
    </div>

    <!-- Divider -->
    <div class="relative my-3">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
        <div class="relative flex justify-start"><span class="pr-3 text-xs font-semibold text-[#294C9A] bg-white">Detail Opname Barang</span></div>
    </div>

    <!-- Items Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-xs text-left" id="tabledetail">
            <thead class="text-xs uppercase bg-[#002e65] text-white">
                <tr>
                    <th class="px-4 py-3">Kode Barang</th>
                    <th class="px-4 py-3">Nama Barang</th>
                    <th class="px-4 py-3 text-right">Jumlah Total</th>
                </tr>
            </thead>
            <tbody id="loaddetail" class="divide-y divide-gray-100 bg-white">
                @foreach ($detail as $d)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-mono font-medium text-gray-700">
                            <input type="hidden" name="kode_barang[]" value="{{ $d->kode_barang }}">
                            {{ $d->kode_barang }}
                        </td>
                        <td class="px-4 py-2 font-semibold text-gray-900">{{ textCamelCase($d->nama_barang) }}</td>
                        <td class="px-4 py-2 text-right">
                            <input type="text" class="w-full text-right px-2 py-1 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] outline-none number-separator font-bold text-gray-900" name="jumlah[]" value="{{ formatAngkaDesimal($d->jumlah) }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-2" id="saveButton">
        <button type="submit" id="btnSimpan" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            Update Data
        </button>
    </div>
</form>

<script>
$(function() {
    const formEdit = $("#formeditopnamegudanglogistik");

    if (typeof easyNumberSeparator === 'function') {
        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });
    }

    $("#getsaldo").click(function(e) {
        e.preventDefault();
        const bulan = formEdit.find("#bulan").val();
        const tahun = formEdit.find("#tahun").val();
        const kode_kategori = formEdit.find("#kode_kategori").val();

        if (bulan === "") {
            Swal.fire({ title: "Oops!", text: 'Bulan Harus Diisi !', icon: "warning" });
        } else if (tahun === "") {
            Swal.fire({ title: "Oops!", text: 'Tahun Harus Diisi !', icon: "warning" });
        } else if (kode_kategori === "") {
            Swal.fire({ title: "Oops!", text: 'Kategori Harus Diisi !', icon: "warning" });
        } else {
            $("#loaddetail").html('<tr><td colspan="3" class="px-4 py-6 text-center text-gray-500"><svg class="w-6 h-6 mx-auto animate-spin text-[#294C9A]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="block mt-2">Memuat saldo...</span></td></tr>');
            $.ajax({
                type: 'POST',
                url: '{{ route("opgudanglogistik.getdetailsaldo") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    bulan: bulan,
                    tahun: tahun,
                    kode_kategori: kode_kategori
                },
                cache: false,
                success: function(respond) {
                    if (respond == 1) {
                        Swal.fire({ title: "Oops!", text: 'Saldo Awal Bulan Ini Belum Dibuat !', icon: "warning" });
                        $("#loaddetail").html('');
                    } else {
                        $("#loaddetail").html(respond);
                    }
                }
            });
        }
    });

    formEdit.submit(function() {
        const bulan = formEdit.find("#bulan").val();
        const tahun = formEdit.find("#tahun").val();
        const kode_kategori = formEdit.find("#kode_kategori").val();

        if (bulan == "") {
            Swal.fire({ title: "Oops!", text: 'Bulan Harus Diisi !', icon: "warning" });
            return false;
        } else if (tahun == "") {
            Swal.fire({ title: "Oops!", text: 'Tahun Harus Diisi !', icon: "warning" });
            return false;
        } else if (kode_kategori == "") {
            Swal.fire({ title: "Oops!", text: 'Kategori Harus Diisi !', icon: "warning" });
            return false;
        } else if ($("#loaddetail tr").length == 0) {
            Swal.fire({ title: "Oops!", text: 'Detail Opname Masih Kosong !', icon: "warning" });
            return false;
        }
    });
});
</script>
