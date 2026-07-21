<x-app-layout>
    <x-slot name="header">
        Barang Keluar Gudang Logistik
    </x-slot>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
    /* ── Isolated Floating Label & Icon Group ──────────── */
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

    .c-fl-group:focus-within .c-fl-icon {
        color: #294C9A !important;
    }

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

    .c-fl-group:focus-within .c-fl-label {
        color: #294C9A !important;
    }

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
        box-shadow: 0 0 0 3px rgba(41, 76, 154, 0.10) !important;
    }
    .fi::placeholder { color: #9CA3AF !important; font-size: 11.5px !important; }

    /* Select2 Alignment */
    .select2-container { width: 100% !important; }
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #D1D5DB !important;
        border-radius: 8px !important;
        background-color: #ffffff !important;
        position: relative !important;
        display: block !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #294C9A !important;
        box-shadow: 0 0 0 3px rgba(41, 76, 154, 0.10) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: flex !important;
        align-items: center !important;
        height: 100% !important;
        line-height: normal !important;
        padding-left: 34px !important;
        padding-right: 32px !important;
        font-size: 12px !important;
        color: #111827 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute !important;
        top: 50% !important;
        right: 10px !important;
        transform: translateY(-50%) !important;
        height: 16px !important;
        width: 16px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        border-color: #6B7280 transparent transparent transparent !important;
        border-style: solid !important;
        border-width: 5px 4px 0 4px !important;
    }

    /* Flatpickr Theme */
    .flatpickr-calendar {
        background: #ffffff !important;
        border-radius: 16px !important;
        border: 1px solid #E5E7EB !important;
        box-shadow: 0 20px 35px -10px rgba(41, 76, 154, 0.22), 0 10px 20px -5px rgba(0, 0, 0, 0.08) !important;
        font-family: inherit !important;
        overflow: hidden !important;
        width: 307px !important;
        z-index: 99999 !important;
    }
    .flatpickr-months {
        background: linear-gradient(135deg, #294C9A 0%, #1E3A70 100%) !important;
        padding: 8px 10px !important;
        align-items: center !important;
        border-radius: 15px 15px 0 0 !important;
    }
    .flatpickr-months .flatpickr-month { color: #ffffff !important; height: 38px !important; }
    .flatpickr-current-month { font-size: 14px !important; font-weight: 700 !important; color: #ffffff !important; padding-top: 4px !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months { font-weight: 700 !important; color: #ffffff !important; background: transparent !important; }
    .flatpickr-current-month input.cur-year { font-weight: 700 !important; color: #ffffff !important; }
    .flatpickr-months .flatpickr-prev-month, .flatpickr-months .flatpickr-next-month { padding: 8px !important; color: #ffffff !important; fill: #ffffff !important; }
    .flatpickr-weekdays { background: #F3F4F6 !important; padding: 8px 0 !important; border-bottom: 1px solid #E5E7EB !important; }
    span.flatpickr-weekday { color: #294C9A !important; font-weight: 700 !important; font-size: 11px !important; text-transform: uppercase !important; }
    .flatpickr-days { width: 307px !important; padding: 6px !important; }
    .dayContainer { width: 294px !important; min-width: 294px !important; max-width: 294px !important; }
    .flatpickr-day { color: #111827 !important; font-weight: 700 !important; font-size: 13px !important; border-radius: 10px !important; height: 38px !important; line-height: 38px !important; max-width: 38px !important; margin: 2px !important; }
    .flatpickr-day:hover { background: #EBF1FF !important; color: #294C9A !important; font-weight: 800 !important; }
    .flatpickr-day.today { border: 2px solid #294C9A !important; color: #294C9A !important; font-weight: 800 !important; background: #F0F4FF !important; }
    .flatpickr-day.selected, .flatpickr-day.selected:hover { background: linear-gradient(135deg, #294C9A 0%, #1E3A70 100%) !important; color: #ffffff !important; font-weight: 800 !important; }
    </style>

    <!-- Header & Navigation -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Barang Keluar Gudang Logistik</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola data pengeluaran barang dari gudang logistik.</p>
    </div>

    <!-- Navigation Tabs -->
    @include('layouts.navigation_mutasigudanglogistik')

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
        <form action="{{ route('barangkeluargudanglogistik.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <div class="md:col-span-3">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="dari" id="dari" value="{{ Request('dari') }}" class="fi flatpickr-date" placeholder="Dari Tanggal" autocomplete="off" />
                        <label for="dari" class="c-fl-label">Dari Tanggal</label>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="sampai" id="sampai" value="{{ Request('sampai') }}" class="fi flatpickr-date" placeholder="Sampai Tanggal" autocomplete="off" />
                        <label for="sampai" class="c-fl-label">Sampai Tanggal</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="no_bukti_search" id="no_bukti_search" value="{{ Request('no_bukti_search') }}" class="fi" placeholder="No. Bukti" autocomplete="off" />
                        <label for="no_bukti_search" class="c-fl-label">No. Bukti</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </span>
                        <select name="kode_jenis_pengeluaran" id="kode_jenis_pengeluaran" class="fi">
                            <option value="">Semua Jenis</option>
                            @foreach ($list_jenis_pengeluaran as $d)
                                <option value="{{ $d['kode_jenis_pengeluaran'] }}" {{ Request('kode_jenis_pengeluaran') == $d['kode_jenis_pengeluaran'] ? 'selected' : '' }}>{{ $d['jenis_pengeluaran'] }}</option>
                            @endforeach
                        </select>
                        <label for="kode_jenis_pengeluaran" class="c-fl-label">Jenis Pengeluaran</label>
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
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <h3 class="font-bold text-base">Data Barang Keluar</h3>
            </div>
            @can('barangkeluargl.create')
            <button type="button" onclick="openModalCreate()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#294C9A] bg-white rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Data
            </button>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-bold">NO. BUKTI</th>
                        <th class="px-4 py-3 font-bold text-center">TANGGAL</th>
                        <th class="px-4 py-3 font-bold">JENIS PENGELUARAN</th>
                        <th class="px-4 py-3 font-bold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($barangkeluar as $d)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-4 py-3 font-bold text-[#294C9A] font-mono">{{ $d->no_bukti }}</td>
                            <td class="px-4 py-3 text-center font-medium text-gray-700">{{ DateToIndo($d->tanggal) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-[#294C9A]">
                                    {{ $jenis_pengeluaran[$d->kode_jenis_pengeluaran] ?? $d->kode_jenis_pengeluaran }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @can('barangkeluargl.edit')
                                        <button type="button" onclick="openModalEdit('{{ Crypt::encrypt($d->no_bukti) }}')" class="p-1 text-emerald-600 hover:text-emerald-800 transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                    @endcan

                                    @can('barangkeluargl.show')
                                        <button type="button" onclick="openModalShow('{{ Crypt::encrypt($d->no_bukti) }}')" class="p-1 text-sky-600 hover:text-sky-800 transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    @endcan

                                    @can('barangkeluargl.delete')
                                        <form method="POST" action="{{ route('barangkeluargudanglogistik.delete', Crypt::encrypt($d->no_bukti)) }}" class="inline deleteform">
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
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                Data Barang Keluar Gudang Logistik tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-100">
            {{ $barangkeluar->links() }}
        </div>
    </div>

    <!-- Modal Dialog -->
    <div id="modalDialog" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
                <h3 id="modalTitle" class="text-base font-bold">Modal Title</h3>
                <button type="button" onclick="closeModal()" class="text-white/80 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div id="modalBody" class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr.localize(flatpickr.l10ns.id);
        flatpickr(".flatpickr-date", {
            dateFormat: "Y-m-d"
        });

        function openModalCreate() {
            $('#modalTitle').text('Tambah Data Barang Keluar Gudang Logistik');
            $('#modalBody').html('<div class="flex items-center justify-center py-8"><svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>');
            $('#modalDialog').removeClass('hidden');

            $.get("{{ route('barangkeluargudanglogistik.create') }}", function(data) {
                $('#modalBody').html(data);
            });
        }

        function openModalEdit(no_bukti) {
            $('#modalTitle').text('Edit Data Barang Keluar Gudang Logistik');
            $('#modalBody').html('<div class="flex items-center justify-center py-8"><svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>');
            $('#modalDialog').removeClass('hidden');

            let url = "{{ route('barangkeluargudanglogistik.edit', ':no_bukti') }}".replace(':no_bukti', no_bukti);
            $.get(url, function(data) {
                $('#modalBody').html(data);
            });
        }

        function openModalShow(no_bukti) {
            $('#modalTitle').text('Detail Barang Keluar Gudang Logistik');
            $('#modalBody').html('<div class="flex items-center justify-center py-8"><svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>');
            $('#modalDialog').removeClass('hidden');

            let url = "{{ route('barangkeluargudanglogistik.show', ':no_bukti') }}".replace(':no_bukti', no_bukti);
            $.get(url, function(data) {
                $('#modalBody').html(data);
            });
        }

        function closeModal() {
            $('#modalDialog').addClass('hidden');
        }

        $('.delete-confirm').click(function(e) {
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
