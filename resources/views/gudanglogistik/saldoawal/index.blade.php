<x-app-layout>
    <x-slot name="header">
        Saldo Awal Gudang Logistik
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
    .fi::placeholder { color: #9CA3AF !important; font-size: 11.5px !important; }
    </style>

    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Saldo Awal Gudang Logistik</h2>
        <p class="text-sm text-gray-500 mt-1">Manajemen saldo awal stok gudang logistik.</p>
    </div>

    <!-- Navigation Tabs -->
    @include('layouts.navigation_mutasigudanglogistik')

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
        <form action="{{ route('sagudanglogistik.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <div class="md:col-span-3">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <select name="bulan" id="bulan" class="fi">
                            <option value="">Semua Bulan</option>
                            @foreach ($list_bulan as $d)
                                @php
                                    $k_bln = is_array($d) ? $d['kode_bulan'] : $d->kode_bulan;
                                    $n_bln = is_array($d) ? $d['nama_bulan'] : $d->nama_bulan;
                                @endphp
                                <option value="{{ $k_bln }}" {{ Request('bulan') == $k_bln ? 'selected' : '' }}>{{ $n_bln }}</option>
                            @endforeach
                        </select>
                        <label for="bulan" class="c-fl-label">Bulan</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <select name="tahun" id="tahun" class="fi">
                            <option value="">Semua Tahun</option>
                            @for ($t = $start_year; $t <= date('Y'); $t++)
                                <option value="{{ $t }}" {{ Request('tahun') == $t || (empty(Request('tahun')) && date('Y') == $t) ? 'selected' : '' }}>{{ $t }}</option>
                            @endfor
                        </select>
                        <label for="tahun" class="c-fl-label">Tahun</label>
                    </div>
                </div>

                <div class="md:col-span-5">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10M7 17h10"></path></svg>
                        </span>
                        <select name="kode_kategori" id="kode_kategori" class="fi">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategori as $d)
                                <option value="{{ $d->kode_kategori }}" {{ Request('kode_kategori') == $d->kode_kategori ? 'selected' : '' }}>{{ strtoupper($d->nama_kategori) }}</option>
                            @endforeach
                        </select>
                        <label for="kode_kategori" class="c-fl-label">Kategori Barang</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari Data
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7zm4 0h8m-8 4h8m-8 4h5"></path></svg>
                <h3 class="font-bold text-base">Data Saldo Awal Gudang Logistik</h3>
            </div>
            @can('sagudanglogistik.create')
            <a href="{{ route('sagudanglogistik.create') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#294C9A] bg-white rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Data
            </a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-bold">KODE SALDO AWAL</th>
                        <th class="px-4 py-3 font-bold text-center">BULAN</th>
                        <th class="px-4 py-3 font-bold text-center">TAHUN</th>
                        <th class="px-4 py-3 font-bold">KATEGORI</th>
                        <th class="px-4 py-3 font-bold text-center">TANGGAL</th>
                        <th class="px-4 py-3 font-bold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($saldo_awal as $d)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-4 py-3 font-bold text-[#294C9A] font-mono">{{ $d->kode_saldo_awal }}</td>
                            <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $nama_bulan[$d->bulan] }}</td>
                            <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $d->tahun }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-[#294C9A]">
                                    {{ strtoupper($d->nama_kategori) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center font-medium text-gray-700">{{ DateToIndo($d->tanggal) }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @can('sagudanglogistik.show')
                                        <button type="button" onclick="openModalShow('{{ Crypt::encrypt($d->kode_saldo_awal) }}')" class="p-1 text-sky-600 hover:text-sky-800 transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    @endcan

                                    @can('sagudanglogistik.delete')
                                        <form method="POST" action="{{ route('sagudanglogistik.delete', Crypt::encrypt($d->kode_saldo_awal)) }}" class="inline deleteform">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition delete-confirm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7zm4 0h8m-8 4h8m-8 4h5"></path></svg>
                                Data Saldo Awal Gudang Logistik tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Dialog -->
    <div id="modalDialog" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
                <h3 id="modalTitle" class="text-base font-bold">Modal Title</h3>
                <button type="button" onclick="closeModal()" class="text-white/80 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="modalBody" class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
    <script>
        function openModalShow(kode_saldo_awal) {
            $('#modalTitle').text('Detail Saldo Awal Gudang Logistik');
            $('#modalBody').html('<div class="flex items-center justify-center py-8"><svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>');
            $('#modalDialog').removeClass('hidden');
            let url = "{{ route('sagudanglogistik.show', ':kode') }}".replace(':kode', kode_saldo_awal);
            $.get(url, function(data) {
                $('#modalBody').html(data);
            });
        }

        function closeModal() {
            $('#modalDialog').addClass('hidden');
        }

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#294C9A',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
