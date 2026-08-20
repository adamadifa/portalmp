<x-app-layout>
    <x-slot name="header">
        Detail Penjualan Marketing
    </x-slot>

    <!-- Main Container -->
    <div class="space-y-6">
        
        <!-- Header & Navigation -->
        <div class="flex justify-between items-center w-full mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Detail Penjualan Marketing</h2>
                <p class="text-sm text-gray-500 mt-1 font-mono"># {{ $penjualan->no_bukti }}</p>
            </div>
            <div>
                <a href="{{ route('penjualanmarketing.index') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition shadow-sm h-[38px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>

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
            
            // Keep full decimal totals for formatting
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

        <!-- Top Grid: Transaction Info & Payment Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6 items-stretch text-sm">
            <!-- Card 1: Detail Transaksi -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-[#294C9A] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Detail Transaksi
                            </h5>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">No. Bukti</span>
                                <span class="font-semibold text-gray-900 font-mono text-sm block">{{ $penjualan->no_bukti }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Tanggal</span>
                                <span class="font-semibold text-gray-900 block">{{ date('d M Y', strtotime($penjualan->tanggal)) }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Jenis Transaksi</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold {{ $penjualan->jenis_transaksi == 'T' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $penjualan->jenis_transaksi == 'T' ? 'TUNAI' : 'KREDIT' }}
                                </span>
                            </div>
                            @if ($penjualan->jenis_transaksi == 'T')
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Metode Bayar</span>
                                <span class="font-semibold text-gray-900 block">{{ $penjualan->jenis_bayar == 'TN' ? 'CASH' : 'TRANSFER' }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Informasi Pelanggan -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-[#294C9A] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#294C9A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Pelanggan
                            </h5>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Nama Customer</span>
                                <span class="font-bold text-gray-900 text-sm block">{{ $penjualan->nama_pelanggan }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block mb-0.5">Alamat</span>
                                <span class="text-xs text-gray-650 block leading-relaxed">{{ $penjualan->alamat_pelanggan ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Summary & Payment -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden h-full flex flex-col justify-between">
                    <!-- Grand Total Display Header -->
                    <div class="bg-gradient-to-br from-[#294C9A] to-[#1E3A70] text-white p-5 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                        <div class="relative z-10 space-y-1">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-blue-200 block">Grand Total (+PPN)</span>
                             <h2 class="text-xl font-bold font-mono tracking-tight">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</h2>
                        </div>
                    </div>

                    <!-- Payment summary body -->
                    <div class="p-5 space-y-4 flex-1 flex flex-col justify-between">
                        <table class="w-full text-xs text-left border-collapse">
                            <tr class="border-b border-gray-50">
                                <td class="py-2 text-gray-400 font-semibold">Tagihan</td>
                                <td class="py-2 text-right font-bold text-gray-900 font-mono">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</td>
                            </tr>
                             <tr class="border-b border-gray-50">
                                <td class="py-2 text-gray-400 font-semibold">Total Bayar</td>
                                <td class="py-2 text-right font-bold text-emerald-600 font-mono">
                                    Rp {{ number_format($total_bayar, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-50">
                                <td class="py-2 text-gray-400 font-semibold">Sisa Tagihan</td>
                                <td class="py-2 text-right font-bold text-rose-600 font-mono">
                                    Rp {{ number_format($sisa_tagihan, 2, ',', '.') }}
                                </td>
                            </tr>
                        </table>

                        <div class="pt-2">
                            @if ($penjualan->status == '1')
                                <div class="flex items-center justify-center gap-1.5 py-2 rounded-xl bg-emerald-50 border border-emerald-200/50 text-emerald-700 text-xs font-bold uppercase tracking-wide">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Lunas
                                </div>
                            @else
                                <div class="flex items-center justify-center gap-1.5 py-2 rounded-xl bg-rose-50 border border-rose-200/50 text-rose-700 text-xs font-bold uppercase tracking-wide">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Belum Lunas
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Card: Full-width Product Details -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-[#294C9A] text-white">
                <h5 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Produk Detail
                </h5>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse text-gray-600">
                    <thead class="bg-[#294C9A] text-white text-sm uppercase tracking-wider">
                        <tr>
                            <th class="py-3.5 px-6 font-semibold whitespace-nowrap">Kode</th>
                            <th class="py-3.5 px-6 font-semibold whitespace-nowrap">Nama Produk</th>
                            <th class="py-3.5 px-6 font-semibold text-center whitespace-nowrap">Satuan</th>
                            <th class="py-3.5 px-6 font-semibold text-center whitespace-nowrap">Jumlah</th>
                            <th class="py-3.5 px-6 font-semibold text-right whitespace-nowrap">Harga / Dus</th>
                            <th class="py-3.5 px-6 font-semibold text-right whitespace-nowrap">PPN</th>
                            <th class="py-3.5 px-6 font-semibold text-right whitespace-nowrap">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-sm">
                        @foreach ($detail as $d)
                            @php
                                $dpp = $d->harga_dus * $d->jumlah;
                                $ppn = $dpp * 0.11;
                                $jumlah_item = $dpp + $ppn;
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-2.5 px-6 font-mono font-semibold text-gray-900 whitespace-nowrap">{{ $d->kode_produk }}</td>
                                <td class="py-2.5 px-6 font-medium text-gray-800">{{ $d->nama_produk }}</td>
                                <td class="py-2.5 px-6 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-gray-100 text-gray-700 font-semibold text-[10px]">
                                        {{ $d->satuan }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-6 text-center font-semibold text-gray-900 whitespace-nowrap">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
                                <td class="py-2.5 px-6 text-right font-mono text-gray-900 whitespace-nowrap">Rp {{ number_format($d->harga_dus, 2, ',', '.') }}</td>
                                <td class="py-2.5 px-6 text-right font-mono text-gray-400 whitespace-nowrap">Rp {{ number_format($ppn, 2, ',', '.') }}</td>
                                <td class="py-2.5 px-6 text-right font-mono font-bold text-gray-900 whitespace-nowrap">Rp {{ number_format($jumlah_item, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50/30 font-bold text-gray-900 border-t border-gray-100 text-sm">
                        <tr>
                            <td colspan="5" class="py-2.5 px-6 text-right font-semibold text-gray-500 whitespace-nowrap">TOTAL</td>
                            <td class="py-2.5 px-6 text-right font-mono text-gray-400 whitespace-nowrap">Rp {{ number_format($total_ppn_val, 2, ',', '.') }}</td>
                            <td class="py-2.5 px-6 text-right font-mono text-sm text-[#294C9A] whitespace-nowrap">Rp {{ number_format($total_jumlah_val, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if ($penjualan->jenis_transaksi == 'K')
        <!-- Payment Section (Credit Transactions Only) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">
            <!-- Left Card: Payment History -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div class="px-6 py-4 bg-gradient-to-br from-[#294C9A] to-[#1E3A70] text-white flex justify-between items-center relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-16 h-16 bg-white/10 rounded-full blur-lg"></div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-1.5 relative z-10">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Histori Pembayaran Piutang
                    </h5>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white relative z-10 border border-white/10">
                        {{ count($historibayar) }} Pembayaran
                    </span>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-xs text-left border-collapse text-gray-650">
                        <thead class="bg-gray-50 text-gray-800 text-[11px] uppercase tracking-wider font-bold border-b border-gray-100">
                            <tr>
                                <th class="py-2.5 px-6">No. Bukti Bayar</th>
                                <th class="py-2.5 px-6">Tanggal</th>
                                <th class="py-2.5 px-6 text-center">Metode</th>
                                <th class="py-2.5 px-6 text-right">Jumlah Bayar</th>
                                <th class="py-2.5 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($historibayar as $h)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-2.5 px-6 font-mono font-semibold text-gray-900">{{ $h->no_bukti }}</td>
                                    <td class="py-2.5 px-6">{{ date('d-m-Y', strtotime($h->tanggal)) }}</td>
                                    <td class="py-2.5 px-6 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $h->jenis_bayar == 'TN' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                            {{ $h->jenis_bayar == 'TN' ? 'TUNAI' : 'TRANSFER' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-6 text-right font-mono font-semibold text-gray-900">Rp {{ number_format($h->jumlah, 2, ',', '.') }}</td>
                                    <td class="py-2.5 px-6 text-center">
                                        @can('penjualanmarketing.delete')
                                        <form action="{{ route('penjualanmarketing.destroybayar', Crypt::encrypt($h->no_bukti)) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 p-1 hover:bg-rose-50 rounded transition" title="Hapus Pembayaran">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-400">Belum ada histori pembayaran untuk transaksi ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Card: Form Input Pembayaran -->
            <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div class="px-6 py-4 bg-gradient-to-br from-[#294C9A] to-[#1E3A70] text-white relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-16 h-16 bg-white/10 rounded-full blur-lg"></div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-1.5 relative z-10">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Input Pembayaran Baru
                    </h5>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between">
                    @if ($sisa_tagihan <= 0.05)
                        <div class="flex flex-col items-center justify-center py-6 text-center text-emerald-600 space-y-2">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-bold uppercase">Transaksi Sudah Lunas</span>
                            <span class="text-[10px] text-gray-400">Tidak dapat menambahkan pembayaran lagi.</span>
                        </div>
                    @else
                        <form action="{{ route('penjualanmarketing.storebayar', Crypt::encrypt($penjualan->no_bukti)) }}" method="POST" class="space-y-3.5 pt-1">
                            @csrf
                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                <input type="text" name="tanggal" id="tanggal_bayar_input" value="{{ date('Y-m-d') }}" class="fi flatpickr-date" placeholder="Pilih Tanggal" required autocomplete="off">
                                <label for="tanggal_bayar_input" class="c-fl-label">Tanggal Bayar *</label>
                            </div>

                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                <input type="text" name="jumlah" id="jumlah_bayar_input" placeholder="Contoh: 50.000" class="fi font-mono font-bold text-gray-900 text-right" required autocomplete="off">
                                <label for="jumlah_bayar_input" class="c-fl-label">Jumlah Bayar *</label>
                            </div>

                            <div class="c-fl-group">
                                <span class="c-fl-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </span>
                                <select name="jenis_bayar" id="jenis_bayar_input" class="fi" required>
                                    <option value="TN">Cash / Tunai</option>
                                    <option value="TR">Transfer</option>
                                </select>
                                <label for="jenis_bayar_input" class="c-fl-label">Metode Pembayaran *</label>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-lg transition shadow-sm gap-1.5 h-[38px]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Pembayaran
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });

            // Dynamic Thousands Separator Formatter
            $('#jumlah_bayar_input').on('keyup', function(e) {
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
        });
    </script>
    @endpush
</x-app-layout>
