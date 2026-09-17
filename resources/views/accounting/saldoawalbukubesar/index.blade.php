<x-app-layout>
    <x-slot name="header">
        Saldo Awal Buku Besar
    </x-slot>

    <!-- Header & Subtitle -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Saldo Awal Buku Besar</h2>
            <p class="text-sm text-gray-500 mt-1">Mengelola saldo awal buku besar per periode bulanan.</p>
        </div>
        @can('saldoawalbukubesar.create')
        <a href="{{ route('saldoawalbukubesar.create') }}" class="inline-flex items-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Buat Saldo Awal</span>
        </a>
        @endcan
    </div>

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

    <div class="space-y-4">
        <!-- Filter Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <form action="{{ route('saldoawalbukubesar.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-end">
                <div class="flex-1 w-full sm:w-auto">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Bulan</label>
                    <select name="bulan" id="bulan" class="w-full py-2 px-3 text-xs bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:outline-none transition">
                        <option value="">Semua Bulan</option>
                        @foreach ($list_bulan as $d)
                            <option {{ Request('bulan') == $d['kode_bulan'] ? 'selected' : '' }} value="{{ $d['kode_bulan'] }}">{{ $d['nama_bulan'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 w-full sm:w-auto">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tahun</label>
                    <select name="tahun" id="tahun" class="w-full py-2 px-3 text-xs bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#294C9A] focus:outline-none transition">
                        <option value="">Semua Tahun</option>
                        @for ($t = $start_year; $t <= date('Y') + 1; $t++)
                            <option {{ (Request('tahun') == $t || (!Request('tahun') && date('Y') == $t)) ? 'selected' : '' }} value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white uppercase font-bold">
                            <th class="px-5 py-3.5" style="width: 5%">NO</th>
                            <th class="px-5 py-3.5" style="width: 25%">KODE SALDO AWAL</th>
                            <th class="px-5 py-3.5" style="width: 25%">PERIODE</th>
                            <th class="px-5 py-3.5" style="width: 25%">TANGGAL INISIALISASI</th>
                            <th class="px-5 py-3.5 text-center" style="width: 20%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($saldoawalbukubesar as $d)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-5 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3 font-mono font-bold text-[#294C9A]">
                                    <span class="bg-blue-50 text-[#294C9A] px-2.5 py-1 rounded-lg border border-blue-100">{{ $d->kode_saldo_awal }}</span>
                                </td>
                                <td class="px-5 py-3 font-semibold text-gray-800">
                                    {{ $nama_bulan[$d->bulan] ?? $d->bulan }} {{ $d->tahun }}
                                </td>
                                <td class="px-5 py-3 text-gray-600">
                                    {{ formatIndo($d->tanggal) }}
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @can('saldoawalbukubesar.show')
                                        <a href="{{ route('saldoawalbukubesar.show', Crypt::encrypt($d->kode_saldo_awal)) }}" class="p-1 text-sky-600 hover:text-sky-800 transition" title="Lihat Rincian">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        @endcan

                                        @can('saldoawalbukubesar.edit')
                                        <a href="{{ route('saldoawalbukubesar.edit', Crypt::encrypt($d->kode_saldo_awal)) }}" class="p-1 text-emerald-600 hover:text-emerald-800 transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        @endcan

                                        @can('saldoawalbukubesar.delete')
                                        <form action="{{ route('saldoawalbukubesar.destroy', Crypt::encrypt($d->kode_saldo_awal)) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-red-500 hover:text-red-700 transition delete-confirm" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400 italic">
                                    Belum ada data saldo awal buku besar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('myscript')
    <script>
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Saldo awal periode ini akan dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#294C9A",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
