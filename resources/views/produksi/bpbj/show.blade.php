<div class="space-y-6">
    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
        <div class="flex justify-between text-xs">
            <span class="text-gray-500 font-medium">No. BPBJ:</span>
            <span class="text-gray-900 font-bold">{{ $bpbj->no_mutasi }}</span>
        </div>
        <div class="flex justify-between text-xs">
            <span class="text-gray-500 font-medium">Tanggal:</span>
            <span class="text-gray-900 font-semibold">{{ date('d-m-Y', strtotime($bpbj->tanggal_mutasi)) }}</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-[#294C9A] px-6 py-4 border-b border-white/10">
            <h3 class="text-sm font-semibold text-white">Detail Produk</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white border-t border-white/10">
                    <th class="py-3 px-4">Kode Produk</th>
                    <th class="py-3 px-4">Nama Produk</th>
                    <th class="py-3 px-4">Shift</th>
                    <th class="py-3 px-4 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @foreach ($detail as $d)
                <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
                    <td class="py-2.5 px-4 font-semibold text-gray-700">{{ $d->kode_produk }}</td>
                    <td class="py-2.5 px-4 text-gray-600">{{ $d->nama_produk }}</td>
                    <td class="py-2.5 px-4 text-gray-600">{{ $d->shift }}</td>
                    <td class="py-2.5 px-4 text-right font-medium text-gray-700">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
