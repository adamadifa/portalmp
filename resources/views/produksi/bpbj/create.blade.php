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

<form action="{{ route('bpbj.store') }}" method="POST" id="formcreateBpbj" class="space-y-6">
    @csrf
    <input type="hidden" id="cekdetailtemp" name="cekdetailtemp" value="0">
    <input type="hidden" id="cektutuplaporan" name="cektutuplaporan" value="0">

    <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="fl-group">
                <input type="text" name="tanggal_mutasi" id="tanggal_mutasi" required placeholder=" " class="fl-input flatpickr-date" autocomplete="off" />
                <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <label class="fl-label" for="tanggal_mutasi">Tanggal BPBJ <span class="fl-req">*</span></label>
            </div>
            <div class="fl-group">
                <input type="text" name="no_mutasi" id="no_mutasi" readonly required placeholder=" " class="fl-input" />
                <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <label class="fl-label" for="no_mutasi">No. BPBJ</label>
            </div>
        </div>

        <hr class="border-gray-100" />

        <div class="space-y-4">
            <div class="fl-group">
                <select id="kode_produk" class="fl-select">
                    <option value="">Pilih Produk</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->kode_produk }}">{{ strtoupper($p->kode_produk) }} - {{ strtoupper($p->nama_produk) }}</option>
                    @endforeach
                </select>
                <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <label class="fl-label" for="kode_produk">Pilih Produk <span class="fl-req">*</span></label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="fl-group">
                    <select id="shift" class="fl-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <label class="fl-label" for="shift">Shift <span class="fl-req">*</span></label>
                </div>
                <div class="fl-group">
                    <input type="number" id="jumlah" placeholder=" " class="fl-input" />
                    <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <label class="fl-label" for="jumlah">Jumlah <span class="fl-req">*</span></label>
                </div>
                <div>
                    <button type="button" id="tambahproduk" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Temp Details Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-4">
        <div class="bg-[#294C9A] px-6 py-4 border-b border-white/10">
            <h3 class="text-sm font-semibold text-white">Detail Item Penyerahan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                        <th class="py-3 px-4">Kode Produk</th>
                        <th class="py-3 px-4">Nama Produk</th>
                        <th class="py-3 px-4">Shift</th>
                        <th class="py-3 px-4 text-right">Jumlah</th>
                        <th class="py-3 px-4 text-center">#</th>
                    </tr>
                </thead>
                <tbody id="loaddetailbpbjtemp" class="text-sm divide-y divide-gray-100">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada item ditambahkan.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="agreement" required class="rounded border-gray-300 text-[#294C9A] focus:ring-[#294C9A]" />
                <label for="agreement" class="text-xs text-gray-600 font-medium cursor-pointer">Yakin data sudah benar dan siap disimpan?</label>
            </div>
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Simpan BPBJ
            </button>
        </div>
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
        document.querySelectorAll('#formcreateBpbj .fl-select').forEach(function(sel) {
            sel.addEventListener('change', function() {
                this.classList.toggle('has-value', this.value !== '');
            });
            if (sel.value !== '') sel.classList.add('has-value');
        });

        function cekdetailtemp() {
            var kode_produk = $("#kode_produk").val();
            $.ajax({
                type: 'POST',
                url: '/bpbj/cekdetailtemp',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_produk: kode_produk
                },
                cache: false,
                success: function(respond) {
                    $("#cekdetailtemp").val(respond);
                }
            });
        }

        function loaddetailtemp() {
            var kode_produk = $("#kode_produk").val();
            if (kode_produk != "") {
                $.ajax({
                    type: 'GET',
                    url: '/bpbj/' + kode_produk + '/getdetailtemp',
                    cache: false,
                    success: function(respond) {
                        $("#loaddetailbpbjtemp").html(respond);
                        cekdetailtemp();
                    }
                });
            } else {
                $("#loaddetailbpbjtemp").html('<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada item ditambahkan.</td></tr>');
            }
        }

        function generateNoBpbj() {
            var tanggal_mutasi = $("#tanggal_mutasi").val();
            var kode_produk = $("#kode_produk").val();
            if (tanggal_mutasi != "" && kode_produk != "") {
                $.ajax({
                    type: 'POST',
                    url: '/bpbj/generatenobpbj',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal_mutasi: tanggal_mutasi,
                        kode_produk: kode_produk
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

        $("#tanggal_mutasi, #kode_produk").change(function() {
            generateNoBpbj();
            loaddetailtemp();
        });

        $("#tambahproduk").click(function(e) {
            e.preventDefault();
            var kode_produk = $("#kode_produk").val();
            var shift = $("#shift").val();
            var jumlah = $("#jumlah").val();
            var tanggal_mutasi = $("#tanggal_mutasi").val();

            if (tanggal_mutasi == "") {
                Swal.fire({ title: "Oops!", text: "Tanggal BPBJ Harus Diisi !", icon: "warning", customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                return false;
            } else if (kode_produk == "") {
                Swal.fire({ title: "Oops!", text: "Produk Harus Diisi !", icon: "warning", customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                return false;
            } else if (jumlah == "" || jumlah == 0) {
                Swal.fire({ title: "Oops!", text: "Jumlah Harus Diisi !", icon: "warning", customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '/bpbj/storedetailtemp',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_produk: kode_produk,
                    shift: shift,
                    jumlah: jumlah
                },
                cache: false,
                success: function(respond) {
                    Swal.fire({ title: "Berhasil!", text: "Data ditambahkan!", icon: "success", customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                    loaddetailtemp();
                    $("#jumlah").val("");
                    document.getElementById('jumlah').dispatchEvent(new Event('input'));
                },
                error: function(err) {
                    Swal.fire({ title: "Gagal!", text: err.responseJSON.message || "Gagal menyimpan data", icon: "error", customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                }
            });
        });

        $(document).on('click', '.btn-delete-temp', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '/bpbj/deletetemp',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(respond) {
                    loaddetailtemp();
                }
            });
        });

        $("#formcreateBpbj").submit(function(e) {
            var cekdetailtemp = $("#cekdetailtemp").val();
            if (cekdetailtemp == 0 || cekdetailtemp == "") {
                Swal.fire({ title: "Oops!", text: "Detail Item Penyerahan Masih Kosong !", icon: "warning", customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' }, buttonsStyling: false });
                return false;
            }
        });
    });
</script>
