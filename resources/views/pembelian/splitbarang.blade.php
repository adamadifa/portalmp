<form action="#" id="formSplitbarang" class="space-y-4">
    @php
        $total = toNumber($databarang['jumlah']) * toNumber($databarang['harga']) + toNumber($databarang['penyesuaian']);
    @endphp

    <!-- Info Box -->
    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-4 mb-4 text-xs">
        <h4 class="font-bold text-gray-900 border-b border-gray-200 pb-2 mb-3 uppercase tracking-wider">Informasi Item Asal</h4>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-gray-700">
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Kode Barang</span>
                <span class="font-mono text-gray-900">{{ $databarang['kode_barang'] }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Nama Barang</span>
                <span class="font-medium text-gray-900">{{ $databarang['nama_barang'] }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Qty Asal</span>
                <span class="font-medium text-gray-900">{{ $databarang['jumlah'] }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Harga Asal</span>
                <span class="font-medium text-gray-900">{{ $databarang['harga'] }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Penyesuaian</span>
                <span class="font-medium text-gray-900">{{ $databarang['penyesuaian'] }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Total Asal</span>
                <span class="font-bold text-[#294C9A]" id="totalSplit">{{ formatAngkaDesimal($total) }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Akun</span>
                <span class="font-medium text-gray-900">{{ $databarang['kode_akun'] }} - {{ $akun->nama_akun }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Cabang</span>
                <span class="font-medium text-gray-900">{{ $databarang['kode_cabang'] }}</span>
            </div>
        </div>
    </div>

    <!-- Input Fields for Split -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
        <div class="md:col-span-3">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </span>
                <input type="text" name="nama_barang_split" id="nama_barang_split" class="fi cursor-pointer" placeholder="Klik Pilih Barang" readonly />
                <input type="hidden" id="kode_barang" name="kode_barang">
                <label for="nama_barang_split" class="c-fl-label">Pilih Barang</label>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                </span>
                <input type="text" name="jumlah" id="jumlah" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                <label for="jumlah" class="c-fl-label">Qty</label>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                </span>
                <input type="text" name="harga" id="harga" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                <label for="harga" class="c-fl-label">Harga</label>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                </span>
                <input type="text" name="penyesuaian" id="penyesuaian" class="fi number-separator text-right" placeholder="0" autocomplete="off" />
                <label for="penyesuaian" class="c-fl-label">Penyesuaian</label>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
                <select name="kode_akun" id="kode_akun_split" class="fi select2Kodeakunsplit">
                    <option value="">Akun</option>
                    @foreach ($coa as $d)
                        <option value="{{ $d->kode_akun }}">{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
        <div class="md:col-span-8">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </span>
                <input type="text" name="keterangan" id="keterangan" class="fi" placeholder="Keterangan" autocomplete="off" />
                <label for="keterangan" class="c-fl-label">Keterangan</label>
            </div>
        </div>

        <div class="md:col-span-4">
            <div class="c-fl-group">
                <span class="c-fl-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </span>
                <select name="kode_cabang_split" id="kode_cabang_split" class="fi select2Kodecabangsplit">
                    <option value="">Cabang</option>
                    @foreach ($cabang as $d)
                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div>
        <button type="button" id="btnSplitbarang" class="w-full inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-[#294C9A] bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-xl transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Split Barang
        </button>
    </div>

    <!-- Table of Split Results -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mt-3">
        <table class="w-full text-xs text-left">
            <thead class="text-xs uppercase bg-gray-50 text-gray-700 border-b border-gray-200">
                <tr>
                    <th class="px-3 py-2.5">Kode</th>
                    <th class="px-3 py-2.5">Nama Barang</th>
                    <th class="px-3 py-2.5 text-center">Qty</th>
                    <th class="px-3 py-2.5 text-right">Harga</th>
                    <th class="px-3 py-2.5 text-right">Peny</th>
                    <th class="px-3 py-2.5 text-right">Total</th>
                    <th class="px-3 py-2.5">Akun</th>
                    <th class="px-3 py-2.5">Cabang</th>
                    <th class="px-3 py-2.5 text-center">#</th>
                </tr>
            </thead>
            <tbody id="loadsplitbarang" class="divide-y divide-gray-100 bg-white"></tbody>
            <tfoot class="bg-gray-50 text-gray-900 border-t border-gray-200 font-bold">
                <tr>
                    <td colspan="5" class="px-3 py-2.5">TOTAL</td>
                    <td id="grandtotal" class="px-3 py-2.5 text-right">0</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="pt-2">
        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            Submit
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formSplitbarang");

        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        const select2Kodeakunsplit = $('.select2Kodeakunsplit');
        if (select2Kodeakunsplit.length) {
            select2Kodeakunsplit.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Akun',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodecabangsplit = $('.select2Kodecabangsplit');
        if (select2Kodecabangsplit.length) {
            select2Kodecabangsplit.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Cabang',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }
    });
</script>
