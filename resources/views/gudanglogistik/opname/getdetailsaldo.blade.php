@foreach ($barang as $d)
    @php
        $saldo_akhir = ($d->saldo_awal_jumlah ?? 0) + ($d->bm_jumlah ?? 0) - ($d->bk_jumlah ?? 0);
    @endphp
    @if (!empty($saldo_akhir))
        <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-2 font-mono font-medium text-gray-700">
                <input type="hidden" name="kode_barang[]" value="{{ $d->kode_barang }}">
                {{ $d->kode_barang }}
            </td>
            <td class="px-4 py-2 font-semibold text-gray-900">{{ textCamelCase($d->nama_barang) }}</td>
            <td class="px-4 py-2 text-right">
                <input type="text" class="w-full text-right px-2 py-1 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] outline-none number-separator font-bold text-gray-900" name="jumlah[]" value="{{ formatAngkaDesimal($saldo_akhir) }}">
            </td>
        </tr>
    @endif
@endforeach

<script>
    if (typeof easyNumberSeparator === 'function') {
        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });
    }
</script>
