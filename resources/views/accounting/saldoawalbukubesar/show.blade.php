<x-app-layout>
    <x-slot name="header">
        Detail Saldo Awal Buku Besar
    </x-slot>

    <!-- Header & Subtitle -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Detail Saldo Awal Buku Besar</h2>
            <p class="text-sm text-gray-500 mt-1">
                Kode: <span class="font-semibold text-gray-800 font-mono">{{ $saldoawal->kode_saldo_awal }}</span> | 
                Periode: <span class="font-semibold text-gray-800">{{ $nama_bulan[(int)$saldoawal->bulan] ?? $saldoawal->bulan }} {{ $saldoawal->tahun }}</span>
            </p>
        </div>
        <div class="flex items-center gap-2">
            @can('saldoawalbukubesar.edit')
            <a href="{{ route('saldoawalbukubesar.edit', Crypt::encrypt($saldoawal->kode_saldo_awal)) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition shadow-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit</span>
            </a>
            @endcan
            <a href="{{ route('saldoawalbukubesar.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition shadow-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-5xl">
        <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/75 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-4 py-3.5 w-12 text-center">No</th>
                            <th class="px-4 py-3.5">Kode Akun</th>
                            <th class="px-4 py-3.5">Nama Akun</th>
                            <th class="px-4 py-3.5 text-right">Jumlah Saldo (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @php
                            $total = 0;
                        @endphp
                        @forelse ($details as $index => $d)
                            @php
                                $total += $d->jumlah;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-4 py-3 text-center text-xs text-gray-400">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 font-mono text-xs font-semibold text-gray-700">{{ $d->kode_akun }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $d->nama_akun }}</td>
                                <td class="px-4 py-3 text-right font-mono font-medium text-gray-900">{{ formatAngka($d->jumlah) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400 italic">Tidak ada rincian saldo awal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold text-gray-900 border-t border-gray-200">
                            <td colspan="3" class="px-4 py-3.5 text-right uppercase tracking-wider text-xs">Total Saldo:</td>
                            <td class="px-4 py-3.5 text-right font-mono text-base text-[#294C9A]">{{ formatAngka($total) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
