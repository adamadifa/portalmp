<div class="space-y-4">
    <!-- Header Details -->
    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100 text-xs">
        <div>
            <span class="block text-gray-500 font-medium">No. Bukti</span>
            <span class="font-bold text-[#294C9A] text-sm">{{ $barangmasuk->no_bukti }}</span>
        </div>
        <div>
            <span class="block text-gray-500 font-medium">Tanggal Diterima</span>
            <span class="font-semibold text-gray-800">{{ DateToIndo($barangmasuk->tanggal) }}</span>
        </div>
        <div>
            <span class="block text-gray-500 font-medium">Kode Supplier</span>
            <span class="font-semibold text-gray-800">{{ $barangmasuk->kode_supplier ?? '-' }}</span>
        </div>
        <div>
            <span class="block text-gray-500 font-medium">Nama Supplier</span>
            <span class="font-semibold text-gray-800">{{ $barangmasuk->nama_supplier ?? '-' }}</span>
        </div>
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
                    <th class="px-3 py-2.5 text-right">Qty</th>
                    <th class="px-3 py-2.5 text-right">Harga</th>
                    <th class="px-3 py-2.5 text-right">Subtotal</th>
                    <th class="px-3 py-2.5 text-right">Peny.</th>
                    <th class="px-3 py-2.5 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @php $grandTotal = 0; @endphp
                @foreach ($detail as $d)
                    @php
                        $subtotal = $d->jumlah * $d->harga;
                        $total = $subtotal + $d->penyesuaian;
                        $grandTotal += $total;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-3 py-2 text-center text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2 font-mono font-medium text-gray-700">{{ $d->kode_barang }}</td>
                        <td class="px-3 py-2 font-semibold text-gray-900">{{ textCamelCase($d->nama_barang) }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $d->keterangan ?? '-' }}</td>
                        <td class="px-3 py-2 text-right font-medium text-gray-800">{{ formatAngkaDesimal($d->jumlah) }}</td>
                        <td class="px-3 py-2 text-right font-medium text-gray-800">{{ formatAngkaDesimal($d->harga) }}</td>
                        <td class="px-3 py-2 text-right font-medium text-gray-800">{{ formatAngkaDesimal($subtotal) }}</td>
                        <td class="px-3 py-2 text-right font-medium text-gray-800">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                        <td class="px-3 py-2 text-right font-bold text-gray-900">{{ formatAngkaDesimal($total) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 font-bold text-gray-900 border-t border-gray-200">
                <tr>
                    <td colspan="8" class="px-3 py-2.5 text-right">Grand Total:</td>
                    <td class="px-3 py-2.5 text-right text-[#294C9A] text-sm">{{ formatAngkaDesimal($grandTotal) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
