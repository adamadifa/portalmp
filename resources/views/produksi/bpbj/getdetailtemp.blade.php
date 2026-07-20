@foreach ($detailtemp as $d)
    <tr class="hover:bg-gray-50 transition-colors">
        <td class="py-2.5 px-4 font-semibold text-gray-700">{{ $d->kode_produk }}</td>
        <td class="py-2.5 px-4 text-gray-600">{{ $d->nama_produk }}</td>
        <td class="py-2.5 px-4 text-gray-600">{{ $d->shift }}</td>
        <td class="py-2.5 px-4 text-right font-medium text-gray-700">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
        <td class="py-2.5 px-4 text-center">
            <button type="button" data-id="{{ $d->id }}" class="btn-delete-temp text-red-600 hover:text-red-800 transition">
                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </td>
    </tr>
@endforeach
