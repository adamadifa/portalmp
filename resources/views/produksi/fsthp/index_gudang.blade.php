<x-app-layout>
    <x-slot name="header">
        Form Serah Terima Hasil Produksi (FSTHP) - Gudang Jadi
    </x-slot>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar { font-family: 'Poppins', sans-serif; font-size: 12px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); border: 1px solid #e5e7eb; }
        .flatpickr-day.selected, .flatpickr-day.selected:hover { background: #294C9A; border-color: #294C9A; }
        .flatpickr-day:hover { background: #EEF2FF; }
        .flatpickr-months .flatpickr-month { background: #294C9A; color: white; border-radius: 12px 12px 0 0; }
        .flatpickr-current-month .flatpickr-monthDropdown-months, .flatpickr-current-month input.cur-year { color: white; }
        .flatpickr-weekday { color: #294C9A; font-weight: 600; }
        .flatpickr-prev-month svg, .flatpickr-next-month svg { fill: white; }
    </style>

    <!-- Header & Subtitle -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Form Serah Terima Hasil Produksi (FSTHP)</h2>
        <p class="text-sm text-gray-500 mt-1">Konfirmasi penerimaan FSTHP dari produksi.</p>
    </div>

    <!-- Navigation Tabs -->
    @include('layouts.navigation_mutasigudangjadi')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <div class="lg:col-span-2 space-y-6">
            <!-- Filter -->
            <div class="mb-4">
                <form action="{{ route('fsthpgudang.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                    <div class="flex-1">
                        <input type="text" name="tanggal_mutasi_search" id="tanggal_mutasi_search" value="{{ Request('tanggal_mutasi_search') }}" 
                               class="block w-full py-2.5 px-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm flatpickr-date" placeholder="Cari Tanggal" autocomplete="off" />
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <h3 class="text-sm font-semibold">Data FSTHP</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                                <th class="py-3 px-4">No. FSTHP</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">Unit</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse ($fsthp as $d)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                                <td class="py-2.5 px-4">
                                    <button type="button" onclick="openModalShow('{{ Crypt::encrypt($d->no_mutasi) }}')" class="font-bold text-blue-600 hover:text-blue-800">
                                        {{ $d->no_mutasi }}
                                    </button>
                                </td>
                                <td class="py-2.5 px-4 text-gray-700 font-medium">{{ date('d-m-Y', strtotime($d->tanggal_mutasi)) }}</td>
                                <td class="py-2.5 px-4 text-gray-600">{{ $d->unit }}</td>
                                <td class="py-2.5 px-4">
                                    @if ($d->status === '1')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-200">Diterima Gudang</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-200">Belum Diterima</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-4 font-medium text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <button type="button" onclick="openModalShow('{{ Crypt::encrypt($d->no_mutasi) }}')" class="p-1.5 text-cyan-600 hover:bg-cyan-50 rounded-lg transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        @if ($d->status !== '1')
                                        <a href="{{ route('fsthp.approve', Crypt::encrypt($d->no_mutasi)) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition" title="Terima">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </a>
                                        @else
                                        <form action="{{ route('fsthp.cancel', Crypt::encrypt($d->no_mutasi)) }}" method="POST" class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan penerimaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Batalkan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 px-4 text-center text-sm text-gray-400">Belum ada data FSTHP.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $fsthp->links() }}
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div>
            <div class="bg-gradient-to-br from-[#002e65] to-[#294C9A] p-6 rounded-2xl text-white shadow-md">
                <h4 class="font-bold text-lg mb-3">Konfirmasi FSTHP</h4>
                <p class="text-xs text-blue-100 leading-relaxed mb-4">
                    Gunakan panel ini untuk memverifikasi penerimaan serah terima hasil produksi ke dalam saldo gudang jadi.
                </p>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">1</div>
                        <span class="text-xs text-blue-100">Klik icon centang hijau untuk menerima dan memasukkan data ke gudang.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">2</div>
                        <span class="text-xs text-blue-100">Gunakan icon minus kuning untuk membatalkan penerimaan jika ada kesalahan data.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="modalShow" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalShowContentWrapper">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900">Rincian FSTHP</h3>
                <button onclick="closeModal('modalShow')" class="text-gray-400 hover:text-gray-500" type="button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6" id="modalShowContent">
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#294C9A]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flatpickr Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    @push('myscript')
    <script>
        $(function() {
            flatpickr("#tanggal_mutasi_search", {
                dateFormat: "Y-m-d",
                locale: "id",
                allowInput: true
            });

            // Modal animation helper functions
            window.openModal = function(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    wrapper.classList.remove('scale-95', 'opacity-0');
                    wrapper.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            window.closeModal = function(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                wrapper.classList.remove('scale-100', 'opacity-100');
                wrapper.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            window.openModalShow = function(code) {
                openModal('modalShow');
                $("#modalShowContent").load(`/fsthp/${code}/show`);
            }
        });
    </script>
    @endpush
</x-app-layout>
