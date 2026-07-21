@foreach ($barang as $d)
   <tr class="odd:bg-white even:bg-gray-50/50 hover:bg-gray-100/50 transition-colors">
      <td class="py-2 px-4 font-semibold text-[#294C9A]">
         <input type="hidden" name="kode_barang[]" value="{{ $d->kode_barang }}">
         {{ $d->kode_barang }}
      </td>
      <td class="py-2 px-4 text-gray-700 font-medium">{{ $d->nama_barang }}</td>
      <td class="py-2 px-4 text-gray-500 font-medium">{{ $d->nama_kategori }}</td>
      <td class="py-2 px-4 text-right">
         @if ($readonly)
            <input type="hidden" name="qty_unit[]" value="{{ formatAngkaDesimal($d->saldo_unit) }}">
            <span class="font-bold text-gray-900">{{ formatAngkaDesimal($d->saldo_unit) }}</span>
         @else
            <input type="text" name="qty_unit[]" value="{{ formatAngkaDesimal($d->saldo_unit) }}"
               class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none money">
         @endif
      </td>
      <td class="py-2 px-4 text-right">
         @if ($readonly)
            <input type="hidden" name="qty_berat[]" value="{{ formatAngkaDesimal($d->saldo_berat) }}">
            <span class="font-bold text-gray-900">{{ formatAngkaDesimal($d->saldo_berat) }}</span>
         @else
            <input type="text" name="qty_berat[]" value="{{ formatAngkaDesimal($d->saldo_berat) }}"
               class="w-24 text-right text-xs font-bold text-gray-800 border border-gray-200 focus:ring-1 focus:ring-[#294C9A] focus:border-[#294C9A] rounded-lg px-2 py-1 focus:outline-none money">
         @endif
      </td>
   </tr>
@endforeach
