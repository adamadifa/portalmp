<div class="space-y-6 max-w-5xl mx-auto p-2 pb-8">
    <!-- Header Card (Clean & Formal, No Left Accent Bar) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Informasi Transaksi</span>
                <h3 class="text-lg font-bold text-slate-800 font-mono tracking-tight">{{ $pembelian->no_bukti }}</h3>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-medium">Status PPN:</span>
                @if($pembelian->ppn == '1')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        PPN Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-600 border border-slate-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Non-PPN
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mt-6 pt-6 border-t border-slate-100 text-xs">
            <div>
                <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Tanggal Transaksi</span>
                <span class="font-bold text-slate-850 text-sm">{{ DateToIndo($pembelian->tanggal) }}</span>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Nama Supplier</span>
                <span class="font-bold text-slate-850 text-sm">{{ $pembelian->nama_supplier }}</span>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Jenis Transaksi</span>
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase {{ $pembelian->jenis_transaksi == 'K' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                        {{ $pembelian->jenis_transaksi == 'K' ? 'Kredit (Tempo)' : 'Tunai' }}
                    </span>
                </div>
            </div>
            <div>
                <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Kategori</span>
                <div>
                    @if(($pembelian->kategori_pembelian ?? 'L') == 'I')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-purple-50 text-purple-800 border border-purple-200">
                            Import
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-sky-50 text-sky-700 border border-sky-200">
                            Lokal
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @can('pembelian.harga')
        <!-- Data Barang Pembelian -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-slate-100 border-b border-slate-200">
                <h4 class="font-bold text-slate-850 text-xs uppercase tracking-wider">Detail Barang Pembelian</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-24">Kode</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Nama Barang</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Keterangan</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-center w-20">Qty</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-24">Harga</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-24">Subtotal</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-20">Peny</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">DPP</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">DPP Lain</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-24">PPN</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @php
                            $total_pembelian = 0;
                            $total_dpp_detail = 0;
                            $total_dpp_lain_detail = 0;
                            $total_ppn_detail = 0;
                            $is_import = (($pembelian->kategori_pembelian ?? 'L') == 'I');
                        @endphp
                        @foreach ($detail as $d)
                            @php
                                $subtotal = $d->jumlah * $d->harga;
                                $total = $subtotal + $d->penyesuaian;
                                // Untuk Import + PPN: hutang = DPP (subtotal * 100/111), bukan subtotal+penyesuaian
                                if ($is_import && $pembelian->ppn == '1') {
                                    $total_pembelian += $subtotal * 100 / 111;
                                } else {
                                    $total_pembelian += $total;
                                }

                                if ($pembelian->ppn == '1') {
                                    $dpp_val = $subtotal * 100 / 111;
                                    $dpp_lain_val = $dpp_val * 11 / 12;
                                    $ppn_val = $dpp_lain_val * 0.12;
                                } else {
                                    $dpp_val = $total;
                                    $dpp_lain_val = 0;
                                    $ppn_val = 0;
                                }

                                $total_dpp_detail += $dpp_val;
                                $total_dpp_lain_detail += $dpp_lain_val;
                                $total_ppn_detail += $ppn_val;

                                $bg = !empty($d->kode_cr) ? 'bg-blue-50/40 text-blue-900' : '';
                            @endphp
                            <tr class="{{ $bg }} hover:bg-slate-50/30 transition">
                                <td class="px-5 py-3.5 font-mono text-slate-500 font-medium">{{ $d->kode_barang }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-850">
                                    <div>{{ textCamelCase($d->nama_barang) }}</div>
                                    @if(!empty($d->kode_akun))
                                        <div class="text-[10px] text-slate-400 font-mono font-normal mt-0.5">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-semibold">{{ $d->kode_akun }}</span> {{ $d->nama_akun }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-slate-500">{{ textCamelCase($d->keterangan) }}</td>
                                <td class="px-5 py-3.5 text-center font-medium">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-600">{{ formatAngkaDesimal($d->harga) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-600">{{ formatAngkaDesimal($subtotal) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-500">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-indigo-700">{{ formatAngkaDesimal($dpp_val) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-violet-700">{{ formatAngkaDesimal($dpp_lain_val) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-emerald-700">{{ formatAngkaDesimal($ppn_val) }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-slate-900">{{ formatAngkaDesimal($total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-slate-200 bg-slate-50/80 font-bold text-slate-800">
                        <tr>
                            <td colspan="7" class="px-5 py-3 text-right uppercase tracking-wider text-[11px] text-slate-500">Subtotal Barang</td>
                            <td class="px-5 py-3 text-right font-bold text-indigo-800">{{ formatAngkaDesimal($total_dpp_detail) }}</td>
                            <td class="px-5 py-3 text-right font-bold text-violet-800">{{ formatAngkaDesimal($total_dpp_lain_detail) }}</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-800">{{ formatAngkaDesimal($total_ppn_detail) }}</td>
                            <td class="px-5 py-3 text-right font-black text-slate-900">{{ formatAngkaDesimal($total_pembelian) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Potongan Pembelian (Full Width with integrated Summary in Table Footer) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-rose-100/70 border-b border-rose-250">
                <h4 class="font-bold text-rose-800 text-xs uppercase tracking-wider">Potongan Pembelian & Ikhtisar Biaya</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-rose-50/10 text-slate-550 border-b border-rose-100">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Keterangan</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-center w-24">Qty</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-36">Harga</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-44">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @php
                            $total_potongan = 0;
                        @endphp
                        @foreach ($potongan as $d)
                            @php
                                $subtotal = $d->jumlah * $d->harga;
                                $total_potongan += $subtotal;
                            @endphp
                            <tr class="hover:bg-rose-50/10 transition">
                                <td class="px-5 py-3.5 font-medium text-slate-800">{{ textCamelCase($d->keterangan_penjualan) }}</td>
                                <td class="px-5 py-3.5 text-center font-medium">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                <td class="px-5 py-3.5 text-right text-slate-600">{{ formatAngkaDesimal($d->harga) }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-rose-700">{{ formatAngkaDesimal($subtotal) }}</td>
                            </tr>
                        @endforeach
                        @if ($potongan->isEmpty())
                            <tr>
                                <td colspan="4" class="px-5 py-6 text-center text-slate-400">Tidak ada potongan pembelian.</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot class="border-t border-slate-200 bg-slate-50/70 text-slate-750">
                        <tr class="border-b border-slate-200/60">
                            <td colspan="3" class="px-5 py-3 text-right font-semibold uppercase text-slate-500">Total Pembelian</td>
                            <td class="px-5 py-3 text-right font-bold text-slate-800">{{ formatAngkaDesimal($total_pembelian) }}</td>
                        </tr>
                        <tr class="border-b border-slate-200/60">
                            <td colspan="3" class="px-5 py-3 text-right font-semibold uppercase text-slate-500">Total Potongan</td>
                            <td class="px-5 py-3 text-right font-bold text-rose-700">- {{ formatAngkaDesimal($total_potongan) }}</td>
                        </tr>
                        <tr class="border-b border-slate-200/60">
                            <td colspan="3" class="px-5 py-3 text-right font-semibold uppercase text-slate-500">Peny. Jurnal Koreksi</td>
                            <td class="px-5 py-3 text-right font-bold text-amber-700">{{ formatAngkaDesimal($pembelian->penyesuaian_jk) }}</td>
                        </tr>
                        <tr class="bg-emerald-50/50 text-[#294C9A]">
                            <td colspan="3" class="px-5 py-4 text-right font-bold uppercase tracking-wider text-xs">Grand Total</td>
                            <td class="px-5 py-4 text-right font-black text-base">{{ formatAngkaDesimal($total_pembelian - $total_potongan + $pembelian->penyesuaian_jk) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @php
            // Perhitungan Rincian Akun Akuntansi Pembelian
            // Untuk Import + PPN: grand total = total_pembelian (sudah DPP) - potongan (tanpa penyesuaian_jk)
            if ($is_import && $pembelian->ppn == '1') {
                $grand_total_pmb = $total_pembelian - $total_potongan;
            } else {
                $grand_total_pmb = $total_pembelian - $total_potongan + ($pembelian->penyesuaian_jk ?? 0);
            }
            $pembelianByAkun = [];

            $itemBreakdowns = [];
            $total_dpp_items = 0;
            $total_ppn_items = 0;
            $total_hutang_items = 0;

            foreach ($detail as $d) {
                $sub = ($d->jumlah * $d->harga) + $d->penyesuaian;
                $dpp = ($pembelian->ppn == '1') ? (($d->jumlah * $d->harga) * 100 / 111) : $sub;
                $ppn = ($pembelian->ppn == '1') ? ($sub - $dpp) : 0;
                // Untuk Import + PPN: hutang per item = DPP, bukan sub
                $hutang = ($is_import && $pembelian->ppn == '1') ? $dpp : $sub;

                $kdAkun = $d->kode_akun ?? ($pembelian->kode_akun ?? '5-11101');
                $nmAkun = $d->nama_akun ?? 'Pembelian';

                $itemBreakdowns[] = [
                    'kode_barang' => $d->kode_barang,
                    'nama_barang' => $d->nama_barang,
                    'keterangan' => $d->keterangan,
                    'jumlah' => $d->jumlah,
                    'harga' => $d->harga,
                    'kode_akun' => $kdAkun,
                    'nama_akun' => $nmAkun,
                    'dpp' => $dpp,
                    'ppn' => $ppn,
                    'hutang' => $hutang,
                ];

                $total_dpp_items += $dpp;
                $total_ppn_items += $ppn;
                $total_hutang_items += $hutang;

                if (!isset($pembelianByAkun[$kdAkun])) {
                    $pembelianByAkun[$kdAkun] = [
                        'kode_akun' => $kdAkun,
                        'nama_akun' => $nmAkun,
                        'jumlah' => 0
                    ];
                }
                $pembelianByAkun[$kdAkun]['jumlah'] += $dpp;
            }

            $total_dpp_pmb = array_sum(array_column($pembelianByAkun, 'jumlah'));
            $ppn_masukan_pmb = ($pembelian->ppn == '1') ? max(0, $grand_total_pmb - $total_dpp_pmb) : 0;
            $total_debet_pmb = $total_dpp_pmb + $ppn_masukan_pmb;
            $total_kredit_pmb = $grand_total_pmb;
        @endphp

        <!-- Rincian Akun Per Item Detail Pembelian & Jurnal -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-indigo-50 border-b border-indigo-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h4 class="font-bold text-indigo-900 text-xs uppercase tracking-wider">Rincian Akun Per Item Detail Pembelian</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Rincian nilai DPP Pembelian (Beban), PPN Masukan, dan Hutang Usaha per item transaksi</p>
                </div>
                <div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white text-indigo-700 border border-indigo-200 shadow-2xs">
                        {{ $pembelian->ppn == '1' ? 'Termasuk PPN 11%' : 'Non-PPN' }}
                    </span>
                </div>
            </div>

            <!-- Tabel Rincian Per Item Detail Pembelian -->
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-12 text-center">No</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Nama Barang / Item</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-36">Akun Pembelian</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-36">DPP Pembelian (Rp)</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-32">PPN Masukan (Rp)</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-36">{{ $is_import ? 'Nilai DPP/Hutang (Rp)' : 'Hutang Usaha (Rp)' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @foreach ($itemBreakdowns as $item)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="px-5 py-3.5 text-center font-mono text-slate-500 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-850">
                                    <div>{{ textCamelCase($item['nama_barang']) }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono font-normal mt-0.5">
                                        {{ $item['kode_barang'] }} @if(!empty($item['keterangan'])) &bull; {{ textCamelCase($item['keterangan']) }} @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ $item['kode_akun'] }}
                                    </span>
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
                    <tfoot class="border-t border-slate-200 bg-slate-50/70 font-semibold text-slate-750">
                        <tr class="border-b border-slate-200/60">
                            <td colspan="3" class="px-5 py-3 text-right uppercase text-slate-500 text-xs">Subtotal Item Detail</td>
                            <td class="px-5 py-3 text-right font-bold text-slate-800">{{ formatAngkaDesimal($total_dpp_items) }}</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($total_ppn_items) }}</td>
                            <td class="px-5 py-3 text-right font-bold text-slate-900">{{ formatAngkaDesimal($total_hutang_items) }}</td>
                        </tr>
                        @if($total_potongan > 0 || !empty($pembelian->penyesuaian_jk))
                            <tr class="text-[11px] text-slate-500 border-b border-slate-200/60">
                                <td colspan="5" class="px-5 py-2 text-right">Potongan Pembelian & Penyesuaian JK:</td>
                                <td class="px-5 py-2 text-right font-bold {{ ($pembelian->penyesuaian_jk - $total_potongan) < 0 ? 'text-rose-700' : 'text-slate-800' }}">
                                    {{ formatAngkaDesimal($pembelian->penyesuaian_jk - $total_potongan) }}
                                </td>
                            </tr>
                        @endif
                    </tfoot>
                </table>
            </div>

            <!-- Ikhtisar Rekapitulasi Jurnal Akuntansi -->
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
                        <!-- Akun Pembelian / Beban (DPP) -->
                        @foreach ($pembelianByAkun as $itemAkun)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="px-5 py-3 font-mono font-bold text-indigo-700">{{ $itemAkun['kode_akun'] }}</td>
                                <td class="px-5 py-3 font-semibold text-slate-850">
                                    {{ $itemAkun['nama_akun'] }}
                                    <span class="text-[10px] text-slate-400 font-normal block">
                                        {{ $pembelian->ppn == '1' ? 'Nilai DPP (Dasar Pengenaan Pajak)' : 'Nilai Transaksi Pembelian' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-200">
                                        Debet
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right font-bold text-slate-850">{{ formatAngkaDesimal($itemAkun['jumlah']) }}</td>
                                <td class="px-5 py-3 text-right text-slate-400">-</td>
                            </tr>
                        @endforeach

                        <!-- Akun PPN Masukan (Jika ada PPN) -->
                        @if($pembelian->ppn == '1' && $ppn_masukan_pmb > 0)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="px-5 py-3 font-mono font-bold text-indigo-700">1-11501</td>
                                <td class="px-5 py-3 font-semibold text-slate-850">
                                    PPN Masukan
                                    <span class="text-[10px] text-slate-400 font-normal block">PPN Masukan (11%)</span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-200">
                                        Debet
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($ppn_masukan_pmb) }}</td>
                                <td class="px-5 py-3 text-right text-slate-400">-</td>
                            </tr>
                        @endif

                        <!-- Akun Hutang Usaha / Kas (Kredit) - Dikecualikan jika kategori Import -->
                        @if(!$is_import)
                            <tr class="hover:bg-slate-50/40 transition">
                                <td class="px-5 py-3 font-mono font-bold text-indigo-700">
                                    {{ $pembelian->jenis_transaksi == 'K' ? '2-11101' : '1-11101' }}
                                </td>
                                <td class="px-5 py-3 font-semibold text-slate-850">
                                    {{ $pembelian->jenis_transaksi == 'K' ? 'Hutang Usaha' : 'Kas / Bank' }}
                                    <span class="text-[10px] text-slate-400 font-normal block">
                                        {{ $pembelian->jenis_transaksi == 'K' ? 'Kewajiban Hutang kepada ' . ($pembelian->nama_supplier ?? 'Supplier') : 'Pembelian Tunai' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-50 text-amber-700 border border-amber-200">
                                        Kredit
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right text-slate-400">-</td>
                                <td class="px-5 py-3 text-right font-bold text-indigo-900">{{ formatAngkaDesimal($total_kredit_pmb) }}</td>
                            </tr>
                        @else
                            <tr class="bg-violet-50/50">
                                <td colspan="5" class="px-5 py-3 text-violet-800 text-[11px]">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 shrink-0 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span><strong>Pembelian Kategori Import:</strong> Lawan akun Hutang Usaha (2-11101) dikecualikan. Lawan akun dicatat manual melalui form <strong>Jurnal Umum</strong> di bawah.</span>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot class="border-t border-slate-200 bg-slate-50 font-bold text-slate-800">
                        <tr>
                            <td colspan="3" class="px-5 py-3.5 text-right uppercase tracking-wider text-xs">Total Jurnal</td>
                            <td class="px-5 py-3.5 text-right font-black text-slate-900">{{ formatAngkaDesimal($total_debet_pmb) }}</td>
                            <td class="px-5 py-3.5 text-right font-black text-slate-900">{{ formatAngkaDesimal($is_import ? 0 : $total_kredit_pmb) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Histori Pembayaran -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 bg-emerald-100/70 border-b border-emerald-250 flex justify-between items-center">
                <h4 class="font-bold text-emerald-800 text-xs uppercase tracking-wider">Histori Pembayaran</h4>
                @can('pembelian.create')
                <button type="button" onclick="toggleFormPembayaran()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Input Pembayaran
                </button>
                @endcan
            </div>
            @can('pembelian.create')
            @php
                $total_paid = $historibayar->sum('jumlah');
                // Untuk Import + PPN: hutang = DPP (tanpa penyesuaian_jk)
                if ($is_import && $pembelian->ppn == '1') {
                    $grand_total = $total_pembelian - $total_potongan;
                } else {
                    $grand_total = $total_pembelian - $total_potongan + $pembelian->penyesuaian_jk;
                }
                $unpaid_balance = max(0, $grand_total - $total_paid);
            @endphp
            <div id="formInputPembayaran" class="hidden p-5 bg-slate-50/50 border-b border-slate-100">
                <form id="formStorePembayaran" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Tanggal Bayar</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full text-xs border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white shadow-sm" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Pilih Bank</label>
                            <select name="kode_bank" id="kode_bank_pembayaran" required class="w-full text-xs border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white shadow-sm">
                                <option value="">-- Pilih Bank --</option>
                                @foreach($banks as $b)
                                    <option value="{{ $b->kode_bank }}">{{ $b->kode_bank }} - {{ $b->nama_bank }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5">Jumlah Bayar</label>
                            <input type="number" step="0.01" min="0.01" name="jumlah" value="{{ $unpaid_balance }}" required class="w-full text-xs border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white shadow-sm font-bold text-slate-800" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="toggleFormPembayaran()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition shadow-sm">Simpan Pembayaran</button>
                    </div>
                </form>
            </div>
            @endcan
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-emerald-50/10 text-slate-550 border-b border-emerald-100">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-16">No</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-40">Tanggal Bayar</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Bank</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-36">Cabang</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-44">Jumlah</th>
                            @can('pembelian.delete')
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
                                <td class="px-5 py-3.5 uppercase font-medium text-slate-500">{{ $d->kode_cabang }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                @can('pembelian.delete')
                                <td class="px-5 py-3.5 text-center">
                                    <button type="button" onclick="deletePembayaran({{ $d->id }})" class="text-rose-600 hover:text-rose-800 transition" title="Hapus Pembayaran">
                                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                        @if ($historibayar->isEmpty())
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-slate-400">Belum ada catatan pembayaran.</td>
                            </tr>
                        @endif
                    </tbody>
                    @php
                        $total_paid = $historibayar->sum('jumlah');
                        // Konsisten dengan kalkulasi di atas
                        if ($is_import && $pembelian->ppn == '1') {
                            $grand_total = $total_pembelian - $total_potongan;
                        } else {
                            $grand_total = $total_pembelian - $total_potongan + $pembelian->penyesuaian_jk;
                        }
                        $remaining = $grand_total - $total_paid;
                    @endphp
                    <tfoot class="border-t border-slate-200 bg-slate-50/70">
                        <tr class="border-b border-slate-200/60">
                            <td colspan="{{ auth()->user()->can('pembelian.delete') ? 4 : 3 }}" class="px-5 py-3 text-right font-semibold uppercase text-slate-500 text-xs">Total Pembayaran</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-700">{{ formatAngkaDesimal($total_paid) }}</td>
                            @can('pembelian.delete')<td></td>@endcan
                        </tr>
                        <tr class="{{ $remaining <= 0 ? 'bg-emerald-50/50 text-emerald-800' : 'bg-rose-50/50 text-rose-800' }}">
                            <td colspan="{{ auth()->user()->can('pembelian.delete') ? 4 : 3 }}" class="px-5 py-3 text-right font-bold uppercase text-xs tracking-wider">Sisa Pembayaran</td>
                            <td class="px-5 py-3 text-right font-black text-base {{ $remaining <= 0 ? 'text-emerald-700' : 'text-rose-700' }}">{{ formatAngkaDesimal($remaining) }}</td>
                            @can('pembelian.delete')<td></td>@endcan
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if($is_import)
            <!-- Section: Jurnal Umum (Khusus Import) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-3 bg-[#EEF2FF] border-b border-[#C7D2FE] flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-[#4F46E5] text-white text-xs font-bold shadow-xs">JU</span>
                        <div>
                            <h4 class="font-bold text-[#312E81] text-xs uppercase tracking-wider">Jurnal Umum (Import)</h4>
                            <p class="text-[10px] text-[#4338CA]">Pencatatan manual lawan akun untuk transaksi pembelian Import</p>
                        </div>
                    </div>
                    @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))
                    <button type="button" onclick="toggleFormJurnalUmum()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-[#4F46E5] hover:bg-[#4338CA] text-white transition shadow-sm cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Input Jurnal Umum
                    </button>
                    @endif
                </div>

                @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))
                <div id="formInputJurnalUmum" class="hidden p-5 bg-slate-50/70 border-b border-slate-200">
                    <form id="formStoreJurnalUmum" class="space-y-4">
                        @csrf
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                            <span class="text-xs font-bold text-slate-700">Tambah Baris Jurnal</span>
                            <button type="button" onclick="tambahBarisJurnal()" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-white border border-[#4F46E5] text-[#4F46E5] hover:bg-indigo-50 transition">
                                + Tambah Akun
                            </button>
                        </div>
                        <div id="containerBarisJurnal" class="space-y-3">
                            <div class="baris-jurnal grid grid-cols-1 md:grid-cols-12 gap-2 p-3 bg-white rounded-xl border border-slate-200 items-end shadow-2xs">
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Tanggal</label>
                                    <input type="date" name="tanggal_item[]" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Kode / Nama Akun</label>
                                    <select name="kode_akun_item[]" class="select2-akun w-full text-xs rounded-lg border-slate-200" required>
                                        <option value="">-- Pilih Akun --</option>
                                        @foreach($coa ?? [] as $c)
                                            <option value="{{ $c->kode_akun }}">{{ $c->kode_akun }} - {{ $c->nama_akun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Posisi</label>
                                    <select name="debet_kredit_item[]" class="w-full text-xs rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="K">Kredit</option>
                                        <option value="D">Debet</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jumlah (Rp)</label>
                                    <input type="text" name="jumlah_item[]" class="input-rupiah w-full text-xs text-right rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 font-semibold" placeholder="0" required>
                                </div>
                                <div class="md:col-span-2 flex items-center gap-1">
                                    <input type="text" name="keterangan_item[]" value="Import - {{ $pembelian->no_bukti }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Keterangan">
                                    <button type="button" onclick="hapusBarisJurnal(this)" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" onclick="toggleFormJurnalUmum()" class="px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</button>
                            <button type="submit" class="px-4 py-1.5 text-xs font-semibold bg-[#4F46E5] hover:bg-[#4338CA] text-white rounded-xl transition shadow-sm">Simpan Jurnal</button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Tabel Data Jurnal Umum Terkait -->
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="bg-indigo-50/70 text-indigo-950 border-b border-indigo-100 font-semibold uppercase tracking-wider">
                                <th class="px-5 py-3 w-12 text-center">No</th>
                                <th class="px-5 py-3 w-28">No. Bukti JU</th>
                                <th class="px-5 py-3 w-24">Tanggal</th>
                                <th class="px-5 py-3 w-32">Kode Akun</th>
                                <th class="px-5 py-3">Nama Akun</th>
                                <th class="px-5 py-3">Keterangan</th>
                                <th class="px-5 py-3 w-20 text-center">Posisi</th>
                                <th class="px-5 py-3 text-right w-36">Jumlah (Rp)</th>
                                @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))<th class="px-5 py-3 text-center w-16">Aksi</th>@endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                            @forelse($jurnalumum ?? [] as $ju)
                                <tr class="hover:bg-slate-50/40 transition">
                                    <td class="px-5 py-3 text-center font-mono text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-mono font-bold text-[#4F46E5]">{{ $ju->kode_ju }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ DateToIndo($ju->tanggal) }}</td>
                                    <td class="px-5 py-3 font-mono font-semibold text-slate-800">{{ $ju->kode_akun }}</td>
                                    <td class="px-5 py-3 font-semibold text-slate-850">{{ $ju->nama_akun ?? '-' }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $ju->keterangan }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $ju->debet_kredit == 'D' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                            {{ $ju->debet_kredit == 'D' ? 'Debet' : 'Kredit' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-right font-bold {{ $ju->debet_kredit == 'D' ? 'text-blue-700' : 'text-amber-700' }}">
                                        {{ formatAngkaDesimal($ju->jumlah) }}
                                    </td>
                                    @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))
                                    <td class="px-5 py-3 text-center">
                                        <button type="button" onclick="deleteJurnalUmum('{{ $ju->kode_ju }}')" class="p-1 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus Jurnal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ (auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create')) ? 9 : 8 }}" class="px-5 py-6 text-center text-slate-400 italic">
                                        Belum ada data Jurnal Umum untuk pembelian import ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @else
        <!-- Non-Harga View (Simple Detail) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 bg-slate-50 border-b border-slate-100">
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Data Barang Pembelian</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead>
                        <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider w-24">Kode</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Nama Barang</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider">Keterangan</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-center w-24">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @foreach ($detail as $d)
                            @php
                                $bg = !empty($d->kode_cr) ? 'bg-blue-50/40 text-blue-900' : '';
                            @endphp
                            <tr class="{{ $bg }} hover:bg-slate-50/30 transition">
                                <td class="px-5 py-3.5 font-mono text-slate-500 font-medium">{{ $d->kode_barang }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-800">{{ textCamelCase($d->nama_barang) }}</td>
                                <td class="px-5 py-3.5 text-slate-500">{{ textCamelCase($d->keterangan) }}</td>
                                <td class="px-5 py-3.5 text-center font-bold text-slate-900">{{ formatAngkaDesimal($d->jumlah) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
</div>

<script>
    function toggleFormPembayaran() {
        $('#formInputPembayaran').toggleClass('hidden');
        if (!$('#formInputPembayaran').hasClass('hidden')) {
            $('#kode_bank_pembayaran').select2({
                dropdownParent: $('#modalDialog'),
                width: '100%'
            });
        }
    }

    $('#formStorePembayaran').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: '{{ route("pembelian.storepembayaran", $crypted_no_bukti) }}',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    
                    // Reload modal content dynamically
                    $("#modalBody").load('/pembelian/{{ $crypted_no_bukti }}/show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                    submitBtn.prop('disabled', false).text('Simpan Pembayaran');
                }
            },
            error: function(xhr) {
                var msg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg
                });
                submitBtn.prop('disabled', false).text('Simpan Pembayaran');
            }
        });
    });

    function deletePembayaran(id) {
        Swal.fire({
            title: 'Hapus Pembayaran?',
            text: "Histori pembayaran ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("pembelian.destroypembayaran", $crypted_no_bukti) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#modalBody").load('/pembelian/{{ $crypted_no_bukti }}/show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Terjadi kesalahan pada server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: msg
                        });
                    }
                });
            }
        });
    }

    function initSelect2Akun(element) {
        element.select2({
            dropdownParent: $('#modalDialog'),
            width: '100%'
        });
    }

    function toggleFormJurnalUmum() {
        $('#formInputJurnalUmum').toggleClass('hidden');
        if (!$('#formInputJurnalUmum').hasClass('hidden')) {
            initSelect2Akun($('.select2-akun'));
        }
    }

    function tambahBarisJurnal() {
        var rowHtml = `
            <div class="baris-jurnal grid grid-cols-1 md:grid-cols-12 gap-2 p-3 bg-white rounded-xl border border-slate-200 items-end">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Tanggal</label>
                    <input type="date" name="tanggal_item[]" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-violet-500 focus:ring-violet-500" required>
                </div>
                <div class="md:col-span-4">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Kode / Nama Akun</label>
                    <select name="kode_akun_item[]" class="select2-akun w-full text-xs rounded-lg border-slate-200" required>
                        <option value="">-- Pilih Akun --</option>
                        @foreach($coa ?? [] as $c)
                            <option value="{{ $c->kode_akun }}">{{ $c->kode_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Posisi</label>
                    <select name="debet_kredit_item[]" class="w-full text-xs rounded-lg border-slate-200 focus:border-violet-500 focus:ring-violet-500" required>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jumlah (Rp)</label>
                    <input type="text" name="jumlah_item[]" class="input-rupiah w-full text-xs text-right rounded-lg border-slate-200 focus:border-violet-500 focus:ring-violet-500" placeholder="0" required>
                </div>
                <div class="md:col-span-2 flex items-center gap-1">
                    <input type="text" name="keterangan_item[]" value="Import - {{ $pembelian->no_bukti }}" class="w-full text-xs rounded-lg border-slate-200 focus:border-violet-500 focus:ring-violet-500" placeholder="Keterangan">
                    <button type="button" onclick="hapusBarisJurnal(this)" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>`;
        var newRow = $(rowHtml);
        $('#containerBarisJurnal').append(newRow);
        initSelect2Akun(newRow.find('.select2-akun'));
    }

    function hapusBarisJurnal(btn) {
        if ($('#containerBarisJurnal .baris-jurnal').length > 1) {
            $(btn).closest('.baris-jurnal').remove();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Minimal harus ada 1 baris akun jurnal.'
            });
        }
    }

    $('#formStoreJurnalUmum').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: '{{ route("pembelian.storejurnalumum", $crypted_no_bukti) }}',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#modalBody").load('/pembelian/{{ $crypted_no_bukti }}/show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                    submitBtn.prop('disabled', false).text('Simpan Jurnal');
                }
            },
            error: function(xhr) {
                var msg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg
                });
                submitBtn.prop('disabled', false).text('Simpan Jurnal');
            }
        });
    });

    function deleteJurnalUmum(kode_ju) {
        Swal.fire({
            title: 'Hapus Jurnal?',
            text: 'Jurnal ' + kode_ju + ' ini akan dihapus dari Jurnal Umum!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("pembelian.destroyjurnalumum", $crypted_no_bukti) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        kode_ju: kode_ju
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#modalBody").load('/pembelian/{{ $crypted_no_bukti }}/show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Terjadi kesalahan pada server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: msg
                        });
                    }
                });
            }
        });
    }
</script>
