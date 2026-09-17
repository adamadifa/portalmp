<x-app-layout>
    <x-slot name="header">
        Buat Saldo Awal Buku Besar
    </x-slot>

    <!-- Header & Subtitle -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Buat Saldo Awal Buku Besar</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih periode bulan dan tahun lalu klik "Get Saldo" untuk memuat atau menginisialisasi saldo awal.</p>
        </div>
        <a href="{{ route('saldoawalbukubesar.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-5xl">
        <form action="{{ route('saldoawalbukubesar.store') }}" method="POST" id="formCreatesaldoawal" autocomplete="off">
            @csrf
            <!-- Filter Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Bulan -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Bulan</label>
                    <select name="bulan" id="bulan" class="w-full py-2.5 px-3.5 text-sm bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:outline-none transition">
                        <option value="">Pilih Bulan</option>
                        @foreach ($list_bulan as $d)
                            <option value="{{ $d['kode_bulan'] }}" {{ date('m') == $d['kode_bulan'] ? 'selected' : '' }}>{{ $d['nama_bulan'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tahun</label>
                    <select name="tahun" id="tahun" class="w-full py-2.5 px-3.5 text-sm bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:outline-none transition">
                        <option value="">Pilih Tahun</option>
                        @for ($t = $start_year; $t <= date('Y') + 1; $t++)
                            <option value="{{ $t }}" {{ date('Y') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Get Saldo Button -->
                <div class="flex items-end">
                    <button type="button" class="w-full bg-[#294C9A] hover:bg-[#1E3A70] text-white px-4 py-2.5 rounded-xl flex items-center justify-center gap-2 transition shadow-sm font-semibold text-sm h-[42px]" id="getsaldo">
                        <svg id="getsaldo-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span id="getsaldo-text">Get Saldo</span>
                        <div id="getsaldo-loading" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    </button>
                </div>
            </div>

            <!-- Table of Account Balances -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm mb-6">
                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/75 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-semibold sticky top-0 z-10">
                                <th class="px-4 py-3.5">Akun (COA)</th>
                                <th class="px-4 py-3.5 text-right w-64">Jumlah Saldo (Rp)</th>
                            </tr>
                        </thead>
                        <tbody id="loaddetailsaldo" class="divide-y divide-gray-100 text-sm">
                            <tr id="empty-row">
                                <td colspan="2" class="px-4 py-12 text-center text-gray-400 italic">
                                    Pilih Bulan & Tahun di atas lalu klik tombol <strong class="text-gray-600 font-medium">"Get Saldo"</strong> untuk menampilkan daftar akun.
                                </td>
                            </tr>
                            <tr id="loading-row" class="hidden">
                                <td colspan="2" class="px-4 py-16 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-7 h-7 border-2 border-[#294C9A] border-t-transparent rounded-full animate-spin"></div>
                                        <p class="text-xs font-semibold text-gray-500">Memuat saldo akun...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Submit Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('saldoawalbukubesar.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" id="btnSubmit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    <span>Simpan Saldo Awal</span>
                </button>
            </div>
        </form>
    </div>

    @push('myscript')
    <script>
        $(function() {
            // Function to apply formatting
            function initMoney() {
                if (typeof easyNumberSeparator !== 'undefined') {
                    easyNumberSeparator({
                        selector: '.money',
                        separator: '.'
                    });
                }
            }

            $('#getsaldo').on('click', function(e) {
                e.preventDefault();
                let bulan = $('#bulan').val();
                let tahun = $('#tahun').val();

                if (!bulan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih Bulan terlebih dahulu!',
                        confirmButtonColor: '#294C9A'
                    });
                    return;
                }
                if (!tahun) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih Tahun terlebih dahulu!',
                        confirmButtonColor: '#294C9A'
                    });
                    return;
                }

                // Show loading
                $('#getsaldo-icon').addClass('hidden');
                $('#getsaldo-loading').removeClass('hidden');
                $('#getsaldo-text').text('Memuat...');
                $('#empty-row').addClass('hidden');
                $('#loading-row').removeClass('hidden');

                $.ajax({
                    url: "{{ route('saldoawalbukubesar.getsaldo') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    success: function(response) {
                        $('#loaddetailsaldo').html(response);
                        initMoney();
                    },
                    error: function(xhr) {
                        let msg = 'Terjadi kesalahan saat memuat saldo.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: msg,
                            confirmButtonColor: '#294C9A'
                        });
                        $('#loading-row').addClass('hidden');
                        $('#empty-row').removeClass('hidden');
                    },
                    complete: function() {
                        $('#getsaldo-icon').removeClass('hidden');
                        $('#getsaldo-loading').addClass('hidden');
                        $('#getsaldo-text').text('Get Saldo');
                    }
                });
            });

            $('#formCreatesaldoawal').on('submit', function(e) {
                let inputs = $('#loaddetailsaldo input[name="kode_akun[]"]');
                if (inputs.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan klik "Get Saldo" terlebih dahulu sebelum menyimpan data!',
                        confirmButtonColor: '#294C9A'
                    });
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
