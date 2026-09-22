<x-app-layout>
    <x-slot name="header">
        Jurnal Umum
    </x-slot>

    <!-- Alert Notifications -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#294C9A'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif

    <style>
    /* ── Isolated Floating Label & Icon Group ──────────── */
    .c-fl-group {
        position: relative !important;
        width: 100% !important;
        margin-top: 10px !important;
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
        display: flex !important;
        align-items: center !important;
        padding-top: 0 !important;
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
    </style>

    <!-- Header & Navigation -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Data Jurnal Umum</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola data transaksi posting jurnal umum akuntansi dan pencatatan buku besar.</p>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-4">
        <form action="{{ route('jurnalumum.index') }}" method="GET" id="formSearch">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <div class="md:col-span-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="dari" id="dari" value="{{ Request('dari') ?? date('Y-m-01') }}" class="fi flatpickr-date" placeholder="Dari Tanggal" autocomplete="off" />
                        <label for="dari" class="c-fl-label">Dari Tanggal</label>
                    </div>
                </div>

                <div class="md:col-span-4">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="sampai" id="sampai" value="{{ Request('sampai') ?? date('Y-m-t') }}" class="fi flatpickr-date" placeholder="Sampai Tanggal" autocomplete="off" />
                        <label for="sampai" class="c-fl-label">Sampai Tanggal</label>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </span>
                        <select name="kode_akun_search" id="kode_akun_search" class="fi select2Akun">
                            <option value="">Semua Akun (COA)</option>
                            @foreach ($coa as $d)
                                <option value="{{ $d->kode_akun }}" {{ Request('kode_akun_search') == $d->kode_akun ? 'selected' : '' }}>
                                    {{ $d->kode_akun }} - {{ $d->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="font-bold text-base">Data Transaksi Jurnal Umum</h3>
            </div>
            <div class="flex items-center gap-2">
                @can('jurnalumum.create')
                <button type="button" id="btnCreate" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#294C9A] bg-white rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Input Jurnal Umum
                </button>
                @endcan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-600">
                <thead class="text-xs uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                    <tr>
                        <th class="px-4 py-3 font-bold">KODE JU</th>
                        <th class="px-4 py-3 font-bold">TANGGAL</th>
                        <th class="px-4 py-3 font-bold" style="min-width: 220px;">KETERANGAN</th>
                        <th class="px-4 py-3 font-bold" style="min-width: 200px;">AKUN</th>
                        <th class="px-4 py-3 font-bold text-end">DEBET</th>
                        <th class="px-4 py-3 font-bold text-end">KREDIT</th>
                        <th class="px-4 py-3 font-bold text-center">DEPT</th>
                        <th class="px-4 py-3 font-bold text-center w-24">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @php
                        $totDebet = 0;
                        $totKredit = 0;
                    @endphp
                    @forelse ($jurnalumum as $d)
                        @php
                            $debet = $d->debet_kredit == 'D' ? $d->jumlah : 0;
                            $kredit = $d->debet_kredit == 'K' ? $d->jumlah : 0;
                            $totDebet += $debet;
                            $totKredit += $kredit;
                        @endphp
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-4 py-3 font-bold text-[#294C9A] font-mono">{{ $d->kode_ju }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">{{ formatIndo($d->tanggal) }}</td>
                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $d->keterangan }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="font-bold text-[#294C9A]">{{ $d->kode_akun }}</span>
                                <span class="text-gray-500 block text-[11px]">{{ $d->nama_akun }}</span>
                            </td>
                            <td class="px-4 py-3 text-end font-semibold text-gray-900 whitespace-nowrap">
                                {{ $debet > 0 ? formatAngkaDesimal($debet) : '-' }}
                            </td>
                            <td class="px-4 py-3 text-end font-semibold text-gray-900 whitespace-nowrap">
                                {{ $kredit > 0 ? formatAngkaDesimal($kredit) : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $d->kode_dept ?? 'AKT' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    @can('jurnalumum.edit')
                                    <button type="button" class="btnEdit p-1 text-emerald-600 hover:text-emerald-800 transition" data-kode-ju="{{ Crypt::encrypt($d->kode_ju) }}" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    @endcan
                                    @can('jurnalumum.delete')
                                    <form action="{{ route('jurnalumum.delete', Crypt::encrypt($d->kode_ju)) }}" method="POST" class="inline formDelete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btnDelete p-1 text-red-600 hover:text-red-800 transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Data Transaksi Jurnal Umum tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($jurnalumum) > 0)
                <tfoot class="bg-gray-50/80 font-bold text-gray-900 border-t border-gray-200">
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-end uppercase text-xs tracking-wider">Total :</td>
                        <td class="px-4 py-3 text-end text-xs text-[#294C9A] font-bold whitespace-nowrap">{{ formatAngkaDesimal($totDebet) }}</td>
                        <td class="px-4 py-3 text-end text-xs text-[#294C9A] font-bold whitespace-nowrap">{{ formatAngkaDesimal($totKredit) }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Modal Form (Input / Edit) -->
    <div id="modalJurnalUmum" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all my-8 max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
                <h3 class="text-base font-bold flex items-center gap-2" id="modalTitle">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Input Jurnal Umum</span>
                </h3>
                <button type="button" class="text-white/80 hover:text-white transition" onclick="closeModal()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto flex-1" id="loadModal">
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
    <script>
        function openModal(title) {
            $('#modalTitle span').text(title);
            $('#modalJurnalUmum').removeClass('hidden');
            $('body').addClass('overflow-hidden');
        }

        function closeModal() {
            $('#modalJurnalUmum').addClass('hidden');
            $('body').removeClass('overflow-hidden');
            $('#loadModal').html(`
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            `);
        }

        $(function() {
            const select2Akun = $('.select2Akun');
            if (select2Akun.length) {
                select2Akun.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Semua Akun (COA)',
                        allowClear: true,
                        dropdownParent: $this.parent()
                    });
                });
            }

            $('#btnCreate').on('click', function(e) {
                e.preventDefault();
                openModal('Input Jurnal Umum');
                $('#loadModal').load("{{ route('jurnalumum.create') }}");
            });

            $(document).on('click', '.btnEdit', function(e) {
                e.preventDefault();
                const kode_ju = $(this).data('kode-ju');
                openModal('Edit Jurnal Umum');
                $('#loadModal').load(`/jurnalumum/${kode_ju}/edit`);
            });

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Data jurnal umum ini akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
