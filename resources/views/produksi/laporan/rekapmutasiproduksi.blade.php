<form action="{{ route('cetakrekapmutasiproduksi') }}" method="POST" id="frmRekapnmutasiproduksi" target="_blank" class="space-y-2">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <div class="fl-group">
            <input type="text" name="dari" id="dari" required placeholder=" " class="fl-input flatpickr-date" autocomplete="off" />
            <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <label class="fl-label" for="dari">Dari <span class="fl-req">*</span></label>
        </div>
        <div class="fl-group">
            <input type="text" name="sampai" id="sampai" required placeholder=" " class="fl-input flatpickr-date" autocomplete="off" />
            <svg class="fl-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <label class="fl-label" for="sampai">Sampai <span class="fl-req">*</span></label>
        </div>
    </div>

    <div class="flex gap-2">
        <button type="submit" name="submitButton" class="flex-1 inline-flex items-center justify-center px-4 py-3 text-xs font-semibold text-white bg-[#294C9A] hover:bg-[#1E3A70] rounded-xl transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Rekap
        </button>
        <button type="submit" name="exportButton" class="inline-flex items-center justify-center px-4 py-3 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-xl transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
        </button>
    </div>
</form>

@push('myscript')
<script>
$(document).ready(function(){
    $("#frmRekapnmutasiproduksi").submit(function(){
        const dari = $("#frmRekapnmutasiproduksi").find("#dari").val();
        const sampai = $("#frmRekapnmutasiproduksi").find("#sampai").val();
        
        if(dari == ""){
            Swal.fire({
                title: "Oops!",
                text: 'Periode Dari Harus Diisi !',
                icon: "warning",
                showConfirmButton: true,
                didClose: () => {
                    $("#frmRekapnmutasiproduksi").find("#dari").focus();
                },
            });
            return false;
        } else if(sampai == ""){
            Swal.fire({
                title: "Oops!",
                text: 'Periode Sampai Harus Diisi !',
                icon: "warning",
                showConfirmButton: true,
                didClose: () => {
                    $("#frmRekapnmutasiproduksi").find("#sampai").focus();
                },
            });
            return false;
        }
        
        var start = new Date(dari);
        var end = new Date(sampai);
        if (start.getTime() > end.getTime()) {
            Swal.fire({
                title: "Oops!",
                text: 'Periode Tidak Valid !, Periode Sampai Harus Lebih Akhir dari Periode Dari',
                icon: "warning",
                showConfirmButton: true,
                didClose: () => {
                    $("#frmRekapnmutasiproduksi").find("#sampai").focus();
                },
            });
            return false;
        }
    });
});
</script>
@endpush
