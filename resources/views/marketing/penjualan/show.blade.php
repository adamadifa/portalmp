<x-app-layout>
    <x-slot name="header">
        Detail Penjualan Marketing
    </x-slot>

    <!-- Main Container -->
    <div class="space-y-6">
        
        <!-- Header & Navigation -->
        <div class="flex justify-between items-center w-full mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Detail Penjualan Marketing</h2>
                <p class="text-sm text-gray-500 mt-1 font-mono"># {{ $penjualan->no_bukti }}</p>
            </div>
            <div>
                <a href="{{ route('penjualanmarketing.index') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition shadow-sm h-[38px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>

        @php
            $total_dpp = 0;
            $total_ppn = 0;
            $total_jumlah = 0;
            
            foreach ($detail as $d) {
                $dpp = $d->harga_dus * $d->jumlah;
                $ppn = $dpp * 0.11;
                $jumlah_item = $dpp + $ppn;
                
                $total_dpp += $dpp;
                $total_ppn += $ppn;
                $total_jumlah += $jumlah_item;
            }
            
            // Keep full decimal totals for formatting
            $total_ppn_val = $total_ppn;
            $total_jumlah_val = $total_jumlah;
        @endphp

        <!-- Top Grid: Transaction Info & Payment Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6 items-stretch text-sm">
            <!-- Card 1: Detail Transaksi -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-[#294C9A] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Detail Transaksi
                            </h5>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">No. Bukti</span>
                                <span class="font-semibold text-gray-900 font-mono text-sm block">{{ $penjualan->no_bukti }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Tanggal</span>
                                <span class="font-semibold text-gray-900 block">{{ date('d M Y', strtotime($penjualan->tanggal)) }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Jenis Transaksi</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold {{ $penjualan->jenis_transaksi == 'T' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $penjualan->jenis_transaksi == 'T' ? 'TUNAI' : 'KREDIT' }}
                                </span>
                            </div>
                            @if ($penjualan->jenis_transaksi == 'T')
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Metode Bayar</span>
                                <span class="font-semibold text-gray-900 block">{{ $penjualan->jenis_bayar == 'TN' ? 'CASH' : 'TRANSFER' }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Informasi Pelanggan -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-[#294C9A] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Pelanggan
                            </h5>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Nama Customer</span>
                                <span class="font-bold text-gray-900 text-sm block">{{ $penjualan->nama_pelanggan }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Alamat</span>
                                <span class="text-xs text-gray-650 block leading-relaxed">{{ $penjualan->alamat_pelanggan ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Summary & Payment -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden h-full flex flex-col justify-between">
                    <!-- Grand Total Display Header -->
                    <div class="bg-gradient-to-br from-[#294C9A] to-[#1E3A70] text-white p-5 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                        <div class="relative z-10 space-y-1">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-blue-200 block">Grand Total (+PPN)</span>
                             <h2 class="text-xl font-bold font-mono tracking-tight">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</h2>
                        </div>
                    </div>

                    <!-- Payment summary body -->
                    <div class="p-5 space-y-4 flex-1 flex flex-col justify-between">
                        <table class="w-full text-xs text-left border-collapse">
                            <tr class="border-b border-gray-50">
                                <td class="py-2 text-gray-400 font-semibold">Tagihan</td>
                                <td class="py-2 text-right font-bold text-gray-900 font-mono">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="py-2 text-gray-400 font-semibold">Total Bayar</td>
                                <td class="py-2 text-right font-bold text-emerald-600 font-mono">
                                    Rp {{ number_format($penjualan->status == '1' ? $total_jumlah_val : 0, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="py-2 text-gray-400 font-semibold">Sisa Tagihan</td>
                                <td class="py-2 text-right font-bold text-rose-600 font-mono">
                                    Rp {{ number_format($penjualan->status == '1' ? 0 : $total_jumlah_val, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>

                        <div class="pt-2">
                            @if ($penjualan->status == '1')
                                <div class="flex items-center justify-center gap-1.5 py-2 rounded-xl bg-emerald-50 border border-emerald-200/50 text-emerald-700 text-xs font-bold uppercase tracking-wide">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Lunas
                                </div>
                            @else
                                <div class="flex items-center justify-center gap-1.5 py-2 rounded-xl bg-rose-50 border border-rose-200/50 text-rose-700 text-xs font-bold uppercase tracking-wide">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Belum Lunas
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Card: Full-width Product Details -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-[#294C9A] text-white">
                <h5 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Produk Detail
                </h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse text-gray-600">
                    <thead class="bg-[#294C9A] text-white text-sm uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-6 font-semibold whitespace-nowrap">Kode</th>
                            <th class="py-3.5 px-6 font-semibold whitespace-nowrap">Nama Produk</th>
                            <th class="py-3.5 px-6 font-semibold text-center whitespace-nowrap">Satuan</th>
                            <th class="py-3.5 px-6 font-semibold text-center whitespace-nowrap">Jumlah</th>
                            <th class="py-3.5 px-6 font-semibold text-right whitespace-nowrap">Harga / Dus</th>
                            <th class="py-3.5 px-6 font-semibold text-right whitespace-nowrap">PPN</th>
                            <th class="py-3.5 px-6 font-semibold text-right whitespace-nowrap">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-sm">
                        @foreach ($detail as $d)
                            @php
                                $dpp = $d->harga_dus * $d->jumlah;
                                $ppn = $dpp * 0.11;
                                $jumlah_item = $dpp + $ppn;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-2.5 px-6 font-mono font-semibold text-gray-900 whitespace-nowrap">{{ $d->kode_produk }}</td>
                                <td class="py-2.5 px-6 font-medium text-gray-800">{{ $d->nama_produk }}</td>
                                <td class="py-2.5 px-6 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-gray-100 text-gray-700 font-semibold text-[10px]">
                                        {{ $d->satuan }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-6 text-center font-semibold text-gray-900 whitespace-nowrap">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                                <td class="py-2.5 px-6 text-right font-mono text-gray-900 whitespace-nowrap">Rp {{ number_format($d->harga_dus, 2, ',', '.') }}</td>
                                <td class="py-2.5 px-6 text-right font-mono text-gray-400 whitespace-nowrap">Rp {{ number_format($ppn, 2, ',', '.') }}</td>
                                <td class="py-2.5 px-6 text-right font-mono font-bold text-gray-900 whitespace-nowrap">Rp {{ number_format($jumlah_item, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50/30 font-bold text-gray-900 border-t border-gray-100 text-sm">
                        <tr>
                            <td colspan="5" class="py-2.5 px-6 text-right font-semibold text-gray-500 whitespace-nowrap">TOTAL</td>
                            <td class="py-2.5 px-6 text-right font-mono text-gray-400 whitespace-nowrap">Rp {{ number_format($total_ppn_val, 2, ',', '.') }}</td>
                            <td class="py-2.5 px-6 text-right font-mono text-sm text-[#294C9A] whitespace-nowrap">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
