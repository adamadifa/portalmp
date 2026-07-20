<x-app-layout>
    <x-slot name="header">
        Buat Saldo Awal Mutasi Produksi
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Buat Saldo Awal Mutasi Produksi</h2>
            <p class="text-sm text-gray-500 mt-1">Isi periode bulan dan tahun lalu klik "Get Saldo" untuk mengisi saldo awal.</p>
        </div>
        <div>
            <a href="{{ route('samutasiproduksi.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200 flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <div class="lg:col-span-2">
            <form action="{{ route('samutasiproduksi.store') }}" method="POST" id="formCreateSaldoMutasi" class="space-y-6">
                @csrf

                <!-- Period Filter (same style as filter form) -->
                <div class="mb-4">
                    <div class="flex flex-col sm:flex-row gap-2 w-full items-center">
                        <div class="flex-1 w-full">
                            <select name="bulan" id="bulan" required class="block w-full py-3 px-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm">
                                <option value="">Pilih Bulan *</option>
                                @foreach ($list_bulan as $d)
                                    <option value="{{ $d['kode_bulan'] }}">{{ $d['nama_bulan'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1 w-full">
                            <select name="tahun" id="tahun" required class="block w-full py-3 px-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm">
                                <option value="">Pilih Tahun *</option>
                                @for ($t = $start_year; $t <= date('Y'); $t++)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="w-full sm:w-auto">
                            <button type="button" id="getsaldo" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shadow-sm whitespace-nowrap">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Get Saldo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Detail Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="bg-[#294C9A] px-6 py-4 flex items-center gap-2 border-b border-white/10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <h3 class="text-sm font-semibold text-white">Detail Saldo Produk</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                                    <th class="py-3 px-4" style="width: 25%;">Kode Produk</th>
                                    <th class="py-3 px-4" style="width: 50%;">Nama Produk</th>
                                    <th class="py-3 px-4 text-right" style="width: 25%;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="loaddetailsaldo" class="text-sm divide-y divide-gray-100">
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-400">
                                        Silakan isi Periode Bulan & Tahun kemudian klik "Get Saldo".
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-end border-t border-gray-100">
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Saldo Awal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Guide Column -->
        <div>
            <div class="bg-gradient-to-br from-[#002e65] to-[#294C9A] p-6 rounded-2xl text-white shadow-md">
                <h4 class="font-bold text-lg mb-3">Panduan Pengisian</h4>
                <p class="text-xs text-blue-100 leading-relaxed mb-4">
                    Ikuti instruksi berikut untuk mendaftarkan saldo awal mutasi produksi:
                </p>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">1</div>
                        <span class="text-xs text-blue-100">Tentukan periode bulan dan tahun saldo awal.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">2</div>
                        <span class="text-xs text-blue-100">Klik "Get Saldo" untuk menarik daftar produk aktif beserta perhitungan sisa saldo dari bulan sebelumnya.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">3</div>
                        <span class="text-xs text-blue-100">Isi jumlah saldo jika form input tidak terkunci (Readonly), lalu tekan "Simpan Saldo Awal".</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
    <script>
        $(function() {
            function loaddetailsaldo() {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                if (bulan == "") {
                    Swal.fire({ title: "Oops!", text: "Silahkan Pilih dulu Bulan !", icon: "warning", showConfirmButton: true, customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false, didClose: () => $("#bulan").focus() });
                    return false;
                } else if (tahun == "") {
                    Swal.fire({ title: "Oops!", text: "Silahkan Pilih dulu Tahun !", icon: "warning", showConfirmButton: true, customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false, didClose: () => $("#tahun").focus() });
                    return false;
                } else {
                    $("#loaddetailsaldo").html(`<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400"><div class="flex justify-center items-center gap-2"><div class="animate-spin rounded-full h-5 w-5 border-b-2 border-[#294C9A]"></div><span>Menarik data produk...</span></div></td></tr>`);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('samutasiproduksi.getdetailsaldo') }}",
                        data: { _token: "{{ csrf_token() }}", bulan: bulan, tahun: tahun },
                        cache: false,
                        success: function(respond) {
                            if (respond === '1') {
                                Swal.fire({ title: "Oops!", text: "Saldo Bulan Sebelumnya Belum di input !", icon: "warning", showConfirmButton: true, customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                                $("#loaddetailsaldo").html(`<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-red-500 font-semibold">Gagal: Saldo Bulan Sebelumnya Belum Diinput!</td></tr>`);
                            } else {
                                $("#loaddetailsaldo").html(respond);
                            }
                        }
                    });
                }
            }

            $("#getsaldo").click(function(e) {
                e.preventDefault();
                loaddetailsaldo();
            });

            $("#formCreateSaldoMutasi").submit(function(e) {
                if ($(this).find('#loaddetailsaldo input[name="kode_produk[]"]').length == 0) {
                    Swal.fire({ title: "Oops!", text: "Silakan Get Saldo Terlebih Dahulu !", icon: "warning", showConfirmButton: true, customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                    return false;
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
