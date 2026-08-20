<x-app-layout>
    <x-slot name="header">
        Penjualan Marketing
    </x-slot>

    <!-- Header & Navigation -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Penjualan Marketing</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola data transaksi penjualan produk ke Portax.</p>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#294C9A'
                });
            });
        </script>
    @endif

    <!-- Filter Panel (c-fl-group style) -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-4">
        <form action="{{ route('penjualanmarketing.index') }}" method="GET" id="formSearch">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <div class="md:col-span-3">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        </span>
                        <input type="text" name="no_bukti_search" id="no_bukti_search" value="{{ request('no_bukti_search') }}" class="fi" placeholder="No. Bukti Penjualan" autocomplete="off" />
                        <label for="no_bukti_search" class="c-fl-label">No. Bukti Penjualan</label>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input type="text" name="nama_pelanggan_search" id="nama_pelanggan_search" value="{{ request('nama_pelanggan_search') }}" class="fi" placeholder="Nama Pelanggan" autocomplete="off" />
                        <label for="nama_pelanggan_search" class="c-fl-label">Nama Pelanggan</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="dari" id="dari" value="{{ request('dari') }}" class="fi flatpickr-date" placeholder="Dari Tanggal" autocomplete="off" />
                        <label for="dari" class="c-fl-label">Dari Tanggal</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="c-fl-group">
                        <span class="c-fl-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="text" name="sampai" id="sampai" value="{{ request('sampai') }}" class="fi flatpickr-date" placeholder="Sampai Tanggal" autocomplete="off" />
                        <label for="sampai" class="c-fl-label">Sampai Tanggal</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <h3 class="font-bold text-base">Data Transaksi Penjualan Marketing</h3>
            </div>
            @can('penjualanmarketing.create')
            <div class="flex gap-2">
                @can('penjualanmarketing.delete')
                <button type="button" id="btnHapusTerpilih" onclick="hapusTerpilih()" class="hidden inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-red-600 rounded-xl hover:bg-red-700 transition shadow-sm gap-1.5 animate-pulse">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Terpilih
                </button>
                @endcan
                <button type="button" onclick="resetPenjualan()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-red-600 rounded-xl hover:bg-red-700 transition shadow-sm gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Reset Penjualan
                </button>
                <button type="button" onclick="toggleModalImport()" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition shadow-sm gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import Excel
                </button>
                <a href="{{ route('penjualanmarketing.create') }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#294C9A] bg-white rounded-xl hover:bg-gray-50 transition shadow-sm gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Input Penjualan
                </a>
            </div>
            @endcan
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-sm uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                    <tr>
                        <th class="px-6 py-2.5 font-bold text-center w-12">
                            <input type="checkbox" id="checkAll" class="rounded border-gray-350 text-[#294C9A] focus:ring-[#294C9A] w-4 h-4 cursor-pointer">
                        </th>
                        <th class="px-6 py-2.5 font-bold">NO. BUKTI</th>
                        <th class="px-6 py-2.5 font-bold">TANGGAL</th>
                        <th class="px-6 py-2.5 font-bold">PELANGGAN</th>
                        <th class="px-6 py-2.5 font-bold">TRANSAKSI</th>
                        <th class="px-6 py-2.5 font-bold text-right">TOTAL</th>
                        <th class="px-6 py-2.5 font-bold text-center">STATUS</th>
                        <th class="px-6 py-2.5 font-bold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($penjualan as $d)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-2.5 text-center">
                                <input type="checkbox" name="selected_no_bukti[]" value="{{ $d->no_bukti }}" class="row-checkbox rounded border-gray-350 text-[#294C9A] focus:ring-[#294C9A] w-4 h-4 cursor-pointer">
                            </td>
                            <td class="px-6 py-2.5 font-bold text-[#294C9A] font-mono">
                                {{ $d->no_bukti }}
                            </td>
                            <td class="px-6 py-2.5 text-gray-600">
                                {{ date('d-m-Y', strtotime($d->tanggal)) }}
                            </td>
                            <td class="px-6 py-2.5 font-semibold text-gray-900">
                                {{ $d->nama_pelanggan }}
                            </td>
                            <td class="px-6 py-2.5 text-xs font-bold">
                                @if ($d->jenis_transaksi == 'T')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full">TUNAI ({{ $d->jenis_bayar }})</span>
                                @else
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full">KREDIT</span>
                                @endif
                            </td>
                            <td class="px-6 py-2.5 text-right font-semibold text-gray-900">
                                Rp {{ number_format($d->total, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-2.5 text-center">
                                @if ($d->status == '1')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Lunas</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Belum Lunas</span>
                                @endif
                            </td>
                            <td class="px-6 py-2.5">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Show -->
                                    <a href="{{ route('penjualanmarketing.show', Crypt::encrypt($d->no_bukti)) }}" class="text-blue-600 hover:text-blue-900 p-1.5 hover:bg-blue-50 rounded-lg transition" title="Detail Penjualan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <!-- Edit -->
                                    @can('penjualanmarketing.edit')
                                    <a href="{{ route('penjualanmarketing.edit', Crypt::encrypt($d->no_bukti)) }}" class="text-emerald-600 hover:text-emerald-900 p-1.5 hover:bg-emerald-50 rounded-lg transition" title="Edit Transaksi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @endcan
                                    <!-- Delete -->
                                    @can('penjualanmarketing.delete')
                                    <button type="button" class="btn-delete text-red-600 hover:text-red-950 p-1.5 hover:bg-red-50 rounded-lg transition" data-id="{{ Crypt::encrypt($d->no_bukti) }}" data-name="{{ $d->no_bukti }}" title="Hapus Transaksi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 px-6 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    <span>Belum ada data penjualan marketing.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($penjualan->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                {{ $penjualan->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Import Excel -->
    <div id="modalImport" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40 backdrop-blur-sm overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <h3 class="font-bold text-base text-white">Import Penjualan Excel</h3>
                </div>
                <button type="button" class="btn-close-modal text-white hover:text-gray-200 transition" onclick="toggleModalImport()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('penjualanmarketing.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" id="file_excel" name="file_excel" accept=".xlsx,.xls,.csv" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#294C9A] hover:file:bg-blue-100 transition border border-gray-200 rounded-xl p-2" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih Sheet</label>
                    <select name="sheet_name" id="import_sheet_name" class="w-full text-sm border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5">
                        <option value="">-- Unggah File Excel Dahulu --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                    <select name="jenis_transaksi" id="import_jenis_transaksi" class="w-full text-sm border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5" required>
                        <option value="K">Kredit (Tempo)</option>
                        <option value="T">Tunai (Cash)</option>
                    </select>
                </div>
                <div id="import_jenis_bayar_container" class="hidden">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jenis Bayar</label>
                    <select name="jenis_bayar" class="w-full text-sm border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 p-2.5">
                        <option value="TN">Cash / Tunai</option>
                        <option value="TR">Transfer</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition" onclick="toggleModalImport()">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-[#294C9A] rounded-xl hover:bg-[#1E3A70] transition shadow-sm">Proses Import</button>
                </div>
            </form>
        </div>
    </div>

    @push('myscript')
        <script>
            function toggleModalImport() {
                $('#modalImport').toggleClass('hidden');
            }

            $('#file_excel').change(function() {
                var file = this.files[0];
                if (!file) return;

                var formData = new FormData();
                formData.append('file_excel', file);
                formData.append('_token', '{{ csrf_token() }}');

                $('#import_sheet_name').html('<option value="">Sedang membaca sheet...</option>');

                $.ajax({
                    url: '{{ route("penjualanmarketing.getsheets") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            var options = '<option value="">-- Pilih Sheet / Deteksi Otomatis --</option>';
                            response.sheets.forEach(function(sheetName) {
                                options += '<option value="' + sheetName + '">' + sheetName + '</option>';
                            });
                            $('#import_sheet_name').html(options);
                        } else {
                            $('#import_sheet_name').html('<option value="">Gagal membaca sheet: ' + response.message + '</option>');
                        }
                    },
                    error: function() {
                        $('#import_sheet_name').html('<option value="">Gagal menghubungi server</option>');
                    }
                });
            });

            $('#import_jenis_transaksi').change(function() {
                if ($(this).val() == 'T') {
                    $('#import_jenis_bayar_container').removeClass('hidden');
                } else {
                    $('#import_jenis_bayar_container').addClass('hidden');
                }
            });

            // SweetAlert2 Delete Confirmation
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                Swal.fire({
                    title: 'Hapus Transaksi?',
                    text: "Apakah Anda yakin ingin menghapus transaksi '" + name + "'?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#294C9A',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '/penjualanmarketing/' + id
                        });
                        form.append($('<input>', {
                            'name': '_token',
                            'value': $('meta[name="csrf-token"]').attr('content'),
                            'type': 'hidden'
                        }));
                        form.append($('<input>', {
                            'name': '_method',
                            'value': 'DELETE',
                            'type': 'hidden'
                        }));
                        $('body').append(form);
                        form.submit();
                    }
                });
            });

            // SweetAlert2 Reset Penjualan Confirmation
            window.resetPenjualan = function() {
                Swal.fire({
                    title: 'Reset Semua Penjualan?',
                    text: "Seluruh data transaksi, item produk detail, dan histori pembayaran akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Reset Semua!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route("penjualanmarketing.reset") }}'
                        });
                        form.append($('<input>', {
                            'name': '_token',
                            'value': $('meta[name="csrf-token"]').attr('content'),
                            'type': 'hidden'
                        }));
                        $('body').append(form);
                        form.submit();
                    }
                });
            };

            // Checkbox logic and Bulk Delete
            $(document).on('change', '#checkAll', function() {
                $('.row-checkbox').prop('checked', this.checked);
                toggleBulkDeleteButton();
            });

            $(document).on('change', '.row-checkbox', function() {
                if ($('.row-checkbox:checked').length == $('.row-checkbox').length) {
                    $('#checkAll').prop('checked', true);
                } else {
                    $('#checkAll').prop('checked', false);
                }
                toggleBulkDeleteButton();
            });

            function toggleBulkDeleteButton() {
                var checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#btnHapusTerpilih').removeClass('hidden').addClass('inline-flex');
                } else {
                    $('#btnHapusTerpilih').addClass('hidden').removeClass('inline-flex');
                }
            }

            window.hapusTerpilih = function() {
                var selected = [];
                $('.row-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) return;

                Swal.fire({
                    title: 'Hapus Transaksi Terpilih?',
                    text: "Apakah Anda yakin ingin menghapus " + selected.length + " transaksi penjualan yang terpilih beserta detail dan pembayaran terkait?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route("penjualanmarketing.delete-selected") }}'
                        });
                        form.append($('<input>', {
                            'name': '_token',
                            'value': $('meta[name="csrf-token"]').attr('content'),
                            'type': 'hidden'
                        }));
                        selected.forEach(function(id) {
                            form.append($('<input>', {
                                'name': 'ids[]',
                                'value': id,
                                'type': 'hidden'
                            }));
                        });
                        $('body').append(form);
                        form.submit();
                    }
                });
            };
        </script>
    @endpush
</x-app-layout>
