<x-app-layout>
    <x-slot name="header">
        Chart of Accounts (COA)
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Chart of Accounts (COA)</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar kode perkiraan akuntansi (COA) untuk pencatatan transaksi keuangan.</p>
        </div>
        <div class="flex items-center gap-3">
            @can('coa.create')
            <button type="button" id="btnTambahCoa" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm cursor-pointer" style="background-color: #294C9A !important; color: #ffffff !important;">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Akun
            </button>
            @endcan
        </div>
    </div>

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

    <!-- Compact Container -->
    <div class="max-w-5xl">
        <!-- Filter -->
        <div class="mb-4">
            <form action="{{ route('coa.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="nama_akun" value="{{ request('nama_akun') }}" class="block w-full py-3 pl-9 pr-4 text-xs text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:border-[#294C9A] focus:outline-none transition placeholder-gray-400 shadow-sm" placeholder="Cari Kode atau Nama Akun...">
                </div>
                <div>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm" style="background-color: #294C9A !important; color: #ffffff !important;">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
            <div class="bg-[#294C9A] px-6 py-4 flex items-center justify-between border-b border-white/10">
                <div class="flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <h3 class="text-sm font-semibold text-white">Buku Daftar Akun (Chart of Accounts)</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                            <th class="py-3 px-6" style="width: 22%;">Kode Akun</th>
                            <th class="py-3 px-6">Nama Akun</th>
                            <th class="py-3 px-6 text-center" style="width: 12%;">Level</th>
                            <th class="py-3 px-6 text-center" style="width: 14%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse ($coa as $d)
                            @php
                                $paddingLeft = 'ps-6';
                                if ($d->level == 2) {
                                    $paddingLeft = 'ps-10';
                                } elseif ($d->level == 3) {
                                    $paddingLeft = 'ps-16';
                                } elseif ($d->level == 4) {
                                    $paddingLeft = 'ps-20';
                                } elseif ($d->level >= 5) {
                                    $paddingLeft = 'ps-24';
                                }
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                                <td class="py-2.5 px-6 font-mono text-xs font-bold text-[#294C9A]">
                                    {{ $d->kode_akun }}
                                </td>
                                <td class="py-2.5 px-6 {{ $paddingLeft }} font-medium text-gray-900">
                                    @if($d->level == 1)
                                        <span class="font-bold text-gray-900 uppercase">{{ $d->nama_akun }}</span>
                                    @elseif($d->level == 2)
                                        <span class="font-semibold text-gray-800">{{ $d->nama_akun }}</span>
                                    @else
                                        <span class="text-gray-600">{{ $d->nama_akun }}</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-6 text-center">
                                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded-md border
                                        @if($d->level == 1)
                                            bg-blue-50 text-blue-700 border-blue-200
                                        @elseif($d->level == 2)
                                            bg-emerald-50 text-emerald-700 border-emerald-200
                                        @else
                                            bg-gray-50 text-gray-700 border-gray-200
                                        @endif">
                                        Lvl {{ $d->level }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-6 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        @can('coa.edit')
                                        <button type="button" class="btnEditCoa p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition cursor-pointer" data-kode="{{ $d->kode_akun }}" title="Edit Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        @endcan
                                        @can('coa.delete')
                                        <form action="{{ route('coa.destroy', $d->kode_akun) }}" method="POST" class="inline delete-coa-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btnDeleteCoa p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" data-kode="{{ $d->kode_akun }}" title="Hapus Akun">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <span>Belum ada data Chart of Accounts.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Dialog -->
    <div id="modalDialog" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 bg-[#294C9A] text-white flex justify-between items-center">
                <h3 id="modalTitle" class="text-base font-bold text-white">Tambah Akun COA</h3>
                <button type="button" onclick="closeModal()" class="text-white/80 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="modalBody" class="p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    @push('myscript')
    <script>
        function openModal(title, url) {
            $("#modalTitle").text(title);
            $("#modalBody").html(`
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 text-[#294C9A] animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            `);
            $("#modalDialog").removeClass("hidden");
            $("#modalBody").load(url);
        }

        function closeModal() {
            $("#modalDialog").addClass("hidden");
        }

        $(document).ready(function() {
            $("#btnTambahCoa").click(function(e) {
                e.preventDefault();
                openModal("Tambah Akun COA Baru", "{{ route('coa.create') }}");
            });

            $(".btnEditCoa").click(function(e) {
                e.preventDefault();
                var kode = $(this).data("kode");
                openModal("Edit Akun COA", "/coa/" + encodeURIComponent(kode) + "/edit");
            });

            $(".btnDeleteCoa").click(function(e) {
                e.preventDefault();
                var kode = $(this).data("kode");
                var form = $(this).closest("form");

                Swal.fire({
                    title: 'Hapus Akun?',
                    text: 'Akun ' + kode + ' akan dihapus dari daftar COA!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6B7280',
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
