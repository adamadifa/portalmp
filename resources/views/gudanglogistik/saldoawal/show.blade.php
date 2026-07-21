<div class="space-y-4">
    <!-- Header Info -->
    <div class="grid grid-cols-2 gap-4">
        <table class="w-full text-xs">
            <tbody>
                <tr class="border-b border-gray-100">
                    <th class="py-2 pr-3 text-left font-semibold text-gray-600 whitespace-nowrap">Kode</th>
                    <td class="py-2 font-mono font-bold text-[#294C9A]">{{ $saldo_awal->kode_saldo_awal }}</td>
                </tr>
                <tr class="border-b border-gray-100">
                    <th class="py-2 pr-3 text-left font-semibold text-gray-600 whitespace-nowrap">Bulan</th>
                    <td class="py-2 font-medium text-gray-900">{{ $nama_bulan[$saldo_awal->bulan] }}</td>
                </tr>
                <tr class="border-b border-gray-100">
                    <th class="py-2 pr-3 text-left font-semibold text-gray-600 whitespace-nowrap">Tahun</th>
                    <td class="py-2 font-medium text-gray-900">{{ $saldo_awal->tahun }}</td>
                </tr>
                <tr class="border-b border-gray-100">
                    <th class="py-2 pr-3 text-left font-semibold text-gray-600 whitespace-nowrap">Tanggal</th>
                    <td class="py-2 font-medium text-gray-900">{{ DateToIndo($saldo_awal->tanggal) }}</td>
                </tr>
                <tr>
                    <th class="py-2 pr-3 text-left font-semibold text-gray-600 whitespace-nowrap">Kategori</th>
                    <td class="py-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-[#294C9A]">
                            {{ strtoupper($saldo_awal->nama_kategori) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Divider -->
    <div class="relative">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
        <div class="relative flex justify-start"><span class="pr-3 text-xs font-semibold text-[#294C9A] bg-white">Detail Saldo Awal Barang</span></div>
    </div>

    <!-- Detail Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm" style="max-height: 450px; overflow-y: auto;">
        <table class="w-full text-xs text-left">
            <thead class="text-xs uppercase bg-[#002e65] text-white sticky top-0">
                <tr>
                    <th class="px-4 py-3">No.</th>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Nama Barang</th>
                    <th class="px-4 py-3 text-right">Jumlah</th>
                    <th class="px-4 py-3 text-right">Harga</th>
                    <th class="px-4 py-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($detail as $d)
                    @php $total_harga = $d->jumlah * $d->harga; @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-mono font-medium text-gray-700">{{ $d->kode_barang }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-900">{{ textCamelCase($d->nama_barang) }}</td>
                        <td class="px-4 py-2 text-right font-bold text-gray-900">{{ formatAngkaDesimal($d->jumlah) }}</td>
                        <td class="px-4 py-2 text-right font-bold text-gray-900">{{ formatAngkaDesimal($d->harga) }}</td>
                        <td class="px-4 py-2 text-right font-bold text-[#294C9A]">{{ formatAngkaDesimal($total_harga) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-xs">
                            Tidak ada detail saldo awal.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
