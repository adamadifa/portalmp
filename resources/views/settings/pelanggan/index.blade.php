<x-app-layout>
    <x-slot name="header">Master Data Pelanggan</x-slot>
    <x-slot name="headerTitle">Master Data Pelanggan</x-slot>
    <x-slot name="headerDescription">Kelola data pelanggan, informasi outlet/toko, limit piutang, dan cabang operasional.</x-slot>

    <div class="space-y-6">

        <!-- Action & Filter Bar (Modern Frameless & Full Width - Consistent with /produk) -->
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 w-full">
            <form method="GET" action="{{ route('pelanggan.index') }}" class="flex flex-wrap sm:flex-nowrap items-center gap-3 flex-1 w-full">
                
                <!-- Search Input: Placeholder without floating label -->
                <div class="relative flex-1 min-w-[220px] w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="nama_pelanggan" 
                        value="{{ request('nama_pelanggan') }}" 
                        placeholder="Cari kode atau nama pelanggan..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                </div>

                <!-- Filter Cabang -->
                <div class="relative min-w-[190px] w-full sm:w-auto">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <select name="kode_cabang" onchange="this.form.submit()" class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer">
                        <option value="">Semua Cabang</option>
                        @foreach($cabang as $c)
                            <option value="{{ $c->kode_cabang }}" {{ request('kode_cabang') == $c->kode_cabang ? 'selected' : '' }}>
                                {{ $c->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs transition shadow-2xs flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>

                    @if(request('nama_pelanggan') || request('kode_cabang'))
                        <a href="{{ route('pelanggan.index') }}" class="px-3 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition flex items-center gap-1">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Action: Tambah Pelanggan -->
            @can('pelanggan.create')
            <div class="shrink-0">
                <button type="button" onclick="openModalCreate()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Pelanggan</span>
                </button>
            </div>
            @endcan
        </div>

        <!-- Section Header Strip (Solid Biru Dongker #162a5b) -->
        <div class="px-6 py-4 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-2xl shadow-2xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                    <i data-lucide="users-round" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                        <span>Daftar Master Pelanggan</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                            {{ $pelanggan->total() }} Total
                        </span>
                    </h3>
                    <p class="text-[11px] text-blue-200/80">Kelola data pelanggan, outlet/toko, limit piutang, dan cabang operasional</p>
                </div>
            </div>

            @if(request('nama_pelanggan') || request('kode_cabang'))
            <div class="text-[11px] text-blue-100 flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-300"></i>
                <span>Filter aktif diterapkan</span>
            </div>
            @endif
        </div>

        <!-- Cards List (Full Width Customer Cards) -->
        <div class="space-y-3.5">
            @forelse ($pelanggan as $d)
                @if(str_contains(strtoupper($d->kode_pelanggan), 'PST'))
                    @continue
                @endif
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-2xs hover:shadow-md hover:border-slate-300 dark:hover:border-slate-700 transition-all duration-200">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        
                        <!-- Left Details Area -->
                        <div class="flex items-start sm:items-center gap-4 min-w-0">
                            
                            <!-- Avatar / Photo with Online Status Dot -->
                            <div class="relative shrink-0">
                                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-xl overflow-hidden border border-slate-200/80 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 flex items-center justify-center shadow-xs">
                                    @if($d->foto)
                                        <img src="{{ asset('storage/pelanggan/' . $d->foto) }}" alt="{{ $d->nama_pelanggan }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#162a5b] text-white flex items-center justify-center font-bold text-sm tracking-wider">
                                            {{ strtoupper(substr($d->nama_pelanggan, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <span 
                                    class="w-3.5 h-3.5 rounded-full absolute -bottom-0.5 -right-0.5 ring-2 ring-white dark:ring-slate-900 {{ $d->status_aktif_pelanggan == '1' ? 'bg-emerald-500' : 'bg-rose-500' }}" 
                                    title="{{ $d->status_aktif_pelanggan == '1' ? 'Pelanggan Aktif' : 'Pelanggan Non-Aktif' }}"
                                ></span>
                            </div>

                            <!-- Customer Information -->
                            <div class="min-w-0 flex-1">
                                <!-- Top Badges Row -->
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                                        {{ $d->kode_pelanggan }}
                                    </span>

                                    @if($d->cabang)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[11px] font-semibold bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20">
                                            <i data-lucide="building-2" class="w-3 h-3"></i>
                                            <span>{{ $d->cabang->nama_cabang }}</span>
                                        </span>
                                    @endif

                                    <!-- Status Pill -->
                                    @if($d->status_aktif_pelanggan == '1')
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
                                </div>

                                <!-- Customer Name -->
                                <h4 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white truncate">
                                    {{ $d->nama_pelanggan }}
                                </h4>

                                <!-- Store / Home Address -->
                                @if($d->alamat_toko || $d->alamat_pelanggan)
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-xl truncate">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                    <span class="truncate">{{ $d->alamat_toko ?: $d->alamat_pelanggan }}</span>
                                </div>
                                @endif

                                <!-- Secondary Metadata Chips Row -->
                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-600 dark:text-slate-400">
                                    <span class="inline-flex items-center gap-1 font-medium">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span class="text-slate-700 dark:text-slate-200 font-semibold">{{ $d->no_hp_pelanggan ?: '-' }}</span>
                                    </span>
                                    
                                    <span class="text-slate-300 dark:text-slate-700 hidden sm:inline">•</span>

                                    <span class="inline-flex items-center gap-1 font-medium">
                                        <i data-lucide="credit-card" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>Limit:</span>
                                        <span class="text-slate-800 dark:text-slate-200 font-bold">Rp {{ number_format($d->limit_pelanggan ?? 0, 0, ',', '.') }}</span>
                                    </span>

                                    <span class="text-slate-300 dark:text-slate-700 hidden sm:inline">•</span>

                                    <span class="inline-flex items-center gap-1 font-medium">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>LJT:</span>
                                        <span class="text-slate-800 dark:text-slate-200 font-bold">{{ $d->ljt ?? 0 }} Hari</span>
                                    </span>

                                    @if($d->hari)
                                    <span class="text-slate-300 dark:text-slate-700 hidden sm:inline">•</span>
                                    <span class="inline-flex items-center gap-1 font-medium">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span>Kunjungan:</span>
                                        <span class="text-slate-700 dark:text-slate-300 font-semibold">{{ $d->hari }}</span>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Action Buttons Area -->
                        <div class="flex items-center justify-end gap-2 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100 dark:border-slate-800 shrink-0">
                            @can('pelanggan.edit')
                            <button 
                                type="button" 
                                onclick="openModalEdit('{{ Crypt::encrypt($d->kode_pelanggan) }}')" 
                                class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20 text-blue-600 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/20 transition cursor-pointer shadow-2xs" 
                                title="Edit Pelanggan"
                            >
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                            </button>
                            @endcan

                            @can('pelanggan.delete')
                            <button 
                                type="button" 
                                class="btn-delete w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20 transition cursor-pointer shadow-2xs" 
                                data-id="{{ Crypt::encrypt($d->kode_pelanggan) }}" 
                                data-name="{{ $d->nama_pelanggan }}" 
                                title="Hapus Pelanggan"
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
                            <i data-lucide="users" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Tidak ada data pelanggan</h4>
                        <p class="text-xs text-slate-400 mt-1">Data pelanggan belum terdaftar atau tidak cocok dengan filter pencarian.</p>
                        @if(request('nama_pelanggan') || request('kode_cabang'))
                            <a href="{{ route('pelanggan.index') }}" class="mt-4 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 font-bold text-xs transition">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Custom Pagination -->
        @if ($pelanggan->hasPages())
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 shadow-2xs">
                {{ $pelanggan->links() }}
            </div>
        @endif
    </div>

    @push('modals')
        <!-- Modal Create -->
        <div id="modalCreate" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-3xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCreateContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="user-plus" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Tambah Pelanggan Baru</h3>
                            <p class="text-[10px] text-blue-200/80">Masukkan informasi toko, kontak, limit piutang, dan cabang</p>
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
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-3xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalEditContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="pencil" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Edit Data Pelanggan</h3>
                            <p class="text-[10px] text-blue-200/80">Perbarui data kontak, toko, limit piutang, atau cabang</p>
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
                $('#loadCreateContent').load('/pelanggan/create', function() {
                    initFormValidation('#formCreatePelanggan');
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            function openModalEdit(id) {
                openModal('modalEdit');
                $('#loadEditContent').load('/pelanggan/' + id + '/edit', function() {
                    initFormValidation('#formEditPelanggan');
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            // Real-time validation for Pelanggan forms
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
                    title: 'Hapus Pelanggan?',
                    text: "Apakah Anda yakin ingin menghapus pelanggan '" + name + "' secara permanen?",
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
                            'action': '/pelanggan/' + id
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
