<div class="space-y-4">
    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
            <div>
                <span class="text-gray-400 block font-medium">No. Bukti Biaya:</span>
                <span class="font-bold text-gray-800 font-mono">{{ $biaya->no_bukti }}</span>
            </div>
            <div>
                <span class="text-gray-400 block font-medium">Total Biaya:</span>
                <span class="font-bold text-blue-700">Rp {{ formatAngkaDesimal($biaya->total_biaya) }}</span>
            </div>
            <div>
                <span class="text-gray-400 block font-medium">Sudah Dibayar:</span>
                <span class="font-bold text-emerald-600">Rp {{ formatAngkaDesimal($biaya->total_bayar) }}</span>
            </div>
            <div>
                <span class="text-gray-400 block font-medium">Sisa Tagihan:</span>
                <span class="font-bold text-rose-600">Rp {{ formatAngkaDesimal($biaya->sisa_bayar) }}</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-xs text-left">
            <thead class="bg-gray-50 text-gray-700 uppercase border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 w-12 text-center">No</th>
                    <th class="px-4 py-3 w-32">Tanggal</th>
                    <th class="px-4 py-3">Bank / Kas</th>
                    <th class="px-4 py-3">Keterangan</th>
                    <th class="px-4 py-3 text-right w-36">Jumlah</th>
                    <th class="px-4 py-3 text-center w-20">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach ($historibayar as $d)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-4 py-3 font-mono text-center text-gray-500 font-semibold">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ DateToIndo($d->tanggal) }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $d->nama_bank }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $d->keterangan ?? '-' }}</td>
                        <td class="px-4 py-3 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($d->jumlah) }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('biaya.deletepembayaran', Crypt::encrypt($d->id)) }}" method="POST" class="formDelete inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 transition delete-confirm" title="Hapus Pembayaran">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($historibayar->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat pembayaran untuk transaksi ini.</td>
                    </tr>
                @endif
            </tbody>
            <tfoot class="bg-gray-50 font-bold border-t border-gray-200">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right uppercase text-xs text-gray-600">Total Terbayar:</td>
                    <td class="px-4 py-3 text-right text-emerald-700 text-sm">{{ formatAngkaDesimal($biaya->total_bayar) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="flex justify-end pt-3">
        <button type="button" onclick="closeModal()" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
            Tutup
        </button>
    </div>
</div>
