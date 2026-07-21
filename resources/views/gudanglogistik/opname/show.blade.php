<div class="space-y-4">
    <!-- Header Details -->
    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100 text-xs">
        <div>
            <span class="block text-gray-500 font-medium">Kode Opname</span>
            <span class="font-bold text-[#294C9A] text-sm">{{ $opname->kode_opname }}</span>
        </div>
        <div>
            <span class="block text-gray-500 font-medium">Periode Bulan & Tahun</span>
            <span class="font-semibold text-gray-800">{{ $nama_bulan[$opname->bulan] }} {{ $opname->tahun }}</span>
        </div>
        <div>
            <span class="block text-gray-500 font-medium">Tanggal Opname</span>
            <span class="font-semibold text-gray-800">{{ DateToIndo($opname->tanggal) }}</span>
        </div>
    </div>

    <!-- Items Detail Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-xs text-left">
            <thead class="text-xs uppercase bg-[#002e65] text-white">
                <tr>
                    <th class="px-3 py-2.5 text-center">No</th>
                    <th class="px-3 py-2.5">Kode Barang</th>
                    <th class="px-3 py-2.5">Nama Barang</th>
                    <th class="px-3 py-2.5">Kategori</th>
                    <th class="px-3 py-2.5 text-right">Jumlah Total</th>
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
                        <td class="px-3 py-2 text-gray-600">{{ strtoupper($d->nama_kategori) }}</td>
                        <td class="px-3 py-2 text-right font-bold text-gray-900">{{ formatAngkaDesimal($d->jumlah) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 font-bold text-gray-900 border-t border-gray-200">
                <tr>
                    <td colspan="4" class="px-3 py-2.5 text-right">Total Quantity:</td>
                    <td class="px-3 py-2.5 text-right text-[#294C9A] text-sm">{{ formatAngkaDesimal($grandTotalQty) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
