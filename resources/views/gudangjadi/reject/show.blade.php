<div class="space-y-4">
    <!-- Header Details -->
    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
        <table class="w-full text-sm text-left">
            <tbody>
                <tr class="border-b border-gray-200/50">
                    <th class="py-2 font-bold text-gray-500 w-1/3">No. Reject</th>
                    <td class="py-2 text-gray-800 font-semibold">{{ $reject->no_mutasi }}</td>
                </tr>
                <tr>
                    <th class="py-2 font-bold text-gray-500">Tanggal</th>
                    <td class="py-2 text-gray-800 font-medium">{{ DateToIndo($reject->tanggal) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Items List -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                    <th class="py-2.5 px-4">Kode</th>
                    <th class="py-2.5 px-4" style="width:50%">Nama Produk</th>
                    <th class="py-2.5 px-4 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @foreach ($detail as $d)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-2 px-4 font-semibold text-gray-700">{{ $d->kode_produk }}</td>
                        <td class="py-2 px-4 text-gray-600">{{ $d->nama_produk }}</td>
                        <td class="py-2 px-4 text-right font-bold text-gray-800">{{ formatAngka($d->jumlah) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
