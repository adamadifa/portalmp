<x-app-layout>
    <x-slot name="header">Chart of Accounts (COA)</x-slot>
    <x-slot name="headerTitle">Chart of Accounts (COA)</x-slot>
    <x-slot name="headerDescription">Kelola data kode perkiraan akuntansi (COA), hierarki level akun, dan relasi sub-akun untuk pencatatan transaksi keuangan.</x-slot>

    <div class="space-y-6">

        <!-- Action & Filter Bar (Modern Frameless & Full Width) -->
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 w-full">
            <form method="GET" action="{{ route('coa.index') }}" class="flex flex-wrap sm:flex-nowrap items-center gap-3 flex-1 w-full">
                <!-- Search Input -->
                <div class="relative flex-1 min-w-[220px] w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="nama_akun" 
                        value="{{ request('nama_akun') }}" 
                        placeholder="Cari kode atau nama akun..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-bold text-xs transition shadow-2xs flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>

                    @if(request('nama_akun'))
                        <a href="{{ route('coa.index') }}" class="px-3 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold text-xs transition flex items-center gap-1">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Action: Tambah Akun COA -->
            @can('coa.create')
            <div class="shrink-0">
                <button type="button" onclick="openModalCreate()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Tambah Akun</span>
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
                        <i data-lucide="book-open" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                            <span>Buku Daftar Akun (Chart of Accounts)</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                                {{ count($coa) }} Total Akun
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/80">Katalog bagan akun perkiraan standar akuntansi, hierarki level, dan relasi sub-akun</p>
                    </div>
                </div>

                @if(request('nama_akun'))
                <div class="text-[11px] text-blue-100 flex items-center gap-1.5 bg-black/20 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-sky-300"></i>
                    <span>Filter pencarian aktif</span>
                </div>
                @endif
            </div>

            <!-- Table Responsive Area -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#162a5b]">
                        <tr class="text-[11px] font-extrabold uppercase tracking-wider text-blue-200/90 bg-[#162a5b]">
                            <th class="py-2.5 px-4 w-40">Kode Akun</th>
                            <th class="py-2.5 px-4">Nama Akun Perkiraan</th>
                            <th class="py-2.5 px-4 w-44">Parent / Sub Dari</th>
                            <th class="py-2.5 px-4 w-28 text-center">Level</th>
                            <th class="py-2.5 px-4 w-24 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse ($coa as $d)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                                <!-- Kode Akun -->
                                <td class="py-2.5 px-4 font-mono font-bold">
                                    <span class="inline-block px-2 py-0.5 rounded-md text-[11px] font-mono font-bold bg-blue-50 dark:bg-blue-900/30 text-[#162a5b] dark:text-blue-300 border border-blue-200/70 dark:border-blue-800/60">
                                        {{ $d->kode_akun }}
                                    </span>
                                </td>

                                <!-- Nama Akun with Level Indentation -->
                                <td class="py-2.5 px-4">
                                    @if ($d->level == 1)
                                        <div class="font-bold text-slate-900 dark:text-white uppercase tracking-wide flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-[#162a5b] dark:bg-blue-400 shrink-0"></span>
                                            <span>{{ $d->nama_akun }}</span>
                                        </div>
                                    @elseif ($d->level == 2)
                                        <div class="pl-5 font-semibold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400 dark:bg-slate-500 shrink-0"></span>
                                            <span>{{ $d->nama_akun }}</span>
                                        </div>
                                    @elseif ($d->level == 3)
                                        <div class="pl-10 font-medium text-slate-700 dark:text-slate-300 flex items-center gap-2">
                                            <span class="text-slate-300 dark:text-slate-600 font-mono text-[10px] shrink-0">└─</span>
                                            <span>{{ $d->nama_akun }}</span>
                                        </div>
                                    @else
                                        <div class="pl-16 font-normal text-slate-600 dark:text-slate-400 flex items-center gap-2">
                                            <span class="text-slate-300 dark:text-slate-600 font-mono text-[10px] shrink-0">└──</span>
                                            <span>{{ $d->nama_akun }}</span>
                                        </div>
                                    @endif
                                </td>

                                <!-- Parent / Sub Akun -->
                                <td class="py-2.5 px-4 font-mono text-xs">
                                    @if ($d->sub_akun)
                                        <span class="inline-block px-2 py-0.5 rounded text-[11px] font-mono text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 border border-slate-200/70 dark:border-slate-700">
                                            {{ $d->sub_akun }}
                                        </span>
                                    @else
                                        <span class="text-[11px] text-slate-400 italic">Header / Utama</span>
                                    @endif
                                </td>

                                <!-- Level Badge -->
                                <td class="py-2.5 px-4 text-center">
                                    @if ($d->level == 1)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                            Lvl 1
                                        </span>
                                    @elseif ($d->level == 2)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                            Lvl 2
                                        </span>
                                    @elseif ($d->level == 3)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                            Lvl 3
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                            Lvl {{ $d->level }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="py-2.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        @can('coa.edit')
                                        <button 
                                            type="button" 
                                            onclick="openModalEdit('{{ $d->kode_akun }}')" 
                                            class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 flex items-center justify-center transition cursor-pointer" 
                                            title="Edit Akun"
                                        >
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        </button>
                                        @endcan

                                        @can('coa.delete')
                                        <button 
                                            type="button" 
                                            class="btn-delete w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/50 flex items-center justify-center transition cursor-pointer" 
                                            data-id="{{ $d->kode_akun }}" 
                                            data-name="{{ $d->nama_akun }}" 
                                            title="Hapus Akun"
                                        >
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i data-lucide="inbox" class="w-10 h-10 text-slate-300 dark:text-slate-600"></i>
                                        <span class="text-xs font-medium">Belum ada data Chart of Accounts (COA).</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('modals')
        <!-- Modal Create -->
        <div id="modalCreate" class="fixed inset-0 z-[100] hidden bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalCreateContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="plus-circle" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Tambah Akun COA Baru</h3>
                            <p class="text-[10px] text-blue-200/80">Masukkan kode akun, nama perkiraan, dan relasi parent account</p>
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
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200/90 dark:border-slate-800 shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalEditContentWrapper">
                <div class="bg-[#162a5b] px-5 py-3.5 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shadow-xs">
                            <i data-lucide="pencil" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-tight">Edit Akun COA</h3>
                            <p class="text-[10px] text-blue-200/80">Perbarui nama perkiraan atau relasi parent account</p>
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
            function openModalCreate() {
                openModal('modalCreate');
                $('#loadCreateContent').html(`
                    <div class="flex flex-col items-center justify-center py-12 gap-2.5">
                        <div class="w-8 h-8 border-3 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs font-semibold text-slate-500">Memuat formulir...</span>
                    </div>
                `);
                $('#loadCreateContent').load('/coa/create', function(response, status, xhr) {
                    if (status === "error") {
                        $('#loadCreateContent').html(`
                            <div class="p-6 text-center text-rose-500 font-semibold text-xs">
                                Gagal memuat formulir: ${xhr.status} ${xhr.statusText}
                            </div>
                        `);
                    }
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            }

            function openModalEdit(kode) {
                openModal('modalEdit');
                $('#loadEditContent').html(`
                    <div class="flex flex-col items-center justify-center py-12 gap-2.5">
                        <div class="w-8 h-8 border-3 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs font-semibold text-slate-500">Memuat formulir...</span>
                    </div>
                `);
                $('#loadEditContent').load('/coa/' + encodeURIComponent(kode) + '/edit', function(response, status, xhr) {
                    if (status === "error") {
                        $('#loadEditContent').html(`
                            <div class="p-6 text-center text-rose-500 font-semibold text-xs">
                                Gagal memuat formulir: ${xhr.status} ${xhr.statusText}
                            </div>
                        `);
                    }
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            }

            // SweetAlert2 Delete Confirmation
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');

                Swal.fire({
                    title: 'Hapus Akun COA?',
                    text: "Apakah Anda yakin ingin menghapus akun '" + id + " - " + name + "'?",
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
                            'action': '/coa/' + encodeURIComponent(id)
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

            @if(session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#162a5b',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
                    }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
                    }
                });
            @endif

            document.addEventListener('DOMContentLoaded', function () {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        </script>
    @endpush
</x-app-layout>
