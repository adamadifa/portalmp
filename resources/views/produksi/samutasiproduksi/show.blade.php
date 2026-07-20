<div class="mb-3">
    <p class="text-xs text-gray-500">
        <span class="font-semibold text-gray-700">Kode:</span> {{ $saldo_awal->kode_saldo_awal }} &nbsp;|&nbsp;
        <span class="font-semibold text-gray-700">Periode:</span> {{ $nama_bulan[$saldo_awal->bulan] }} {{ $saldo_awal->tahun }} &nbsp;|&nbsp;
        <span class="font-semibold text-gray-700">Tanggal:</span> {{ date('d-m-Y', strtotime($saldo_awal->tanggal)) }}
    </p>
</div>

<div class="overflow-x-auto rounded-xl border border-gray-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                <th class="py-3 px-4">Kode Produk</th>
                <th class="py-3 px-4">Nama Produk</th>
                <th class="py-3 px-4 text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($detail as $d)
            <tr class="odd:bg-white even:bg-gray-50">
                <td class="py-1.5 px-4 text-xs font-semibold text-gray-700">{{ $d->kode_produk }}</td>
                <td class="py-1.5 px-4 text-sm text-gray-600">{{ $d->nama_produk }}</td>
                <td class="py-1.5 px-4 text-right text-sm font-medium text-gray-800">{{ formatAngka($d->jumlah) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
