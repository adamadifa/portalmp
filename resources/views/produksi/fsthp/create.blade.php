<style>
/* Floating Label with Icons */
.fl-group { position: relative; }
.fl-icon {
    position: absolute;
    left: 14px; top: 14px;
    width: 16px; height: 16px;
    color: #9ca3af;
    pointer-events: none;
    transition: color 0.2s;
}
.fl-input, .fl-select {
    display: block; width: 100%;
    padding: 14px 14px 4px 38px;
    font-size: 12px; color: #111827;
    background: #f9fafb;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    appearance: none;
}
.fl-input:focus, .fl-select:focus {
    border-color: #294C9A;
    box-shadow: 0 0 0 3px rgba(41,76,154,0.1);
    background: #fff;
}
.fl-input:focus ~ .fl-icon, .fl-select:focus ~ .fl-icon {
    color: #294C9A;
}
.fl-input:disabled, .fl-select:disabled {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
}
.fl-label {
    position: absolute;
    left: 38px; top: 9px;
    font-size: 12px; color: #9ca3af;
    font-weight: 500;
    pointer-events: none;
    transition: all 0.15s ease;
    transform-origin: left top;
}
.fl-input:focus ~ .fl-label,
.fl-input:not(:placeholder-shown) ~ .fl-label,
.fl-input:disabled ~ .fl-label,
.fl-select:focus ~ .fl-label,
.fl-select.has-value ~ .fl-label {
    top: 3px;
    font-size: 9px;
    color: #294C9A;
    font-weight: 600;
}
.fl-select {
    padding-top: 16px;
    padding-bottom: 2px;
}
.fl-req { color: #ef4444; margin-left: 2px; }
</style>

<form action="{{ route('fsthp.store') }}" method="POST" id="formcreateFsthp" class="space-y-4">
    @csrf
    <input type="hidden" id="cektutuplaporan" name="cektutuplaporan" value="0">

    <div class="fl-group">
        <input type="text" name="tanggal_mutasi" id="tanggal_mutasi" required placeholder=" " class="fl-input flatpickr-date" autocomplete="off" />
        <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <label class="fl-label" for="tanggal_mutasi">Tanggal FSTHP <span class="fl-req">*</span></label>
    </div>

    <div class="fl-group">
        <select name="unit" id="unit" required class="fl-select">
            <option value="">Pilih Unit</option>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        <label class="fl-label" for="unit">Unit <span class="fl-req">*</span></label>
    </div>

    <div class="fl-group">
        <select name="kode_produk" id="kode_produk" required class="fl-select">
            <option value="">Pilih Produk</option>
            @foreach ($produk as $p)
                <option value="{{ $p->kode_produk }}">{{ strtoupper($p->kode_produk) }} - {{ strtoupper($p->nama_produk) }}</option>
            @endforeach
        </select>
        <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        <label class="fl-label" for="kode_produk">Produk <span class="fl-req">*</span></label>
    </div>

    <div class="fl-group">
        <select name="shift" id="shift" required class="fl-select">
            <option value="">Pilih Shift</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <label class="fl-label" for="shift">Shift <span class="fl-req">*</span></label>
    </div>

    <div class="fl-group">
        <input type="number" name="jumlah" id="jumlah" required placeholder=" " class="fl-input" />
        <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <label class="fl-label" for="jumlah">Jumlah <span class="fl-req">*</span></label>
    </div>

    <div class="fl-group">
        <input type="text" name="no_mutasi" id="no_mutasi" readonly required placeholder=" " class="fl-input" />
        <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <label class="fl-label" for="no_mutasi">No. FSTHP</label>
    </div>

    <div class="pt-4">
        <button type="submit" id="btnSimpan" class="w-full inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Simpan FSTHP
        </button>
    </div>
</form>

<script>
    $(function() {
        flatpickr("#tanggal_mutasi", {
            dateFormat: "Y-m-d",
            locale: "id",
            allowInput: true,
            onReady: function(_, __, fp) {
                if (fp.input.value) fp.input.dispatchEvent(new Event('input'));
            },
            onChange: function(_, __, fp) {
                if (fp.input.value) fp.input.dispatchEvent(new Event('input'));
            }
        });

        // Floating label for selects
        document.querySelectorAll('#formcreateFsthp .fl-select').forEach(function(sel) {
            sel.addEventListener('change', function() {
                this.classList.toggle('has-value', this.value !== '');
            });
            if (sel.value !== '') sel.classList.add('has-value');
        });

        function generatenofsthp() {
            var tanggal_mutasi = $("#tanggal_mutasi").val();
            var kode_produk = $("#kode_produk").val();
            var shift = $("#shift").val();

            if (tanggal_mutasi != "" && kode_produk != "" && shift != "") {
                $.ajax({
                    type: 'POST',
                    url: '/fsthp/generatenofsthp',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal_mutasi: tanggal_mutasi,
                        kode_produk: kode_produk,
                        shift: shift
                    },
                    cache: false,
                    success: function(respond) {
                        $("#no_mutasi").val(respond);
                        document.getElementById('no_mutasi').dispatchEvent(new Event('input'));
                    }
                });
            } else {
                $("#no_mutasi").val("");
                document.getElementById('no_mutasi').dispatchEvent(new Event('input'));
            }
        }

        $("#tanggal_mutasi, #kode_produk, #shift").change(function() {
            generatenofsthp();
        });

        $("#formcreateFsthp").submit(function(e) {
            const no_mutasi = $("#no_mutasi").val();
            const tanggal_mutasi = $("#tanggal_mutasi").val();
            const unit = $("#unit").val();
            const kode_produk = $("#kode_produk").val();

            if (no_mutasi == "" || tanggal_mutasi == "" || unit == "" || kode_produk == "") {
                Swal.fire("Oops!", "Semua kolom bertanda * wajib diisi!", "warning");
                return false;
            }
            $("#btnSimpan").prop('disabled', true);
        });
    });
</script>
