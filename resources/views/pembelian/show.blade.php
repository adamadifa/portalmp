<div class="space-y-6">
    <!-- Top General Info Grid -->
    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
        <h4 class="font-bold text-gray-900 border-b border-gray-200 pb-2.5 mb-4 uppercase tracking-wider text-xs">Informasi Transaksi</h4>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-xs">
            <div>
                <span class="block text-gray-500 font-semibold mb-1">No. Bukti</span>
                <span class="font-bold text-gray-900 font-mono text-sm">{{ $pembelian->no_bukti }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Tanggal</span>
                <span class="font-medium text-gray-900">{{ DateToIndo($pembelian->tanggal) }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Supplier</span>
                <span class="font-medium text-gray-900">{{ $pembelian->nama_supplier }}</span>
            </div>

            <div>
                <span class="block text-gray-500 font-semibold mb-1">PPN</span>
                <span>
                    @if($pembelian->ppn == '1')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-250">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Ya
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-rose-50 text-rose-700 border border-rose-250">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tidak
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    @can('pembelian.harga')
        <!-- Detail Barang Pembelian -->
        <div class="space-y-2">
            <h4 class="font-bold text-gray-800 text-xs uppercase tracking-wider">Data Barang Pembelian</h4>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-xs text-left">
                    <thead class="text-[11px] uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                        <tr>
                            <th class="px-3.5 py-2.5">Kode</th>
                            <th class="px-3.5 py-2.5">Nama Barang</th>
                            <th class="px-3.5 py-2.5">Keterangan</th>
                            <th class="px-3.5 py-2.5 text-center">Qty</th>
                            <th class="px-3.5 py-2.5 text-right">Harga</th>
                            <th class="px-3.5 py-2.5 text-right">Subtotal</th>
                            <th class="px-3.5 py-2.5 text-right">Peny</th>
                            <th class="px-3.5 py-2.5 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                        @php
                            $total_pembelian = 0;
                        @endphp
                        @foreach ($detail as $d)
                            @php
                                $subtotal = $d->jumlah * $d->harga;
                                $total = $subtotal + $d->penyesuaian;
                                $total_pembelian += $total;
                                $bg = '';
                                if (!empty($d->kode_cr)) {
                                    $bg = 'bg-blue-50 text-blue-900';
                                }
                            @endphp
                            <tr class="{{ $bg }} hover:bg-gray-50/50 transition">
                                <td class="px-3.5 py-2 font-medium text-gray-900 font-mono">{{ $d->kode_barang }}</td>
                                <td class="px-3.5 py-2">{{ textCamelCase($d->nama_barang) }}</td>
                                <td class="px-3.5 py-2 text-gray-500">{{ textCamelCase($d->keterangan) }}</td>
                                <td class="px-3.5 py-2 text-center">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                <td class="px-3.5 py-2 text-right">{{ formatAngkaDesimal($d->harga) }}</td>
                                <td class="px-3.5 py-2 text-right">{{ formatAngkaDesimal($subtotal) }}</td>
                                <td class="px-3.5 py-2 text-right">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                                <td class="px-3.5 py-2 text-right font-bold text-gray-950">{{ formatAngkaDesimal($total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 text-gray-900 font-bold border-t border-gray-200">
                        <tr>
                            <td colspan="7" class="px-3.5 py-2.5 text-left uppercase">TOTAL</td>
                            <td class="px-3.5 py-2.5 text-right text-base text-[#294C9A]">{{ formatAngkaDesimal($total_pembelian) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Potongan Pembelian -->
        <div class="space-y-2">
            <h4 class="font-bold text-red-800 text-xs uppercase tracking-wider">Potongan Pembelian</h4>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-xs text-left">
                    <thead class="text-[11px] uppercase bg-red-600 text-white">
                        <tr>
                            <th class="px-3.5 py-2.5">Keterangan</th>
                            <th class="px-3.5 py-2.5 text-center">Qty</th>
                            <th class="px-3.5 py-2.5 text-right">Harga</th>
                            <th class="px-3.5 py-2.5 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                        @php
                            $total_potongan = 0;
                        @endphp
                        @foreach ($potongan as $d)
                            @php
                                $subtotal = $d->jumlah * $d->harga;
                                $total_potongan += $subtotal;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-3.5 py-2">{{ textCamelCase($d->keterangan_penjualan) }}</td>
                                <td class="px-3.5 py-2 text-center">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                <td class="px-3.5 py-2 text-right">{{ formatAngkaDesimal($d->harga) }}</td>
                                <td class="px-3.5 py-2 text-right font-semibold text-gray-900">{{ formatAngkaDesimal($subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 text-gray-900 font-bold border-t border-gray-200">
                        <tr>
                            <td colspan="3" class="px-3.5 py-2 uppercase">TOTAL POTONGAN</td>
                            <td class="px-3.5 py-2 text-right text-red-650">{{ formatAngkaDesimal($total_potongan) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-3.5 py-2 uppercase">PENY. JURNAL KOREKSI</td>
                            <td class="px-3.5 py-2 text-right text-amber-600">{{ formatAngkaDesimal($pembelian->penyesuaian_jk) }}</td>
                        </tr>
                        <tr class="bg-emerald-50 text-emerald-950 text-sm">
                            <td colspan="3" class="px-3.5 py-3 uppercase">GRAND TOTAL</td>
                            <td class="px-3.5 py-3 text-right font-black">{{ formatAngkaDesimal($total_pembelian - $total_potongan + $pembelian->penyesuaian_jk) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Histori Pembayaran -->
        <div class="space-y-2">
            <h4 class="font-bold text-emerald-800 text-xs uppercase tracking-wider">Histori Pembayaran</h4>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-xs text-left">
                    <thead class="text-[11px] uppercase bg-emerald-600 text-white">
                        <tr>
                            <th class="px-3.5 py-2.5">No</th>
                            <th class="px-3.5 py-2.5">Tanggal Bayar</th>
                            <th class="px-3.5 py-2.5">Bank</th>
                            <th class="px-3.5 py-2.5">Cabang</th>
                            <th class="px-3.5 py-2.5 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                        @foreach ($historibayar as $d)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-3.5 py-2 font-mono font-semibold text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-3.5 py-2">{{ DateToIndo($d->tanggal) }}</td>
                                <td class="px-3.5 py-2">{{ $d->nama_bank }}</td>
                                <td class="px-3.5 py-2 uppercase">{{ $d->kode_cabang }}</td>
                                <td class="px-3.5 py-2 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            </tr>
                        @endforeach
                        @if ($historibayar->isEmpty())
                            <tr>
                                <td colspan="5" class="px-3.5 py-3 text-center text-gray-400">Belum ada pembayaran.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Non-Harga View (Simple Detail) -->
        <div class="space-y-2">
            <h4 class="font-bold text-gray-800 text-xs uppercase tracking-wider">Data Barang Pembelian</h4>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full text-xs text-left">
                    <thead class="text-[11px] uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                        <tr>
                            <th class="px-3.5 py-2.5">Kode</th>
                            <th class="px-3.5 py-2.5">Nama Barang</th>
                            <th class="px-3.5 py-2.5">Keterangan</th>
                            <th class="px-3.5 py-2.5 text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                        @foreach ($detail as $d)
                            @php
                                $bg = '';
                                if (!empty($d->kode_cr)) {
                                    $bg = 'bg-blue-50 text-blue-900';
                                }
                            @endphp
                            <tr class="{{ $bg }} hover:bg-gray-50/50 transition">
                                <td class="px-3.5 py-2 font-mono text-gray-900">{{ $d->kode_barang }}</td>
                                <td class="px-3.5 py-2">{{ textCamelCase($d->nama_barang) }}</td>
                                <td class="px-3.5 py-2 text-gray-500">{{ textCamelCase($d->keterangan) }}</td>
                                <td class="px-3.5 py-2 text-center">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
</div>
