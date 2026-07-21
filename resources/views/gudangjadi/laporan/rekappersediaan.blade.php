<form method="POST" action="{{ route('laporangudangjadi.cetakrekappersediaan') }}" id="frmRekappersediaan" target="_blank" class="space-y-3.5">
    @csrf

    <div class="grid grid-cols-2 gap-2">
        <div class="fl-group">
            <input type="text" name="dari" id="dari_rekap" required placeholder=" " class="fl-input flatpickr-date" autocomplete="off" />
            <label class="fl-label" for="dari_rekap">Dari Tanggal <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <input type="text" name="sampai" id="sampai_rekap" required placeholder=" " class="fl-input flatpickr-date" autocomplete="off" />
            <label class="fl-label" for="sampai_rekap">Sampai Tanggal <span class="fl-req">*</span></label>
        </div>
    </div>

    <div class="flex gap-2 pt-2">
        <button type="submit" name="submitButton" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm h-[42px]">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak PDF
        </button>
        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold text-white bg-green-600 hover:bg-green-700 rounded-xl transition shadow-sm h-[42px]" title="Export Excel">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
        </button>
    </div>
</form>

<script>
    $(function() {
        $("#frmRekappersediaan").submit(function(e) {
            const dari = $(this).find("#dari_rekap").val();
            const sampai = $(this).find("#sampai_rekap").val();
            var start = new Date(dari);
            var end = new Date(sampai);

            if (dari == "") {
                Swal.fire({
                    title: "Oops!",
                    text: 'Periode Dari Harus Diisi !',
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else if (sampai == "") {
                Swal.fire({
                    title: "Oops!",
                    text: 'Periode Sampai Harus Diisi !',
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            } else if (start.getTime() > end.getTime()) {
                Swal.fire({
                    title: "Oops!",
                    text: 'Periode Tidak Valid !, Periode Sampai Harus Lebih Akhir dari Periode Dari',
                    icon: "warning",
                    customClass: { confirmButton: 'inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-[#294C9A] rounded-xl' },
                    buttonsStyling: false
                });
                return false;
            }
        });
    });
</script>
