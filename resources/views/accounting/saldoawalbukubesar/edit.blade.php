<x-app-layout>
    <x-slot name="header">
        Edit Saldo Awal Buku Besar
    </x-slot>

    <!-- Header & Subtitle -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Edit Saldo Awal Buku Besar</h2>
            <p class="text-sm text-gray-500 mt-1">
                Kode: <span class="font-semibold text-gray-800 font-mono">{{ $saldoawal->kode_saldo_awal }}</span> | 
                Periode: <span class="font-semibold text-gray-800">{{ $nama_bulan[(int)$saldoawal->bulan] ?? $saldoawal->bulan }} {{ $saldoawal->tahun }}</span>
            </p>
        </div>
        <a href="{{ route('saldoawalbukubesar.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-5xl">
        <form action="{{ route('saldoawalbukubesar.store') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" name="bulan" value="{{ $saldoawal->bulan }}">
            <input type="hidden" name="tahun" value="{{ $saldoawal->tahun }}">

            <!-- Table of Account Balances -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm mb-6">
                <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/75 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-semibold sticky top-0 z-10">
                                <th class="px-4 py-3.5">Akun (COA)</th>
                                <th class="px-4 py-3.5 text-right w-64">Jumlah Saldo (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($accounts as $index => $d)
                                @php
                                    $indent = ($d->level ?? 0) * 16;
                                    $saldo_val = $saldo_map[$d->kode_akun] ?? 0;
                                @endphp
                                <tr class="{{ $d->level < 3 ? 'bg-gray-50/50 font-semibold text-gray-900' : 'hover:bg-blue-50/20 text-gray-700' }}">
                                    <td class="px-4 py-2.5" style="padding-left: {{ max(16, $indent) }}px;">
                                        @if ($d->level < 3)
                                            <span class="text-xs font-mono font-bold text-gray-500 mr-2">{{ $d->kode_akun }}</span>
                                            <span class="font-bold text-gray-900">{{ $d->nama_akun }}</span>
                                        @else
                                            <span class="text-xs font-mono text-gray-400 mr-2">{{ $d->kode_akun }}</span>
                                            <span>{{ $d->nama_akun }}</span>
                                        @endif
                                        <input type="hidden" name="kode_akun[]" value="{{ $d->kode_akun }}">
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        @if ($d->level < 3)
                                            <span class="text-xs text-gray-400 italic">Akun Induk</span>
                                            <input type="hidden" name="jumlah[]" value="0">
                                        @else
                                            <input type="text" name="jumlah[]" value="{{ formatAngka($saldo_val) }}" 
                                                class="w-full max-w-[200px] ml-auto text-right py-1.5 px-3 text-xs bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#294C9A] focus:outline-none transition money">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Submit Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('saldoawalbukubesar.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="bg-[#294C9A] hover:bg-[#1E3A70] text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    <span>Update Saldo Awal</span>
                </button>
            </div>
        </form>
    </div>

    @push('myscript')
    <script>
        $(function() {
            if (typeof easyNumberSeparator !== 'undefined') {
                easyNumberSeparator({
                    selector: '.money',
                    separator: '.'
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
