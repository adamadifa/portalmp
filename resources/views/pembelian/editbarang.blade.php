<form action="#" id="formEditbarang" class="space-y-4">
    @php
        $total = toNumber($databarang['jumlah']) * toNumber($databarang['harga']) + toNumber($databarang['penyesuaian']);
    @endphp

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
        </span>
        <input type="text" name="kode_barang" id="kode_barang" class="fi bg-gray-50" disabled="true" value="{{ $databarang['kode_barang'] }}" />
        <label for="kode_barang" class="c-fl-label">Kode Barang</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </span>
        <input type="text" name="nama_barang" id="nama_barang" class="fi bg-gray-50" disabled="true" value="{{ textCamelCase($barang->nama_barang) }}" />
        <label for="nama_barang" class="c-fl-label">Nama Barang</label>
    </div>

    @if ($databarang['cekhistoribayar'] == '1')
        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </span>
            <input type="text" name="jumlah" id="jumlah" class="fi bg-gray-50 text-right" value="{{ $databarang['jumlah'] }}" disabled="true" />
            <label for="jumlah" class="c-fl-label">Qty</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
            </span>
            <input type="text" name="harga" id="harga" class="fi bg-gray-50 text-right" value="{{ $databarang['harga'] }}" disabled="true" />
            <label for="harga" class="c-fl-label">Harga</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
            </span>
            <input type="text" name="penyesuaian" id="penyesuaian" class="fi bg-gray-50 text-right" value="{{ $databarang['penyesuaian'] }}" disabled="true" />
            <label for="penyesuaian" class="c-fl-label">Penyesuaian</label>
        </div>
    @else
        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </span>
            <input type="text" name="jumlah" id="jumlah" class="fi number-separator text-right" value="{{ $databarang['jumlah'] }}" autocomplete="off" />
            <label for="jumlah" class="c-fl-label">Qty</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
            </span>
            <input type="text" name="harga" id="harga" class="fi number-separator text-right" value="{{ $databarang['harga'] }}" autocomplete="off" />
            <label for="harga" class="c-fl-label">Harga</label>
        </div>

        <div class="c-fl-group">
            <span class="c-fl-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
            </span>
            <input type="text" name="penyesuaian" id="penyesuaian" class="fi number-separator text-right" value="{{ $databarang['penyesuaian'] }}" autocomplete="off" />
            <label for="penyesuaian" class="c-fl-label">Penyesuaian</label>
        </div>
    @endif

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 5h4a2 2 0 012 2v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
        </span>
        <input type="text" name="total" id="total" class="fi bg-gray-50 text-right" value="{{ formatAngkaDesimal($total) }}" readonly />
        <label for="total" class="c-fl-label">Total</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        </span>
        <select name="kode_akun" id="kode_akun_editBarang" class="fi select2KodeakuneditBarang">
            <option value="">Akun</option>
            @foreach ($coa as $d)
                <option value="{{ $d->kode_akun }}" {{ $databarang['kode_akun'] == $d->kode_akun ? 'selected' : '' }}>{{ $d->kode_akun }} - {{ $d->nama_akun }}</option>
            @endforeach
        </select>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </span>
        <input type="text" name="keterangan" id="keterangan" class="fi" value="{{ $databarang['keterangan'] }}" placeholder="Keterangan" autocomplete="off" />
        <label for="keterangan" class="c-fl-label">Keterangan</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </span>
        <select name="kode_cabang_editBarang" id="kode_cabang_editBarang" class="fi select2Kodecabangeditbarang">
            <option value="">Cabang</option>
            @foreach ($cabang as $d)
                <option value="{{ $d->kode_cabang }}" {{ $databarang['kode_cabang'] == $d->kode_cabang ? 'selected' : '' }}>{{ strtoupper($d->nama_cabang) }}</option>
            @endforeach
        </select>
    </div>

    <div class="pt-2">
        <button type="submit" id="btnUpdatebarang" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            Update
        </button>
    </div>
</form>

<script>
    $(function() {
        easyNumberSeparator({
            selector: '.number-separator',
            separator: '.',
            decimalSeparator: ',',
        });

        function convertNumber(number) {
            let formatted = number.replace(/\./g, '');
            formatted = formatted.replace(/,/g, '.');
            return formatted || 0;
        }

        function numberFormat(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
                dec = typeof dec_point === 'undefined' ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        function calculateTotal() {
            let qty = $("#formEditbarang").find("#jumlah").val();
            let harga = $("#formEditbarang").find("#harga").val();
            let penyesuaian = $("#formEditbarang").find("#penyesuaian").val();
            qty = convertNumber(qty);
            harga = convertNumber(harga);
            penyesuaian = convertNumber(penyesuaian);
            return parseFloat(qty) * parseFloat(harga) + parseFloat(penyesuaian);
        }

        $("#formEditbarang").find("#jumlah, #harga, #penyesuaian").on('keyup keydown', function(e) {
            const total = calculateTotal();
            $("#formEditbarang").find("#total").val(numberFormat(total, '2', ',', '.'));
        });

        calculateTotal();

        const select2KodeakuneditBarang = $('.select2KodeakuneditBarang');
        if (select2KodeakuneditBarang.length) {
            select2KodeakuneditBarang.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Akun',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodecabangeditbarang = $('.select2Kodecabangeditbarang');
        if (select2Kodecabangeditbarang.length) {
            select2Kodecabangeditbarang.each(function() {
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
