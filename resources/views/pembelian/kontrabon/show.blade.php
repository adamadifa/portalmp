<div class="space-y-6">
    <!-- Info Grid -->
    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5">
        <h4 class="font-bold text-gray-900 border-b border-gray-200 pb-2.5 mb-4 uppercase tracking-wider text-xs">Detail Kontrabon</h4>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div>
                <span class="block text-gray-500 font-semibold mb-1">No. Kontrabon</span>
                <span class="font-bold text-gray-900 font-mono text-sm">{{ $kontrabon->no_kontrabon }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Tanggal</span>
                <span class="font-medium text-gray-900">{{ DateToIndo($kontrabon->tanggal) }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Terima Dari</span>
                <span class="font-medium text-gray-900">{{ $kontrabon->nama_supplier }}</span>
            </div>
        </div>
    </div>

    <!-- Table Details -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-xs text-left">
            <thead class="text-[11px] uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                <tr>
                    <th class="px-4 py-2.5 text-center" style="width: 8%">No.</th>
                    <th class="px-4 py-2.5">Tanggal</th>
                    <th class="px-4 py-2.5">No. Bukti</th>
                    <th class="px-4 py-2.5 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                @php
                    $total = 0;
                @endphp
                @foreach ($detail as $d)
                    @php
                        $total += $d->jumlah;
                    @endphp
                    <tr class="cursor-pointer btnShowpembelian hover:bg-blue-50/50 transition" no_bukti="{{ Crypt::encrypt($d->no_bukti) }}">
                        <td class="px-4 py-2 text-center font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-medium text-gray-900">{{ DateToIndo($d->tanggal) }}</td>
                        <td class="px-4 py-2 font-mono font-semibold text-[#294C9A]">{{ $d->no_bukti }}</td>
                        <td class="px-4 py-2 text-right font-bold text-gray-950">{{ formatAngkaDesimal($d->jumlah) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 text-gray-900 font-bold border-t border-gray-200">
                <tr>
                    <td colspan="3" class="px-4 py-2.5 uppercase">TOTAL</td>
                    <td class="px-4 py-2.5 text-right text-base text-[#294C9A]">{{ formatAngkaDesimal($total) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
