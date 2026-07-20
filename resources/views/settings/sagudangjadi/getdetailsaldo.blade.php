@foreach ($produk as $d)
    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100/50 transition-colors">
        <td class="px-4 py-1.5 text-xs font-semibold text-gray-700">
            <input type="hidden" name="kode_produk[]" value="{{ $d->kode_produk }}">
            {{ $d->kode_produk }}
        </td>
        <td class="px-4 py-1.5 text-sm text-gray-600 font-medium">{{ $d->nama_produk }}</td>
        <td class="px-4 py-1.5 text-right">
            @if ($readonly)
                <input type="hidden" name="jumlah[]"
                    value="{{ empty($d->saldo_akhir) ? 0 : formatAngka($d->saldo_akhir) }}">
                <span class="text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-lg px-3 py-1 inline-block min-w-[100px] text-right">
                    {{ !empty($d->saldo_akhir) ? formatAngka($d->saldo_akhir) : '0' }}
                </span>
            @else
                <input type="text" name="jumlah[]" value="{{ isset($d->jumlah) ? formatAngka($d->jumlah) : '' }}" style="text-align: right"
                    class="money w-full max-w-[140px] rounded-xl border-gray-200 text-xs focus:border-[#294C9A] focus:ring-[#294C9A] text-right px-3 py-1">
            @endif
        </td>
    </tr>
@endforeach

<script>
    $(function() {
        if (typeof $.fn.maskMoney !== 'undefined') {
            $(".money").maskMoney({
                thousands: '.',
                decimal: ',',
                precision: 0,
                allowZero: true
            });
        } else {
            $(".money").on('input', function() {
                var val = $(this).val().replace(/[^0-9]/g, '');
                if(val) {
                    $(this).val(new Intl.NumberFormat('id-ID').format(val));
                } else {
                    $(this).val('');
                }
            });
        }
    });
</script>
