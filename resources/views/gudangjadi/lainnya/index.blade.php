<x-app-layout>
    <x-slot name="header">
        Lainnya Gudang Jadi
    </x-slot>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Header & Subtitle -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Lainnya Gudang Jadi</h2>
        <p class="text-sm text-gray-500 mt-1">Mengelola data mutasi penyesuaian/lainnya di gudang jadi.</p>
    </div>

    <!-- Navigation Tabs -->
    @include('layouts.navigation_mutasigudangjadi')

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 rounded-xl border border-green-200 flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200 flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <div class="lg:col-span-2 space-y-6">
            <!-- Filter -->
            <div class="mb-4">
                <form action="{{ route('lainnyagudangjadi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                    <div class="flex-1">
                        <input type="text" name="dari" id="dari" value="{{ Request('dari') }}" 
                               class="block w-full py-2.5 px-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm flatpickr-date" placeholder="Dari Tanggal" autocomplete="off" />
                    </div>
                    <div class="flex-1">
                        <input type="text" name="sampai" id="sampai" value="{{ Request('sampai') }}" 
                               class="block w-full py-2.5 px-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition shadow-sm flatpickr-date" placeholder="Sampai Tanggal" autocomplete="off" />
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <h3 class="text-sm font-semibold">Data Mutasi Lainnya</h3>
                    </div>
                    @can('lainnyagudangjadi.create')
                    <button type="button" onclick="openModalCreate()" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-[#294C9A] bg-white rounded-lg hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Data
                    </button>
                    @endcan
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                                <th class="py-3 px-4">No. Dokumen</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4">In/Out</th>
                                <th class="py-3 px-4">Keterangan</th>
                                <th class="py-3 px-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse ($lainnya as $d)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                                <td class="py-2.5 px-4 font-bold text-[#294C9A]">{{ $d->no_mutasi }}</td>
                                <td class="py-2.5 px-4 text-gray-700 font-medium">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                <td class="py-2.5 px-4">
                                    @if ($d->in_out === 'I')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-50 text-green-700 border border-green-200">IN (Masuk)</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-50 text-red-700 border border-red-200">OUT (Keluar)</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-4 text-gray-600 font-medium text-xs">{{ $d->keterangan }}</td>
                                <td class="py-2.5 px-4 font-medium text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        @can('lainnyagudangjadi.show')
                                        <button type="button" onclick="openModalShow('{{ Crypt::encrypt($d->no_mutasi) }}')" class="p-1.5 text-cyan-600 hover:bg-cyan-50 rounded-lg transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        @endcan
                                        
                                        @can('lainnyagudangjadi.edit')
                                        <button type="button" onclick="openModalEdit('{{ Crypt::encrypt($d->no_mutasi) }}')" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        @endcan

                                        @can('lainnyagudangjadi.delete')
                                        <button type="button" class="btn-delete p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" data-code="{{ Crypt::encrypt($d->no_mutasi) }}" data-name="{{ $d->no_mutasi }}" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 px-4 text-center text-sm text-gray-400">Belum ada data mutasi lainnya.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $lainnya->links() }}
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div>
            <div class="bg-gradient-to-br from-[#002e65] to-[#294C9A] p-6 rounded-2xl text-white shadow-md">
                <h4 class="font-bold text-lg mb-3">Informasi Mutasi Lainnya</h4>
                <p class="text-xs text-blue-100 leading-relaxed mb-4">
                    Menu Mutasi Lainnya digunakan untuk menginput penyesuaian stok di luar transaksi standar seperti perbaikan administrasi stok.
                </p>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">1</div>
                        <span class="text-xs text-blue-100">Gunakan tipe IN untuk penambahan stok dan OUT untuk pengurangan stok.</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs shrink-0">2</div>
                        <span class="text-xs text-blue-100">Masukkan alasan penyesuaian pada kolom Keterangan secara detail.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="modalCreate" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCreateContentWrapper">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between border-b border-white/10 text-white">
                <h3 class="text-sm font-bold">Tambah Data Lainnya</h3>
                <button onclick="closeModal('modalCreate')" class="text-white/80 hover:text-white" type="button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 max-h-[85vh] overflow-y-auto" id="modalCreateContent">
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#294C9A]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="modalEdit" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalEditContentWrapper">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between border-b border-white/10 text-white">
                <h3 class="text-sm font-bold">Edit Data Lainnya</h3>
                <button onclick="closeModal('modalEdit')" class="text-white/80 hover:text-white" type="button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 max-h-[85vh] overflow-y-auto" id="modalEditContent">
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#294C9A]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="modalShow" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalShowContentWrapper">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900">Rincian Mutasi</h3>
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
            flatpickr(".flatpickr-date", {
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

            window.openModalCreate = function() {
                openModal('modalCreate');
                $("#modalCreateContent").load(`/lainnyagudangjadi/create`, function() {
                    initFormValidation('#formcreateLainnya');
                });
            }

            window.openModalEdit = function(code) {
                openModal('modalEdit');
                $("#modalEditContent").load(`/lainnyagudangjadi/${code}/edit`, function() {
                    initFormValidation('#formeditLainnya');
                });
            }

            window.openModalShow = function(code) {
                openModal('modalShow');
                $("#modalShowContent").load(`/lainnyagudangjadi/${code}/show`);
            }

            // SweetAlert2 Delete Confirmation
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const code = $(this).data('code');
                const name = $(this).data('name');
                
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: `Data mutasi "${name}" akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-xl mr-2',
                        cancelButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/lainnyagudangjadi/${code}`;
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            function initFormValidation(formSelector) {
                const form = $(formSelector);
                const inputs = form.find('input[required], select[required]');

                function validateField(field) {
                    const input = $(field);
                    const value = input.val() ? input.val().trim() : '';
                    let isValid = true;
                    let errorMsg = '';

                    if (value === '') {
                        isValid = false;
                        errorMsg = 'Kolom ini tidak boleh kosong.';
                    }

                    input.parent().find('.error-msg').remove();

                    if (!isValid) {
                        input.addClass('is-invalid');
                        input.after('<p class="text-xs text-red-500 mt-1 error-msg">' + errorMsg + '</p>');
                    } else {
                        input.removeClass('is-invalid');
                    }
                    return isValid;
                }

                inputs.on('keyup input change blur', function() {
                    validateField(this);
                });

                form.on('submit', function(e) {
                    let formIsValid = true;
                    inputs.each(function() {
                        if (!validateField(this)) {
                            formIsValid = false;
                        }
                    });
                    
                    // Custom validation for table items
                    if (form.find('#loaddetail tr').length == 0) {
                        Swal.fire({
                            title: "Oops!",
                            text: "Data Produk Masih Kosong !",
                            icon: "warning",
                            customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                            buttonsStyling: false
                        });
                        formIsValid = false;
                    }

                    if (!formIsValid) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
