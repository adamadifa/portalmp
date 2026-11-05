<x-app-layout>
    <x-slot name="header">Detail Penjualan Marketing</x-slot>
    <x-slot name="headerTitle">Detail Penjualan Marketing</x-slot>
    <x-slot name="headerDescription">Faktur Penjualan #{{ $penjualan->no_bukti }} - {{ $penjualan->nama_pelanggan }}</x-slot>

    @php
        $total_dpp = 0;
        $total_ppn = 0;
        $total_jumlah = 0;
        
        foreach ($detail as $d) {
            $dpp = $d->harga_dus * $d->jumlah;
            $ppn = $dpp * 0.11;
            $jumlah_item = $dpp + $ppn;
            
            $total_dpp += $dpp;
            $total_ppn += $ppn;
            $total_jumlah += $jumlah_item;
        }
        
        $total_ppn_val = $total_ppn;
        $total_jumlah_val = $total_jumlah;

        $total_bayar = 0;
        if (isset($historibayar)) {
            foreach ($historibayar as $h) {
                $total_bayar += $h->jumlah;
            }
        }
        $sisa_tagihan = $total_jumlah_val - $total_bayar;
    @endphp

    <div class="space-y-6">

        <!-- Top Navigation & Action Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 w-full">
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('penjualanmarketing.index') }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs shadow-2xs transition cursor-pointer"
                >
                    <i data-lucide="arrow-left" class="w-4 h-4 text-slate-500"></i>
                    <span>Kembali ke Daftar</span>
                </a>

                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold text-xs {{ $penjualan->jenis_transaksi == 'T' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/20' : 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20' }}">
                        <i data-lucide="{{ $penjualan->jenis_transaksi == 'T' ? 'wallet' : 'calendar-clock' }}" class="w-3.5 h-3.5"></i>
                        <span>{{ $penjualan->jenis_transaksi == 'T' ? 'TUNAI' : 'KREDIT' }}</span>
                    </span>

                    @if ($penjualan->status == '1' || $sisa_tagihan <= 0.05)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold text-xs bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/20">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                            <span>LUNAS</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold text-xs bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200/60 dark:border-rose-500/20">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                            <span>BELUM LUNAS</span>
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    No. Bukti:
                </span>
                <span class="font-mono text-xs font-bold px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200/60 dark:border-blue-700/50">
                    {{ $penjualan->no_bukti }}
                </span>
            </div>
        </div>

        <!-- 3 Modern Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-5 items-stretch">
            
            <!-- Card 1: Detail Transaksi -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-[#162a5b] text-white flex items-center justify-center shadow-xs shrink-0">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Detail Transaksi</h4>
                            <p class="text-[11px] text-slate-400">Parameter faktur penjualan</p>
                        </div>
                    </div>

                    <div class="space-y-3.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">No. Bukti</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white">{{ $penjualan->no_bukti }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Tanggal Transaksi</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ date('d F Y', strtotime($penjualan->tanggal)) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Jenis Transaksi</span>
                            <span class="font-bold {{ $penjualan->jenis_transaksi == 'T' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                                {{ $penjualan->jenis_transaksi == 'T' ? 'TUNAI' : 'KREDIT' }}
                            </span>
                        </div>
                        @if ($penjualan->jenis_transaksi == 'T')
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Metode Bayar</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $penjualan->jenis_bayar == 'TN' ? 'Cash / Tunai' : 'Transfer Bank' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card 2: Informasi Pelanggan -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-xl bg-[#162a5b] text-white flex items-center justify-center shadow-xs shrink-0">
                            <i data-lucide="users" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Data Pelanggan</h4>
                            <p class="text-[11px] text-slate-400">Identitas penerima faktur</p>
                        </div>
                    </div>

                    <div class="space-y-3.5 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Kode Pelanggan</span>
                            <span class="font-mono text-xs font-semibold px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200/60 dark:border-blue-700/50">
                                {{ $penjualan->kode_pelanggan }}
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-500 dark:text-slate-400 font-medium block mb-0.5">Nama Customer</span>
                            <span class="font-bold text-slate-900 dark:text-white text-sm block">{{ $penjualan->nama_pelanggan }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 dark:text-slate-400 font-medium block mb-0.5">Alamat Pengiriman</span>
                            <span class="text-slate-600 dark:text-slate-300 block leading-relaxed">{{ $penjualan->alamat_pelanggan ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Summary & Payment -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden flex flex-col justify-between">
                <!-- Grand Total Display Header -->
                <div class="bg-[#162a5b] text-white p-5">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-blue-200 block mb-1">Total Tagihan (+PPN 11%)</span>
                    <h2 class="text-xl font-extrabold font-mono tracking-tight text-white">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</h2>
                </div>

                <!-- Payment summary body -->
                <div class="p-5 space-y-3 text-xs flex-1 flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Total Nilai DPP</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 font-mono">Rp {{ number_format($total_dpp, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">PPN (11%)</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 font-mono">Rp {{ number_format($total_ppn_val, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Total Terbayar</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400 font-mono">Rp {{ number_format($total_bayar, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-700 dark:text-slate-300 font-bold">Sisa Tagihan</span>
                            <span class="font-extrabold font-mono {{ $sisa_tagihan > 0.05 ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                Rp {{ number_format($sisa_tagihan, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-3">
                        @if ($penjualan->status == '1' || $sisa_tagihan <= 0.05)
                            <div class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200/60 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                <span>Tagihan Lunas</span>
                            </div>
                        @else
                            <div class="flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200/60 dark:border-rose-500/20 text-rose-700 dark:text-rose-300 text-xs font-bold uppercase tracking-wider">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                <span>Menunggu Pembayaran</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Table Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl shadow-2xs overflow-hidden">
            
            <!-- Table Card Header (Solid Biru Dongker) -->
            <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                        <i data-lucide="package" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-white tracking-tight flex items-center gap-2">
                            <span>Rincian Produk Terjual</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                                {{ count($detail) }} Item
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/80">Daftar item kuantiti dan subtotal harga per dus</p>
                    </div>
                </div>
            </div>

            <!-- Table Responsive Area -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#162a5b] text-white border-b border-blue-900/50">
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase text-center w-12">No</th>
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase w-32">Kode</th>
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase">Nama Produk</th>
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase text-center w-24">Satuan</th>
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase text-center w-24">Jumlah</th>
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase text-right w-40">Harga / Dus</th>
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase text-right w-36">PPN (11%)</th>
                            <th class="py-2.5 px-4 text-[11px] font-bold tracking-wider text-blue-100 uppercase text-right w-44">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-slate-900 text-xs">
                        @foreach ($detail as $d)
                            @php
                                $dpp = $d->harga_dus * $d->jumlah;
                                $ppn = $dpp * 0.11;
                                $jumlah_item = $dpp + $ppn;
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                                <td class="py-1 px-4 text-center font-medium text-slate-400">{{ $loop->iteration }}</td>
                                <td class="py-1 px-4">
                                    <span class="font-mono text-xs font-semibold px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200/60 dark:border-blue-700/50">
                                        {{ $d->kode_produk }}
                                    </span>
                                </td>
                                <td class="py-1 px-4 font-bold text-slate-800 dark:text-white">{{ $d->nama_produk }}</td>
                                <td class="py-1 px-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        {{ $d->satuan }}
                                    </span>
                                </td>
                                <td class="py-1 px-4 text-center font-bold text-slate-800 dark:text-white">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                                <td class="py-1 px-4 text-right font-mono text-slate-700 dark:text-slate-300">Rp {{ number_format($d->harga_dus, 2, ',', '.') }}</td>
                                <td class="py-1 px-4 text-right font-mono text-slate-400">Rp {{ number_format($ppn, 2, ',', '.') }}</td>
                                <td class="py-1 px-4 text-right font-mono font-bold text-slate-900 dark:text-white">Rp {{ number_format($jumlah_item, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50 dark:bg-slate-800/60 font-bold text-slate-800 dark:text-white border-t border-slate-200 dark:border-slate-800 text-xs">
                        <tr>
                            <td colspan="5" class="py-2.5 px-4 text-right font-bold text-slate-500 uppercase tracking-wider">TOTAL TAGIHAN</td>
                            <td class="py-2.5 px-4 text-right font-mono text-slate-800 dark:text-slate-200">Rp {{ number_format($total_dpp, 2, ',', '.') }}</td>
                            <td class="py-2.5 px-4 text-right font-mono text-slate-400">Rp {{ number_format($total_ppn_val, 2, ',', '.') }}</td>
                            <td class="py-2.5 px-4 text-right font-mono text-sm text-[#162a5b] dark:text-blue-400 font-extrabold">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if ($penjualan->jenis_transaksi == 'K')
        <!-- Credit Section: Payment History & Input -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left Card: Histori Pembayaran -->
            <div class="lg:col-span-8 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Header -->
                    <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                                <i data-lucide="receipt" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-xs uppercase tracking-wider text-white">Histori Pembayaran Piutang</h4>
                                <p class="text-[11px] text-blue-200/80">Riwayat alokasi cicilan faktur</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
                            {{ count($historibayar) }} Pembayaran
                        </span>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 border-b border-slate-200/80 dark:border-slate-800 text-[11px] font-bold uppercase tracking-wider">
                                    <th class="py-2.5 px-4 w-40">No. Bukti Bayar</th>
                                    <th class="py-2.5 px-4 w-32">Tanggal</th>
                                    <th class="py-2.5 px-4 text-center w-36">Metode</th>
                                    <th class="py-2.5 px-4 text-right">Jumlah Bayar</th>
                                    <th class="py-2.5 px-4 text-center w-24">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                                @forelse ($historibayar as $h)
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                                        <td class="py-1 px-4 font-mono font-bold text-slate-800 dark:text-white">{{ $h->no_bukti }}</td>
                                        <td class="py-1 px-4 text-slate-600 dark:text-slate-300">{{ date('d-m-Y', strtotime($h->tanggal)) }}</td>
                                        <td class="py-1 px-4 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $h->jenis_bayar == 'TN' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                                {{ $h->jenis_bayar == 'TN' ? 'TUNAI' : 'TRANSFER' }}
                                            </span>
                                            @if(!empty($h->nama_bank))
                                                <div class="text-[11px] font-semibold text-slate-500 mt-0.5">{{ $h->nama_bank }}</div>
                                            @endif
                                        </td>
                                        <td class="py-1 px-4 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                            Rp {{ number_format($h->jumlah, 2, ',', '.') }}
                                        </td>
                                        <td class="py-1 px-4 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                @can('penjualanmarketing.edit')
                                                <button 
                                                    type="button" 
                                                    class="btn-edit-bayar p-1 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition cursor-pointer"
                                                    data-no-bukti-bayar="{{ Crypt::encrypt($h->no_bukti) }}"
                                                    data-tanggal="{{ $h->tanggal }}"
                                                    data-jumlah="{{ number_format($h->jumlah, 0, ',', '.') }}"
                                                    data-jenis-bayar="{{ $h->jenis_bayar }}"
                                                    data-kode-bank="{{ $h->kode_bank }}"
                                                    title="Edit Pembayaran"
                                                >
                                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                                </button>
                                                @endcan

                                                @can('penjualanmarketing.delete')
                                                <form action="{{ route('penjualanmarketing.destroybayar', Crypt::encrypt($h->no_bukti)) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Hapus Pembayaran">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400">
                                            <i data-lucide="inbox" class="w-6 h-6 mx-auto mb-2 text-slate-300"></i>
                                            Belum ada histori pembayaran untuk transaksi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Card: Form Input Pembayaran -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Header -->
                    <div class="px-6 pt-5 pb-3 bg-[#162a5b] text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-white/15 text-white flex items-center justify-center shadow-xs shrink-0">
                                <i data-lucide="plus-circle" class="w-4 h-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-xs uppercase tracking-wider text-white">Input Pembayaran</h4>
                                <p class="text-[11px] text-blue-200/80">Catat pembayaran baru</p>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-5">
                        @if ($sisa_tagihan <= 0.05)
                            <div class="flex flex-col items-center justify-center py-8 text-center text-emerald-600 space-y-2">
                                <i data-lucide="check-circle-2" class="w-10 h-10 text-emerald-500"></i>
                                <span class="text-xs font-bold uppercase tracking-wider">Transaksi Sudah Lunas</span>
                                <span class="text-[11px] text-slate-400">Tidak ada sisa tagihan piutang pada faktur ini.</span>
                            </div>
                        @else
                            <form action="{{ route('penjualanmarketing.storebayar', Crypt::encrypt($penjualan->no_bukti)) }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <!-- Tanggal Bayar -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Bayar *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                        </div>
                                        <input 
                                            type="text" 
                                            name="tanggal" 
                                            id="tanggal_bayar_input" 
                                            value="{{ date('Y-m-d') }}" 
                                            placeholder="Pilih Tanggal" 
                                            required 
                                            autocomplete="off"
                                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date"
                                        />
                                    </div>
                                </div>

                                <!-- Jumlah Bayar -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jumlah Bayar *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <i data-lucide="banknote" class="w-4 h-4 text-slate-400"></i>
                                        </div>
                                        <input 
                                            type="text" 
                                            name="jumlah" 
                                            id="jumlah_bayar_input" 
                                            placeholder="Contoh: 50.000" 
                                            required 
                                            autocomplete="off"
                                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold font-mono text-right text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                                        />
                                    </div>
                                </div>

                                <!-- Bank / Kas -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Bank / Kas *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                                        </div>
                                        <select 
                                            name="kode_bank" 
                                            id="kode_bank_input" 
                                            required
                                            class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                        >
                                            <option value="">-- Pilih Bank / Kas --</option>
                                            @if(isset($bank))
                                                @foreach($bank as $b)
                                                    <option value="{{ $b->kode_bank }}">{{ $b->nama_bank }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Metode Pembayaran -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Metode Pembayaran *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <i data-lucide="credit-card" class="w-4 h-4 text-slate-400"></i>
                                        </div>
                                        <select 
                                            name="jenis_bayar" 
                                            id="jenis_bayar_input" 
                                            required
                                            class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                                        >
                                            <option value="TR">Transfer Bank</option>
                                            <option value="TN">Cash / Tunai</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button 
                                        type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#162a5b] hover:bg-[#1c3574] text-white font-bold text-xs shadow-sm transition cursor-pointer"
                                    >
                                        <i data-lucide="save" class="w-4 h-4"></i>
                                        <span>Simpan Pembayaran</span>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    <!-- Modal Edit Pembayaran -->
    @push('modals')
    <div id="modalEditBayar" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-black/50 backdrop-blur-xs overflow-y-auto">
        <div id="modalEditBayarContentWrapper" class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-800 mx-4 transition-all duration-200 scale-95 opacity-0">
            <!-- Header -->
            <div class="px-6 py-4 bg-[#162a5b] text-white flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center text-white">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white">Edit Pembayaran</h5>
                </div>
                <button type="button" class="text-white/80 hover:text-white transition cursor-pointer" onclick="closeModal('modalEditBayar')">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form id="formEditBayar" action="" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Bayar *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <input 
                                type="text" 
                                name="tanggal" 
                                id="edit_tanggal" 
                                required 
                                autocomplete="off"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs flatpickr-date"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jumlah Bayar *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i data-lucide="banknote" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <input 
                                type="text" 
                                name="jumlah" 
                                id="edit_jumlah" 
                                placeholder="Contoh: 50.000" 
                                required 
                                autocomplete="off"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold font-mono text-right text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Bank / Kas *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i data-lucide="building-2" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <select 
                                name="kode_bank" 
                                id="edit_kode_bank" 
                                required
                                class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                            >
                                <option value="">-- Pilih Bank / Kas --</option>
                                @if(isset($bank))
                                    @foreach($bank as $b)
                                        <option value="{{ $b->kode_bank }}">{{ $b->nama_bank }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Metode Pembayaran *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i data-lucide="credit-card" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <select 
                                name="jenis_bayar" 
                                id="edit_jenis_bayar" 
                                required
                                class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900 text-xs font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition shadow-2xs cursor-pointer"
                            >
                                <option value="TR">Transfer Bank</option>
                                <option value="TN">Cash / Tunai</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button 
                            type="button" 
                            class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition cursor-pointer" 
                            onclick="closeModal('modalEditBayar')"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2.5 text-xs font-bold text-white bg-[#162a5b] hover:bg-[#1c3574] rounded-xl transition shadow-sm cursor-pointer"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpush

    @push('myscript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                lucide.createIcons();
            }

            // Dynamic Thousands Separator Formatter
            $('#jumlah_bayar_input, #edit_jumlah').on('keyup', function(e) {
                var number = $(this).val().replace(/[^,\d]/g, '').toString();
                var split = number.split(',');
                var sisa = split[0].length % 3;
                var rupiah = split[0].substr(0, sisa);
                var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                $(this).val(rupiah);
            });

            // Trigger Edit Modal
            $('.btn-edit-bayar').on('click', function() {
                var noBuktiBayar = $(this).data('no-bukti-bayar');
                var tanggal = $(this).data('tanggal');
                var jumlah = $(this).data('jumlah');
                var jenisBayar = $(this).data('jenis-bayar');
                var kodeBank = $(this).data('kode-bank');

                // Set Form Action URL dynamically
                var actionUrl = "{{ route('penjualanmarketing.updatebayar', ':no_bukti_bayar') }}".replace(':no_bukti_bayar', noBuktiBayar);
                $('#formEditBayar').attr('action', actionUrl);

                // Populate Fields
                $('#edit_tanggal').val(tanggal);
                $('#edit_jumlah').val(jumlah);
                $('#edit_jenis_bayar').val(jenisBayar);
                $('#edit_kode_bank').val(kodeBank);

                // Open Modal with smooth animation
                openModal('modalEditBayar');
            });
        });
    </script>
    @endpush
</x-app-layout>
