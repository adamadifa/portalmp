<style>
/* Floating Label (Consistent with /barang) */
.fl-group { position: relative; }
.fl-input, .fl-select {
    display: block; width: 100%;
    padding: 14px 14px 4px;
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
.fl-label {
    position: absolute;
    left: 14px; top: 9px;
    font-size: 12px; color: #9ca3af;
    font-weight: 500;
    pointer-events: none;
    transition: all 0.15s ease;
    transform-origin: left top;
    z-index: 10;
}
.fl-input:focus ~ .fl-label,
.fl-input:not(:placeholder-shown) ~ .fl-label,
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

<form action="{{ route('sahargagb.store') }}" method="POST" id="formCreatesaldoawalharga" class="space-y-4" novalidate>
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="fl-group">
            <select name="bulan" id="bulan_create" required class="fl-select">
                <option value=""></option>
                @foreach ($list_bulan as $d)
                    <option value="{{ $d['kode_bulan'] }}">{{ $d['nama_bulan'] }}</option>
                @endforeach
            </select>
            <label class="fl-label" for="bulan_create">Bulan <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <select name="tahun" id="tahun_create" required class="fl-select">
                <option value=""></option>
                @for ($t = $start_year; $t <= date('Y'); $t++)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endfor
            </select>
            <label class="fl-label" for="tahun_create">Tahun <span class="fl-req">*</span></label>
        </div>
    </div>

    <div>
        <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-xl transition shadow-sm h-[42px]" id="getsaldo">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"></path></svg>
            Get Saldo
        </button>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mt-4">
        <div class="overflow-x-auto max-h-[40vh] overflow-y-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold uppercase tracking-wider bg-[#294C9A] text-white">
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10">Kode</th>
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10" style="width: 40%;">Nama Barang</th>
                        <th class="py-2.5 px-4 sticky top-0 bg-[#294C9A] z-10">Satuan</th>
                        <th class="py-2.5 px-4 text-right sticky top-0 bg-[#294C9A] z-10">Harga</th>
                    </tr>
                </thead>
                <tbody id="loaddetailsaldo" class="text-sm divide-y divide-gray-100">
                    <tr>
                        <td colspan="4" class="py-6 px-4 text-center text-xs text-gray-400">Silahkan pilih bulan & tahun lalu tekan Get Saldo.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-3 border-t border-gray-100">
        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Simpan Saldo Awal Harga
        </button>
    </div>
</form>

<script>
    $(function() {
        // Floating label state helper for AJAX
        function checkValue(element) {
            if ($(element).val() !== "") {
                $(element).addClass('has-value');
            } else {
                $(element).removeClass('has-value');
            }
        }

        $('.fl-select').each(function() {
            checkValue(this);
        });

        $('.fl-select').on('change', function() {
            checkValue(this);
        });

        // Mendapatkan Data Detail Saldo
        function loaddetailsaldo() {
            var bulan = $("#bulan_create").val();
            var tahun = $("#tahun_create").val();
            if (bulan == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Silahkan Pilih dulu Bulan !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else if (tahun == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Silahkan Pilih dulu Tahun !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('sahargagb.getdetailsaldo') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loaddetailsaldo").html(respond);
                    }
                });
            }
        }

        $("#getsaldo").click(function(e) {
            e.preventDefault();
            loaddetailsaldo();
        });

        $("#formCreatesaldoawalharga").submit(function(e) {
            var bulan = $("#bulan_create").val();
            var tahun = $("#tahun_create").val();
            
            if (bulan == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Bulan Harus Diisi !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            }
            
            if (tahun == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Tahun Harus Diisi !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            }
            
            if ($("#loaddetailsaldo").find("input[name='kode_barang[]']").length == 0) {
                Swal.fire({
                    title: "Oops!",
                    text: "Silahkan Get Saldo terlebih dahulu untuk memuat daftar barang !",
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            }
        });
    });
</script>
