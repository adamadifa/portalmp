<x-app-layout>
    <x-slot name="header">Master Data Barang Pembelian</x-slot>
    <x-slot name="headerTitle">Master Data Barang Pembelian</x-slot>
    <x-slot name="headerDescription">Katalog barang pembelian, bahan baku, kemasan, satuan, jenis, dan departemen operasional.</x-slot>

    <div class="space-y-6">

        <!-- Action & Filter Bar (Modern Frameless & Full Width - Consistent with /produk) -->
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 w-full">
            <form method="GET" action="{{ route('barangpembelian.index') }}" class="flex flex-wrap sm:flex-nowrap items-center gap-3 flex-1 w-full">
                
                <!-- Search Input: Placeholder without floating label -->
                <div class="relative flex-1 min-w-[220px] w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="nama_barang" 
                        value="{{ request('nama_barang') }}" 
                        placeholder="Cari kode atau nama barang..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs transition shadow-2xs flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>

                    @if(request('nama_barang'))
                        <a href="{{ route('barangpembelian.index') }}" class="px-3 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition flex items-center gap-1">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Action: Tambah Barang Pembelian -->
            @can('barangpembelian.create')
            <div class="shrink-0">
                <button type="button" onclick="openModalCreate()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Barang</span>
                </button>
            </div>
            @endcan
        </div>

        <!-- Table Card (Solid Biru Dongker Card Header Seamless with Table Header) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl shadow-2xs overflow-hidden">
            
            <!-- Table Card Header (Solid Biru Dongker - Seamless with Table Header) -->
            <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                        <i data-lucide="boxes" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                            <span>Daftar Barang Pembelian</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                                {{ $barang->total() }} Total
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/80">Katalog master barang pembelian, bahan baku, kemasan, dan departemen operasional</p>
                    </div>
                </div>

                @if(request('nama_barang'))
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
                            <th class="py-2.5 px-4 w-12 text-center">No</th>
                            <th class="py-2.5 px-4 w-36 min-w-[130px] whitespace-nowrap">Kode Barang</th>
                            <th class="py-2.5 px-4">Nama Barang</th>
                            <th class="py-2.5 px-4 w-24">Satuan</th>
                            <th class="py-2.5 px-4">Jenis</th>
                            <th class="py-2.5 px-4">Kategori</th>
                            <th class="py-2.5 px-4">Group</th>
                            <th class="py-2.5 px-4 w-36 min-w-[130px] text-center">Status</th>
                            <th class="py-2.5 px-4 w-28 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse ($barang as $index => $d)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- No -->
                                <td class="py-1 px-4 text-center text-slate-400 font-medium">
                                    {{ $barang->firstItem() + $index }}
                                </td>

                                <!-- Kode Barang -->
                                <td class="py-1 px-4 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                                        {{ $d->kode_barang }}
                                    </span>
                                </td>

                                <!-- Nama Barang -->
                                <td class="py-1 px-4">
                                    <div class="font-bold text-slate-900 dark:text-white leading-tight">
                                        {{ textUpperCase($d->nama_barang) }}
                                    </div>
                                </td>

                                <!-- Satuan -->
                                <td class="py-1 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20">
                                        {{ textUpperCase($d->satuan) }}
                                    </span>
                                </td>

                                <!-- Jenis -->
                                <td class="py-1 px-4">
                                    @if(isset($jenis_barang[$d->kode_jenis_barang]))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20">
                                            {{ $jenis_barang[$d->kode_jenis_barang] }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Kategori -->
                                <td class="py-1 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-500/20">
                                        {{ textUpperCase($d->nama_kategori) }}
                                    </span>
                                </td>

                                <!-- Group -->
                                <td class="py-1 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        {{ $group[$d->kode_group] ?? '-' }}
                                    </span>
                                </td>

                                <!-- Status (Consistent Full Width Pill) -->
                                <td class="py-1 px-4 text-center">
                                    @if ($d->status === '1')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Aktif</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            <span>Non-Aktif</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions (Blue Edit & Rose Delete) -->
                                <td class="py-1 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        @can('barangpembelian.edit')
                                        <button 
                                            type="button" 
                                            onclick="openModalEdit('{{ Crypt::encrypt($d->kode_barang) }}')" 
                                            class="w-7 h-7 rounded-lg flex items-center justify-center bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-blue-600 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20 transition cursor-pointer shadow-2xs" 
                                            title="Edit Barang"
                                        >
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        </button>
                                        @endcan

                                        @can('barangpembelian.delete')
                                        <button 
                                            type="button" 
                                            class="btn-delete w-7 h-7 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition cursor-pointer shadow-2xs" 
                                            data-id="{{ Crypt::encrypt($d->kode_barang) }}" 
                                            data-name="{{ $d->nama_barang }}" 
                                            title="Hapus Barang"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-16 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3 shadow-xs">
                                            <i data-lucide="boxes" class="w-6 h-6"></i>
                                        </div>
                                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Tidak ada data barang pembelian</h4>
                                        <p class="text-xs text-slate-400 mt-1">Data barang belum terdaftar atau tidak cocok dengan filter pencarian.</p>
                                        @if(request('nama_barang'))
                                            <a href="{{ route('barangpembelian.index') }}" class="mt-4 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 font-bold text-xs transition">
                                                Reset Filter
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            @if ($barang->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900">
                    {{ $barang->links() }}
                </div>
            @endif
        </div>
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
                            <h3 class="text-sm font-bold text-white tracking-tight">Tambah Barang Pembelian Baru</h3>
                            <p class="text-[10px] text-blue-200/80">Masukkan informasi barang, satuan, jenis, dan departemen group</p>
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
                            <h3 class="text-sm font-bold text-white tracking-tight">Edit Barang Pembelian</h3>
                            <p class="text-[10px] text-blue-200/80">Perbarui informasi barang, satuan, jenis, atau group</p>
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
                $('#loadCreateContent').load('/barangpembelian/create', function() {
                    initFormValidation('#formCreateBarang');
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            function openModalEdit(id) {
                openModal('modalEdit');
                $('#loadEditContent').load('/barangpembelian/' + id + '/edit', function() {
                    initFormValidation('#formEditBarang');
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            // Real-time form validation
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
                    title: 'Hapus Barang Pembelian?',
                    text: "Apakah Anda yakin ingin menghapus barang '" + name + "' secara permanen?",
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
                            'action': '/barangpembelian/' + id
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
