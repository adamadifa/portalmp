<x-app-layout>
    <x-slot name="header">Master Data Harga</x-slot>
    <x-slot name="headerTitle">Master Data Harga</x-slot>
    <x-slot name="headerDescription">Kelola konfigurasi harga beli produk dari supplier dan mitra produksi.</x-slot>

    <div class="space-y-6">

        <!-- Action & Filter Bar (Consistent with /produk) -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <form method="GET" action="{{ route('produkharga.index') }}" class="flex flex-wrap sm:flex-nowrap items-center gap-3 flex-1 w-full">
                
                <!-- Search Input: Clean placeholder without floating label -->
                <div class="relative flex-1 min-w-[240px] w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="nama_produk" 
                        value="{{ request('nama_produk') }}" 
                        placeholder="Cari kode atau nama produk..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs transition shadow-2xs flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>

                    @if(request('nama_produk'))
                        <a href="{{ route('produkharga.index') }}" class="px-3 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition flex items-center gap-1">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Action: Tambah Harga -->
            @can('produkharga.create')
            <div class="shrink-0">
                <button type="button" onclick="openModalCreate()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Harga</span>
                </button>
            </div>
            @endcan
        </div>

        <!-- Prices Table Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl shadow-2xs overflow-hidden">
            
            <!-- Table Card Header (Solid Biru Dongker - Seamless with Table Header) -->
            <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                        <i data-lucide="badge-dollar-sign" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                            <span>Daftar Harga Produk</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                                {{ $produkharga->total() }} Total
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/80">Katalog tarif dan acuan harga beli per produk</p>
                    </div>
                </div>

                @if(request('nama_produk'))
                <div class="text-[11px] text-blue-100 flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-300"></i>
                    <span>Filter aktif diterapkan</span>
                </div>
                @endif
            </div>

            <!-- Table Responsive Area -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#162a5b]">
                        <tr class="text-[11px] font-extrabold uppercase tracking-wider text-blue-200/90 bg-[#162a5b]">
                            <th class="py-2.5 px-4 w-36">Kode Produk</th>
                            <th class="py-2.5 px-4">Nama Produk</th>
                            <th class="py-2.5 px-4 w-44 text-right">Harga Beli</th>
                            <th class="py-2.5 px-4 w-28 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse ($produkharga as $d)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Kode Produk -->
                                <td class="py-1 px-4">
                                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                                        {{ $d->kode_produk }}
                                    </span>
                                </td>

                                <!-- Nama Produk -->
                                <td class="py-1 px-4">
                                    <div class="font-bold text-slate-900 dark:text-white leading-tight">
                                        {{ $d->nama_produk }}
                                    </div>
                                </td>

                                <!-- Harga Beli -->
                                <td class="py-1 px-4 text-right">
                                    <span class="font-mono text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                        Rp {{ number_format($d->harga, 0, ',', '.') }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="py-1 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        @can('produkharga.edit')
                                        <button 
                                            type="button" 
                                            onclick="openModalEdit('{{ Crypt::encrypt($d->kode_produk) }}')" 
                                            class="w-7 h-7 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 border border-blue-200/80 dark:border-blue-500/30 transition shadow-2xs cursor-pointer" 
                                            title="Edit Harga"
                                        >
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        </button>
                                        @endcan

                                        @can('produkharga.delete')
                                        <button 
                                            type="button" 
                                            class="btn-delete w-7 h-7 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 border border-rose-200/80 dark:border-rose-500/30 transition shadow-2xs cursor-pointer" 
                                            data-id="{{ Crypt::encrypt($d->kode_produk) }}" 
                                            data-name="{{ $d->nama_produk }}" 
                                            title="Hapus Harga"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 px-6 text-center text-slate-400 dark:text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                            <i data-lucide="badge-dollar-sign" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Belum ada data harga produk</p>
                                        <p class="text-xs text-slate-400 max-w-sm">Tambahkan tarif harga baru atau sesuaikan pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Area -->
            @if ($produkharga->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Menampilkan <span class="font-bold text-slate-800 dark:text-slate-200">{{ $produkharga->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-800 dark:text-slate-200">{{ $produkharga->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800 dark:text-slate-200">{{ $produkharga->total() }}</span> harga produk
                    </div>
                    <div>
                        {{ $produkharga->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    @push('modals')
        <!-- Modal Create -->
        <div id="modalCreate" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCreateContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="plus-circle" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Tambah Harga Produk</h3>
                            <p class="text-[10px] text-blue-200/80">Konfigurasi tarif harga beli produk baru</p>
                        </div>
                    </div>
                    <button onclick="closeModal('modalCreate')" type="button" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div id="loadCreateContent" class="max-h-[82vh] overflow-y-auto p-5">
                    <!-- Loader -->
                    <div class="flex flex-col items-center justify-center py-10 gap-2.5">
                        <div class="w-8 h-8 border-3 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs font-semibold text-slate-500">Memuat formulir...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="modalEdit" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalEditContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="pencil" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Edit Harga Produk</h3>
                            <p class="text-[10px] text-blue-200/80">Perbarui tarif harga beli produk</p>
                        </div>
                    </div>
                    <button onclick="closeModal('modalEdit')" type="button" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div id="loadEditContent" class="max-h-[82vh] overflow-y-auto p-5">
                    <!-- Loader -->
                    <div class="flex flex-col items-center justify-center py-10 gap-2.5">
                        <div class="w-8 h-8 border-3 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs font-semibold text-slate-500">Memuat formulir...</span>
                    </div>
                </div>
            </div>
        </div>
    @endpush

    @push('myscript')
        <script>
            function openModalCreate() {
                openModal('modalCreate');
                $('#loadCreateContent').load('/produkharga/create', function() {
                    initFormValidation('#formCreateProdukHarga');
                    initMoneyFormatter();
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            function openModalEdit(id) {
                openModal('modalEdit');
                $('#loadEditContent').load('/produkharga/' + id + '/edit', function() {
                    initFormValidation('#formEditProdukHarga');
                    initMoneyFormatter();
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            function initMoneyFormatter() {
                $('.money').on('keyup input', function() {
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
                    const value = (input.val() || '').trim();
                    let isValid = true;
                    let errorMsg = '';

                    if (value === '') {
                        isValid = false;
                        errorMsg = 'Kolom ini wajib diisi.';
                    }

                    input.parent().find('.error-msg').remove();

                    if (!isValid) {
                        input.removeClass('border-slate-200 dark:border-slate-700 focus:ring-blue-600 focus:border-blue-600')
                             .addClass('border-rose-500 focus:ring-rose-500 focus:border-rose-500');
                        input.after('<p class="text-[11px] text-rose-500 font-semibold mt-1 error-msg">' + errorMsg + '</p>');
                    } else {
                        input.removeClass('border-rose-500 focus:ring-rose-500 focus:border-rose-500')
                             .addClass('border-slate-200 dark:border-slate-700 focus:ring-blue-600 focus:border-blue-600');
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
                    confirmButtonColor: '#162a5b',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-xl',
                        confirmButton: 'rounded-lg text-xs font-bold px-4 py-2',
                        cancelButton: 'rounded-lg text-xs font-bold px-4 py-2'
                    }
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

            document.addEventListener('DOMContentLoaded', function () {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        </script>
    @endpush
</x-app-layout>
