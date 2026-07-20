<x-app-layout>
    <x-slot name="header">
        Saldo Awal Mutasi Produksi
    </x-slot>

    <!-- Header & Subtitle -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Saldo Awal Mutasi Produksi</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola data saldo awal mutasi produksi.</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-1" aria-label="Tabs">
            <a href="{{ route('samutasiproduksi.index') }}" class="border-b-2 border-[#294C9A] text-[#294C9A] px-4 py-3 text-sm font-semibold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path></svg>
                Saldo Awal
            </a>
            <a href="#" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 px-4 py-3 text-sm font-medium flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Barang Keluar
            </a>
            <a href="#" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 px-4 py-3 text-sm font-medium flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Barang Masuk
            </a>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <div class="lg:col-span-2 space-y-6">
            <!-- Filter -->
            <div class="mb-4">
                <form action="{{ route('samutasiproduksi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                    <div class="flex-1">
                        <select name="bulan" id="bulan" class="block w-full py-3 px-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm">
                            <option value="">Pilih Bulan</option>
                            @foreach ($list_bulan as $d)
                                <option {{ Request('bulan') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">{{ $d['nama_bulan'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <select name="tahun" id="tahun" class="block w-full py-3 px-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm">
                            <option value="">Pilih Tahun</option>
                            @for ($t = $start_year; $t <= date('Y'); $t++)
                                <option @if(!empty(Request('tahun'))) {{ Request('tahun') == $t ? 'selected' : '' }} @else {{ date('Y') == $t ? 'selected' : '' }} @endif value="{{ $t }}">{{ $t }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between border-b border-white/10">
                    <div class="flex items-center gap-2 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2z"></path></svg>
                        <h3 class="text-sm font-semibold">Data Saldo Awal Mutasi Produksi</h3>
                    </div>
                    @can('samutasiproduksi.create')
                    <a href="{{ route('samutasiproduksi.create') }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-[#294C9A] bg-white rounded-lg hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah
                    </a>
                    @endcan
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                                <th class="py-3 px-4" style="width: 15%;">Kode</th>
                                <th class="py-3 px-4" style="width: 25%;">Bulan</th>
                                <th class="py-3 px-4" style="width: 20%;">Tahun</th>
                                <th class="py-3 px-4" style="width: 25%;">Tanggal</th>
                                <th class="py-3 px-4 text-center" style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse ($saldo_awal as $d)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                                <td class="py-1.5 px-4">
                                    <button type="button" class="btn-show font-bold text-blue-600 hover:text-blue-800" data-code="{{ Crypt::encrypt($d->kode_saldo_awal) }}">
                                        {{ $d->kode_saldo_awal }}
                                    </button>
                                </td>
                                <td class="py-1.5 px-4 text-gray-700 font-medium">{{ $nama_bulan[$d->bulan] }}</td>
                                <td class="py-1.5 px-4 text-gray-500">{{ $d->tahun }}</td>
                                <td class="py-1.5 px-4 text-gray-500">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                <td class="py-1.5 px-4">
                                    <div class="flex items-center justify-center gap-3">
                                        <button type="button" class="btn-show p-1.5 text-cyan-600 hover:bg-cyan-50 rounded-lg transition" data-code="{{ Crypt::encrypt($d->kode_saldo_awal) }}" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        @can('samutasiproduksi.delete')
                                        <form action="{{ route('samutasiproduksi.destroy', Crypt::encrypt($d->kode_saldo_awal)) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 px-4 text-center text-sm text-gray-400">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div>
            <div class="bg-gradient-to-br from-[#002e65] to-[#294C9A] p-6 rounded-2xl text-white shadow-md">
                <h4 class="font-bold text-lg mb-3">Informasi Mutasi</h4>
                <p class="text-xs text-blue-100 leading-relaxed mb-4">
                    Tabel ini menampilkan saldo awal mutasi produksi pada periode bulan dan tahun terpilih.
                </p>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">1</div>
                        <span class="text-xs text-blue-100">Pilih periode Bulan & Tahun lalu tekan Cari.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">2</div>
                        <span class="text-xs text-blue-100">Klik Kode atau icon mata untuk melihat rincian produk.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="modalShow" class="fixed inset-0 z-50 overflow-y-auto hidden" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modalShowBackdrop"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-900">Rincian Saldo Awal</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" id="btnShowClose">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6" id="modalShowContent">
                    <div class="flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#294C9A]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
    <script>
        $(function() {
            const modalShow = $('#modalShow');
            const modalContent = $('#modalShowContent');

            $('.btn-show').click(function(e) {
                e.preventDefault();
                const code = $(this).data('code');
                modalShow.removeClass('hidden');
                modalContent.html(`<div class="flex justify-center items-center py-12"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#294C9A]"></div></div>`);
                $.ajax({
                    url: `/samutasiproduksi/${code}/show`,
                    type: 'GET',
                    success: function(response) { modalContent.html(response); },
                    error: function() { modalContent.html('<div class="text-red-500 text-center py-6">Gagal memuat data.</div>'); }
                });
            });

            $('#btnShowClose, #modalShowBackdrop').click(function() {
                modalShow.addClass('hidden');
            });
        });
    </script>
    @endpush
</x-app-layout>
