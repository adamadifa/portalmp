<div class="space-y-6">
    <!-- Header info table -->
    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-200/60">
                <tr class="first:pt-0">
                    <td class="py-2.5 font-bold text-gray-500 uppercase tracking-wider text-xs">Kode Saldo Awal</td>
                    <td class="py-2.5 font-bold text-gray-900 text-right">{{ $saldo_awal->kode_saldo_awal }}</td>
                </tr>
                <tr>
                    <td class="py-2.5 font-bold text-gray-500 uppercase tracking-wider text-xs">Bulan</td>
                    <td class="py-2.5 font-semibold text-gray-800 text-right">{{ $nama_bulan[$saldo_awal->bulan] }}</td>
                </tr>
                <tr>
                    <td class="py-2.5 font-bold text-gray-500 uppercase tracking-wider text-xs">Tahun</td>
                    <td class="py-2.5 text-gray-700 text-right">{{ $saldo_awal->tahun }}</td>
                </tr>
                <tr class="last:pb-0">
                    <td class="py-2.5 font-bold text-gray-500 uppercase tracking-wider text-xs">Tanggal</td>
                    <td class="py-2.5 text-gray-700 text-right">{{ DateToIndo($saldo_awal->tanggal) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Product list table -->
    <div class="border border-gray-100 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-900 border-b border-gray-900">
                    <th class="px-4 py-3 text-xs font-bold text-white uppercase tracking-wider">Kode Produk</th>
                    <th class="px-4 py-3 text-xs font-bold text-white uppercase tracking-wider">Nama Produk</th>
                    <th class="px-4 py-3 text-xs font-bold text-white uppercase tracking-wider text-right" style="width: 25%">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach ($detail as $d)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-4 py-3 text-xs font-semibold text-gray-700">{{ $d->kode_produk }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 font-medium">{{ $d->nama_produk }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right">
                            {{ !empty($d->jumlah) ? formatAngka($d->jumlah) : '0' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
