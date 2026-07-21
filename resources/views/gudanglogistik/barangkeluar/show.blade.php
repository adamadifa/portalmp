<div class="space-y-4">
    <!-- Header Details -->
    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100 text-xs">
        <div>
            <span class="block text-gray-500 font-medium">No. Bukti</span>
            <span class="font-bold text-[#294C9A] text-sm">{{ $barangkeluar->no_bukti }}</span>
        </div>
        <div>
            <span class="block text-gray-500 font-medium">Tanggal Pengeluaran</span>
            <span class="font-semibold text-gray-800">{{ DateToIndo($barangkeluar->tanggal) }}</span>
        </div>
        <div>
            <span class="block text-gray-500 font-medium">Jenis Pengeluaran</span>
            <span class="font-semibold text-gray-800">{{ $jenis_pengeluaran[$barangkeluar->kode_jenis_pengeluaran] ?? $barangkeluar->kode_jenis_pengeluaran }}</span>
        </div>
        @if ($barangkeluar->kode_jenis_pengeluaran == 'CBG')
        <div>
            <span class="block text-gray-500 font-medium">Cabang Tujuan</span>
            <span class="font-semibold text-gray-800">{{ strtoupper($barangkeluar->nama_cabang) }}</span>
        </div>
        @endif
    </div>

    <!-- Items Detail Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-xs text-left">
            <thead class="text-xs uppercase bg-[#002e65] text-white">
                <tr>
                    <th class="px-3 py-2.5 text-center">No</th>
                    <th class="px-3 py-2.5">Kode</th>
                    <th class="px-3 py-2.5">Nama Barang</th>
                    <th class="px-3 py-2.5">Keterangan</th>
                    <th class="px-3 py-2.5">Cabang Peruntukan</th>
                    <th class="px-3 py-2.5 text-right">Qty</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @php $grandTotalQty = 0; @endphp
                @foreach ($detail as $d)
                    @php $grandTotalQty += $d->jumlah; @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-3 py-2 text-center text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2 font-mono font-medium text-gray-700">{{ $d->kode_barang }}</td>
                        <td class="px-3 py-2 font-semibold text-gray-900">{{ textCamelCase($d->nama_barang) }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $d->keterangan ?? '-' }}</td>
                        <td class="px-3 py-2 text-gray-800 font-medium">{{ $d->nama_cabang ? strtoupper($d->nama_cabang) : '-' }}</td>
                        <td class="px-3 py-2 text-right font-bold text-gray-900">{{ formatAngkaDesimal($d->jumlah) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 font-bold text-gray-900 border-t border-gray-200">
                <tr>
                    <td colspan="5" class="px-3 py-2.5 text-right">Total Quantity:</td>
                    <td class="px-3 py-2.5 text-right text-[#294C9A] text-sm">{{ formatAngkaDesimal($grandTotalQty) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
