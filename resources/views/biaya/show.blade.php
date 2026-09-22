<div class="space-y-6 max-w-5xl mx-auto p-2 pb-8">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Informasi Transaksi Biaya</span>
                <h3 class="text-lg font-bold text-slate-800 font-mono tracking-tight">{{ $biaya->no_bukti }}</h3>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-medium">Status PPN:</span>
                @if($biaya->ppn == '1')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>PPN Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-600 border border-slate-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>Non-PPN
                    </span>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6 pt-6 border-t border-slate-100 text-xs">
            <div>
                <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Tanggal Transaksi</span>
                <span class="font-bold text-slate-850 text-sm">{{ DateToIndo($biaya->tanggal) }}</span>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Supplier / Rekanan</span>
                <span class="font-bold text-slate-850 text-sm">{{ $biaya->nama_supplier ?? '-' }}</span>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Jatuh Tempo</span>
                <span class="font-bold text-slate-850 text-sm">{{ $biaya->tanggal_jatuh_tempo ? DateToIndo($biaya->tanggal_jatuh_tempo) : '-' }}</span>
            </div>
        </div>
    </div>

    @can('biaya.harga')
        <!-- Detail Pos Biaya -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-slate-100 border-b border-slate-200">
                <h4 class="font-bold text-slate-850 text-xs uppercase tracking-wider">Rincian Pos Biaya</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-10 text-center">No</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Keterangan</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-36">Akun (COA)</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-center w-16">Qty</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">Harga</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">Subtotal</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-20">Peny</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">DPP</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">PPN</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @php
                            $total_biaya = 0;
                            $total_dpp_detail = 0;
                            $total_ppn_detail = 0;
                        @endphp
                        @foreach ($detail as $d)
                            @php
                                $subtotal = $d->jumlah * $d->harga;
                                $total = $subtotal + $d->penyesuaian;
                                $total_biaya += $total;
                                if ($biaya->ppn == '1') {
                                    $dpp_val  = $subtotal * 100 / 111;
                                    $dpp_lain = $dpp_val * 11 / 12;
                                    $ppn_val  = $dpp_lain * 0.12;
                                } else {
                                    $dpp_val = $total;
                                    $ppn_val = 0;
                                }
                                $total_dpp_detail += $dpp_val;
                                $total_ppn_detail += $ppn_val;
                            @endphp
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="px-5 py-3.5 text-center text-slate-400">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-850">{{ textCamelCase($d->keterangan ?? $d->nama_barang ?? '-') }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">{{ $d->kode_akun }}</span>
                                    <span class="block text-[10px] text-slate-400 mt-0.5">{{ $d->nama_akun }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-center font-medium">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-600">{{ formatAngkaDesimal($d->harga) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-600">{{ formatAngkaDesimal($subtotal) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-500">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-indigo-700">{{ formatAngkaDesimal($dpp_val) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-emerald-700">{{ $ppn_val > 0 ? formatAngkaDesimal($ppn_val) : '-' }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-slate-900">{{ formatAngkaDesimal($total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-slate-200 bg-slate-50/80 font-bold text-slate-800">
                        <tr>
                            <td colspan="7" class="px-5 py-3 text-right uppercase tracking-wider text-[11px] text-slate-500">Subtotal</td>
                            <td class="px-5 py-3 text-right font-bold text-indigo-800">{{ formatAngkaDesimal($total_dpp_detail) }}</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-800">{{ $total_ppn_detail > 0 ? formatAngkaDesimal($total_ppn_detail) : '-' }}</td>
                            <td class="px-5 py-3 text-right font-black text-slate-900">{{ formatAngkaDesimal($total_biaya) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @php
            $biayaByAkun      = [];
            $itemBreakdowns   = [];
            $total_dpp_items  = 0;
            $total_ppn_items  = 0;
            $total_hutang_items = 0;
            foreach ($detail as $d) {
                $sub    = ($d->jumlah * $d->harga) + $d->penyesuaian;
                $dpp    = ($biaya->ppn == '1') ? (($d->jumlah * $d->harga) * 100 / 111) : $sub;
                $ppn    = ($biaya->ppn == '1') ? ($sub - $dpp) : 0;
                $hutang = $sub;
                $kdAkun = $d->kode_akun ?? '6-11101';
                $nmAkun = $d->nama_akun ?? 'Biaya';
                $itemBreakdowns[] = [
                    'keterangan' => $d->keterangan ?? $d->nama_barang ?? '-',
                    'jumlah'     => $d->jumlah,
                    'harga'      => $d->harga,
                    'kode_akun'  => $kdAkun,
                    'nama_akun'  => $nmAkun,
                    'dpp'        => $dpp,
                    'ppn'        => $ppn,
                    'hutang'     => $hutang,
                ];
                $total_dpp_items    += $dpp;
                $total_ppn_items    += $ppn;
                $total_hutang_items += $hutang;
                if (!isset($biayaByAkun[$kdAkun])) {
                    $biayaByAkun[$kdAkun] = ['kode_akun' => $kdAkun, 'nama_akun' => $nmAkun, 'jumlah' => 0];
                }
                $biayaByAkun[$kdAkun]['jumlah'] += $dpp;
            }
            $total_dpp_biaya    = array_sum(array_column($biayaByAkun, 'jumlah'));
            $ppn_masukan_biaya  = ($biaya->ppn == '1') ? max(0, $total_biaya - $total_dpp_biaya) : 0;
            $total_debet_biaya  = $total_dpp_biaya + $ppn_masukan_biaya;
            $total_kredit_biaya = $total_biaya;
        @endphp

        <!-- Rincian Akun Per Item & Jurnal -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-indigo-50 border-b border-indigo-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h4 class="font-bold text-indigo-900 text-xs uppercase tracking-wider">Rincian Akun Per Item Biaya</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Rincian nilai DPP (Beban), PPN Masukan, dan Hutang Usaha per item transaksi</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white text-indigo-700 border border-indigo-200 shadow-2xs">
                    {{ $biaya->ppn == '1' ? 'Termasuk PPN 11%' : 'Non-PPN' }}
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-12 text-center">No</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Keterangan / Item</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-36">Akun Beban</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-36">DPP Biaya (Rp)</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-32">PPN Masukan (Rp)</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-36">Hutang / Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @foreach ($itemBreakdowns as $item)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="px-5 py-3.5 text-center font-mono text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-850">{{ textCamelCase($item['keterangan']) }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">{{ $item['kode_akun'] }}</span>
                                    <span class="block text-[10px] text-slate-500 mt-0.5">{{ $item['nama_akun'] }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-800">{{ formatAngkaDesimal($item['dpp']) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium {{ $item['ppn'] > 0 ? 'text-emerald-700' : 'text-slate-400' }}">
                                    {{ $item['ppn'] > 0 ? formatAngkaDesimal($item['ppn']) : '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-right font-bold text-slate-900">{{ formatAngkaDesimal($item['hutang']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-slate-200 bg-slate-50/70 font-semibold">
                        <tr>
                            <td colspan="3" class="px-5 py-3 text-right uppercase text-slate-500 text-xs">Subtotal</td>
                            <td class="px-5 py-3 text-right font-bold text-slate-800">{{ formatAngkaDesimal($total_dpp_items) }}</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-700">{{ $total_ppn_items > 0 ? formatAngkaDesimal($total_ppn_items) : '-' }}</td>
                            <td class="px-5 py-3 text-right font-bold text-slate-900">{{ formatAngkaDesimal($total_hutang_items) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Rekapitulasi Jurnal Akuntansi -->
            <div class="px-5 py-3 bg-slate-100/70 border-t border-b border-slate-200">
                <h5 class="font-bold text-slate-700 text-[11px] uppercase tracking-wider">Rekapitulasi Jurnal Akuntansi</h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-white text-slate-500 border-b border-slate-200">
                            <th class="px-5 py-2.5 font-semibold uppercase tracking-wider w-36">Kode Akun</th>
                            <th class="px-5 py-2.5 font-semibold uppercase tracking-wider">Nama Akun</th>
                            <th class="px-5 py-2.5 font-semibold uppercase tracking-wider w-24">Posisi</th>
                            <th class="px-5 py-2.5 font-semibold uppercase tracking-wider text-right w-44">Debet (Rp)</th>
                            <th class="px-5 py-2.5 font-semibold uppercase tracking-wider text-right w-44">Kredit (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @foreach ($biayaByAkun as $itemAkun)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="px-5 py-3 font-mono font-bold text-indigo-700">{{ $itemAkun['kode_akun'] }}</td>
                                <td class="px-5 py-3 font-semibold text-slate-850">
                                    {{ $itemAkun['nama_akun'] }}
                                    <span class="text-[10px] text-slate-400 font-normal block">{{ $biaya->ppn == '1' ? 'Nilai DPP (Dasar Pengenaan Pajak)' : 'Nilai Transaksi Biaya' }}</span>
                                </td>
                                <td class="px-5 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-200">Debet</span></td>
                                <td class="px-5 py-3 text-right font-bold text-slate-850">{{ formatAngkaDesimal($itemAkun['jumlah']) }}</td>
                                <td class="px-5 py-3 text-right text-slate-400">-</td>
                            </tr>
                        @endforeach
                        @if($biaya->ppn == '1' && $ppn_masukan_biaya > 0)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="px-5 py-3 font-mono font-bold text-indigo-700">1-11501</td>
                                <td class="px-5 py-3 font-semibold text-slate-850">
                                    PPN Masukan
                                    <span class="text-[10px] text-slate-400 font-normal block">PPN Masukan (11%)</span>
                                </td>
                                <td class="px-5 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-200">Debet</span></td>
                                <td class="px-5 py-3 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($ppn_masukan_biaya) }}</td>
                                <td class="px-5 py-3 text-right text-slate-400">-</td>
                            </tr>
                        @endif
                        <tr class="hover:bg-slate-50/40 transition">
                            <td class="px-5 py-3 font-mono font-bold text-indigo-700">{{ $biaya->tanggal_jatuh_tempo ? '2-11101' : '1-11101' }}</td>
                            <td class="px-5 py-3 font-semibold text-slate-850">
                                {{ $biaya->tanggal_jatuh_tempo ? 'Hutang Usaha' : 'Kas / Bank' }}
                                <span class="text-[10px] text-slate-400 font-normal block">{{ $biaya->tanggal_jatuh_tempo ? 'Kewajiban Hutang kepada ' . ($biaya->nama_supplier ?? 'Rekanan') : 'Pembayaran Biaya Tunai' }}</span>
                            </td>
                            <td class="px-5 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-50 text-amber-700 border border-amber-200">Kredit</span></td>
                            <td class="px-5 py-3 text-right text-slate-400">-</td>
                            <td class="px-5 py-3 text-right font-bold text-indigo-900">{{ formatAngkaDesimal($total_kredit_biaya) }}</td>
                        </tr>
                    </tbody>
                    <tfoot class="border-t border-slate-200 bg-slate-50 font-bold text-slate-800">
                        <tr>
                            <td colspan="3" class="px-5 py-3.5 text-right uppercase tracking-wider text-xs">Total Jurnal</td>
                            <td class="px-5 py-3.5 text-right font-black text-slate-900">{{ formatAngkaDesimal($total_debet_biaya) }}</td>
                            <td class="px-5 py-3.5 text-right font-black text-slate-900">{{ formatAngkaDesimal($total_kredit_biaya) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Histori Pembayaran -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 bg-emerald-100/70 border-b border-emerald-250 flex justify-between items-center">
                <h4 class="font-bold text-emerald-800 text-xs uppercase tracking-wider">Histori Pembayaran</h4>
                @if($biaya->sisa_bayar > 0)
                    <a href="javascript:void(0)" onclick="inputPembayaranDirect('{{ Crypt::encrypt($biaya->no_bukti) }}')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Input Pembayaran
                    </a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-emerald-50/10 text-slate-550 border-b border-emerald-100">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-16">No</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-40">Tanggal Bayar</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Bank / Kas</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-36">Cabang</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-44">Jumlah</th>
                            @can('biaya.delete')
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-center w-24">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @foreach ($historibayar as $d)
                            <tr class="hover:bg-emerald-50/10 transition">
                                <td class="px-5 py-3.5 font-mono text-slate-500 font-semibold">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3.5 font-medium text-slate-800">{{ DateToIndo($d->tanggal) }}</td>
                                <td class="px-5 py-3.5 text-slate-700">{{ $d->nama_bank }}</td>
                                <td class="px-5 py-3.5 uppercase font-medium text-slate-500">{{ $d->kode_cabang ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                @can('biaya.delete')
                                <td class="px-5 py-3.5 text-center">
                                    <form action="{{ route('biaya.deletepembayaran', Crypt::encrypt($d->id)) }}" method="POST" class="formDelete inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 transition delete-confirm" title="Hapus Pembayaran">
                                            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                        @if ($historibayar->isEmpty())
                            <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">Belum ada catatan pembayaran.</td></tr>
                        @endif
                    </tbody>
                    @php
                        $total_paid = $historibayar->sum('jumlah');
                        $remaining  = $total_biaya - $total_paid;
                    @endphp
                    <tfoot class="border-t border-slate-200 bg-slate-50/70">
                        <tr class="border-b border-slate-200/60">
                            <td colspan="{{ auth()->user()->can('biaya.delete') ? 4 : 3 }}" class="px-5 py-3 text-right font-semibold uppercase text-slate-500 text-xs">Total Pembayaran</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($total_paid) }}</td>
                            @can('biaya.delete')<td></td>@endcan
                        </tr>
                        <tr class="{{ $remaining <= 0 ? 'bg-emerald-50/50 text-emerald-800' : 'bg-rose-50/50 text-rose-800' }}">
                            <td colspan="{{ auth()->user()->can('biaya.delete') ? 4 : 3 }}" class="px-5 py-3 text-right font-bold uppercase text-xs tracking-wider">Sisa Pembayaran</td>
                            <td class="px-5 py-3 text-right font-black text-base {{ $remaining <= 0 ? 'text-emerald-700' : 'text-rose-700' }}">{{ formatAngkaDesimal($remaining) }}</td>
                            @can('biaya.delete')<td></td>@endcan
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @else
        <!-- Non-Harga View -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100">
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Rincian Pos Biaya</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-12 text-center">No</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Keterangan</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-36">Akun</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-center w-24">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @foreach ($detail as $d)
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="px-5 py-3.5 text-center text-slate-400">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-800">{{ textCamelCase($d->keterangan ?? $d->nama_barang ?? '-') }}</td>
                                <td class="px-5 py-3.5 font-mono text-slate-600 text-[11px]">{{ $d->kode_akun }}</td>
                                <td class="px-5 py-3.5 text-center font-bold text-slate-900">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
</div>
