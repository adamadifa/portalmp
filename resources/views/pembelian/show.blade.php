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

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6 pt-6 border-t border-slate-100 text-xs">
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
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">Harga</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-28">Subtotal</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-24">Peny</th>
                            <th class="px-5 py-3 font-semibold uppercase tracking-wider text-right w-32">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 bg-white">
                        @php
                            $total_pembelian = 0;
                        @endphp
                        @foreach ($detail as $d)
                            @php
                                $subtotal = $d->jumlah * $d->harga;
                                $total = $subtotal + $d->penyesuaian;
                                $total_pembelian += $total;
                                $bg = !empty($d->kode_cr) ? 'bg-blue-50/40 text-blue-900' : '';
                            @endphp
                            <tr class="{{ $bg }} hover:bg-slate-50/30 transition">
                                <td class="px-5 py-3.5 font-mono text-slate-500 font-medium">{{ $d->kode_barang }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-850">{{ textCamelCase($d->nama_barang) }}</td>
                                <td class="px-5 py-3.5 text-slate-500">{{ textCamelCase($d->keterangan) }}</td>
                                <td class="px-5 py-3.5 text-center font-medium">{{ formatAngkaDesimal($d->jumlah) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-600">{{ formatAngkaDesimal($d->harga) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-600">{{ formatAngkaDesimal($subtotal) }}</td>
                                <td class="px-5 py-3.5 text-right font-medium text-slate-500">{{ formatAngkaDesimal($d->penyesuaian) }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-slate-900">{{ formatAngkaDesimal($total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
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
                $grand_total = $total_pembelian - $total_potongan + $pembelian->penyesuaian_jk;
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
                            <select name="kode_bank" required class="w-full text-xs border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white shadow-sm">
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
                                    <button type="button" onclick="deletePembayaran('{{ $d->tanggal }}', '{{ $d->kode_bank }}', {{ $d->jumlah }})" class="text-rose-600 hover:text-rose-800 transition" title="Hapus Pembayaran">
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
                </table>
            </div>
        </div>
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

    function deletePembayaran(tanggal, kodeBank, jumlah) {
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
                        tanggal: tanggal,
                        kode_bank: kodeBank,
                        jumlah: jumlah
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
