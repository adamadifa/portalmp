<x-app-layout>
    <x-slot name="header">
        Harga Management
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Master Data Harga</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola harga beli produk dari supplier.</p>
        </div>
        <!-- Breadcrumbs -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs font-semibold text-gray-500">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center hover:text-gray-700">
                        <svg class="w-3 h-3 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        Data Master
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-[#294C9A] font-semibold">Harga</span>
                    </div>
                </li>
            </ol>
        </nav>
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

    <style>
        /* Custom Pagination Styling */
        nav[role="navigation"] svg {
            display: inline-block;
        }
        nav[role="navigation"] .relative.z-0.inline-flex.shadow-sm.rounded-md {
            box-shadow: none !important;
        }
        nav[role="navigation"] span.relative.z-0.inline-flex, 
        nav[role="navigation"] div.flex.justify-between.flex-1 {
            display: flex;
            gap: 4px;
        }
        nav[role="navigation"] a, 
        nav[role="navigation"] span[placeholder] {
            border-radius: 8px !important;
            border: 1px solid #294C9A !important;
            background-color: #294C9A !important;
            color: white !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            padding: 6px 12px !important;
            transition: all 0.2s;
        }
        nav[role="navigation"] span[aria-current="page"] > span {
            background-color: #1E3A70 !important;
            color: white !important;
            border-color: #1E3A70 !important;
            border-radius: 8px !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            padding: 6px 12px !important;
        }
        nav[role="navigation"] a:hover {
            background-color: #1E3A70 !important;
            border-color: #1E3A70 !important;
            color: white !important;
        }
        nav[role="navigation"] span[aria-disabled="true"] > span {
            background-color: #f3f4f6 !important;
            color: #9ca3af !important;
            border-color: #e5e7eb !important;
            border-radius: 8px !important;
            font-size: 11px !important;
            padding: 6px 12px !important;
        }
    </style>

    <!-- Compact Container -->
    <div class="max-w-4xl">
        <!-- Filter -->
        <div class="mb-4">
            <form action="{{ route('produkharga.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="nama_produk" value="{{ request('nama_produk') }}" class="block w-full py-3 pl-9 pr-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400 shadow-sm" placeholder="Cari Nama Produk...">
                </div>
                <div>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between border-b border-white/10">
                <div class="flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-sm font-semibold">Daftar Harga Produk</h3>
                </div>
                @can('produkharga.create')
                <button onclick="openModalCreate()" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-[#294C9A] bg-white rounded-lg hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah
                </button>
                @endcan
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                            <th class="py-3 px-6" style="width: 20%;">Kode Produk</th>
                            <th class="py-3 px-6">Nama Produk</th>
                            <th class="py-3 px-6 text-right" style="width: 25%;">Harga</th>
                            <th class="py-3 px-6 text-center" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse ($produkharga as $d)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                                <td class="py-2.5 px-6 font-mono text-xs text-gray-500 font-medium">
                                    {{ $d->kode_produk }}
                                </td>
                                <td class="py-2.5 px-6 font-medium text-gray-900">
                                    {{ $d->nama_produk }}
                                </td>
                                <td class="py-2.5 px-6 text-right font-semibold text-gray-900">
                                    Rp {{ number_format($d->harga, 0, ',', '.') }}
                                </td>
                                <td class="py-2.5 px-6">
                                    <div class="flex items-center justify-center gap-3.5">
                                        <!-- Edit -->
                                        @can('produkharga.edit')
                                        <button onclick="openModalEdit('{{ Crypt::encrypt($d->kode_produk) }}')" class="text-emerald-600 hover:text-emerald-900 p-1.5 hover:bg-emerald-50 rounded-lg transition" title="Edit Harga">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        @endcan
                                        <!-- Delete -->
                                        @can('produkharga.delete')
                                        <button type="button" class="btn-delete text-red-600 hover:text-red-950 p-1.5 hover:bg-red-50 rounded-lg transition" data-id="{{ Crypt::encrypt($d->kode_produk) }}" data-name="{{ $d->nama_produk }}" title="Hapus Harga">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>Belum ada data harga produk.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($produkharga->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $produkharga->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Create -->
    <div id="modalCreate" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCreateContentWrapper">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white">Tambah Harga Produk</h3>
                <button onclick="closeModal('modalCreate')" class="text-white/80 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="loadCreateContent" class="max-h-[80vh] overflow-y-auto p-6">
                <!-- Loader -->
                <div class="flex items-center justify-center py-6">
                    <svg class="animate-spin h-6 w-6 text-[#294C9A]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalEditContentWrapper">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white">Edit Harga Produk</h3>
                <button onclick="closeModal('modalEdit')" class="text-white/80 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="loadEditContent" class="max-h-[80vh] overflow-y-auto p-6">
                <!-- Loader -->
                <div class="flex items-center justify-center py-6">
                    <svg class="animate-spin h-6 w-6 text-[#294C9A]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
        <script>
            function openModal(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    wrapper.classList.remove('scale-95', 'opacity-0');
                    wrapper.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            function closeModal(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                wrapper.classList.remove('scale-100', 'opacity-100');
                wrapper.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            function openModalCreate() {
                openModal('modalCreate');
                $('#loadCreateContent').load('/produkharga/create', function() {
                    initFormValidation('#formCreateProdukHarga');
                    initMoneyFormatter();
                });
            }

            function openModalEdit(id) {
                openModal('modalEdit');
                $('#loadEditContent').load('/produkharga/' + id + '/edit', function() {
                    initFormValidation('#formEditProdukHarga');
                    initMoneyFormatter();
                });
            }

            function initMoneyFormatter() {
                $('.money').on('keyup', function() {
                    let val = $(this).val().replace(/[^0-9]/g, '');
                    if(val !== '') {
                        $(this).val(new Intl.NumberFormat('id-ID').format(val));
                    } else {
                        $(this).val('');
                    }
                });
            }

            function initFormValidation(formSelector) {
                const form = $(formSelector);
                const inputs = form.find('input[required], select[required]');

                function validateField(field) {
                    const input = $(field);
                    const value = input.val().trim();
                    let isValid = true;
                    let errorMsg = '';

                    if (value === '') {
                        isValid = false;
                        errorMsg = 'Kolom ini tidak boleh kosong.';
                    }

                    input.parent().find('.error-msg').remove();

                    if (!isValid) {
                        input.removeClass('border-gray-200 focus:ring-[#294C9A] focus:border-[#294C9A]')
                             .addClass('border-red-500 focus:ring-red-500 focus:border-red-500');
                        input.after('<p class="text-xs text-red-500 mt-1 error-msg">' + errorMsg + '</p>');
                    } else {
                        input.removeClass('border-red-500 focus:ring-red-500 focus:border-red-500')
                             .addClass('border-gray-200 focus:ring-[#294C9A] focus:border-[#294C9A]');
                    }
                    return isValid;
                }

                inputs.on('keyup input blur change', function() {
                    validateField(this);
                });

                form.on('submit', function(e) {
                    let formIsValid = true;
                    inputs.each(function() {
                        if (!validateField(this)) {
                            formIsValid = false;
                        }
                    });
                    if (!formIsValid) {
                        e.preventDefault();
                    }
                });
            }

            // SweetAlert2 Delete Confirmation
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');
                
                Swal.fire({
                    title: 'Hapus Harga?',
                    text: "Apakah Anda yakin ingin menghapus harga untuk produk '" + name + "'?",
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
                            'action': '/produkharga/' + id
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
        </script>
    @endpush
</x-app-layout>
