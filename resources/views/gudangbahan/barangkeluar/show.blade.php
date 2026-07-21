<div class="space-y-4">
    <!-- Header Details -->
    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
        <div class="grid grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-gray-400 font-medium block mb-0.5">No. Bukti</span>
                <span class="font-bold text-[#294C9A] text-sm">{{ $barangkeluar->no_bukti }}</span>
            </div>
            <div>
                <span class="text-gray-400 font-medium block mb-0.5">Tanggal</span>
                <span class="font-semibold text-gray-800">{{ DateToIndo($barangkeluar->tanggal) }}</span>
            </div>
            <div>
                <span class="text-gray-400 font-medium block mb-0.5">Jenis Pengeluaran</span>
                <span class="font-semibold text-gray-800">{{ $jenis_pengeluaran[$barangkeluar->kode_jenis_pengeluaran] ?? $barangkeluar->kode_jenis_pengeluaran }}</span>
            </div>
            <div>
                <span class="text-gray-400 font-medium block mb-0.5">Keterangan</span>
                <span class="font-semibold text-gray-800">
                    @if ($barangkeluar->kode_jenis_pengeluaran == 'CBG')
                        {{ strtoupper($barangkeluar->nama_cabang) }}
                    @elseif ($barangkeluar->kode_jenis_pengeluaran == 'PRD')
                        Unit {{ $barangkeluar->keterangan }}
                    @else
                        {{ $barangkeluar->keterangan }}
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-[#294C9A] text-white text-[10px] uppercase tracking-wider">
                    <th class="py-2.5 px-3">Kode</th>
                    <th class="py-2.5 px-3" style="width: 35%">Nama Barang</th>
                    <th class="py-2.5 px-3 text-right">Qty Unit</th>
                    <th class="py-2.5 px-3 text-right">Qty Berat</th>
                    <th class="py-2.5 px-3 text-right">Qty Lebih</th>
                    <th class="py-2.5 px-3" style="width: 25%">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs">
                @foreach ($detail as $d)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/40 transition">
                        <td class="py-2 px-3 font-semibold text-[#294C9A]">{{ $d->kode_barang }}</td>
                        <td class="py-2 px-3 text-gray-800 font-medium">{{ strtoupper($d->nama_barang) }}</td>
                        <td class="py-2 px-3 text-right font-semibold text-gray-800">{{ formatAngkaDesimal($d->qty_unit) }}</td>
                        <td class="py-2 px-3 text-right font-semibold text-gray-800">{{ formatAngkaDesimal($d->qty_berat) }}</td>
                        <td class="py-2 px-3 text-right font-semibold text-gray-800">{{ formatAngkaDesimal($d->qty_lebih) }}</td>
                        <td class="py-2 px-3 text-gray-500">{{ $d->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
