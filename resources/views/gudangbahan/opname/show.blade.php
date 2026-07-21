<div class="space-y-6">
    <!-- Meta Info Card -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
        <div>
            <span class="block text-[10px] uppercase font-bold text-gray-400">Kode Opname</span>
            <span class="text-sm font-bold text-gray-800">{{ $opname->kode_opname }}</span>
        </div>
        <div>
            <span class="block text-[10px] uppercase font-bold text-gray-400">Bulan</span>
            <span class="text-sm font-bold text-gray-800">{{ $nama_bulan[$opname->bulan] }}</span>
        </div>
        <div>
            <span class="block text-[10px] uppercase font-bold text-gray-400">Tahun</span>
            <span class="text-sm font-bold text-[#294C9A]">{{ $opname->tahun }}</span>
        </div>
        <div>
            <span class="block text-[10px] uppercase font-bold text-gray-400">Tanggal</span>
            <span class="text-sm font-bold text-gray-800">{{ date('d-m-Y', strtotime($opname->tanggal)) }}</span>
        </div>
    </div>

    <!-- Details Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto max-h-[50vh] overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10">Kode</th>
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10" style="width: 40%;">Nama Barang</th>
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10">Kategori</th>
                        <th class="py-2.5 px-4 text-right sticky top-0 bg-[#294C9A] z-10">Qty Unit</th>
                        <th class="py-2.5 px-4 text-right sticky top-0 bg-[#294C9A] z-10">Qty Berat</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach ($detail as $d)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-2 px-4 font-semibold text-[#294C9A]">{{ $d->kode_barang }}</td>
                            <td class="py-2 px-4 text-gray-700 font-medium">{{ $d->nama_barang }}</td>
                            <td class="py-2 px-4 text-gray-500 font-medium">{{ $d->nama_kategori }}</td>
                            <td class="py-2 px-4 text-right text-gray-900 font-bold">{{ formatAngkaDesimal($d->qty_unit) }}</td>
                            <td class="py-2 px-4 text-right text-gray-900 font-bold">{{ formatAngkaDesimal($d->qty_berat) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
