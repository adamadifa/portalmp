<x-app-layout>
    <x-slot name="header">Detail Pembelian</x-slot>
    <x-slot name="headerTitle">Detail Pembelian</x-slot>
    <x-slot name="headerDescription">Faktur Pembelian #{{ $pembelian->no_bukti }} &bull; {{ $pembelian->nama_supplier }}</x-slot>

    @php
        $is_import = (($pembelian->kategori_pembelian ?? 'L') == 'I');
        
        // Perhitungan Total Barang Pembelian
        $total_pembelian = 0;
        $total_dpp_detail = 0;
        $total_dpp_lain_detail = 0;
        $total_ppn_detail = 0;

        foreach ($detail as $d) {
            $subtotal = $d->jumlah * $d->harga;
            $total_item = $subtotal + $d->penyesuaian;

            if ($is_import && $pembelian->ppn == '1') {
                $total_pembelian += $subtotal * 100 / 111;
            } else {
                $total_pembelian += $total_item;
            }

            if ($pembelian->ppn == '1') {
                $dpp_val = $subtotal * 100 / 111;
                $dpp_lain_val = $dpp_val * 11 / 12;
                $ppn_val = $dpp_lain_val * 0.12;
            } else {
                $dpp_val = $total_item;
                $dpp_lain_val = 0;
                $ppn_val = 0;
            }

            $total_dpp_detail += $dpp_val;
            $total_dpp_lain_detail += $dpp_lain_val;
            $total_ppn_detail += $ppn_val;
        }

        // Perhitungan Potongan
        $total_potongan = 0;
        foreach ($potongan as $d) {
            $total_potongan += ($d->jumlah * $d->harga);
        }

        // Grand Total & Pembayaran
        if ($is_import && $pembelian->ppn == '1') {
            $grand_total = $total_pembelian - $total_potongan;
        } else {
            $grand_total = $total_pembelian - $total_potongan + ($pembelian->penyesuaian_jk ?? 0);
        }

        $total_paid = $historibayar->sum('jumlah');
        $sisa_hutang = max(0, $grand_total - $total_paid);
        $is_lunas = (round($grand_total, 2) <= round($total_paid, 2));
    @endphp

    <div class="space-y-6">

        <!-- Top Navigation & Action Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex flex-wrap items-center gap-2.5">
                <a 
                    href="{{ route('pembelian.index') }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs transition cursor-pointer"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4 text-slate-500"></i>
                    <span>Kembali ke Daftar</span>
                </a>

                <!-- Status Badges -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <!-- Tunai / Kredit -->
                    <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs {{ $pembelian->jenis_transaksi == 'T' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60' : 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60' }}">
                        <i data-lucide="{{ $pembelian->jenis_transaksi == 'T' ? 'wallet' : 'calendar-clock' }}" class="w-3.5 h-3.5"></i>
                        <span>{{ $pembelian->jenis_transaksi == 'T' ? 'TUNAI' : 'KREDIT' }}</span>
                    </span>

                    <!-- PPN Status -->
                    @if($pembelian->ppn == '1')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            <span>PPN AKTIF</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200/60">
                            <span>NON-PPN</span>
                        </span>
                    @endif

                    <!-- Kategori -->
                    @if($is_import)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-300 border border-purple-200/60">
                            <i data-lucide="globe" class="w-3.5 h-3.5"></i>
                            <span>IMPORT</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl font-bold text-xs bg-sky-50 dark:bg-sky-500/10 text-sky-700 dark:text-sky-300 border border-sky-200/60">
                            <span>LOKAL</span>
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
                <a 
                    href="{{ route('pembelian.cetak', $crypted_no_bukti) }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                    title="Cetak Claim Faktur Pembelian"
                >
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    <span>Cetak Claim</span>
                </a>

                @can('pembelian.edit')
                <a 
                    href="{{ route('pembelian.edit', $crypted_no_bukti) }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition cursor-pointer"
                    title="Edit Data Pembelian"
                >
                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                    <span>Edit Pembelian</span>
                </a>
                @endcan

                <div class="hidden sm:flex items-center gap-1.5 pl-2 border-l border-slate-200 dark:border-slate-800">
                    <span class="font-mono text-xs font-bold px-3 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-[#162a5b] dark:text-blue-400 border border-slate-200/60 dark:border-slate-700">
                        {{ $pembelian->no_bukti }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 3 High-Level Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-5 items-stretch">
            
            <!-- Card 1: Parameter Faktur -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-[#162a5b] text-white flex items-center justify-center shadow-xs shrink-0">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Parameter Faktur</h4>
                            <p class="text-[11px] text-slate-400">Identitas nomor bukti dan tanggal</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">No. Bukti</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white text-sm">{{ $pembelian->no_bukti }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Tanggal Transaksi</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ formatIndo($pembelian->tanggal) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Masa / Tahun Pajak</span>
                            <span class="font-bold text-[#162a5b] dark:text-blue-400">
                                {{ $pembelian->bulan_pajak ? str_pad($pembelian->bulan_pajak, 2, '0', STR_PAD_LEFT) : date('m', strtotime($pembelian->tanggal)) }} / {{ $pembelian->tahun_pajak ?: date('Y', strtotime($pembelian->tanggal)) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Asal Pengajuan</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300">
                                {{ $asal_pengajuan[$pembelian->kode_asal_pengajuan] ?? $pembelian->kode_asal_pengajuan ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Supplier & Transaksi -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-xs shrink-0">
                            <i data-lucide="truck" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Supplier & Transaksi</h4>
                            <p class="text-[11px] text-slate-400">Pemasok dan metode transaksi</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Nama Supplier</span>
                            <span class="font-bold text-slate-900 dark:text-white text-right max-w-[200px] truncate" title="{{ $pembelian->nama_supplier }}">
                                {{ $pembelian->nama_supplier }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Kategori Pembelian</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">
                                {{ $is_import ? 'Import Luar Negeri' : 'Lokal Domestik' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Jenis Transaksi</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">
                                {{ $pembelian->jenis_transaksi == 'T' ? 'Tunai (Cash)' : 'Kredit (Tempo)' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Status Uang Muka</span>
                            <span class="font-semibold {{ $pembelian->status_uang_muka == 1 ? 'text-amber-600' : 'text-slate-500' }}">
                                {{ $pembelian->status_uang_muka == 1 ? 'Ya (Uang Muka)' : 'Transaksi Biasa' }}
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
                            <p class="text-[11px] text-slate-400">Total nilai hutang & status bayar</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Grand Total Faktur</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white text-sm">
                                Rp {{ formatAngkaDesimal($grand_total) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Sudah Dibayar</span>
                            <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                Rp {{ formatAngkaDesimal($total_paid) }}
                            </span>
                        </div>
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <span class="text-slate-700 dark:text-slate-300 font-bold">Sisa Hutang Dagang</span>
                            <span class="font-mono text-sm font-black {{ $sisa_hutang <= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                Rp {{ formatAngkaDesimal($sisa_hutang) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('pembelian.harga')
            <!-- Card: Detail Barang Pembelian -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                <div class="px-6 py-4 bg-[#162a5b] text-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                            <i data-lucide="package" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-white">Detail Barang Pembelian</h4>
                            <p class="text-[11px] text-blue-200/80">Katalog item barang, kuantum, harga satuan, dan kalkulasi DPP/PPN</p>
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
                                <th class="py-2.5 px-4 w-28 whitespace-nowrap">Kode</th>
                                <th class="py-2.5 px-4 min-w-[180px]">Nama Barang</th>
                                <th class="py-2.5 px-4">Keterangan</th>
                                <th class="py-2.5 px-4 text-center w-20 whitespace-nowrap">Qty</th>
                                <th class="py-2.5 px-4 text-right w-28 whitespace-nowrap">Harga</th>
                                <th class="py-2.5 px-4 text-right w-28 whitespace-nowrap">Subtotal</th>
                                <th class="py-2.5 px-4 text-right w-24 whitespace-nowrap">Peny</th>
                                <th class="py-2.5 px-4 text-right w-28 whitespace-nowrap">DPP</th>
                                <th class="py-2.5 px-4 text-right w-28 whitespace-nowrap">DPP Lain</th>
                                <th class="py-2.5 px-4 text-right w-24 whitespace-nowrap">PPN</th>
                                <th class="py-2.5 px-4 text-right w-32 whitespace-nowrap">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                            @foreach ($detail as $d)
                                @php
                                    $subtotal = $d->jumlah * $d->harga;
                                    $total_item = $subtotal + $d->penyesuaian;

                                    if ($pembelian->ppn == '1') {
                                        $dpp_val = $subtotal * 100 / 111;
                                        $dpp_lain_val = $dpp_val * 11 / 12;
                                        $ppn_val = $dpp_lain_val * 0.12;
                                    } else {
                                        $dpp_val = $total_item;
                                        $dpp_lain_val = 0;
                                        $ppn_val = 0;
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-2 px-4 font-mono font-semibold text-slate-600 dark:text-slate-400 whitespace-nowrap">{{ $d->kode_barang }}</td>
                                    <td class="py-2 px-4 font-bold text-slate-900 dark:text-white">
                                        <div>{{ textCamelCase($d->nama_barang) }}</div>
                                        @if(!empty($d->kode_akun))
                                            <div class="text-[10px] text-slate-400 font-mono font-normal mt-0.5">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-semibold">{{ $d->kode_akun }}</span> {{ $d->nama_akun }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 text-slate-500 dark:text-slate-400">{{ textCamelCase($d->keterangan) }}</td>
                                    <td class="py-2 px-4 text-center font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                    <td class="py-2 px-4 text-right font-medium text-slate-600 dark:text-slate-400 whitespace-nowrap">{{ formatAngkaDesimal($d->harga) }}</td>
                                    <td class="py-2 px-4 text-right font-medium text-slate-700 dark:text-slate-300 whitespace-nowrap">{{ formatAngkaDesimal($subtotal) }}</td>
                                    <td class="py-2 px-4 text-right font-medium text-slate-500 whitespace-nowrap">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                                    <td class="py-2 px-4 text-right font-semibold text-indigo-700 dark:text-indigo-400 whitespace-nowrap">{{ formatAngkaDesimal($dpp_val) }}</td>
                                    <td class="py-2 px-4 text-right font-semibold text-violet-700 dark:text-violet-400 whitespace-nowrap">{{ formatAngkaDesimal($dpp_lain_val) }}</td>
                                    <td class="py-2 px-4 text-right font-semibold text-emerald-700 dark:text-emerald-400 whitespace-nowrap">{{ formatAngkaDesimal($ppn_val) }}</td>
                                    <td class="py-2 px-4 text-right font-bold text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_item) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 font-bold text-slate-800 dark:text-white text-xs">
                            <tr>
                                <td colspan="7" class="py-3 px-4 text-right uppercase tracking-wider text-[11px] text-slate-500 dark:text-slate-400">Subtotal Barang</td>
                                <td class="py-3 px-4 text-right font-bold text-indigo-700 dark:text-indigo-400 whitespace-nowrap">{{ formatAngkaDesimal($total_dpp_detail) }}</td>
                                <td class="py-3 px-4 text-right font-bold text-violet-700 dark:text-violet-400 whitespace-nowrap">{{ formatAngkaDesimal($total_dpp_lain_detail) }}</td>
                                <td class="py-3 px-4 text-right font-bold text-emerald-700 dark:text-emerald-400 whitespace-nowrap">{{ formatAngkaDesimal($total_ppn_detail) }}</td>
                                <td class="py-3 px-4 text-right font-black text-slate-900 dark:text-white whitespace-nowrap">{{ formatAngkaDesimal($total_pembelian) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Card: Potongan Pembelian & Ikhtisar Biaya -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-rose-700 to-rose-900 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                            <i data-lucide="tag" class="w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-white">Potongan Pembelian & Ikhtisar Biaya</h4>
                            <p class="text-[11px] text-rose-200/80">Kredit potongan supplier dan penyesuaian jurnal koreksi</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead class="bg-rose-50/50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-rose-100 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="py-2.5 px-4">Keterangan Potongan</th>
                                <th class="py-2.5 px-4 text-center w-24 whitespace-nowrap">Qty</th>
                                <th class="py-2.5 px-4 text-right w-36 whitespace-nowrap">Harga</th>
                                <th class="py-2.5 px-4 text-right w-44 whitespace-nowrap">Total Potongan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                            @forelse ($potongan as $d)
                                @php
                                    $subtotal_pot = $d->jumlah * $d->harga;
                                @endphp
                                <tr class="hover:bg-rose-50/30 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-2 px-4 font-medium text-slate-800 dark:text-slate-200">{{ textCamelCase($d->keterangan_penjualan) }}</td>
                                    <td class="py-2 px-4 text-center font-medium">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                    <td class="py-2 px-4 text-right text-slate-600 dark:text-slate-400">{{ formatAngkaDesimal($d->harga) }}</td>
                                    <td class="py-2 px-4 text-right font-bold text-rose-600 dark:text-rose-400">- {{ formatAngkaDesimal($subtotal_pot) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 px-4 text-center text-slate-400 italic">Tidak ada data potongan untuk pembelian ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 text-xs">
                            <tr class="border-b border-slate-200/60 dark:border-slate-700/60">
                                <td colspan="3" class="py-2.5 px-4 text-right font-semibold uppercase text-slate-500">Total Pembelian</td>
                                <td class="py-2.5 px-4 text-right font-bold text-slate-900 dark:text-white">{{ formatAngkaDesimal($total_pembelian) }}</td>
                            </tr>
                            <tr class="border-b border-slate-200/60 dark:border-slate-700/60">
                                <td colspan="3" class="py-2.5 px-4 text-right font-semibold uppercase text-slate-500">Total Potongan</td>
                                <td class="py-2.5 px-4 text-right font-bold text-rose-600 dark:text-rose-400">- {{ formatAngkaDesimal($total_potongan) }}</td>
                            </tr>
                            <tr class="border-b border-slate-200/60 dark:border-slate-700/60">
                                <td colspan="3" class="py-2.5 px-4 text-right font-semibold uppercase text-slate-500">Penyesuaian Jurnal Koreksi</td>
                                <td class="py-2.5 px-4 text-right font-bold text-amber-600 dark:text-amber-400">{{ formatAngkaDesimal($pembelian->penyesuaian_jk ?? 0) }}</td>
                            </tr>
                            <tr class="bg-emerald-50 dark:bg-emerald-900/30 text-[#162a5b] dark:text-emerald-300">
                                <td colspan="3" class="py-3 px-4 text-right font-bold uppercase tracking-wider text-xs">Grand Total Faktur</td>
                                <td class="py-3 px-4 text-right font-black text-base">{{ formatAngkaDesimal($grand_total) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @php
                // Rincian Akuntansi
                $pembelianByAkun = [];
                $itemBreakdowns = [];
                $total_dpp_items = 0;
                $total_ppn_items = 0;
                $total_hutang_items = 0;

                foreach ($detail as $d) {
                    $sub = ($d->jumlah * $d->harga) + $d->penyesuaian;
                    $dpp = ($pembelian->ppn == '1') ? (($d->jumlah * $d->harga) * 100 / 111) : $sub;
                    $ppn = ($pembelian->ppn == '1') ? ($sub - $dpp) : 0;
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
                $ppn_masukan_pmb = ($pembelian->ppn == '1') ? max(0, $grand_total - $total_dpp_pmb) : 0;
                $total_debet_pmb = $total_dpp_pmb + $ppn_masukan_pmb;
                $total_kredit_pmb_base = $is_import ? 0 : $grand_total;
                $total_kredit_pmb = $total_kredit_pmb_base;
            @endphp

            <!-- 2-Column Grid: Rincian Akun & Histori Pembayaran Sebelahan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                
                <!-- Card: Rincian Akun Per Item Detail -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden flex flex-col">
                    <div class="px-5 py-3.5 bg-gradient-to-r from-indigo-800 to-indigo-950 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center shrink-0">
                                <i data-lucide="calculator" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-white">Rincian Akun Akuntansi</h4>
                                <p class="text-[11px] text-indigo-200/80">Alokasi beban/pembelian & hutang per item</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse min-w-[480px]">
                            <thead class="bg-indigo-50/50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-indigo-100 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                                <tr>
                                    <th class="py-2.5 px-3 w-10 text-center">No</th>
                                    <th class="py-2.5 px-3">Item & Akun</th>
                                    <th class="py-2.5 px-3 text-right whitespace-nowrap">DPP</th>
                                    <th class="py-2.5 px-3 text-right whitespace-nowrap">PPN</th>
                                    <th class="py-2.5 px-3 text-right whitespace-nowrap">{{ $is_import ? 'DPP/Hutang' : 'Hutang' }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                @foreach ($itemBreakdowns as $item)
                                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                        <td class="py-2.5 px-3 text-center font-mono text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="py-2.5 px-3 font-bold text-slate-900 dark:text-white">
                                            <div class="leading-tight">{{ textCamelCase($item['nama_barang']) }}</div>
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
                                <p class="text-[11px] text-emerald-200/80">Catatan alokasi pelunasan hutang</p>
                            </div>
                        </div>
                        @can('pembelian.create')
                        <button 
                            type="button" 
                            onclick="toggleFormPembayaran()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-white text-emerald-800 hover:bg-emerald-50 transition shadow-xs cursor-pointer shrink-0"
                        >
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Input Bayar</span>
                        </button>
                        @endcan
                    </div>

                    <!-- Form Input Pembayaran Baru -->
                    @can('pembelian.create')
                    <div id="formInputPembayaran" class="hidden p-5 bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                        <form id="formStorePembayaran" class="space-y-3">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-2xs" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Bank</label>
                                    <select name="kode_bank" id="kode_bank_pembayaran" required class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-2xs">
                                        <option value="">-- Bank --</option>
                                        @foreach($banks as $b)
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
                    @endcan

                    <!-- Form Edit Pembayaran -->
                    @if(auth()->user()->can('pembelian.create') || auth()->user()->can('pembelian.edit'))
                    <div id="formEditPembayaran" class="hidden p-5 bg-amber-50/50 dark:bg-amber-950/20 border-b border-amber-200 dark:border-amber-900/40">
                        <form id="formUpdatePembayaran" class="space-y-3">
                            @csrf
                            <input type="hidden" name="id" id="edit_pembayaran_id">
                            <div class="flex items-center justify-between pb-1.5 border-b border-amber-200/70">
                                <span class="text-xs font-bold text-amber-900 dark:text-amber-300 flex items-center gap-1.5">
                                    <i data-lucide="edit-3" class="w-3.5 h-3.5 text-amber-600"></i>
                                    <span>Edit Histori Pembayaran</span>
                                </span>
                                <button type="button" onclick="cancelEditPembayaran()" class="text-xs font-bold text-slate-500 hover:text-slate-700 cursor-pointer">✕ Batal</button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Tanggal</label>
                                    <input type="date" name="tanggal" id="edit_pembayaran_tanggal" required class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-amber-500 focus:ring-amber-500 p-2 bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-2xs" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Bank</label>
                                    <select name="kode_bank" id="edit_kode_bank_pembayaran" required class="w-full text-xs font-semibold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-amber-500 focus:ring-amber-500 p-2 bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-2xs">
                                        <option value="">-- Bank --</option>
                                        @foreach($banks as $b)
                                            <option value="{{ $b->kode_bank }}">{{ $b->kode_bank }} - {{ $b->nama_bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Jumlah (Rp)</label>
                                    <input type="number" step="0.01" min="0.01" name="jumlah" id="edit_pembayaran_jumlah" required class="w-full text-xs font-bold border border-slate-200 dark:border-slate-700 rounded-xl focus:border-amber-500 focus:ring-amber-500 p-2 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-2xs" />
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-1">
                                <button type="button" onclick="cancelEditPembayaran()" class="px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 transition cursor-pointer">Batal</button>
                                <button type="submit" class="px-4 py-1.5 text-xs font-bold text-white bg-amber-600 rounded-xl hover:bg-amber-700 transition shadow-sm cursor-pointer">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    @php
                        $hasAksiPembayaran = auth()->user()->can('pembelian.create') || auth()->user()->can('pembelian.edit') || auth()->user()->can('pembelian.delete');
                    @endphp
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse min-w-[460px]">
                            <thead class="bg-emerald-50/50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-emerald-100 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                                <tr>
                                    <th class="py-2.5 px-3 w-10 text-center">No</th>
                                    <th class="py-2.5 px-3 whitespace-nowrap">Tanggal</th>
                                    <th class="py-2.5 px-3">Bank / Cabang</th>
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
                                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ $d->kode_cabang }}</div>
                                        </td>
                                        <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                        @if($hasAksiPembayaran)
                                        <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                @if(auth()->user()->can('pembelian.create') || auth()->user()->can('pembelian.edit'))
                                                <button 
                                                    type="button" 
                                                    onclick="editPembayaran({{ $d->id }}, '{{ $d->tanggal }}', '{{ $d->kode_bank }}', {{ $d->jumlah }})" 
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 text-amber-600 border border-amber-200/60 transition cursor-pointer shadow-2xs" 
                                                    title="Edit Pembayaran"
                                                >
                                                    <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                                                </button>
                                                @endif
                                                @can('pembelian.delete')
                                                <button 
                                                    type="button" 
                                                    onclick="deletePembayaran({{ $d->id }})" 
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs" 
                                                    title="Hapus Pembayaran"
                                                >
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                                @endcan
                                            </div>
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
                                    <td colspan="3" class="py-3 px-3 text-right font-bold uppercase text-xs tracking-wider">Sisa Hutang</td>
                                    <td class="py-3 px-3 text-right font-black text-sm {{ $sisa_hutang <= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} whitespace-nowrap">{{ formatAngkaDesimal($sisa_hutang) }}</td>
                                    @if($hasAksiPembayaran)<td></td>@endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

            @if($is_import)
                <!-- Card: Jurnal Umum Khusus Import -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-teal-700 to-teal-900 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                                <i data-lucide="book-open" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-white">Pencatatan Jurnal Umum (Import)</h4>
                                <p class="text-[11px] text-teal-200/80">Pencatatan manual lawan akun untuk transaksi pembelian Import</p>
                            </div>
                        </div>
                        @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))
                        <button 
                            type="button" 
                            onclick="toggleFormJurnalUmum()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-white text-teal-800 hover:bg-teal-50 transition shadow-xs cursor-pointer"
                        >
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Input Jurnal Umum</span>
                        </button>
                        @endif
                    </div>

                    @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))
                    <div id="formInputJurnalUmum" class="hidden p-6 bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                        <form id="formStoreJurnalUmum" class="space-y-4">
                            @csrf
                            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-700">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">Tambah Baris Jurnal</span>
                                <button type="button" onclick="tambahBarisJurnal()" class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-bold bg-white dark:bg-slate-900 border border-teal-600 text-teal-700 hover:bg-teal-50 transition cursor-pointer">
                                    + Tambah Akun
                                </button>
                            </div>
                            <div id="containerBarisJurnal" class="space-y-3">
                                <div class="baris-jurnal grid grid-cols-1 md:grid-cols-12 gap-2 p-3 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 items-end shadow-2xs">
                                    <div class="md:col-span-2">
                                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Tanggal</label>
                                        <input type="date" name="tanggal_item[]" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" required>
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Kode / Nama Akun</label>
                                        <select name="kode_akun_item[]" class="select2-akun w-full text-xs rounded-lg border-slate-200" required>
                                            <option value="">-- Pilih Akun --</option>
                                            @foreach($coa ?? [] as $c)
                                                <option value="{{ $c->kode_akun }}">{{ $c->kode_akun }} - {{ $c->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Posisi</label>
                                        <select name="debet_kredit_item[]" class="w-full text-xs font-semibold rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" required>
                                            <option value="K">Kredit</option>
                                            <option value="D">Debet</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Jumlah (Rp)</label>
                                        <input type="text" name="jumlah_item[]" class="input-rupiah w-full text-xs font-bold text-right rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="0" required>
                                    </div>
                                    <div class="md:col-span-2 flex items-center gap-1">
                                        <input type="text" name="keterangan_item[]" value="Import - {{ $pembelian->no_bukti }}" class="w-full text-xs rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="Keterangan">
                                        <button type="button" onclick="hapusBarisJurnal(this)" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus Baris">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" onclick="toggleFormJurnalUmum()" class="px-4 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 transition cursor-pointer">Batal</button>
                                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-teal-600 rounded-xl hover:bg-teal-700 transition shadow-sm cursor-pointer">Simpan Jurnal</button>
                            </div>
                        </form>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse">
                            <thead class="bg-teal-50/50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-teal-100 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                                <tr>
                                    <th class="py-2.5 px-4 w-12 text-center">No</th>
                                    <th class="py-2.5 px-4 w-32 whitespace-nowrap">No. Bukti JU</th>
                                    <th class="py-2.5 px-4 w-28 whitespace-nowrap">Tanggal</th>
                                    <th class="py-2.5 px-4 w-32 whitespace-nowrap">Kode Akun</th>
                                    <th class="py-2.5 px-4">Nama Akun</th>
                                    <th class="py-2.5 px-4">Keterangan</th>
                                    <th class="py-2.5 px-4 w-20 text-center whitespace-nowrap">Posisi</th>
                                    <th class="py-2.5 px-4 text-right w-36 whitespace-nowrap">Jumlah (Rp)</th>
                                    @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))<th class="py-2.5 px-4 text-center w-16 whitespace-nowrap">Aksi</th>@endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                @forelse($jurnalumum ?? [] as $ju)
                                    <tr class="hover:bg-teal-50/20 dark:hover:bg-slate-800/40 transition">
                                        <td class="py-2 px-4 text-center font-mono text-slate-400">{{ $loop->iteration }}</td>
                                        <td class="py-2 px-4 font-mono font-bold text-teal-700 dark:text-teal-400 whitespace-nowrap">{{ $ju->kode_ju }}</td>
                                        <td class="py-2 px-4 whitespace-nowrap">{{ formatIndo($ju->tanggal) }}</td>
                                        <td class="py-2 px-4 font-mono font-semibold whitespace-nowrap">{{ $ju->kode_akun }}</td>
                                        <td class="py-2 px-4 font-semibold text-slate-900 dark:text-white">{{ $ju->nama_akun ?? '-' }}</td>
                                        <td class="py-2 px-4 text-slate-600 dark:text-slate-400">{{ $ju->keterangan }}</td>
                                        <td class="py-2 px-4 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $ju->debet_kredit == 'D' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                                {{ $ju->debet_kredit == 'D' ? 'Debet' : 'Kredit' }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 text-right font-mono font-bold {{ $ju->debet_kredit == 'D' ? 'text-blue-700' : 'text-amber-700' }} whitespace-nowrap">
                                            {{ formatAngkaDesimal($ju->jumlah) }}
                                        </td>
                                        @if(auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create'))
                                        <td class="py-2 px-4 text-center whitespace-nowrap">
                                            <button 
                                                type="button" 
                                                onclick="deleteJurnalUmum('{{ $ju->kode_ju }}')" 
                                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/60 transition cursor-pointer shadow-2xs mx-auto" 
                                                title="Hapus Jurnal"
                                            >
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ (auth()->user()->can('jurnalumum.create') || auth()->user()->can('pembelian.create')) ? 9 : 8 }}" class="py-8 px-4 text-center text-slate-400 italic">
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
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden">
                <div class="px-6 py-4 bg-[#162a5b] text-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                            <i data-lucide="package" class="w-4 h-4 text-white"></i>
                        </div>
                        <h4 class="font-bold text-sm text-white">Data Barang Pembelian</h4>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider text-[11px] font-bold">
                            <tr>
                                <th class="py-2.5 px-4 w-28 whitespace-nowrap">Kode</th>
                                <th class="py-2.5 px-4 min-w-[200px]">Nama Barang</th>
                                <th class="py-2.5 px-4">Keterangan</th>
                                <th class="py-2.5 px-4 text-center w-28 whitespace-nowrap">Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                            @foreach ($detail as $d)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-2 px-4 font-mono font-semibold text-slate-600 dark:text-slate-400 whitespace-nowrap">{{ $d->kode_barang }}</td>
                                    <td class="py-2 px-4 font-bold text-slate-900 dark:text-white">{{ textCamelCase($d->nama_barang) }}</td>
                                    <td class="py-2 px-4 text-slate-500 dark:text-slate-400">{{ textCamelCase($d->keterangan) }}</td>
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
    });

    function toggleFormPembayaran() {
        $('#formEditPembayaran').addClass('hidden');
        $('#formInputPembayaran').toggleClass('hidden');
        if (!$('#formInputPembayaran').hasClass('hidden')) {
            $('#kode_bank_pembayaran').select2({ width: '100%' });
        }
    }

    function editPembayaran(id, tanggal, kode_bank, jumlah) {
        $('#formInputPembayaran').addClass('hidden');
        $('#edit_pembayaran_id').val(id);
        $('#edit_pembayaran_tanggal').val(tanggal);
        $('#edit_pembayaran_jumlah').val(jumlah);
        $('#formEditPembayaran').removeClass('hidden');

        $('#edit_kode_bank_pembayaran').select2({ width: '100%' });
        $('#edit_kode_bank_pembayaran').val(kode_bank).trigger('change');

        if ($('#formEditPembayaran').length) {
            $('#formEditPembayaran')[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function cancelEditPembayaran() {
        $('#formEditPembayaran').addClass('hidden');
    }

    $('#formUpdatePembayaran').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: '{{ route("pembelian.updatepembayaran", $crypted_no_bukti) }}',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1200
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                    submitBtn.prop('disabled', false).text('Simpan Perubahan');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan pada server.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                submitBtn.prop('disabled', false).text('Simpan Perubahan');
            }
        });
    });

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
                        timer: 1200
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                    submitBtn.prop('disabled', false).text('Simpan Pembayaran');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan pada server.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
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
                                timer: 1200
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                        }
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan pada server.';
                        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    }
                });
            }
        });
    }

    function initSelect2Akun(element) {
        element.select2({ width: '100%' });
    }

    function toggleFormJurnalUmum() {
        $('#formInputJurnalUmum').toggleClass('hidden');
        if (!$('#formInputJurnalUmum').hasClass('hidden')) {
            initSelect2Akun($('.select2-akun'));
        }
    }

    function tambahBarisJurnal() {
        var rowHtml = `
            <div class="baris-jurnal grid grid-cols-1 md:grid-cols-12 gap-2 p-3 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 items-end shadow-2xs">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Tanggal</label>
                    <input type="date" name="tanggal_item[]" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" required>
                </div>
                <div class="md:col-span-4">
                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Kode / Nama Akun</label>
                    <select name="kode_akun_item[]" class="select2-akun w-full text-xs rounded-lg border-slate-200" required>
                        <option value="">-- Pilih Akun --</option>
                        @foreach($coa ?? [] as $c)
                            <option value="{{ $c->kode_akun }}">{{ $c->kode_akun }} - {{ $c->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Posisi</label>
                    <select name="debet_kredit_item[]" class="w-full text-xs font-semibold rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" required>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-600 dark:text-slate-400 mb-1">Jumlah (Rp)</label>
                    <input type="text" name="jumlah_item[]" class="input-rupiah w-full text-xs font-bold text-right rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="0" required>
                </div>
                <div class="md:col-span-2 flex items-center gap-1">
                    <input type="text" name="keterangan_item[]" value="Import - {{ $pembelian->no_bukti }}" class="w-full text-xs rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white" placeholder="Keterangan">
                    <button type="button" onclick="hapusBarisJurnal(this)" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Hapus Baris">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>`;
        var newRow = $(rowHtml);
        $('#containerBarisJurnal').append(newRow);
        initSelect2Akun(newRow.find('.select2-akun'));
        if (typeof lucide !== 'undefined') lucide.createIcons();
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
                        timer: 1200
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                    submitBtn.prop('disabled', false).text('Simpan Jurnal');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan pada server.';
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
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
                                timer: 1200
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                        }
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan pada server.';
                        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    }
                });
            }
        });
    }
</script>
@endpush
</x-app-layout>
