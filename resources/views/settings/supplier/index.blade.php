<x-app-layout>
    <x-slot name="header">Master Data Supplier</x-slot>
    <x-slot name="headerTitle">Master Data Supplier</x-slot>
    <x-slot name="headerDescription">Kelola data vendor & pemasok, informasi kontak person, telepon, alamat, dan nomor rekening pembayaran.</x-slot>

    <div class="space-y-6">

        <!-- Action & Filter Bar (Modern Frameless & Full Width - Consistent with /produk & /pelanggan) -->
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 w-full">
            <form method="GET" action="{{ route('supplier.index') }}" class="flex flex-wrap sm:flex-nowrap items-center gap-3 flex-1 w-full">
                
                <!-- Search Input: Placeholder without floating label -->
                <div class="relative flex-1 min-w-[220px] w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="nama_supplier" 
                        value="{{ request('nama_supplier') }}" 
                        placeholder="Cari kode atau nama supplier..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs transition shadow-2xs flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>

                    @if(request('nama_supplier'))
                        <a href="{{ route('supplier.index') }}" class="px-3 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition flex items-center gap-1">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Actions Group: Export, Import & Tambah Supplier -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <!-- Export Excel -->
                <a 
                    href="{{ route('supplier.export', request()->query()) }}" 
                    class="flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                    title="Export Data ke Excel"
                >
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>

                @can('supplier.create')
                <!-- Import Excel -->
                <button 
                    type="button" 
                    onclick="openModal('modalImportSupplier')" 
                    class="flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                    title="Import Data dari Excel"
                >
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Import Excel</span>
                </button>

                <!-- Tambah Supplier -->
                <button 
                    type="button" 
                    onclick="openModalCreate()" 
                    class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                >
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Supplier</span>
                </button>
                @endcan
            </div>
        </div>

        <!-- Section Header Strip (Solid Biru Dongker #162a5b) -->
        <div class="px-6 py-4 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-2xl shadow-2xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                    <i data-lucide="truck" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                        <span>Daftar Master Supplier</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                            {{ $supplier->total() }} Total
                        </span>
                    </h3>
                    <p class="text-[11px] text-blue-200/80">Katalog vendor/pemasok barang, kontak person, telepon, dan nomor rekening</p>
                </div>
            </div>

            @if(request('nama_supplier'))
            <div class="text-[11px] text-blue-100 flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-300"></i>
                <span>Filter aktif diterapkan</span>
            </div>
            @endif
        </div>

        <!-- Cards List (Compact Full Width Supplier Cards) -->
        <div class="space-y-2.5">
            @forelse ($supplier as $d)
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-xl p-3 sm:px-4 sm:py-3 shadow-2xs hover:shadow-xs hover:border-slate-300 dark:hover:border-slate-700 transition-all duration-150">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                        
                        <!-- Col 1: Identity & Address (md:col-span-4) -->
                        <div class="md:col-span-4 flex items-center gap-3 min-w-0">
                            <!-- Avatar: Solid Navy #162a5b (No gradient) -->
                            <div class="w-10 h-10 rounded-xl bg-[#162a5b] text-white flex items-center justify-center font-bold text-xs tracking-wider shrink-0 shadow-xs">
                                {{ strtoupper(substr($d->nama_supplier, 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5 mb-0.5">
                                    <span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                                        {{ $d->kode_supplier }}
                                    </span>
                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/20">
                                        <i data-lucide="shield-check" class="w-2.5 h-2.5"></i>
                                        <span>Terverifikasi</span>
                                    </span>
                                </div>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate" title="{{ $d->nama_supplier }}">
                                    {{ $d->nama_supplier }}
                                </h4>
                                @if($d->alamat_supplier)
                                <div class="flex items-center gap-1 text-[11px] text-slate-400 dark:text-slate-500 truncate mt-0.5" title="{{ $d->alamat_supplier }}">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                    <span class="truncate">{{ $d->alamat_supplier }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Col 2: Contact Person & Telepon (md:col-span-3) -->
                        <div class="md:col-span-3 min-w-0 pl-0 md:pl-2 border-t md:border-t-0 border-slate-100 dark:border-slate-800 pt-2 md:pt-0">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Kontak & Telepon</p>
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-800 dark:text-slate-200 truncate">
                                <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                <span class="truncate">{!! strip_tags($d->contact_person) ?: '-' !!}</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-slate-600 dark:text-slate-400 truncate mt-0.5">
                                <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                <span class="font-medium truncate">{{ $d->no_hp_supplier ?: '-' }}</span>
                            </div>
                        </div>

                        <!-- Col 3: Rekening & Email (md:col-span-3) -->
                        <div class="md:col-span-3 min-w-0 pl-0 md:pl-2 border-t md:border-t-0 border-slate-100 dark:border-slate-800 pt-2 md:pt-0">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">Rekening & Email</p>
                            <div class="flex items-center gap-1 text-xs font-bold text-slate-800 dark:text-slate-200 truncate">
                                <i data-lucide="credit-card" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                <span class="font-mono truncate">{{ $d->no_rekening_supplier ?: '-' }}</span>
                            </div>
                            <div class="flex items-center gap-1 text-[11px] text-slate-500 dark:text-slate-400 truncate mt-0.5">
                                <i data-lucide="mail" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                <span class="truncate">{{ $d->email_supplier ?: '-' }}</span>
                            </div>
                        </div>

                        <!-- Col 4: Action Buttons (md:col-span-2) -->
                        <div class="md:col-span-2 flex items-center justify-end gap-1.5 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100 dark:border-slate-800 shrink-0">
                            @can('supplier.edit')
                            <button 
                                type="button" 
                                onclick="openModalEdit('{{ Crypt::encrypt($d->kode_supplier) }}')" 
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-blue-600 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20 transition cursor-pointer shadow-2xs" 
                                title="Edit Supplier"
                            >
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                            </button>
                            @endcan

                            @can('supplier.delete')
                            <button 
                                type="button" 
                                class="btn-delete w-7 h-7 sm:w-8 sm:h-8 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition cursor-pointer shadow-2xs" 
                                data-id="{{ Crypt::encrypt($d->kode_supplier) }}" 
                                data-name="{{ $d->nama_supplier }}" 
                                title="Hapus Supplier"
                            >
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 py-16 px-4 text-center">
                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3 shadow-xs">
                            <i data-lucide="truck" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Tidak ada data supplier</h4>
                        <p class="text-xs text-slate-400 mt-1">Data supplier belum terdaftar atau tidak cocok dengan filter pencarian.</p>
                        @if(request('nama_supplier'))
                            <a href="{{ route('supplier.index') }}" class="mt-4 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 font-bold text-xs transition">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Custom Pagination -->
        @if ($supplier->hasPages())
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 shadow-2xs">
                {{ $supplier->links() }}
            </div>
        @endif
    </div>

    @push('modals')
        <!-- Modal Create -->
        <div id="modalCreate" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCreateContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="plus-circle" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Tambah Supplier Baru</h3>
                            <p class="text-[10px] text-blue-200/80">Masukkan informasi vendor, kontak, alamat, dan nomor rekening</p>
                        </div>
                    </div>
                    <button onclick="closeModal('modalCreate')" type="button" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div id="loadCreateContent" class="max-h-[82vh] overflow-y-auto p-5">
                    <!-- Loader -->
                    <div class="flex flex-col items-center justify-center py-12 gap-2.5">
                        <div class="w-8 h-8 border-3 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs font-semibold text-slate-500">Memuat formulir...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="modalEdit" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalEditContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="pencil" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Edit Data Supplier</h3>
                            <p class="text-[10px] text-blue-200/80">Perbarui data vendor, kontak, alamat, atau nomor rekening</p>
                        </div>
                    </div>
                    <button onclick="closeModal('modalEdit')" type="button" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div id="loadEditContent" class="max-h-[82vh] overflow-y-auto p-5">
                    <!-- Loader -->
                    <div class="flex flex-col items-center justify-center py-12 gap-2.5">
                        <div class="w-8 h-8 border-3 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs font-semibold text-slate-500">Memuat formulir...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Import Supplier -->
        <div id="modalImportSupplier" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalImportSupplierContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="upload" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Import Data Supplier</h3>
                            <p class="text-[10px] text-blue-200/80">Upload file Excel (.xlsx / .xls / .csv)</p>
                        </div>
                    </div>
                    <button onclick="closeModal('modalImportSupplier')" type="button" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition cursor-pointer">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <form action="{{ route('supplier.import') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                    @csrf
                    <div class="p-3.5 bg-blue-50/80 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 rounded-xl text-xs text-blue-800 dark:text-blue-300 space-y-1">
                        <p class="font-bold flex items-center gap-1.5">
                            <i data-lucide="info" class="w-4 h-4 text-blue-600 dark:text-blue-400 shrink-0"></i>
                            <span>Panduan Format Excel:</span>
                        </p>
                        <p class="text-[11px] leading-relaxed">
                            File Excel wajib memiliki kolom header <strong>Nama Supplier</strong> (atau di kolom pertama). Kode Supplier akan dibuat otomatis secara berurutan oleh sistem (contoh: <code>SP0001</code>, <code>SP0002</code>, dst).
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                            Pilih File Excel (.xlsx / .xls / .csv) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="file" 
                            name="file_excel" 
                            accept=".xlsx,.xls,.csv" 
                            required 
                            class="block w-full text-xs text-slate-700 dark:text-slate-300 file:mr-4 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 hover:file:bg-slate-200 dark:file:bg-slate-800 dark:hover:file:bg-slate-700 file:text-slate-700 dark:file:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 transition cursor-pointer"
                        />
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button 
                            type="button" 
                            onclick="closeModal('modalImportSupplier')" 
                            class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="inline-flex items-center gap-1.5 px-5 py-2 text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-lg transition shadow-xs cursor-pointer"
                        >
                            <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                            <span>Proses Import</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endpush

    @push('myscript')
        <script>
            function openModal(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    wrapper.classList.remove('scale-95', 'opacity-0');
                    wrapper.classList.add('scale-100', 'opacity-100');
                }, 20);
            }

            function closeModal(id) {
                const modal = document.getElementById(id);
                const wrapper = document.getElementById(id + 'ContentWrapper');
                wrapper.classList.remove('scale-100', 'opacity-100');
                wrapper.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 250);
            }

            function openModalCreate() {
                openModal('modalCreate');
                $('#loadCreateContent').load('/supplier/create', function() {
                    initFormValidation('#formCreateSupplier');
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            function openModalEdit(id) {
                openModal('modalEdit');
                $('#loadEditContent').load('/supplier/' + id + '/edit', function() {
                    initFormValidation('#formEditSupplier');
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            // Real-time validation for Supplier forms
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
                    } else if (input.attr('type') === 'number' && isNaN(value)) {
                        isValid = false;
                        errorMsg = 'Nilai harus berupa angka.';
                    } else if (input.attr('maxlength') && value.length > parseInt(input.attr('maxlength'))) {
                        isValid = false;
                        errorMsg = 'Maksimal ' + input.attr('maxlength') + ' karakter.';
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
                    title: 'Hapus Supplier?',
                    text: "Apakah Anda yakin ingin menghapus supplier '" + name + "' secara permanen?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#162a5b',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
                        cancelButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '/supplier/' + id
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
