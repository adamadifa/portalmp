@foreach ($barang as $d)
    @php
        $saldo_akhir = ($d->saldo_awal_jumlah ?? 0) + ($d->bm_jumlah ?? 0) - ($d->bk_jumlah ?? 0);
        $jumlah_saldoawal_pemasukan = ($d->saldo_awal_jumlah ?? 0) + ($d->bm_jumlah ?? 0);
        if (empty($jumlah_saldoawal_pemasukan)) {
            $jumlah_saldoawal_pemasukan = 1;
        }

        if (empty($d->saldo_awal_harga) && ($d->saldo_awal_harga ?? 0) == 0) {
            $saldo_akhir_harga = !empty($d->bm_jumlah) ? ($d->bm_totalharga / $d->bm_jumlah) : 0;
        } elseif (empty($d->bm_harga) && ($d->bm_harga ?? 0) == 0) {
            $saldo_akhir_harga = $d->saldo_awal_harga ?? 0;
        } else {
            $saldo_akhir_harga = (($d->saldo_awal_totalharga ?? 0) * 1 + ($d->bm_totalharga ?? 0) * 1) / $jumlah_saldoawal_pemasukan;
        }
    @endphp
    @if (!empty($saldo_akhir))
        <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-2 font-mono font-medium text-gray-700">
                <input type="hidden" name="kode_barang[]" value="{{ $d->kode_barang }}">
                {{ $d->kode_barang }}
            </td>
            <td class="px-4 py-2 font-semibold text-gray-900">{{ textCamelCase($d->nama_barang) }}</td>
            <td class="px-4 py-2 text-right">
                @if ($readonly)
                    <input type="hidden" name="jumlah[]" value="{{ formatAngkaDesimal($saldo_akhir) }}">
                    <span class="font-bold text-gray-900">{{ formatAngkaDesimal($saldo_akhir) }}</span>
                @else
                    <input type="text" name="jumlah[]" value="" class="w-full text-right px-2 py-1 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] outline-none number-separator font-bold text-gray-900">
                @endif
            </td>
            <td class="px-4 py-2 text-right">
                @if ($readonly)
                    <input type="hidden" name="harga[]" value="{{ formatAngkaDesimal($saldo_akhir_harga) }}">
                    <span class="font-bold text-gray-900">{{ formatAngkaDesimal($saldo_akhir_harga) }}</span>
                @else
                    <input type="text" name="harga[]" value="" class="w-full text-right px-2 py-1 text-xs border border-gray-300 rounded-lg focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] outline-none number-separator font-bold text-gray-900">
                @endif
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
