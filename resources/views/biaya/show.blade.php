<div class="space-y-5 max-w-5xl mx-auto p-1">
    <!-- Header Summary Information (Minimalist & Formal) -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-none">
        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div>
                <p class="text-[11px] font-semibold uppercase text-slate-400 tracking-wider">No. Bukti Transaksi</p>
                <h3 class="text-base font-bold font-mono text-slate-900">{{ $biaya->no_bukti }}</h3>
            </div>
            <div class="flex items-center gap-2">
                @if($biaya->jenis_transaksi == 'K')
                    <span class="px-2.5 py-1 text-xs font-semibold rounded bg-amber-50 text-amber-800 border border-amber-200">
                        Kredit (Tempo)
                    </span>
                @else
                    <span class="px-2.5 py-1 text-xs font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200">
                        Tunai
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 text-xs">
            <div>
                <span class="text-slate-400 block text-[11px] font-medium">Tanggal Transaksi</span>
                <span class="text-slate-800 font-semibold mt-0.5 block">{{ DateToIndo($biaya->tanggal) }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px] font-medium">Supplier / Rekanan</span>
                <span class="text-slate-800 font-semibold mt-0.5 block">{{ $biaya->nama_supplier ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[11px] font-medium">Jatuh Tempo</span>
                <span class="text-slate-800 font-semibold mt-0.5 block">{{ $biaya->tanggal_jatuh_tempo ? DateToIndo($biaya->tanggal_jatuh_tempo) : '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian Pos Biaya -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-none">
        <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
            <h4 class="font-semibold text-slate-800 text-xs tracking-tight">Rincian Pos Biaya</h4>
            <span class="text-xs text-slate-500">{{ count($detail) }} Item</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 border-b border-slate-200 font-medium">
                        <th class="px-4 py-2.5 w-12 text-center">No</th>
                        <th class="px-4 py-2.5">Keterangan</th>
                        <th class="px-4 py-2.5 w-44">Akun (COA)</th>
                        <th class="px-4 py-2.5 text-center w-16">Qty</th>
                        <th class="px-4 py-2.5 text-right w-28">Harga</th>
                        <th class="px-4 py-2.5 text-right w-28">Subtotal</th>
                        <th class="px-4 py-2.5 text-right w-20">Peny</th>
                        <th class="px-4 py-2.5 text-right w-32">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                    @php
                        $total_biaya = 0;
                    @endphp
                    @foreach ($detail as $d)
                        @php
                            $subtotal = $d->jumlah * $d->harga;
                            $total = $subtotal + $d->penyesuaian;
                            $total_biaya += $total;
                        @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3 text-center text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $d->keterangan ?? $d->nama_barang }}</td>
                            <td class="px-4 py-3">
                                <span class="font-mono text-slate-700 block">{{ $d->kode_akun }}</span>
                                <span class="text-[11px] text-slate-400 block truncate max-w-[160px]">{{ $d->nama_akun }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            <td class="px-4 py-3 text-right text-slate-600">{{ formatAngkaDesimal($d->harga) }}</td>
                            <td class="px-4 py-3 text-right text-slate-600">{{ formatAngkaDesimal($subtotal) }}</td>
                            <td class="px-4 py-3 text-right text-slate-500">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-slate-900">{{ formatAngkaDesimal($total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t border-slate-200 bg-slate-50 font-semibold text-slate-800">
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-right text-xs">Total Biaya</td>
                        <td class="px-4 py-3 text-right text-sm font-bold text-slate-900">{{ formatAngkaDesimal($total_biaya) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Tabel Histori Pembayaran -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-none">
        <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
            <h4 class="font-semibold text-slate-800 text-xs tracking-tight">Histori Pembayaran</h4>
            @if($biaya->sisa_bayar > 0)
            <a href="javascript:void(0)" onclick="inputPembayaranDirect('{{ Crypt::encrypt($biaya->no_bukti) }}')" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded bg-slate-800 text-white hover:bg-slate-700 transition">
                + Input Pembayaran
            </a>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 border-b border-slate-200 font-medium">
                        <th class="px-4 py-2.5 w-12 text-center">No</th>
                        <th class="px-4 py-2.5 w-36">Tanggal Bayar</th>
                        <th class="px-4 py-2.5">Bank / Kas</th>
                        <th class="px-4 py-2.5 w-28">Cabang</th>
                        <th class="px-4 py-2.5 text-right w-36">Jumlah</th>
                        <th class="px-4 py-2.5 text-center w-16">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                    @foreach ($historibayar as $d)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3 text-center text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ DateToIndo($d->tanggal) }}</td>
                            <td class="px-4 py-3 text-slate-700 font-medium">{{ $d->nama_bank }}</td>
                            <td class="px-4 py-3 text-slate-500 uppercase">{{ $d->kode_cabang ?? '-' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-slate-900">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('biaya.deletepembayaran', Crypt::encrypt($d->id)) }}" method="POST" class="formDelete inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 transition delete-confirm text-xs" title="Hapus Pembayaran">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($historibayar->isEmpty())
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-400">Belum ada catatan pembayaran.</td>
                        </tr>
                    @endif
                </tbody>
                @php
                    $total_paid = $historibayar->sum('jumlah');
                    $remaining = $total_biaya - $total_paid;
                @endphp
                <tfoot class="border-t border-slate-200 bg-slate-50 text-slate-700">
                    <tr class="border-b border-slate-200/60">
                        <td colspan="4" class="px-4 py-2.5 text-right font-medium text-slate-500">Total Terbayar</td>
                        <td class="px-4 py-2.5 text-right font-semibold text-slate-900">{{ formatAngkaDesimal($total_paid) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="px-4 py-2.5 text-right font-semibold text-slate-800">Sisa Pembayaran</td>
                        <td class="px-4 py-2.5 text-right font-bold {{ $remaining <= 0 ? 'text-emerald-700' : 'text-rose-600' }}">{{ formatAngkaDesimal($remaining) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
