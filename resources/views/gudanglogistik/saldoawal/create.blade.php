<x-app-layout>
    <x-slot name="header">
        Buat Saldo Awal Gudang Logistik
    </x-slot>

    <style>
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
    .c-fl-group:focus-within .c-fl-icon { color: #294C9A !important; }
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
    .c-fl-group:focus-within .c-fl-label { color: #294C9A !important; }
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
        box-shadow: 0 0 0 3px rgba(41,76,154,.10) !important;
    }
    </style>

    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
            <a href="{{ route('sagudanglogistik.index') }}" class="hover:text-[#294C9A] transition">Saldo Awal Gudang Logistik</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-gray-700 font-medium">Buat Saldo Awal</span>
        </div>
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Buat Saldo Awal Gudang Logistik</h2>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7zm4 0h8m-8 4h8m-8 4h5"></path></svg>
            <h3 class="font-bold text-base">Form Saldo Awal Gudang Logistik</h3>
        </div>

        <div class="p-6">
            <form action="{{ route('sagudanglogistik.store') }}" method="POST" id="formcreatesaldoawal" class="space-y-5">
                @csrf

                <!-- Top Fields in 1 row -->
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
                                    <option value="{{ $k_bln }}" {{ date('m') == $k_bln ? 'selected' : '' }}>{{ $n_bln }}</option>
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
                                    <option value="{{ $t }}" {{ date('Y') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endfor
                            </select>
                            <label for="tahun" class="c-fl-label">Tahun *</label>
                        </div>
                    </div>

                    <div class="md:col-span-4">
                        <div class="c-fl-group">
                            <span class="c-fl-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10M7 17h10"></path></svg>
                            </span>
                            <select name="kode_kategori" id="kode_kategori" class="fi">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $d)
                                    <option value="{{ $d->kode_kategori }}">{{ strtoupper($d->nama_kategori) }}</option>
                                @endforeach
                            </select>
                            <label for="kode_kategori" class="c-fl-label">Kategori *</label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <button type="button" id="getsaldo" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Get Saldo
                        </button>
                    </div>
                </div>

                <!-- Divider -->
                <div class="relative my-2">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-start"><span class="pr-3 text-xs font-semibold text-[#294C9A] bg-white">Detail Saldo Awal Barang</span></div>
                </div>

                <!-- Detail Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="w-full text-xs text-left">
                        <thead class="text-xs uppercase bg-[#002e65] text-white">
                            <tr>
                                <th class="px-4 py-3">Kode Barang</th>
                                <th class="px-4 py-3">Nama Barang</th>
                                <th class="px-4 py-3 text-right">Jumlah</th>
                                <th class="px-4 py-3 text-right">Harga</th>
                            </tr>
                        </thead>
                        <tbody id="loaddetailsaldo" class="divide-y divide-gray-100 bg-white">
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-400 text-xs">
                                    Pilih Bulan, Tahun, dan Kategori lalu klik <strong>Get Saldo</strong>.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('myscript')
    <script>
    $(function() {
        const formCreate = $("#formcreatesaldoawal");

        $("#getsaldo").click(function(e) {
            e.preventDefault();
            const bulan = formCreate.find("#bulan").val();
            const tahun = formCreate.find("#tahun").val();
            const kode_kategori = formCreate.find("#kode_kategori").val();

            if (bulan === "") {
                Swal.fire({ title: "Oops!", text: 'Bulan Harus Diisi !', icon: "warning" });
            } else if (tahun === "") {
                Swal.fire({ title: "Oops!", text: 'Tahun Harus Diisi !', icon: "warning" });
            } else if (kode_kategori === "") {
                Swal.fire({ title: "Oops!", text: 'Kategori Harus Diisi !', icon: "warning" });
            } else {
                $("#loaddetailsaldo").html('<tr><td colspan="4" class="px-4 py-6 text-center text-gray-500"><svg class="w-6 h-6 mx-auto animate-spin text-[#294C9A]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="block mt-2">Memuat saldo...</span></td></tr>');
                $.ajax({
                    type: 'POST',
                    url: '{{ route("sagudanglogistik.getdetailsaldo") }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun,
                        kode_kategori: kode_kategori
                    },
                    cache: false,
                    success: function(respond) {
                        if (respond == 1) {
                            Swal.fire({ title: "Oops!", text: 'Saldo Bulan Sebelumnya Belum di Input !', icon: "warning" });
                            $("#loaddetailsaldo").html('<tr><td colspan="4" class="px-4 py-4 text-center text-gray-400 text-xs">Tidak ada data saldo.</td></tr>');
                        } else {
                            $("#loaddetailsaldo").html(respond);
                        }
                    },
                    error: function() {
                        Swal.fire({ title: "Error!", text: 'Gagal memuat saldo.', icon: "error" });
                    }
                });
            }
        });

        formCreate.submit(function() {
            const bulan = formCreate.find("#bulan").val();
            const tahun = formCreate.find("#tahun").val();
            const kode_kategori = formCreate.find("#kode_kategori").val();

            if (bulan == "") {
                Swal.fire({ title: "Oops!", text: 'Bulan Harus Diisi !', icon: "warning" });
                return false;
            } else if (tahun == "") {
                Swal.fire({ title: "Oops!", text: 'Tahun Harus Diisi !', icon: "warning" });
                return false;
            } else if (kode_kategori == "") {
                Swal.fire({ title: "Oops!", text: 'Kategori Harus Diisi !', icon: "warning" });
                return false;
            } else if ($("#loaddetailsaldo input[name='kode_barang[]']").length == 0) {
                Swal.fire({ title: "Oops!", text: 'Silakan Get Saldo Terlebih Dahulu !', icon: "warning" });
                return false;
            }
        });
    });
    </script>
    @endpush
</x-app-layout>
