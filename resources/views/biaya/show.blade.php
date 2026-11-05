<x-app-layout>
    <x-slot name="header">Detail Biaya Operasional</x-slot>
    <x-slot name="headerTitle">Detail Biaya Operasional</x-slot>
    <x-slot name="headerDescription">Biaya #{{ $biaya->no_bukti }} &bull; {{ $biaya->nama_supplier ?? '-' }}</x-slot>

    @php
        $total_biaya = 0;
        $total_dpp_detail = 0;
        $total_ppn_detail = 0;

        foreach ($detail as $d) {
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
        }

        $total_paid = $historibayar->sum('jumlah');
        $sisa_hutang = max(0, $total_biaya - $total_paid);
        $is_lunas = (round($total_biaya, 2) <= round($total_paid, 2));

        $crypted_no_bukti = Crypt::encrypt($biaya->no_bukti);
    @endphp

    <div class="space-y-6">

        <!-- Top Navigation & Action Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex flex-wrap items-center gap-2.5">
                <a 
                    href="{{ route('biaya.index') }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs transition cursor-pointer"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4 text-slate-500"></i>
                    <span>Kembali ke Daftar</span>
                </a>

                <!-- Status Badges -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <!-- Tunai / Kredit -->
                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs {{ $biaya->jenis_transaksi == 'T' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60' : 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60' }}">
                        <i data-lucide="{{ $biaya->jenis_transaksi == 'T' ? 'wallet' : 'calendar-clock' }}" class="w-3.5 h-3.5"></i>
                        <span>{{ $biaya->jenis_transaksi == 'T' ? 'TUNAI' : 'KREDIT' }}</span>
                    </span>

                    <!-- PPN Status -->
                    @if($biaya->ppn == '1')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            <span>PPN AKTIF</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200/60">
                            <span>NON-PPN</span>
                        </span>
                    @endif

                    <!-- Status Pelunasan -->
                    @if ($is_lunas)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                            <span>LUNAS</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200/60">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            <span>BELUM LUNAS</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons Group -->
            <div class="flex items-center gap-2">
                @can('biaya.edit')
                <a 
                    href="{{ route('biaya.edit', $crypted_no_bukti) }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                    title="Edit Data Biaya"
                >
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                    <span>Edit Biaya</span>
                </a>
                @endcan

                <div class="hidden sm:flex items-center gap-1.5 pl-2 border-l border-slate-200 dark:border-slate-800">
                    <span class="font-mono text-xs font-bold px-3 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-[#162a5b] dark:text-blue-400 border border-slate-200/60 dark:border-slate-700">
                        {{ $biaya->no_bukti }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 3 High-Level Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-5 items-stretch">
            
            <!-- Card 1: Parameter Biaya -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-[#162a5b] text-white flex items-center justify-center shadow-xs shrink-0">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Parameter Biaya</h4>
                            <p class="text-[11px] text-slate-400">Identitas nomor bukti dan tanggal</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">No. Bukti</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white text-sm">{{ $biaya->no_bukti }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Tanggal Transaksi</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ formatIndo($biaya->tanggal) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Masa / Tahun Pajak</span>
                            <span class="font-bold text-[#162a5b] dark:text-blue-400">
                                {{ $biaya->bulan_pajak ? str_pad($biaya->bulan_pajak, 2, '0', STR_PAD_LEFT) : date('m', strtotime($biaya->tanggal)) }} / {{ $biaya->tahun_pajak ?: date('Y', strtotime($biaya->tanggal)) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Keterangan</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300 max-w-[180px] truncate" title="{{ $biaya->keterangan ?? '-' }}">
                                {{ $biaya->keterangan ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Supplier / Rekanan & Transaksi -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-xs shrink-0">
                            <i data-lucide="truck" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Rekanan & Transaksi</h4>
                            <p class="text-[11px] text-slate-400">Pemasok/rekanan dan metode transaksi</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Nama Supplier / Rekanan</span>
                            <span class="font-bold text-slate-900 dark:text-white text-right max-w-[180px] truncate" title="{{ $biaya->nama_supplier ?? '-' }}">
                                {{ $biaya->nama_supplier ?? '-' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Jenis Transaksi</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">
                                {{ $biaya->jenis_transaksi == 'T' ? 'Tunai (Cash)' : 'Kredit (Tempo)' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Jatuh Tempo</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">
                                {{ $biaya->tanggal_jatuh_tempo ? formatIndo($biaya->tanggal_jatuh_tempo) : '-' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Status PPN</span>
                            <span class="font-semibold {{ $biaya->ppn == '1' ? 'text-emerald-600' : 'text-slate-500' }}">
                                {{ $biaya->ppn == '1' ? 'Termasuk PPN' : 'Non-PPN' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Ikhtisar Keuangan -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs shrink-0">
                            <i data-lucide="badge-dollar-sign" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Ikhtisar Keuangan</h4>
                            <p class="text-[11px] text-slate-400">Total nilai biaya & status bayar</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Total Nilai Biaya</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white text-sm">
                                Rp {{ formatAngkaDesimal($total_biaya) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Sudah Dibayar</span>
                            <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                Rp {{ formatAngkaDesimal($total_paid) }}
                            </span>
                        </div>
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <span class="text-slate-700 dark:text-slate-300 font-bold">Sisa Tagihan</span>
                            <span class="font-mono text-sm font-black {{ $sisa_hutang <= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                Rp {{ formatAngkaDesimal($sisa_hutang) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('biaya.harga')
            <!-- Card: Detail Pos Biaya -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                <div class="px-6 py-4 bg-[#162a5b] text-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                            <i data-lucide="layers" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-white">Rincian Pos Biaya</h4>
                            <p class="text-[11px] text-blue-200/80">Daftar item biaya, alokasi akun COA, dan kalkulasi DPP/PPN</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-white/20 text-white">
                        {{ $detail->count() }} Item
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="py-2.5 px-4 w-12 text-center whitespace-nowrap">No</th>
                                <th class="py-2.5 px-4 min-w-[200px]">Keterangan</th>
                                <th class="py-2.5 px-4 min-w-[180px]">Akun (COA)</th>
                                <th class="py-2.5 px-4 text-center w-20 whitespace-nowrap">Qty</th>
                                <th class="py-2.5 px-4 text-right w-28 whitespace-nowrap">Harga</th>
                                <th class="py-2.5 px-4 text-right w-28 whitespace-nowrap">Subtotal</th>
                                <th class="py-2.5 px-4 text-right w-24 whitespace-nowrap">Peny</th>
                                <th class="py-2.5 px-4 text-right w-28 whitespace-nowrap">DPP</th>
                                <th class="py-2.5 px-4 text-right w-24 whitespace-nowrap">PPN</th>
                                <th class="py-2.5 px-4 text-right w-32 whitespace-nowrap">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                            @foreach ($detail as $d)
                                @php
                                    $subtotal = $d->jumlah * $d->harga;
                                    $total_item = $subtotal + $d->penyesuaian;
                                    if ($biaya->ppn == '1') {
                                        $dpp_val  = $subtotal * 100 / 111;
                                        $dpp_lain = $dpp_val * 11 / 12;
                                        $ppn_val  = $dpp_lain * 0.12;
                                    } else {
                                        $dpp_val = $total_item;
                                        $ppn_val = 0;
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-2 px-4 text-center text-slate-400 font-mono">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4 font-bold text-slate-900 dark:text-white">
                                        {{ textCamelCase($d->keterangan ?? $d->nama_barang ?? '-') }}
                                    </td>
                                    <td class="py-2 px-4">
                                        <div class="flex items-center gap-1.5">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-700/50">
                                                {{ $d->kode_akun }}
                                            </span>
                                            <span class="text-[11px] text-slate-500 dark:text-slate-400 truncate max-w-[150px]">{{ $d->nama_akun }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 text-center font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                    <td class="py-2 px-4 text-right font-medium text-slate-600 dark:text-slate-400 whitespace-nowrap">{{ formatAngkaDesimal($d->harga) }}</td>
                                    <td class="py-2 px-4 text-right font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ formatAngkaDesimal($subtotal) }}</td>
                                    <td class="py-2 px-4 text-right font-medium text-slate-500 whitespace-nowrap">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                                    <td class="py-2 px-4 text-right font-semibold text-indigo-700 dark:text-indigo-400 whitespace-nowrap">{{ formatAngkaDesimal($dpp_val) }}</td>
                                    <td class="py-2 px-4 text-right font-semibold text-emerald-700 dark:text-emerald-400 whitespace-nowrap">{{ $ppn_val > 0 ? formatAngkaDesimal($ppn_val) : '-' }}</td>
                                    <td class="py-2 px-4 text-right font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_item) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 font-bold text-slate-800 dark:text-white text-xs">
                            <tr>
                                <td colspan="7" class="py-3 px-4 text-right uppercase tracking-wider text-[11px] text-slate-500 dark:text-slate-400">Total Pos Biaya</td>
                                <td class="py-3 px-4 text-right font-bold text-indigo-700 dark:text-indigo-400 whitespace-nowrap">{{ formatAngkaDesimal($total_dpp_detail) }}</td>
                                <td class="py-3 px-4 text-right font-bold text-emerald-700 dark:text-emerald-400 whitespace-nowrap">{{ $total_ppn_detail > 0 ? formatAngkaDesimal($total_ppn_detail) : '-' }}</td>
                                <td class="py-3 px-4 text-right font-black text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_biaya) }}</td>
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

            <!-- 2-Column Grid: Rincian Akun & Histori Pembayaran Sebelahan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                
                <!-- Card: Rincian Akun & Jurnal -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden flex flex-col">
                    <div class="px-5 py-3.5 bg-gradient-to-r from-indigo-800 to-indigo-950 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                                <i data-lucide="calculator" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-white">Rincian Akun & Jurnal</h4>
                                <p class="text-[11px] text-indigo-200/80">Alokasi beban (DPP), PPN Masukan, dan Jurnal</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-white/20 text-white">
                            {{ $biaya->ppn == '1' ? 'PPN 11%' : 'Non-PPN' }}
                        </span>
                    </div>

                    <!-- Tabel Item Akun -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse min-w-[480px]">
                            <thead class="bg-indigo-50/50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-indigo-100 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                                <tr>
                                    <th class="py-2.5 px-3 w-10 text-center">No</th>
                                    <th class="py-2.5 px-3">Item & Akun</th>
                                    <th class="py-2.5 px-3 text-right whitespace-nowrap">DPP</th>
                                    <th class="py-2.5 px-3 text-right whitespace-nowrap">PPN</th>
                                    <th class="py-2.5 px-3 text-right whitespace-nowrap">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                @foreach ($itemBreakdowns as $item)
                                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                        <td class="py-2.5 px-3 text-center font-mono text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="py-2.5 px-3 font-bold text-slate-900 dark:text-white">
                                            <div class="leading-tight">{{ textCamelCase($item['keterangan']) }}</div>
                                            <div class="flex items-center gap-1.5 mt-1">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-700/50">
                                                    {{ $item['kode_akun'] }}
                                                </span>
                                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-normal truncate max-w-[150px]">{{ $item['nama_akun'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-2.5 px-3 text-right font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">{{ formatAngkaDesimal($item['dpp']) }}</td>
                                        <td class="py-2.5 px-3 text-right font-medium {{ $item['ppn'] > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }} whitespace-nowrap">
                                            {{ $item['ppn'] > 0 ? formatAngkaDesimal($item['ppn']) : '-' }}
                                        </td>
                                        <td class="py-2.5 px-3 text-right font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($item['hutang']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 font-bold text-slate-800 dark:text-white text-xs">
                                <tr>
                                    <td colspan="2" class="py-2.5 px-3 text-right uppercase text-slate-500 dark:text-slate-400">Total Akun</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-slate-800 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_dpp_items) }}</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">{{ formatAngkaDesimal($total_ppn_items) }}</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_hutang_items) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Rekapitulasi Jurnal Akuntansi -->
                    <div class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 border-t border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                        <span class="font-bold text-slate-700 dark:text-slate-300 text-[11px] uppercase tracking-wider">Rekapitulasi Jurnal Akuntansi</span>
                        <span class="text-[10px] text-slate-400">Debet / Kredit</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse min-w-[480px]">
                            <thead class="bg-slate-50/60 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 text-[11px] font-bold">
                                <tr>
                                    <th class="py-2 px-3">Akun</th>
                                    <th class="py-2 px-3 text-center w-16">Posisi</th>
                                    <th class="py-2 px-3 text-right w-28 whitespace-nowrap">Debet</th>
                                    <th class="py-2 px-3 text-right w-28 whitespace-nowrap">Kredit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                @foreach ($biayaByAkun as $itemAkun)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                        <td class="py-2 px-3">
                                            <div class="font-mono font-bold text-indigo-700 dark:text-indigo-400">{{ $itemAkun['kode_akun'] }}</div>
                                            <div class="text-[10px] text-slate-500">{{ $itemAkun['nama_akun'] }}</div>
                                        </td>
                                        <td class="py-2 px-3 text-center">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200/60">Debet</span>
                                        </td>
                                        <td class="py-2 px-3 text-right font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($itemAkun['jumlah']) }}</td>
                                        <td class="py-2 px-3 text-right text-slate-400">-</td>
                                    </tr>
                                @endforeach
                                @if($biaya->ppn == '1' && $ppn_masukan_biaya > 0)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                        <td class="py-2 px-3">
                                            <div class="font-mono font-bold text-indigo-700 dark:text-indigo-400">1-11501</div>
                                            <div class="text-[10px] text-slate-500">PPN Masukan (11%)</div>
                                        </td>
                                        <td class="py-2 px-3 text-center">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200/60">Debet</span>
                                        </td>
                                        <td class="py-2 px-3 text-right font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">{{ formatAngkaDesimal($ppn_masukan_biaya) }}</td>
                                        <td class="py-2 px-3 text-right text-slate-400">-</td>
                                    </tr>
                                @endif
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                    <td class="py-2 px-3">
                                        <div class="font-mono font-bold text-indigo-700 dark:text-indigo-400">{{ $biaya->tanggal_jatuh_tempo ? '2-11101' : '1-11101' }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $biaya->tanggal_jatuh_tempo ? 'Hutang Usaha' : 'Kas / Bank' }}</div>
                                    </td>
                                    <td class="py-2 px-3 text-center">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border border-amber-200/60">Kredit</span>
                                    </td>
                                    <td class="py-2 px-3 text-right text-slate-400">-</td>
                                    <td class="py-2 px-3 text-right font-bold text-indigo-900 dark:text-indigo-300 whitespace-nowrap">{{ formatAngkaDesimal($total_kredit_biaya) }}</td>
                                </tr>
                            </tbody>
                            <tfoot class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 font-bold text-slate-800 dark:text-white text-xs">
                                <tr>
                                    <td colspan="2" class="py-2.5 px-3 text-right uppercase text-slate-500 dark:text-slate-400">Total Jurnal</td>
                                    <td class="py-2.5 px-3 text-right font-black text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_debet_biaya) }}</td>
                                    <td class="py-2.5 px-3 text-right font-black text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_kredit_biaya) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Card: Histori Pembayaran -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden flex flex-col">
                    <div class="px-5 py-3.5 bg-emerald-700 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                                <i data-lucide="receipt" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-white">Histori Pembayaran</h4>
                                <p class="text-[11px] text-emerald-200/80">Catatan pelunasan tagihan biaya</p>
                            </div>
                        </div>
                        @if($sisa_hutang > 0)
                        <button 
                            type="button" 
                            onclick="toggleFormPembayaran()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-white text-emerald-800 hover:bg-emerald-50 transition shadow-xs cursor-pointer shrink-0"
                        >
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Input Bayar</span>
                        </button>
                        @endif
                    </div>

                    <!-- Form Input Pembayaran Baru -->
                    @if($sisa_hutang > 0)
                    <div id="formInputPembayaran" class="hidden p-5 bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                        <form id="formStorePembayaran" action="{{ route('biaya.storeprosespembayaran', $crypted_no_bukti) }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-2xs" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Bank / Kas</label>
                                    <select name="kode_bank" id="kode_bank_pembayaran" required class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-2xs">
                                        <option value="">-- Pilih Bank --</option>
                                        @foreach($bank ?? [] as $b)
                                            <option value="{{ $b->kode_bank }}">{{ $b->kode_bank }} - {{ $b->nama_bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Jumlah (Rp)</label>
                                    <input type="number" step="0.01" min="0.01" name="jumlah" value="{{ $sisa_hutang }}" required class="w-full text-xs font-bold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-2xs" />
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-1">
                                <button type="button" onclick="toggleFormPembayaran()" class="px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 transition cursor-pointer">Batal</button>
                                <button type="submit" class="px-4 py-1.5 text-xs font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition shadow-sm cursor-pointer">Simpan Bayar</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    @php
                        $hasAksiPembayaran = auth()->user()->can('biaya.delete');
                    @endphp
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse min-w-[460px]">
                            <thead class="bg-emerald-50/50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-emerald-100 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                                <tr>
                                    <th class="py-2.5 px-3 w-10 text-center">No</th>
                                    <th class="py-2.5 px-3 whitespace-nowrap">Tanggal</th>
                                    <th class="py-2.5 px-3">Bank / Kas</th>
                                    <th class="py-2.5 px-3 text-right whitespace-nowrap">Jumlah</th>
                                    @if($hasAksiPembayaran)
                                    <th class="py-2.5 px-3 text-center w-20 whitespace-nowrap">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                @forelse ($historibayar as $d)
                                    <tr class="hover:bg-emerald-50/20 dark:hover:bg-slate-800/40 transition">
                                        <td class="py-2.5 px-3 text-center font-mono text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="py-2.5 px-3 font-semibold text-slate-900 dark:text-white whitespace-nowrap">{{ formatIndo($d->tanggal) }}</td>
                                        <td class="py-2.5 px-3">
                                            <div class="font-medium text-slate-800 dark:text-slate-200">{{ $d->nama_bank }}</div>
                                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ $d->kode_cabang ?? '-' }}</div>
                                        </td>
                                        <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                        @if($hasAksiPembayaran)
                                        <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                            <form action="{{ route('biaya.deletepembayaran', Crypt::encrypt($d->id)) }}" method="POST" class="formDelete inline">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs mx-auto delete-confirm" 
                                                    title="Hapus Pembayaran"
                                                >
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $hasAksiPembayaran ? 5 : 4 }}" class="py-8 px-4 text-center text-slate-400 italic">Belum ada catatan pembayaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 text-xs">
                                <tr class="border-b border-slate-200/60 dark:border-slate-700/60">
                                    <td colspan="3" class="py-2.5 px-3 text-right font-semibold uppercase text-slate-500">Total Pembayaran</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">{{ formatAngkaDesimal($total_paid) }}</td>
                                    @if($hasAksiPembayaran)<td></td>@endif
                                </tr>
                                <tr class="{{ $sisa_hutang <= 0 ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300' : 'bg-rose-50 dark:bg-rose-900/30 text-rose-800 dark:text-rose-300' }}">
                                    <td colspan="3" class="py-3 px-3 text-right font-bold uppercase text-xs tracking-wider">Sisa Tagihan</td>
                                    <td class="py-3 px-3 text-right font-black text-sm {{ $sisa_hutang <= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} whitespace-nowrap">{{ formatAngkaDesimal($sisa_hutang) }}</td>
                                    @if($hasAksiPembayaran)<td></td>@endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        @else
            <!-- Non-Harga View (Simple Detail) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                <div class="px-6 py-4 bg-[#162a5b] text-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                            <i data-lucide="layers" class="w-4 h-4 text-white"></i>
                        </div>
                        <h4 class="font-bold text-sm text-white">Data Pos Biaya</h4>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="py-2.5 px-4 w-12 text-center whitespace-nowrap">No</th>
                                <th class="py-2.5 px-4 min-w-[200px]">Keterangan</th>
                                <th class="py-2.5 px-4 min-w-[180px]">Akun (COA)</th>
                                <th class="py-2.5 px-4 text-center w-28 whitespace-nowrap">Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                            @foreach ($detail as $d)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-2 px-4 text-center text-slate-400 font-mono">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4 font-bold text-slate-900 dark:text-white">{{ textCamelCase($d->keterangan ?? $d->nama_barang ?? '-') }}</td>
                                    <td class="py-2 px-4 font-mono text-slate-600 dark:text-slate-400">{{ $d->kode_akun }} - {{ $d->nama_akun }}</td>
                                    <td class="py-2 px-4 text-center font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan

    </div>

@push('myscript')
<script>
    $(document).ready(function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        $(document).on('click', '.delete-confirm', function(e) {
            var form = $(this).closest("form");
            e.preventDefault();
            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Histori pembayaran ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#162a5b",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    function toggleFormPembayaran() {
        $('#formInputPembayaran').toggleClass('hidden');
        if (!$('#formInputPembayaran').hasClass('hidden')) {
            $('#kode_bank_pembayaran').select2({ width: '100%' });
        }
    }
</script>
@endpush
</x-app-layout>
