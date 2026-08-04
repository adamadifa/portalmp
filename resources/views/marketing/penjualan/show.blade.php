<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-5">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Detail Penjualan Marketing</h2>
                <div class="flex items-center gap-1.5 text-xs text-gray-400 mt-1 font-mono">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                    <span>{{ $penjualan->no_bukti }}</span>
                </div>
            </div>
            <div>
                <a href="{{ route('penjualanmarketing.index') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition shadow-sm h-[38px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>

        @php
            $total_dpp = 0;
            $total_ppn = 0;
            $total_jumlah = 0;
            
            foreach ($detail as $d) {
                $dpp = $d->subtotal;
                $ppn = $dpp * (11/12) * 0.12;
                $jumlah_item = $dpp + $ppn;
                
                $total_dpp += $dpp;
                $total_ppn += $ppn;
                $total_jumlah += $jumlah_item;
            }
            
            // Bulatkan total
            $total_ppn_rounded = round($total_ppn);
            $total_jumlah_rounded = round($total_jumlah);
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start text-xs">
            <!-- Left Column: Transaction Info & Products -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Information Card -->
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-50 pb-3">
                        <h5 class="text-xs font-bold uppercase tracking-wider text-[#294C9A] flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Informasi Transaksi
                        </h5>
                        <div>
                            @if ($penjualan->status == '1')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800">
                                    Lunas
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                    Belum Lunas
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex flex-col">
                                <span class="text-gray-400 font-semibold mb-0.5">No. Bukti</span>
                                <span class="font-bold text-gray-900 font-mono text-sm">{{ $penjualan->no_bukti }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-400 font-semibold mb-0.5">Tanggal</span>
                                <span class="font-semibold text-gray-900">{{ date('d-m-Y', strtotime($penjualan->tanggal)) }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-400 font-semibold mb-0.5">Pelanggan</span>
                                <span class="font-semibold text-gray-900">{{ $penjualan->nama_pelanggan }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex flex-col">
                                <span class="text-gray-400 font-semibold mb-0.5">Alamat</span>
                                <span class="font-semibold text-gray-850">{{ $penjualan->alamat_pelanggan ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-400 font-semibold mb-0.5">Jenis Transaksi</span>
                                <span class="font-bold {{ $penjualan->jenis_transaksi == 'T' ? 'text-green-600' : 'text-amber-600' }}">
                                    {{ $penjualan->jenis_transaksi == 'T' ? 'TUNAI' : 'KREDIT' }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-400 font-semibold mb-0.5">Jenis Bayar</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $penjualan->jenis_transaksi == 'T' ? ($penjualan->jenis_bayar == 'TN' ? 'CASH' : 'TRANSFER') : '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product details -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                        <h5 class="text-xs font-bold uppercase tracking-wider text-gray-700 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Produk Detail
                        </h5>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse text-gray-600">
                            <thead class="bg-[#294C9A] text-white">
                                <tr>
                                    <th class="py-3 px-6 font-bold uppercase tracking-wider whitespace-nowrap" style="width: 15%;">Kode</th>
                                    <th class="py-3 px-6 font-bold uppercase tracking-wider whitespace-nowrap" style="width: 35%;">Nama Produk</th>
                                    <th class="py-3 px-6 font-bold uppercase tracking-wider text-center whitespace-nowrap" style="width: 10%;">Satuan</th>
                                    <th class="py-3 px-6 font-bold uppercase tracking-wider text-center whitespace-nowrap" style="width: 10%;">Jumlah</th>
                                    <th class="py-3 px-6 font-bold uppercase tracking-wider text-right whitespace-nowrap" style="width: 15%;">Harga / Dus</th>
                                    <th class="py-3 px-6 font-bold uppercase tracking-wider text-right whitespace-nowrap" style="width: 10%;">PPN</th>
                                    <th class="py-3 px-6 font-bold uppercase tracking-wider text-right whitespace-nowrap" style="width: 15%;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($detail as $d)
                                    @php
                                        $dpp = $d->subtotal;
                                        $ppn = $dpp * (11/12) * 0.12;
                                        $jumlah_item = $dpp + $ppn;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-6 font-mono font-semibold text-[#294C9A]">{{ $d->kode_produk }}</td>
                                        <td class="py-3 px-6 font-semibold text-gray-900">{{ $d->nama_produk }}</td>
                                        <td class="py-3 px-6 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-gray-100 text-gray-800 font-bold text-[10px]">
                                                {{ $d->satuan }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center font-bold text-gray-800">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                                        <td class="py-3 px-6 text-right font-medium">Rp {{ number_format($d->harga_dus, 0, ',', '.') }}</td>
                                        <td class="py-3 px-6 text-right text-gray-400">Rp {{ number_format(round($ppn), 0, ',', '.') }}</td>
                                        <td class="py-3 px-6 text-right font-bold text-gray-900">Rp {{ number_format(round($jumlah_item), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50/50 font-bold text-gray-900 border-t border-gray-100">
                                <tr>
                                    <td colspan="5" class="py-3.5 px-6 text-right">TOTAL</td>
                                    <td class="py-3.5 px-6 text-right text-gray-400">Rp {{ number_format($total_ppn_rounded, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-6 text-right text-sm text-[#294C9A]">Rp {{ number_format($total_jumlah_rounded, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column: Summary Box -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Grand Total Display Card -->
                <div class="bg-[#294C9A] text-white rounded-3xl p-6 shadow-md relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                    <div class="relative z-10 space-y-1">
                        <span class="text-[9px] font-bold uppercase tracking-wider text-blue-200">Grand Total (+PPN)</span>
                        <h2 class="text-2xl font-black font-mono">Rp {{ number_format($total_jumlah_rounded, 0, ',', '.') }}</h2>
                    </div>
                </div>

                <!-- Status Pembayaran Box -->
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-4">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-gray-700 border-b border-gray-100 pb-2">
                        Pembayaran
                    </h5>
                    <table class="w-full text-left border-collapse">
                        <tr class="border-b border-gray-50">
                            <td class="py-2.5 text-gray-400 font-semibold">Total Tagihan</td>
                            <td class="py-2.5 text-right font-bold text-gray-900">Rp {{ number_format($total_jumlah_rounded, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2.5 text-gray-400 font-semibold">Total Bayar</td>
                            <td class="py-2.5 text-right font-bold text-green-600">
                                Rp {{ number_format($penjualan->status == '1' ? $total_jumlah_rounded : 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="border-b border-gray-50">
                            <td class="py-2.5 text-gray-400 font-semibold">Sisa Tagihan</td>
                            <td class="py-2.5 text-right font-bold text-red-600">
                                Rp {{ number_format($penjualan->status == '1' ? 0 : $total_jumlah_rounded, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>

                    <div class="pt-2 text-center">
                        @if ($penjualan->status == '1')
                            <span class="inline-flex items-center justify-center w-full py-2.5 rounded-2xl text-xs font-bold bg-green-100 text-green-800 uppercase tracking-wide">
                                Lunas
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center w-full py-2.5 rounded-2xl text-xs font-bold bg-red-100 text-red-800 uppercase tracking-wide">
                                Belum Lunas
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
