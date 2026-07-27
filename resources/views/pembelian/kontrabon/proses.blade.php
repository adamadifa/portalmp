<form action="{{ route('kontrabonpmb.storeproses', Crypt::encrypt($kontrabon->no_kontrabon)) }}" method="POST" id="formProseskontrabon" class="space-y-4">
    @csrf

    <!-- Info Grid -->
    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-4 mb-4">
        <h4 class="font-bold text-gray-900 border-b border-gray-200 pb-2 mb-3 uppercase tracking-wider text-[10px]">Informasi Kontrabon</h4>
        <div class="grid grid-cols-3 gap-4 text-xs">
            <div>
                <span class="block text-gray-500 font-semibold mb-1">No. Kontrabon</span>
                <span class="font-bold text-gray-900 font-mono">{{ $kontrabon->no_kontrabon }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Tanggal</span>
                <span class="font-medium text-gray-900">{{ DateToIndo($kontrabon->tanggal) }}</span>
            </div>
            <div>
                <span class="block text-gray-500 font-semibold mb-1">Terima Dari</span>
                <span class="font-medium text-gray-900">{{ $kontrabon->nama_supplier }}</span>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm mb-4">
        <table class="w-full text-xs text-left">
            <thead class="text-[11px] uppercase bg-gradient-to-r from-[#294C9A] to-[#1E3A70] text-white">
                <tr>
                    <th class="px-3.5 py-2 text-center" style="width: 8%">No.</th>
                    <th class="px-3.5 py-2">Tanggal</th>
                    <th class="px-3.5 py-2">No. Bukti</th>
                    <th class="px-3.5 py-2 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white text-gray-700">
                @php
                    $total = 0;
                @endphp
                @foreach ($detail as $d)
                    @php
                        $total += $d->jumlah;
                    @endphp
                    <tr class="cursor-pointer btnShowpembelian hover:bg-blue-50/50 transition" no_bukti="{{ Crypt::encrypt($d->no_bukti) }}">
                        <td class="px-3.5 py-1.5 text-center font-medium text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-3.5 py-1.5 font-medium text-gray-900">{{ DateToIndo($d->tanggal) }}</td>
                        <td class="px-3.5 py-1.5 font-mono text-[#294C9A]">{{ $d->no_bukti }}</td>
                        <td class="px-3.5 py-1.5 text-right font-bold text-gray-950">{{ formatAngkaDesimal($d->jumlah) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 text-gray-900 font-bold border-t border-gray-200">
                <tr>
                    <td colspan="3" class="px-3.5 py-2 uppercase">TOTAL</td>
                    <td class="px-3.5 py-2 text-right text-base text-[#294C9A]">{{ formatAngkaDesimal($total) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Inputs -->
    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </span>
        <input type="text" name="tanggal" id="tanggal" class="fi flatpickr-date" placeholder="Tanggal Proses" autocomplete="off" />
        <label for="tanggal" class="c-fl-label">Tanggal Proses</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </span>
        <select name="kode_bank" id="kode_bank" class="fi select2Kodebank">
            <option value="">Bank</option>
            @foreach ($bank as $d)
                <option value="{{ $d->kode_bank }}">{{ $d->nama_bank }} {{ !empty($d->no_rekening) ? '(' . $d->no_rekening . ')' : '' }}</option>
            @endforeach
        </select>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        </span>
        <select name="kode_akun" id="kode_akun" class="fi select2Kodeakun">
            <option value="">Akun</option>
            <option value="2-1300">2-1300 - Hutang Lainnya</option>
            <option value="2-1200">2-1200 - Hutang Dagang</option>
        </select>
    </div>

    <div id="kaskecil" class="c-fl-group hidden">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
        </span>
        <input type="text" name="no_bkk" id="no_bkk" class="fi" placeholder="No. BKK" autocomplete="off" />
        <label for="no_bkk" class="c-fl-label">No. BKK</label>
    </div>

    <div class="c-fl-group">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </span>
        <input type="text" name="keterangan" id="keterangan" class="fi" placeholder="Keterangan" autocomplete="off" />
        <label for="keterangan" class="c-fl-label">Keterangan</label>
    </div>

    <div class="flex items-center space-x-2 py-2">
        <input type="checkbox" name="dibayarcabang" value="1" id="dibayarcabang" class="w-4 h-4 text-[#294C9A] border-gray-300 rounded focus:ring-[#294C9A] dibayarcabang" />
        <label for="dibayarcabang" class="text-xs font-semibold text-gray-700 select-none">Dibayar Oleh Cabang ?</label>
    </div>

    <div id="cabang" class="c-fl-group hidden">
        <span class="c-fl-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </span>
        <select name="kode_cabang" id="kode_cabang" class="fi select2Kodecabang">
            <option value="">Cabang</option>
            @foreach ($cabang as $d)
                <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
            @endforeach
        </select>
    </div>

    <div class="pt-2">
        <button type="submit" id="btnSimpan" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm gap-1.5 h-[38px]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            Submit
        </button>
    </div>
</form>

<script>
    $(function() {
        const form = $("#formProseskontrabon");

        function showkaskecil() {
            const kode_bank = form.find("#kode_bank").val();
            if (kode_bank == "BK071") {
                $("#kaskecil").removeClass("hidden");
            } else {
                $("#kaskecil").addClass("hidden");
            }
        }

        showkaskecil();

        form.find("#kode_bank").on("change", function() {
            showkaskecil();
        });

        $(".flatpickr-date").flatpickr();

        function buttonDisable() {
            $("#btnSimpan").prop('disabled', true);
            $("#btnSimpan").html(`
            <svg class="animate-spin h-4 w-4 text-white mr-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            Loading..`);
        }

        const select2Kodecabang = $('.select2Kodecabang');
        if (select2Kodecabang.length) {
            select2Kodecabang.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Cabang',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodebank = $('.select2Kodebank');
        if (select2Kodebank.length) {
            select2Kodebank.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Bank',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        const select2Kodeakun = $('.select2Kodeakun');
        if (select2Kodeakun.length) {
            select2Kodeakun.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Akun',
                    allowClear: true,
                    dropdownParent: $this.parent()
                });
            });
        }

        form.find('.dibayarcabang').change(function() {
            if (this.checked) {
                form.find("#cabang").removeClass("hidden");
            } else {
                form.find("#cabang").addClass("hidden");
            }
        });

        form.submit(function(e) {
            const tanggal = form.find("#tanggal").val();
            const kode_akun = form.find("#kode_akun").val();
            const keterangan = form.find("#keterangan").val();
            const kode_cabang = form.find("#kode_cabang").val();
            const kode_bank = form.find("#kode_bank").val();
            const no_bkk = form.find("#no_bkk").val();
            if (tanggal == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Tanggal Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#tanggal").focus();
                    },
                });
                return false;
            } else if (kode_bank == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Bank Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_bank").focus();
                    },
                });
                return false;
            } else if (kode_bank == "BK071" && no_bkk == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "No BKK Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#no_bkk").focus();
                    }
                });
                return false;
            } else if (kode_akun == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Akun Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_akun").focus();
                    },
                });
                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Keterangan Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#keterangan").focus();
                    },
                });
                return false;
            } else if ($(".dibayarcabang").is(':checked') && kode_cabang == "") {
                Swal.fire({
                    title: "Oops!",
                    text: "Cabang Harus Diisi !",
                    icon: "warning",
                    showConfirmButton: true,
                    didClose: (e) => {
                        form.find("#kode_cabang").focus();
                    },
                });
                return false;
            } else {
                buttonDisable();
            }
        });
    });
</script>
